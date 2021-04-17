@extends('layouts.user')

@section('content')

<div class="dashboard-area tabs-area">

    <h2>Outreach Services</h2>

    <div class="tab-content" id="outreach-services">
      <div class="container-fluid">
        <div class="btn-group group">
          <label for="name">Schedule Ref</label>
          <input type="text" name="first_name" value="" class="form-control">
        </div>
        <div class="btn-group">
          <label for="name" style="margin-top: .5rem; margin-right: 8px;">Location</label>
          <input type="text" name="first_name" value="" class="form-control">
        </div>
        <div class="btn-group">
          <label >Organisation:</label>
          <select id="organisation" name="organisation" class="form-control">
            @foreach($organisations as $key)
            <option value="{{$key->ORG_ID}}">{{$key->ORG_NAME}}</option>
            @endforeach
          </select>
        </div>
        <div class="btn-group">
          <label >Health Category:</label>
          <select id="healthCategory" name="healthCategory" class="form-control">
            @foreach($healthCategories as $key)
            <option value="{{$key->SpecialityRef}}">{{$key->SpecialityName}}</option>
            @endforeach
          </select>
        </div>
        <div class="btn-group">
          <label >Year of contract:</label>
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
        @foreach($outreachServices as $key => $service) 
        <tr onclick="getData({{$key}})">
          <td>{{$service->ref}}</td>
          <td>{{$service->location}}</td>
          <td>{{$service->organisation}}</td>
          <td>{{$service->healthCategory}}</td>
          <td>{{$service->totalVisits}}</td>
          <td>{{$service->visitsRemaining}}</td>
        </tr>
        @endforeach
      </table>



      <p>Visits related to schedule ref: <strong>A1</strong></p>
      <div class="btn-group">
        <label>Visit status</label>
        <select class="form-control">
        <option value="-1">All</option>
          <option>Accepted</option>
          <option>Under Review</option>
          <option>Draft</option>
          <option>Ready to submit</option>
          <option>Action Needed</option>
        </select>
      </div>
      <div class="btn-group">
        <label>Method of Delivery</label>
        <select class="form-control"><option value="-1">All</option><option value="0">Offsite</option><option value="1">Onsite</option></select>
      </div>
      <div class="btn-group">
        <label>Visit date From</label>
        <input type="text" value="2020-07-01" />
      </div>
      <div class="btn-group">
        <label>To</label>
        <input type="text" value="2021-06-31" />
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
    axios.post('{{route('user.outreachservicedetails')}}', {
        item: item
    }, {
        headers: {'Content-Type': 'application/json',}
    }).then(response => {
        $('#result-table').html(response.data);
    }).catch(error => {
        console.error(error);
    });

  }
</script>
@endpush