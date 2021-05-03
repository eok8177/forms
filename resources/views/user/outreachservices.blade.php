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
        <button id="filterServices">Filter</button>
      </div>

      <div id="result-table-services"></div>

<p>&nbsp;</p>

      <p>Visits related to schedule ref: <strong><span id="spanScheduleRef">A1</span></strong></p>
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
      <button id="filterVisits">Filter</button>


      <div id="result-table-visits"></div>

    </div>

    </div>
</div>

@endsection

@push('styles')
<style>
#outreach-services label {
    font-size: 14px;
    margin-top: .5rem; 
    margin-right: 8px;
}
#outreach-services input[type=text] {
    width: 120px;
}
#outreach-services ul.navigation {
    display: flex;
    justify-content: space-between;
    list-style-type: none;
    padding-left: 0;
}
#outreach-services ul.navigation li {
    flex: 1 1 0;
}
#outreach-services ul.navigation li.center {
    text-align: center;
}
#outreach-services ul.navigation li.bold {
    font-weight: bold;
}
#outreach-services ul.navigation li.right {
    text-align: right;
}
</style>
@endpush

@push('scripts')
<script>
  var filterServices = {};
  var filterVisits = {};
  var ref = false;

  /* Filter Services */

  window.getServices = async function(item) {
    ref = item;
    filter = {};
    await axios.post('{{route('user.outreachservices')}}', {
        filter: filterServices
    }, {
        headers: {'Content-Type': 'application/json',}
    }).then(response => {
        $('#result-table-services').html(response.data);
    }).catch(error => console.error(error));
  };


  $('#filterServices').on('click', function() {
    filterServices['scheduleRef'] = $('#scheduleRef').val();
    filterServices['location'] = $('#location').val();
    filterServices['organisation'] = $('#organisation').val();
    filterServices['healthCategory'] = $('#healthCategory').val();
    filterServices['yearOfContract'] = $('#yearOfContract').val();
    // getServices();
    loadFirstTable();
  });

  /* Filter Visits*/

  window.getAllVisits = function(item) {
    filterVisits = {};
    getVisits(item);
  };

  window.getVisits = function(item) {
    ref = item;
    axios.post('{{route('user.outreachservicevisits')}}', {
        ref: item,
        filter: filterVisits
    }, {
        headers: {'Content-Type': 'application/json',}
    }).then(response => {
        $('#result-table-visits').html(response.data);
        $('#spanScheduleRef').html(item);
    }).catch(error => console.error(error));
  };

  $('#filterVisits').on('click', function() {
    filterVisits['visitStatus'] = $('#visitStatus').val();
    filterVisits['methodOfDelivery'] = $('#methodOfDelivery').val();
    filterVisits['visitDateFrom'] = $('#visitDateFrom').val();
    filterVisits['visitDateTo'] = $('#visitDateTo').val();
    getVisits(ref);
  });

  window.loadFirstTable = async function() {
    await getServices();
    window.requestAnimationFrame(() => {
      let firstItem = $('#result-table-services tbody tr:first td:first').text();
      getVisits(firstItem);
    });

  }

  $('#visitDateFrom').datepicker({
    dateFormat: 'yy-mm-dd'
  });

  $('#visitDateTo').datepicker({
    dateFormat: 'yy-mm-dd'
  });

  loadFirstTable();
</script>
@endpush