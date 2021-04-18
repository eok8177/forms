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
  @foreach($data as $item) 
  <tr onclick="getAllVisits({{$item->ServiceRef}})">
    <td>{{$item->ServiceRef}}</td>
    <td>{{$item->TownSuburb}}</td>
    <td>{{$item->ORG_NAME}}</td>
    <td>{{$item->HealthCategory}}</td>
    <td>{{$item->countVisit}}</td>
    <td>{{$item->countVisit_Remaining}}</td>
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

