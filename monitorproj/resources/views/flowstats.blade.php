<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Flow Statistics</title>
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
							<div class="col-md-6">All FlowStat Records</div>
							<div class="col-md-6"><span class="pull-right"><a href="/flowstat/delete-all" class="btn btn-danger">Delete All FlowStats</a></span></div>
						</div>
						<table id="flowstatstable" class="table">
							<thead>
								<tr>
									<th>Datapath</th>
									<th>In-Port</th>
									<th>Eth-Dst</th>
									<th>Out-Port</th>
									<th>Packets</th>
									<th>Bytes</th>
								</tr>
							</thead>
							<tbody>
								@foreach($flowstats as $flowstat)
								<tr>
									<td>{{$flowstat->datapath}}</td>
									<td>{{$flowstat->in_port}}</td>
									<td>{{$flowstat->eth_dst}}</td>
									<td>{{$flowstat->out_port}}</td>
									<td>{{$flowstat->packets}}</td>
									<td>{{$flowstat->bytes}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<span>
							{{ $flowstats->links()}}
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