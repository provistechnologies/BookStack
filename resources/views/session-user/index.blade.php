@extends('layouts.simple')

@section('body')
    <div class="container pt-xl">
        <main class="card content-wrap">
            <h1 class="list-heading">All Session Users</h1>


            <div class="flex flex-col">
              <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                  <div class="overflow-hidden">
                    <table class="min-w-full">
                      <thead class="border-b">
                        <tr>
                          <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            User Id
                          </th>
                          <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            user name
                          </th>
                          <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            User Email
                          </th>
                          <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                            Action
                          </th>
                        </tr>
                      </thead>
                      @if(count($sessionUsers) > 0)
                              @foreach($sessionUsers as $index => $sessionUser)
                                 <tr>
                                   <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                    {{$sessionUser->userSession->id}}
                                   </th>
                                   <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                     {{$sessionUser->userSession->name}}
                                   </th>
                                   <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                     {{$sessionUser->userSession->email}}
                                   </th>
                                   <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                     <button>
                                        <a href="{{ url('/user-sessions/'.$sessionUser->userSession->id)  }}" class="card-footer-link">View Sessions</a>
                                     </button>
                                   </th>
                                 </tr>
                              @endforeach
                          </div>
                      @else
                           <tr>
                             <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                              No user awailable
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