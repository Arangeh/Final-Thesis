@extends('layouts.base')
@section('title','Connected Devices')

@section('content')

	<div class="card" style="width: 18rem;">
  
		<div class="card-body">
			<h5 class="card-title">VM-A</h5>
			<p class="card-text">	
				<b>IP Address:</b> 192.168.1.101
			</p>
			<p class="card-text">
				<b>MAC Address:</b> 08:00:27:a8:d8:19
			</p>
			<p class="card-text">
				<b>Average TX packets:</b> 87
			</p>
			<p class = "card-text">
				<b>Average RX Packets:</b> 66
			</p>
			<p class = "card-text">
				<b>Connected To:</b> mybridge
			</p>
		</div>
	</div>
	<div class="card" style="width: 18rem;">	
		<div class="card-body">
			<h5 class="card-title">VM-B</h5>
			<p class="card-text">	
				<b>IP Address:</b> 192.168.1.100
			</p>
			<p class="card-text">
				<b>MAC Address:</b> 08:00:27:65:46:f4
			</p>
			<p class="card-text">
				<b>Average TX Packets:</b> 76
			</p>
			<p class = "card-text">
				<b>Average RX Packets:</b> 59
			</p>
			<p class = "card-text">
				<b>Connected To:</b> mybridge
			</p>
		</div>
	</div>
@endsection