@extends('layouts.simple')

@section('body')
    <div class="container pt-xl">
        <main class="card content-wrap">
            <h1 class="list-heading">All Session's Tasks for Tracker</h1>

            <div class="py-s">
              <form id="filter-form" action="{{ url("/session-tasks") }}" method="get">
                <div class="grid half">
                  <div class="{{user()->can('session-view-all') ? 'grid third' : 'grid half'}}">
                    @if (user()->can('session-view-all'))
                    <div class="">
                      <label for="name">Select user</label>
                      <select name="user_id">
                        <option value="">Select User</option>
                        @foreach ($usersRepo->getUsers() as $user)
                        @if(isset($user->userSession))
                        <option value="{{$user->userSession->id}}" {{ !empty($filterData) ? $filterData->user_id == $user->userSession->id ? 'selected' : '' : ''}}>{{$user->userSession->name}}</option>
                        @endif
                        @endforeach
                      </select>
                    </div>
                    @endif
                    <div class="basis-1/6">
                      <label for="fromDate">From Date : </label>
                      <input type="date" class="input-date" id="fromDate" name="from_date" value="{{ !empty($filterData) ? $filterData->from_date ? $filterData->from_date : '' : ''}}">
                    </div>
                    <div class="basis-1/6">
                      <label for="toDate">To Date : </label>
                      <input type="date" class="input-date" id="toDate" name="to_date" value="{{ !empty($filterData) ? $filterData->to_date ? $filterData->to_date : '' : ''}}" max="" min="">
                    </div>
                  </div>
                  
                  <div class="grid third">

                    <div class=" pt-m">
                      <input type="submit" class="button text-white px-lg" value="Search">
                    </div>
                    @if (!empty($filterData->user_id) || !empty($filterData->from_date) || !empty($filterData->to_date))
                    <div class="form-group text-right pt-m">
                      <a href="{{ url('/session-tasks')  }}" class="button outline text-white px-lg">Clear filter</a>
                    </div>
                    @endif
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
                                  Date
                              </th>
                              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                  Task
                              </th>
                              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                  Time
                              </th>
                            </tr>
                            
                          </thead>
                          @if(count($allSessions) > 0)
                          @php
                              $totalMins = 0;
                            //   $sessionTasks = $usersRepo->getTasksBySessionId(strval($session->id));
                          @endphp
                              @foreach($allSessions as $index => $session)
                              @php
                                  $sessionTasks = $usersRepo->getTasksBySessionId(strval($session->id));
                              @endphp
                              @foreach ($sessionTasks['sessionTasks'] as $task => $minutes)
                                 <tr>
                                     @if ($loop->index == 0)
                                       <th scope="col" rowspan="{{count($sessionTasks['sessionTasks'])}}" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                       {{$session->session_date}}
                                       </th>  
                                     @endif
                                   
                                   <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                      {{$task}}
                                   </th>
                                   <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                       @php
                                            // $totalMins = 0;
                                            $totalMins += $minutes;
                                            $hours = floor($minutes / 60);
                                            $minutes = $minutes % 60;
                                        @endphp
                                        {{$hours.'H '.$minutes.'M'}}
                                   </th>
                                   
                                 </tr>
                                 @endforeach
                              @endforeach
                              
                              @if($totalMins > 0)
                                  <tr>
                                      <th scope="col" colspan="2" class="text-sm font-medium text-gray-900 px-6 py-4 text-center">
                                          <strong>Total Time</strong>
                                      </th>
                                      <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-center">
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
                                 <th scope="col" colspan="3" class="text-sm font-medium text-gray-900 px-6 py-4 text-center">
                                  Not available any tasks
                                 </th>
                               </tr>
                          @endif
                          <tbody>
                          </tbody>
                        </table>
                        <div class="text-right">
                          {!! count($allSessions) > 0 ? $allSessions->withQueryString()->links() : '' !!}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
        </main>
    </div>
@stop