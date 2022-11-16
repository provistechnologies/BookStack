<?php

namespace BookStack\Uploads;

use BookStack\Exceptions\FileUploadException;
use Illuminate\Contracts\Filesystem\Filesystem as Storage;
use Illuminate\Filesystem\FilesystemManager;

use BookStack\Exceptions\ImageUploadException;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
    public function saveScreenshot(UploadedFile $uploadedFile, $session_id)
    {
        return $this->putFileInStorage($uploadedFile, $session_id);
    }

    protected function putFileInStorage(UploadedFile $uploadedFile, $session_id): string
    {
        $storage = $this->getStorageDisk();
        $imagePath = '/uploads/screenshots/' . $session_id;
        try {
            $path = $storage->put($imagePath, $uploadedFile);
            return $path;
        } catch (Exception $e) {
            Log::error('Error when attempting file upload:' . $e->getMessage());
            throw new FileUploadException(trans('errors.path_not_writable', ['filePath' => $imagePath]));
        }
    }

    /**
     * Get the storage that will be used for storing files.
     */
    protected function getStorageDisk(): Storage
    {
        return $this->fileSystem->disk(config('filesystems.screenshots'));
    }
}