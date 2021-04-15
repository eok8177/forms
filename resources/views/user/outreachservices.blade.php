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
        @foreach($outreachServices as $service) 
        <tr>
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
       <table class="table table-hover">
      <thead>
      <tr>
      <th>Visit Ref</th>
      <th>Status</th>
      <th>Method of Delivery</th>
      <th>Visit Date</th>
      <th>Submitted Date</th>
      <th>Submitter</th>
      <th>Action</th>
      </tr>
      </thead>
      <tr>
        <td>visitRef</td>
        <td>visitStatus</td>
        <td>visitMethodOfDelivery</td>
        <td>visitDate</td>
        <td>visitSubmittedDate</td>
        <td>visitSubmitter</td>
        <td>Accepted</td>
      </tr>
      </table>
    </div>

      

      
      

      
      
      
      
    </div>
</div>

@endsection