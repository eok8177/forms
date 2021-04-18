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
@foreach($data as $item) 
<tr>
  <td>{{$item->ActivityRef}}</td>
  <td>{{$item->VisitReportStatus}}</td>
  <td>{{$item->DeliveryMode}}</td>
  <td>{{ \Carbon\Carbon::parse($item->DateFrom)->format('Y-m-d') }}</td>
  <td>{{$item->SubmittedDate}}</td>
  <td>{{$item->Submitter}}</td>
  <td></td>
</tr>
@endforeach
</table>

<div>
  <ul class="navigation">
    <li>
    @if ($pagination[0]->FromRecord > 1)
    <a href="#"><< Previous</a>
    @endif
    </li>
    <li class="center bold">Showing {{$pagination[0]->FromRecord}}-{{$pagination[0]->ToRecord}} of {{$pagination[0]->TotalRecords}} services</li>
    <li class="right">
    @if ($pagination[0]->HasNextPage == 1)
      <a href="#">Next >></a>
    @endif
    </li>
  </ul>
</div>