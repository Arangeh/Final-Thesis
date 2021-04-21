@extends('layouts.base')
@section('title','Main Page')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				{{-- <div class="card-header">
					Card Header
				</div> --}}
				<div class="card-body">
					{{-- Card Body --}}
					{{-- content goes here
					SIUUU	 --}}
					<h1>Welcome to Admin Panel for the Monitor Project</h1>
					This is the main page. 
					<br/>
					A brief description of each page is provided below:
					<br/>
					<hr/>
					<b>CAPABILITIES:</b>
					<br/>
					<hr/>
					<b>EVENTS:</b>
					<br/>
					<hr/>
					<b>PORT STATISTICAL INFORMATION:</b> Contains statistical information on a per-port basis.
					<br/>
					Port properties from which these statistical information is extracted are as follows
					<ul>
							<li>rx_pkts</li>
							<li>rx_bytes</li>
							<li>tx_pkts</li>
							<li>tx_bytes</li>
							<li>rx_error</li>
							<li>tx_error</li>
					</ul>
					For each of these properties, the following statistical functions are applied
					<ul>
						<li>Max</li>
						<li>Min</li>
						<li>Standard Deviation</li>
						<li>Mean</li>
					</ul>	
					<br/>
					Note that you <i><b>"need"</b></i> to specify <i><u>datapath</u></i> and <i><u>port</u></i> at first hand; in order to see statistical information about ports in a tabular format. 
					<br/>
					<hr/>
					<b>FLOW STATISTICAL INFORMATION:</b> contains statistical information on a per-flow basis.
					<br/>
					Port properties from which these statistical information is extracted are as follows
					<ul>
							<li>packets</li>
							<li>bytes</li>
					</ul>
					For each of these properties, the following statistical functions are applied
					<ul>
						<li>Max</li>
						<li>Min</li>
						<li>Standard Deviation</li>
						<li>Mean</li>
					</ul>	
					<br/>
					Note that you <i><b>"need"</b></i> to specify <i><u>datapath</u></i>, <i><u>in_port</u></i>, <i><u>eth_dst</u></i> and <i><u>out_port</u></i> for seeing statistical information about flows. Otherwise, nothing will be output.
					<br/>
					<hr/>
					<b>CONFIGURATION:</b>
					<br/>
					<b>PORT STATS:</b> Port-related statistical information; collected from each and every whitebox switch that is connected to the controller. It's shown in a tabular format whose columns are:
					<ul>
						<li>datapath (id of the whitebox switch)</li>
						<li>port (a port from the determined whitebox switch for which we want to get statistical information)</li>
						<li>rx_pkts (number of packets that are received from this port)</li>
						<li>rx_bytes (number of bytes that are received from this port)</li>
						<li>tx_pkts (number of packets that are transmitted to this port)</li>
						<li>tx_bytes (number of bytes that are transmitted to this port)</li>
						<li>rx_error (number of errors occured while receiving from this port)</li>
						<li>tx_error (number of errors occurd while transmitting to this port)</li>
					</ul>
					<br/>
					<hr/>
					<b>FLOW STATS:</b> Statistical information related to flow entry. It's shown in a tabular format whose columns are: 
					<ul>
						<li>datapath (id of the whitebox switch)</li>
						<li>eth_dst (destination ethernet address)</li>
						<li>out_port (port to which packet is transmitted in order to make a trip to its destination)</li>
						<li>in_port (port from which packet is received)</li>
						<li>packets (number of packets that belong to this flow)</li>
						<li>bytes (number of bytes that belong to this flow)</li>	
					</ul>
					
					<br/>
					<hr/>
					<b>CONNECTED DEVICES:</b>	
				</div>
			</div>
		</div>
		
	</div>
@endsection