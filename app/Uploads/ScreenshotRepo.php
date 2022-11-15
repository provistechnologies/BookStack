<?php

namespace BookStack\Uploads;

use Illuminate\Support\Str;
use Illuminate\Contracts\Filesystem\Filesystem as Storage;
use Illuminate\Filesystem\FilesystemManager;

use BookStack\Exceptions\ImageUploadException;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use League\Flysystem\Util;
use Illuminate\Support\Facades\Log;


class ScreenshotRepo
{
    protected FilesystemManager $fileSystem;
    protected $storageUrl;


    /**
     * ImageRepo constructor.
     */
    public function __construct(FilesystemManager $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    /**
     * Save a new image into storage and return the new image.
     *
     * @throws ImageUploadException
     */
    public function saveScreemshot(UploadedFile $uploadFile, $session_id)
    {
        $image = $this->saveNewFromUpload($uploadFile, $session_id);
        return $image;
    }

    /**
     * Saves a new image from an upload.
     *
     * @throws ImageUploadException
     *
     * @return mixed
     */
    public function saveNewFromUpload( UploadedFile $uploadedFile, $session_id) {
        $imageName = $uploadedFile->getClientOriginalName();
        $imageData = file_get_contents($uploadedFile->getRealPath());

        return $this->saveNew($imageName, $imageData, $session_id);
    }

    /**
     * Save a new image into storage.
     *
     * @throws ImageUploadException
     */
    public function saveNew(string $imageName, string $imageData, $session_id)
    {
        $storage = $this->getStorageDisk($type ='');
        $secureUploads = setting('app-secure-images');

        $imagePath = '/uploads/screenshots/' . $session_id . '/';

        while ($storage->exists($this->adjustPathForStorageDisk($imagePath . $imageName, $session_id))) {
            $imageName = Str::random(3) . $imageName;
        }

        $fullPath = $imagePath . $imageName;
        if ($secureUploads) {
            $fullPath = $imagePath . Str::random(16) . '-' . $imageName;
        }

        try {
            $this->saveImageDataInPublicSpace($storage, $this->adjustPathForStorageDisk($fullPath, $type), $imageData);
        } catch (Exception $e) {
            Log::error('Error when attempting image upload:' . $e->getMessage());

            throw new ImageUploadException(trans('errors.path_not_writable', ['filePath' => $fullPath]));
        }

        $imageDetails = [
            'name'        => $imageName,
            'path'        => $fullPath,
            'url'         => $this->getPublicUrl($fullPath),
            'type'        => $type,
            'uploaded_to' => 0,
        ];

        if (user()->id !== 0) {
            $userId = user()->id;
            $imageDetails['created_by'] = $userId;
            $imageDetails['updated_by'] = $userId;
        }

        $image = (new Image())->forceFill($imageDetails);
        $image->save();

        return $image;
    }

    protected function adjustPathForStorageDisk(string $path, string $imageType = ''): string
    {
        $path = Util::normalizePath(str_replace('uploads/screenshots/', '', $path));

        if ($this->usingSecureImages($imageType)) {
            return $path;
        }

        return 'uploads/screenshots/' . $path;
    }

    protected function usingSecureImages(string $imageType = 'gallery'): bool
    {
        return $this->getStorageDiskName($imageType) === 'local_secure_images';
    }

    protected function getStorageDisk(string $imageType = ''): Storage
    {
        return $this->fileSystem->disk($this->getStorageDiskName($imageType));
    }

    protected function getStorageDiskName(string $imageType): string
    {
        $storageType = config('filesystems.images');

        // Ensure system images (App logo) are uploaded to a public space
        if ($imageType === 'system' && $storageType === 'local_secure') {
            $storageType = 'local';
        }

        if ($storageType === 'local_secure' || $storageType === 'local_secure_restricted') {
            $storageType = 'local_secure_images';
        }

        return $storageType;
    }

    protected function saveImageDataInPublicSpace(Storage $storage, string $path, string $data)
    {
        $storage->put($path, $data);

        $usingS3 = strtolower(config('filesystems.images')) === 's3';
        $usingS3Like = $usingS3 && !is_null(config('filesystems.disks.s3.endpoint'));
        if (!$usingS3Like) {
            $storage->setVisibility($path, 'public');
        }
    }

    private function getPublicUrl(string $filePath): string
    {
        if (is_null($this->storageUrl)) {
            $storageUrl = config('filesystems.url');

            if ($storageUrl == false && config('filesystems.images') === 's3') {
                $storageDetails = config('filesystems.disks.s3');
                if (strpos($storageDetails['bucket'], '.') === false) {
                    $storageUrl = 'https://' . $storageDetails['bucket'] . '.s3.amazonaws.com';
                } else {
                    $storageUrl = 'https://s3-' . $storageDetails['region'] . '.amazonaws.com/' . $storageDetails['bucket'];
                }
            }

            $this->storageUrl = $storageUrl;
        }

        $basePath = ($this->storageUrl == false) ? url('/') : $this->storageUrl;

        return rtrim($basePath, '/') . $filePath;
    }

}
