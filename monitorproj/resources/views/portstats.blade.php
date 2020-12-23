<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Port Statistics</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
	<section>
		<div class=" container">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header row">
							<div class="col-md-6">All PortStat Records</div>
							<div class="col-md-6"><span class="pull-right"><a href="/portstat/delete-all" class="btn btn-danger">Delete All PortStats</a>
								</span></div>
						</div>
						<table id="portstatstable" class="table">
							<thead>
								<tr>
									<th>Datapath</th>
									<th>Port</th>
									<th>Rx-Packets</th>
									<th>Rx-Bytes</th>
									<th>Tx-Packets</th>
									<th>Tx-Bytes</th>
									<th>Tx-Error</th>
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
					</div>
				</div>
			</div>
		</div>
	</section>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
	<script>
		$(document).ready(
			function() {
				setInterval(function() {
					location.reload();
				}, 5000); //Delay here = 5 seconds
			});
	</script>
</body>

</html>