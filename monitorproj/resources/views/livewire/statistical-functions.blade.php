<div>
	<form action="" method="POST" enctype="multipart/form-data" form-horizontal>
		<div class="card-header row">
			<div class="col-md-6">	
				<b>Caveat:</b> Each time the page loads, you can only see the statistical information for only one branch of cascading dropdown menus. If you have altered some dropdown menu whereas you want to see statistical information for another branch, then you should click on the "Refresh" button first.  	
			</div>
			<div class="col-md-6"><span class="pull-right"><a href="/statistics" class="btn btn-danger">Refresh</a></span></div>
			
		</div>

		<div class="col-md-12"><b>Port-Related Info:</b> Select the <i><u>datapath</u></i> and <i><u>port</u></i> to collect statistical information in tabular format.
							</div>
    {{ csrf_field() }}
    {{-- Datapath Selection --}}
		
		<div class="card-body">
      <div class="form-group">
        <div class="col-sm-10">
          <label for="siu">Select Datapath</label>
          <select class="form-control" wire:model="selectedPortDP">
            <option value="">Datapath</option>
            @foreach ($uniqueDP as $portstat)
            <option value="{{ $portstat->datapath }}">{{ $portstat->datapath }} </option>
            @endforeach
          </select>
        </div>
      </div>
			{{-- Port Selection --}}
      @if (!is_null($ports))
      <div class="form-group">
        <div class="col-sm-10">
          <label for="stiatus">Select a Port</label>
          <select class="form-control" wire:model="selectedPort" wire:ignore>
            <option value="">Port</option>
            @foreach ($ports as $prt)
            <option value="{{ $prt->port }}">
							{{ $prt->port }}
						</option>
            
						@endforeach
          </select>
        </div>
      </div>
      @endif

			{{-- {{ $partialPortstats }}	 --}}
			{{-- AVERAGE: {{ $avg_tx_pkts }} --}}
			{{-- SIUU
			<br/>
      Ports: {{ $ports }}
			<br/>
			Portstats: {{ $portstats }}
			<br/>
			{{ $selectedPort }}
			<br/>
			 --}}
			@if(! is_null($partialPortstats))
				<table id="portstatistical" class="table">
				<thead>
					<tr>
						<th>Field Name</th>
						<th>Min</th>
						<th>Max</th>
						<th>Mean</th>
						<th>Standard Deviation</th>
					</tr>
				</thead>
				<tbody>
					{{-- @foreach($flowstats as $flowstat) --}}
					<tr>
						<td>rx_pkts</td>
						<td>{{ $rx_pkts_min }}</td><!--Min-->
						<td>{{ $rx_pkts_max }}</td><!--Max-->
						<td>{{ $rx_pkts_avg }}</td><!--Mean-->
						<td>
							@if(! is_null($rx_pkts_std))
							@foreach($rx_pkts_std as $item)
							{{-- {{ $tx_pkts_std->kos}} --}}
							{{ $item->std }}
							@endforeach
							@endif	
						</td><!--Standard Deviation-->
						{{-- <td>{{$flowstat->packets}}</td>
						<td>{{$flowstat->bytes}}</td> --}}
					</tr>
					<tr>
						<td>rx_bytes</td>
						<td>{{ $rx_bytes_min }}</td><!--Min-->
						<td>{{ $rx_bytes_max }}</td><!--Max-->
						<td>{{ $rx_bytes_avg }}</td><!--Mean-->
						<td>
							@if(! is_null($rx_bytes_std))
							@foreach($rx_bytes_std as $item)
							{{-- {{ $tx_pkts_std->kos}} --}}
							{{ $item->std }}
							@endforeach
							@endif	
						</td><!--Standard Deviation-->
						{{-- <td>{{$flowstat->packets}}</td>
						<td>{{$flowstat->bytes}}</td> --}}
					</tr>
					<tr>
						<td>rx_error</td>
						<td>{{ $rx_error_min }}</td><!--Min-->
						<td>{{ $rx_error_max }}</td><!--Max-->
						<td>{{ $rx_error_avg }}</td><!--Mean-->
						<td>
							@if(! is_null($rx_error_std))
							@foreach($rx_error_std as $item)
							{{-- {{ $tx_pkts_std->kos}} --}}
							{{ $item->std }}
							@endforeach
							@endif	
						</td><!--Standard Deviation-->
						{{-- <td>{{$flowstat->packets}}</td>
						<td>{{$flowstat->bytes}}</td> --}}
					</tr>
					<tr>
						<td>tx_pkts</td>
						<td>{{ $tx_pkts_min }}</td><!--Min-->
						<td>{{ $tx_pkts_max }}</td><!--Max-->
						<td>{{ $tx_pkts_avg }}</td><!--Mean-->
						<td>
							@if(! is_null($tx_pkts_std))
							@foreach($tx_pkts_std as $item)
							{{-- {{ $tx_pkts_std->kos}} --}}
							{{ $item->std }}
							@endforeach
							@endif

						</td><!--Standard Deviation-->
						{{-- <td>{{$flowstat->packets}}</td>
						<td>{{$flowstat->bytes}}</td> --}}
					</tr>
					<tr>
						<td>tx_bytes</td>
						<td>{{ $tx_bytes_min }}</td><!--Min-->
						<td>{{ $tx_bytes_max }}</td><!--Max-->
						<td>{{ $tx_bytes_avg }}</td><!--Mean-->
						<td>
							@if(! is_null($tx_bytes_std))
							@foreach($tx_bytes_std as $item)
							{{-- {{ $tx_pkts_std->kos}} --}}
							{{ $item->std }}
							@endforeach
							@endif	
						</td>
						<!--Standard Deviation-->
						{{-- <td>{{$flowstat->packets}}</td>
						<td>{{$flowstat->bytes}}</td> --}}
					</tr>
					<tr>
						<td>tx_error</td>
						<td>{{ $tx_error_min }}</td><!--Min-->
						<td>{{ $tx_error_max }}</td><!--Max-->
						<td>{{ $tx_error_avg }}</td><!--Mean-->
						<td>
							@if(! is_null($tx_error_std))
							@foreach($tx_error_std as $item)
							{{-- {{ $tx_pkts_std->kos}} --}}
							{{ $item->std }}
							@endforeach
							@endif	
						</td><!--Standard Deviation-->
						{{-- <td>{{$flowstat->packets}}</td>
						<td>{{$flowstat->bytes}}</td> --}}
					</tr>
					{{-- @endforeach --}}
				</tbody>
			</table>
			@else
				You haven't selected a datapath and port yet. Upon selection, a table will be shown here.
			@endif
			 
    </div>

  <form action="" method="POST" enctype="multipart/form-data" form-horizontal>
		<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
		<div class="col-md-12">		<b>Flow-Related Info:</b> Select a <i><u>datapath</u></i>, <i><u>input port</u></i>, <i><u>output port</u></i> and <i><u>ethernet destination</u></i> to collect statistical information in tabular format.</div>
	
	

    {{ csrf_field() }}
    {{-- Datapath Selection --}}
		<div class="card-body">
      <div class="form-group">
        <div class="col-sm-10">
          <label for="flowdatapath">Select Datapath</label>
          <select class="form-control" wire:model="selectedFlowDP">
            <option value="">Datapath</option>
            @foreach ($uniqueDP as $portstat)
            <option value="{{ $portstat->datapath }}">{{ $portstat->datapath }} </option>
            @endforeach
          </select>
        </div>
      </div>
			{{-- Input Port Selection --}}
      @if (!is_null($flowsInPort))
      <div class="form-group">
        <div class="col-sm-10">
          <label for="stiatus">Select an Input Port</label>
          <select class="form-control" wire:model="selectedInputPort" wire:ignore>
            <option value="">Input Port</option>
            @foreach ($flowsInPort as $flow)
            <option value="{{ $flow->in_port }}">
							{{ $flow->in_port }}
						</option>
						@endforeach
          </select>
        </div>
      </div>
      @endif
			{{-- Output Port Selection --}}
      @if (!is_null($flowsOutPort))
      <div class="form-group">
        <div class="col-sm-10">
          <label for="stiatus">Select an Output Port</label>
          <select class="form-control" wire:model="selectedOutputPort" wire:ignore>
            <option value="">Output Port</option>
            @foreach ($flowsOutPort as $flow)
            <option value="{{ $flow->out_port }}">
							{{ $flow->out_port }}
						</option>
            
						@endforeach
          </select>
        </div>
      </div>
      @endif
			{{-- Ethernet Destination Selection --}}
      @if (!is_null($flowsEthDst))
      <div class="form-group">
        <div class="col-sm-10">
          <label for="stiatus">Select an Ethernet Destination</label>
          <select class="form-control" wire:model="selectedEthernetDestination" wire:ignore>
            <option value="">Ethernet Destination</option>
            @foreach ($flowsEthDst as $flow)
            <option value="{{ $flow->eth_dst }}">
							{{ $flow->eth_dst }}
						</option>
            
						@endforeach
          </select>
        </div>
      </div>
      @endif
			{{-- {{ $partialFlowstatsEthDst }} --}}
			@if(! is_null($partialFlowstatsEthDst))
				<table id="flowstatistical" class="table">
					<thead>
						<tr>
							<th>Field Name</th>
							<th>Min</th>
							<th>Max</th>
							<th>Mean</th>
							<th>Standard Deviation</th>
						</tr>
					</thead>
					<tbody>
						{{-- @foreach($flowstats as $flowstat) --}}
						<tr>
							<td>packets</td>
							<td>{{ $packets_min }}</td><!--Min-->
							<td>{{ $packets_max }}</td><!--Max-->
							<td>{{ $packets_avg }}</td><!--Mean-->
							<td>
								@if(! is_null($packets_std))
								@foreach($packets_std as $item)
								{{-- {{ $tx_pkts_std->kos}} --}}
								{{ $item->std }}
								@endforeach
								@endif		
							</td><!--Standard Deviation-->
							{{-- <td>{{$flowstat->packets}}</td>
							<td>{{$flowstat->bytes}}</td> --}}
						</tr>
						<tr>
							<td>bytes</td>
							<td>{{ $bytes_min }}</td><!--Min-->
							<td>{{ $bytes_max }}</td><!--Max-->
							<td>{{ $bytes_avg }}</td><!--Mean-->
							<td>
								@if(! is_null($bytes_std))
								@foreach($bytes_std as $item)
								{{-- {{ $tx_pkts_std->kos}} --}}
								{{ $item->std }}
								@endforeach
								@endif		
							</td><!--Standard Deviation-->
							{{-- <td>{{$flowstat->packets}}</td>
							<td>{{$flowstat->bytes}}</td> --}}
						</tr>
						{{-- @endforeach --}}
					</tbody>
				</table>
			@else
				You haven't selected a datapath, input port, output port and ethernet destination yet. Upon selection, a table will be shown here.
			@endif
			 
    </div>
  </form>
</div>
