@extends('layouts.simple')

@section('body')
    <div class="container pt-xl">
        <main class="card content-wrap">
            <h1 class="list-heading">User Sessions</h1>


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
                            Session Date
                          </th>
                          <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Session Start Time
                          </th>
                          <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            user name
                          </th>
                          <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            User Email
                          </th>
                          <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Session End Time
                          </th>
                          <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Action
                          </th>
                        </tr>
                      </thead>
                      @if(count($userAllSessions) > 0)
                              @foreach($userAllSessions as $index => $session)
                                 <tr>
                                   <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                       {{$session->id}}
                                    </th>
                                    <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                       {{$session->session_date}}
                                   </th>
                                   <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                    {{$session->session_start_time}}
                                   </th>
                                   <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                     {{$session->userSession->name}}
                                   </th>
                                   <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                     {{$session->userSession->email}}
                                   </th>
                                   <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                     {{$session->session_end_time}}
                                   </th>
                                   <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                     <button>
                                        <a href="{{ url('/session-screenshots/'.$session->id)  }}" class="card-footer-link">View Screenshots</a>
                                     </button>
                                   </th>
                                 </tr>
                              @endforeach
                          </div>
                      @else
                           <tr>
                             <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                              No Session available
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