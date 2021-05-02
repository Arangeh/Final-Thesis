<div>
	{{--<form action="" method="POST" enctype="multipart/form-data" form-horizontal>--}}
	<div class="card-header row">
		<div class="col-md-6">	
			<b>Caveat:</b> Each time the page loads, you can only see the statistical information for only one branch of cascading dropdown menus. If you have altered some dropdown menu whereas you want to see statistical information for another branch, then you should click on the "Refresh" button first.  	
		</div>
		<div class="col-md-6">
			<span class="pull-right">
				<a href="/flow-statistics" class="btn btn-danger">Refresh</a>
			</span>
		</div>
		
	</div>
  
	<div class="card-body">
		<form action="" method="POST" enctype="multipart/form-data" form-horizontal>
			<div class="col-md-12">		
				<b>Flow-Related Info:</b> Select a <i><u>datapath</u></i>, <i><u>input port</u></i>, <i><u>output port</u></i> and <i><u>ethernet destination</u></i> to collect statistical information in tabular format.
			</div>
	
			{{ csrf_field() }}
			{{-- Datapath Selection --}}
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
		</form>
	</div>
</div>
