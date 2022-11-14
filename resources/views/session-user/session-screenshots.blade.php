@extends('layouts.simple')

@section('body')
    <div class="container pt-xl">
        <main class="card content-wrap">
            <h1 class="list-heading">User Session Screenshots</h1>


            <div class="flex flex-col">
              <div class="row">
                  <div class="col-xl-12">
                      <div id="panel-1" class="panel">
                          <div class="panel-container show">
                              <div class="panel-content">
                                  <div id="js-lightgallery">
                                    @if (count($sessionScreenshots) > 0)
                                    @foreach($sessionScreenshots as $index => $screenshotData)
                                      <a class="" href="{{asset($screenshotData->screenshot)}}" data-sub-html="{{$screenshotData->screenshot_time}} <br>Key Count : {{$screenshotData->key_count}}">
                                          <img class="img-responsive" src="{{asset($screenshotData->screenshot)}}" alt="{{$screenshotData->screenshot_time}}">
                                      </a>
                                    @endforeach
                                    @else
                                    <h3 class="text-center">No Screenshots available</h3>
                                    @endif
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>


            </div>
        </main>
    </div>
@stop
@section('scripts')
<script nonce="{{ $cspNonce }}">
    $(document).ready(function()
    {
        var $initScope = $('#js-lightgallery');
        if ($initScope.length)
        {
            $initScope.justifiedGallery(
            {
                border: -1,
                rowHeight: 150,
                margins: 8,
                waitThumbnailsLoad: true,
                randomize: false,
            }).on('jg.complete', function()
            {
                $initScope.lightGallery(
                {
                    thumbnail: true,
                    animateThumb: true,
                    showThumbByDefault: true,
                });
            });
        };
        $initScope.on('onAfterOpen.lg', function(event)
        {
            $('body').addClass("overflow-hidden");
        });
        $initScope.on('onCloseAfter.lg', function(event)
        {
            $('body').removeClass("overflow-hidden");
        });
    });
</script>
@endsection