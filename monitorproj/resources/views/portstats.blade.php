@extends('layouts.base')
@section('title','Port Statistics')

@section('content')
<div class="row">
		<div class="col-md-12">
			<div class="card">
						<div class="card-header row">

							<div class="col-md-6">All PortStat Records</div>
							<div class="col-md-6"><span class="pull-right"><a href="/portstat/delete-all" class="btn btn-danger">Delete All PortStats</a>
								</span></div>
						</div>
						
						<table id="portstatstable" class="table" >
							<thead>
								<tr>
									<th>Datapath</th>
									<th>Port</th>
									<th>Rx-Packets</th>
									<th>Rx-Bytes</th>
									<th>Tx-Packets</th>
									<th>Tx-Bytes</th>
									<th>Tx-Error</th>
									<th>Rx-Error</th>
								</tr>
							</thead>
							<tbody>
								@foreach($portstats as $portstat)
								<tr>
									<td>{{$portstat->datapath}}</td>
									<td>{{$portstat->port}}</td>
									<td>{{$portstat->rx_pkts}}</td>
									<td>{{$portstat->rx_bytes}}</td>
									<td>{{$portstat->tx_pkts}}</td>
									<td>{{$portstat->tx_bytes}}</td>
									<td>{{$portstat->tx_error}}</td>
									<td>{{!! nl2br($portstat->rx_error) !!}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<span>
							{{ $portstats->links()}}
						</span>
						<style>
							.w-5 {
								display: none
							}
						</style>
						{{--@foreach ($portstats as $portstat)
							{{ $portstat->rx_error }}
							<br/>
						@endforeach--}}
					</div>

		</div>
		
	</div>
@endsection