@extends('layouts.simple')

@section('body')
    <div class="container pt-xl">
        <main class="card content-wrap">
            <h1 class="list-heading">All Sessions for Tracker</h1>

            <div class="py-s">
              <form id="filter-form" action="{{ url("/tracker-sessions") }}" method="get">
                <div class="grid half">
                  <div class="grid third">
                    <div class="">
                      <label for="name">Select user</label>
                      <select name="user_id">
                        <option value="">Select User</option>
                        @foreach ($users as $user)
                          <option value="{{$user->userSession->id}}" {{ !empty($filterData) ? $filterData->user_id == $user->userSession->id ? 'selected' : '' : ''}}>{{$user->userSession->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="basis-1/6">
                      <label for="fromDate">From Date : </label>
                      <input type="date" id="fromDate" name="from_date" value="{{ !empty($filterData) ? $filterData->from_date ? $filterData->from_date : '' : ''}}">
                    </div>
                    <div class="basis-1/6">
                      <label for="toDate">To Date : </label>
                      <input type="date" id="toDate" name="to_date" value="{{ !empty($filterData) ? $filterData->to_date ? $filterData->to_date : '' : ''}}" max="" min="">
                    </div>
                  </div>
                  
                  <div class="grid third">
                    <div class="basis-1/6">
                      <label for="">Search by keyword</label>
                      <input type="text" name="search_keyword" placeholder="Search" value="{{ !empty($filterData) ? $filterData->search_keyword ? $filterData->search_keyword : '' : ''}}">
                    </div>

                    <div class=" pt-m">
                      <input type="submit" class="button text-white px-lg" value="Search">
                    </div>
                    <input id="column-order" type="hidden" name="order" value="">
                    <input id="column-name" type="hidden" name="col_name" value="">
                    <div class="form-group text-right pt-m">
                      <a href="{{ URL::previous() }}" class="button text-white px-lg">Go Back</a>
                    </div>
                  </div>
                </div>
                <div>
                  <a href="{{ url('/tracker-sessions')  }}" class="card-footer-link">clear Filter</a>
                </div>
                <div class="flex flex-col">
                  <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                      <div class="overflow-hidden">
                        <table class="min-w-full">
                          <thead class="border-b">
                            <tr>
                              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                Sr No.
                              </th>
                              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                <button class="sort-column" id="session_date" data-order="{{$session_date_order == 'desc' ? 'asc' : 'desc'}}">Session Date</button>
                              </th>
                              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                <button class="sort-column" id="session_start_time" data-order="{{$start_time_order == 'desc' ? 'asc' : 'desc'}}" >Session Start Time</button>
                              </th>
                              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                <button class="sort-column" id="name" data-order="{{$name_order == 'desc' ? 'asc' : 'desc'}}">user name</button>
                              </th>
                              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                <button class="sort-column" id="email" data-order="{{$email_order == 'desc' ? 'asc' : 'desc'}}">User Email</button>
                              </th>
                              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                <button class="sort-column" id="session_end_time" data-order="{{$end_time_order == 'desc' ? 'asc' : 'desc'}}">Session End Time</button>
                              </th>
                              <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                Action
                              </th>
                            </tr>
                            
                          </thead>
                          @if(count($allSessions) > 0)
                              @foreach($allSessions as $index => $session)
                                 <tr>
                                   <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                       {{$index+1}}
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
                          @else
                               <tr>
                                 <th scope="col" colspan="7" class="text-sm font-medium text-gray-900 px-6 py-4 text-center">
                                  No Session available
                                 </th>
                               </tr>
                          @endif
                          <tbody>
                          </tbody>
                        </table>
                        <div class="text-right">
                          {!! $allSessions->links() !!}
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
@section('scripts')
<script nonce="{{ $cspNonce }}">
  
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth() + 1;
  var yyyy = today.getFullYear();
  today = yyyy + '-' + mm + '-' + dd;
  document.getElementById("toDate").setAttribute("max", today);
  document.getElementById("fromDate").setAttribute("max", today);
  let from_date = document.getElementById("fromDate");
  from_date.addEventListener("change", function(event) {
    console.log('okay');
    document.getElementById("toDate").setAttribute("min", this.value);
  });

  let filter_form = document.getElementById("filter-form");
  let formData = new FormData();
  let sort_by_start_time = document.getElementById("session_start_time");

  sort_by_start_time.addEventListener("click", function(event) {
    event.preventDefault()
    let start_time_col = this.getAttribute('id');
    let order = this.getAttribute("data-order");
    document.getElementById("column-order").value = order;
    document.getElementById("column-name").value = start_time_col;
    filter_form.submit();
  });

  let sort_by_date = document.getElementById("session_date");

  sort_by_date.addEventListener("click", function(event) {
    event.preventDefault()
    let session_date_col = this.getAttribute('id')
    let order = this.getAttribute("data-order");
    document.getElementById("column-order").value = order;
    document.getElementById("column-name").value = session_date_col;
    filter_form.submit();
  });

  let sort_by_name = document.getElementById("name");

  sort_by_name.addEventListener("click", function(event) {
    event.preventDefault()
    let name_col = this.getAttribute('id')
    let order = this.getAttribute("data-order");
    document.getElementById("column-order").value = order;
    document.getElementById("column-name").value = name_col;
    filter_form.submit();
  });

  let sort_by_email = document.getElementById("email");

  sort_by_email.addEventListener("click", function(event) {
    event.preventDefault()
    let email_col = this.getAttribute('id')
    let order = this.getAttribute("data-order");
    document.getElementById("column-order").value = order;
    document.getElementById("column-name").value = email_col;
    filter_form.submit();
  });

  let sort_by_end_time = document.getElementById("session_end_time");

  sort_by_end_time.addEventListener("click", function(event) {
    event.preventDefault()
    let end_time_col = this.getAttribute('id')
    let order = this.getAttribute("data-order");
    document.getElementById("column-order").value = order;
    document.getElementById("column-name").value = end_time_col;
    filter_form.submit();
  });
</script>
@endsection