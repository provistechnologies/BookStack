@extends('layouts.simple')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@stop

@section('body')
    <div class="container pt-xl">
        <main class="card content-wrap">
            <h1 class="list-heading">User Session Tasks</h1>
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
              <div class="grid half">
                <form method="post" action="{{ url('/session-status-update/'.$sessionUser->id)  }}">
                    @csrf
                    <div class="form-group description-input">
                        <label for="comments">Comments</label>
                        @include('form.textarea', ['name' => 'comments', 'model' => $sessionUser])
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="1"
                                @if(isset($sessionUser) || old('status')) @if(old('status') && old('status') === '1') selected @elseif(isset($sessionUser) && $sessionUser->status === '1') selected @endif @endif>
                                Active
                            </option>
                            <option value="0"
                                @if(isset($sessionUser) || old('status')) @if(old('status') && old('status') === '0') selected @elseif(isset($sessionUser) && $sessionUser->status === '0') selected @endif @endif>
                                Not Active
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="button">Update Status</button>
                    </div>
                </form>
              </div>
            </div>

            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="overflow-hidden">
                            <table class="min-w-full">
                                <thead class="border-b">
                                    <tr>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                            Task
                                        </th>
                                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                            Total Time
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($sessionTasks) > 0)
                                        @php $totalMins = 0 @endphp
                                        @foreach($sessionTasks as $task => $minutes)
                                            <tr>
                                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                    {{$task}}
                                                </th>
                                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                    @php
                                                        $totalMins += $minutes;
                                                        $hours = floor($minutes / 60);
                                                        $minutes = $minutes % 60;
                                                    @endphp
                                                    {{$hours.'H '.$minutes.'M'}}
                                                </th>
                                            </tr>
                                        @endforeach
                                        @if($totalMins > 0)
                                            <tr>
                                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-right">
                                                    <strong>Total Time</strong>
                                                </th>
                                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                    @php
                                                        $hours = floor($totalMins / 60);
                                                        $minutes = $totalMins % 60;
                                                    @endphp
                                                    {{$hours.'H '.$minutes.'M'}}
                                                </th>
                                            </tr>
                                        @endif
                                    @else
                                        <tr>
                                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                                No Tasks available
                                            </th>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@stop
@section('scripts')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" nonce="{{ $cspNonce }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" nonce="{{ $cspNonce }}"></script>
@endsection