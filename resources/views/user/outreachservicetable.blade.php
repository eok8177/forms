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
@foreach($outreachServices[0] as $key) 
<tr>
  <td>{{$key->ActivityRef}}</td>
  <td>{{$key->VisitReportStatus}}</td>
  <td>{{$key->DeliveryMode}}</td>
  <td>{{ \Carbon\Carbon::parse($key->DateFrom)->format('Y-m-d') }}</td>
  <td>{{$key->SubmittedDate}}</td>
  <td>{{$key->Submitter}}</td>
  <td></td>
</tr>
@endforeach
</table>

<div>
  <ul class="navigation">
    <li>
    @if ($outreachServices[1][0]->FromRecord > 1)
    <a href="#"><< Previous</a>
    @endif
    </li>
    <li class="center bold">Showing {{$outreachServices[1][0]->FromRecord}}-{{$outreachServices[1][0]->ToRecord}} of {{$outreachServices[1][0]->TotalRecords}} services</li>
    <li class="right">
    @if ($outreachServices[1][0]->HasNextPage == 1)
      <a href="#">Next >></a>
    @endif
    </li>
  </ul>
</div>