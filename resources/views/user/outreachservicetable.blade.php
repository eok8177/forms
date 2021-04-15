
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
        <td>{{$outreachServices['visitRef']}}</td>
        <td>{{$outreachServices['visitStatus']}}</td>
        <td>{{$outreachServices['visitMethodOfDelivery']}}</td>
        <td>{{$outreachServices['visitDate']}}</td>
        <td>{{$outreachServices['visitSubmittedDate']}}</td>
        <td>{{$outreachServices['visitSubmitter']}}</td>
        <td>{{$outreachServices['Accepted']}}</td>
      </tr>
      </table>


