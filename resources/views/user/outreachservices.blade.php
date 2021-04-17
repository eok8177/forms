@extends('layouts.user')

@section('content')

<div class="dashboard-area tabs-area">

    <h2>Outreach Services</h2>

    <div class="tab-content" id="outreach-services">
      <div class="container-fluid">
        <div class="btn-group group">
          <label for="scheduleRef">Schedule Ref</label>
          <input type="text" id="scheduleRef" name="scheduleRef" value="" class="form-control">
        </div>
        <div class="btn-group">
          <label for="location">Location</label>
          <input type="text" id="location" name="location" value="" class="form-control">
        </div>
        <div class="btn-group">
          <label for="organisation">Organisation:</label>
          <select id="organisation" name="organisation" class="form-control">
            @foreach($organisations as $key)
            <option value="{{$key->ORG_ID}}">{{$key->ORG_NAME}}</option>
            @endforeach
          </select>
        </div>
        <div class="btn-group">
          <label for="healthCategory">Health Category:</label>
          <select id="healthCategory" name="healthCategory" class="form-control">
            @foreach($healthCategories as $key)
            <option value="{{$key->SpecialityRef}}">{{$key->SpecialityName}}</option>
            @endforeach
          </select>
        </div>
        <div class="btn-group">
          <label for="yearOfContract">Year of contract:</label>
          <select id="yearOfContract" name="yearOfContract" class="form-control">
            <option value="2021-2022">Financial Year 21-22</option>
          </select>
        </div>
        <button>Filter</button>
      </div>
      <table class="table table-hover">
        <thead>
        <tr>
        <th>Schedule Ref</th>
        <th>Location</th>
        <th>Organisation</th>
        <th>Health Category</th>
        <th>Total Visits</th>
        <th>Visits remaining</th>
        </tr>
        </thead>
        @foreach($outreachServices[0] as $key) 
        <tr onclick="getData({{$key->ServiceRef}})">
          <td>{{$key->ServiceRef}}</td>
          <td>{{$key->TownSuburb}}</td>
          <td>{{$key->ORG_NAME}}</td>
          <td>{{$key->HealthCategory}}</td>
          <td>{{$key->countVisit}}</td>
          <td>{{$key->countVisit_Remaining}}</td>
        </tr>
        @endforeach
      </table>

@if ($outreachServices[1][0]->FromRecord > 1)
<< Previous
@endif

Showing {{$outreachServices[1][0]->FromRecord}}-{{$outreachServices[1][0]->ToRecord}} of {{$outreachServices[1][0]->TotalRecords}} services

@if ($outreachServices[1][0]->HasNextPage == 1)
Next >>
@endif

<p>&nbsp;</p>

      <p>Visits related to schedule ref: <strong>A1</strong></p>
      <div class="btn-group">
        <label for="visitStatus">Visit status</label>
        <select id="visitStatus" name="visitStatus" class="form-control">
        <option value="-1">All</option>
          <option value="accepted">Accepted</option>
          <option value="underReview">Under Review</option>
          <option value="draft">Draft</option>
          <option value="readyToSubmit">Ready to submit</option>
          <option value="actionNeeded">Action Needed</option>
        </select>
      </div>
      <div class="btn-group">
        <label for="methodOfDelivery">Method of Delivery</label>
        <select id="methodOfDelivery" name="methodOfDelivery" class="form-control">
            <option value="-1">All</option>
            <option value="0">Offsite</option>
            <option value="1">Onsite</option>
        </select>
      </div>
      <div class="btn-group">
        <label for="visitDateFrom">Visit date From</label>
        <input type="text" id="visitDateFrom" name="visitDateFrom" value="2020-07-01" />
      </div>
      <div class="btn-group">
        <label for="visitDateTo">To</label>
        <input type="text" id="visitDateTo" name="visitDateTo" value="2021-06-31" />
      </div>
      <button>Filter</button>


      <div id="result-table"></div>

    </div>

      

      

      
      
      
      
    </div>
</div>

@endsection

@push('styles')
<style>
#outreach-services label {
    font-size: 14px;
    margin-top: .5rem; margin-right: 8px;
}
#outreach-services input[type=text] {
    width: 120px;
}
</style>
@endpush

@push('scripts')
<script>
  window.getData = function(item) {
    console.log(item);
    axios.post('{{route('user.outreachservicevisits')}}', {
        item: item
    }, {
        headers: {'Content-Type': 'application/json',}
    }).then(response => {
    console.log(response.data);
        $('#result-table').html(response.data);
    }).catch(error => {
        console.error(error);
    });

  }
</script>
@endpush