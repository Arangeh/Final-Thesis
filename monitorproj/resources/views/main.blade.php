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
					<h1>Welcome to Admin Panel of the Monitor Project</h1>
					This is the main page. 
					<br/>
					A brief description of each page is provided below:
					<br/>
					<hr/>
					<b>CAPABILITIES-CONFIGURATIONS:</b> Capabilities refers to abilities/limitations of an abstraction collected in read only format. Configurations refers to the configured state of the application which can be in readable or writable format. 
					<br/>	
					The capabilities and configurations for each switch are as follows:
					<ul>
						<li>
							switch ports description:
							<ul>
								<li>Datapath (datapath id whose port is described)</li>
								<li>Port No (port number)</li>
								<li>Hw Address (Ethernet hardware address a.k.a. MAC)</li>
								<li>Name (name of port)</li>
								<li>Current Speed (current port bitrate in kbps)</li>
								<li>Configuration (port configuration flags)</li>
								<li>State (port state flags)</li>
							</ul>
						</li>
						<li>switch flows:
							<ul>
								<li>Priority (priority of the entry)</li>
								<li>Cookie (opaque controller-issued identifier)</li>
								<li>Hard Timeout (number of seconds before expiration)</li>
								<li>Duration Sec (time flow has been alive in seconds)</li>
								<li>Packet Count (number of packets in flow)</li>
								<li>Actions (instruction set to be applied on the flow)</li>
								<li>In-Port (input port for matching)</li>
								<li>Dl-Dst (ethernet destination addresss for matching)</li>
								<li>Table ID (table ID)</li>
							</ul>
						</li>
						<li>
							switch active tables: tables from the switch having at least one active entry:
							<ul>
								<li>Table ID</li>
								<li>Active Count (number of active entries)</li>
								<li>Lookup Count (number of packets looked up in the table)</li>
								<li>Matched Count (number of packets that hit table)</li>
							</ul>
						</li>
						<li>switch description and features:
							<ul>
								<li>Manufacturer</li>
								<li>Hardware Description</li>
								<li>Software Description</li>
								<li>Buffer Max (max packets buffered at once)</li>
								<li>Number of Tables</li>
								<li>Capabilities</li>
							</ul>
						</li>
					</ul>
					<br/>
					
					<hr/>
					<b>EVENTS:</b> A log of events that is kept in the project database. For simplicity we have only kept those logs that are concerned to registering/unregistering a new whitebox switch or altering the state of a port from a whitebox switch. Note that the whitebox switch should be connected to the controller. Otherwise no event will be triggered to the controller hence nothing will be tracked. 
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
					<b>CONNECTED DEVICES:</b>	A grid view of the devices that are connected to whitebox switches whose states are tracked by the monitor. This is done by customizing LLDP which serves as a topology discovery protocol in traditional networks. Attributes for each connected device are as follows:
					<ul>
						<li>Device Name</li>
						<li>IP Address</li>
						<li>MAC Address</li>
						<li>Average TX Packets (Average number of packets on TX side)</li>
						<li>Average RX Packets (Average number of packets on RX side)</li>
						<li>Connected To (Name of the whitebox switch to whom this device is connected)</li>
					</ul>
				</div>
			</div>
		</div>
		
	</div>
@endsection