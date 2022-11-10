@extends('layouts.simple')

@section('body')
    <div class="container pt-xl">
        <main class="card content-wrap">
            <h1 class="list-heading">User Session Screenshots</h1>


            <div class="flex flex-col">
              <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                  <div class="overflow-hidden">
                    <table class="min-w-full">
                      <thead class="border-b">
                        <tr>
                          <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Session Id
                          </th>
                          <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Session Screenshot Time
                          </th>
                          <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Session Key Count
                          </th>
                          <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Session Screenshot
                          </th>
                        </tr>
                      </thead>
                      @if(count($sessionScreenshots) > 0)
                              @foreach($sessionScreenshots as $index => $screenshotData)
                                 <tr>
                                   <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                    {{$screenshotData->session_id}}
                                   </th>
                                   <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                    {{$screenshotData->screenshot_time}}
                                   </th>
                                   <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                    {{$screenshotData->key_count}}
                                   </th>
                                   <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                     <img height="200" width="200" src="{{asset($screenshotData->screenshot)}}" alt="">
                                   </th>
                                 </tr>
                              @endforeach
                          </div>
                      @else
                           <tr>
                             <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                              No Screenshots awailable
                             </th>
                           </tr>
                      @endif
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </main>
    </div>
@stop