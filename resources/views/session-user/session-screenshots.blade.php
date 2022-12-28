@extends('layouts.simple')

@section('head')
    <link rel="stylesheet" href="{{ versioned_asset('dist/css/lightgallery/lightgallery.bundle.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@stop

@section('body')
    <div class="container pt-xl">
        <main class="card content-wrap">
            <h1 class="list-heading">User Session Screenshots</h1>
            <div class="form-group text-right">
              <a href="{{ URL::previous() }}" class="button text-white px-lg">Go Back</a>
            </div>
            <div>
              <h4>
                <span>User Name : </span>
                <span>{{$sessionUser->userSession->name}}</span>
              </h4>
              <h4>
                <span>Session Date : </span>
                <span>{{$sessionUser->session_date}}</span>
              </h4>
            </div>

            <div class="flex flex-col">
              <div class="row">
                  <div class="col-xl-12">
                      <div id="panel-1" class="panel">
                          <div class="panel-container show">
                              <div class="panel-content">
                                  <div id="js-lightgallery">
                                    @if (count($sessionScreenshots) > 0)
                                    @foreach($sessionScreenshots as $index => $screenshotData)
                                      <a class="" href="{{asset($screenshotData->screenshot)}}" data-sub-html="{{$screenshotData->screenshot_time}} <br>Memo : {{$screenshotData->key_count}}">
                                          <img class="img-responsive" src="{{asset($screenshotData->screenshot)}}" alt="{{$screenshotData->screenshot_time}} (Memo : {{$screenshotData->key_count}})">
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" nonce="{{ $cspNonce }}"></script>
  <script src="{{ versioned_asset('dist/js/lightgallery/lightgallery.bundle.js') }}"  nonce="{{ $cspNonce }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" nonce="{{ $cspNonce }}"></script>
    
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