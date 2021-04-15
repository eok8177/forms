@extends('layouts.user')

@section('content')

<div class="dashboard-area tabs-area">

    <h2>Outreach Services</h2>

    <div class="tab-content">
      <div class="container-fluid">
        <div class="btn-group">
          <label for="name" style="margin-top: .5rem; margin-right: 8px;">Schedule Ref</label>
          <input type="text" name="first_name" value="" class="form-control">
        </div>
        <div class="btn-group">
          <label for="name" style="margin-top: .5rem; margin-right: 8px;">Location</label>
          <input type="text" name="first_name" value="" class="form-control">
        </div>
        <div class="btn-group">
          <label >Organisation:</label>
          <select class="form-control">
            @foreach($organisations as $org)
            <option>{{$org}}</option>
            @endforeach
          </select>
        </div>
        <div class="btn-group">
          <label >Health Category:</label>
          <select class="form-control">
            @foreach($healthCategories as $cat)
            <option>{{$cat}}</option>
            @endforeach
          </select>
        </div>
        <div class="btn-group">
          <label >Year of contract:</label>
          <select class="form-control">
            <option>Financial Year 21-22</option>
          </select>
        </div>
        <button>Search</button>
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

      <div id="result-table"></div>

    </div>

      

      

      
      
      
      
    </div>
</div>

@endsection

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