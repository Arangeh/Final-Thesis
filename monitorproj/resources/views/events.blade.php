@extends('layouts.base')
@section('title','Events')

@section('content')
<div class="row">
		<div class="col-md-12">
			<div class="card">
						<div class="card-header row">
							<div class="col-md-6">All Events</div>
							<div class="col-md-6"><span class="pull-right"><a href="/event/delete-all" class="btn btn-danger">Delete All Events</a></span></div>
						</div>
						<table id="eventstable" class="table">
							<thead>
								<tr>
									<th>Event Time</th>
									<th>Description</th>
								</tr>
							</thead>
							<tbody>
								@foreach($events as $event)
								<tr>
									@if($event->type === 'datapath')
										<td>datapath</td>
										<td></td>
										
									@elseif($event->type === 'port')
										port
										<td>port</td>
										<td></td>
									@endif
								</tr>
								@endforeach
							</tbody>
						</table>
						<span>
							{{ $events->links()}}
						</span>
						<style>
							.w-5 {
								display: none
							}
						</style>
					</div>

		</div>
		
	</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
@endsection