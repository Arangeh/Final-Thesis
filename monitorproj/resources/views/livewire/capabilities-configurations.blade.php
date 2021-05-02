<div>
	<form action="" method="POST" enctype="multipart/form-data" form-horizontal>
		<div class="card-header row">
			<div class="col-md-6">	
				<b>Caveat:</b> Each time the page loads, you can only see the capabilities and configurations for only one switch that is selected in dropdown menu. Select a switch for which you want to see capabilities and configurations.
				{{--If you have altered some dropdown menu whereas you want to see statistical information for another branch, then you should click on the "Refresh" button first.  	--}}
			</div>
			<div class="col-md-6"><span class="pull-right">
				<a href="/capabilities-configurations" class="btn btn-danger">
					Refresh
				</a>
			</span>
		</div>
			
		</div>
  <form action="" method="POST" enctype="multipart/form-data" form-horizontal>
		<div class="col-md-12">		<b>Switch-Related Info:</b> Select a <i><u>datapath</u></i> in order to see capabilities and configurations.</div>
	
    {{ csrf_field() }}
    {{-- Datapath Selection --}}
		<div class="card-body">
      <div class="form-group">
        <div class="col-sm-10">
          <label for="datapath">Select Datapath</label>
          <select class="form-control" wire:model="selectedDP" wire:ignore>
            <option value="">Datapath</option>
            @foreach ($datapaths as $datapath)
            <option value="{{ $datapath->datapath }}">{{ $datapath->datapath }} </option>
            @endforeach
          </select>
        </div>
      </div>
			
			<h3>Whitebox Switch Description and Capabilities</h3>

			
			<div>
			@if(!is_null($hw_desc))
				{{--<br/>--}}
				<b>Hardware Description:</b> {{ $hw_desc }}
			@endif
			</div>	
			<div>
			@if(!is_null($mfr_desc))
				{{--<br/>--}}
				<b>Manufacturer:</b> {{ $mfr_desc }}
			@endif
			</div>
			<div>
			@if(!is_null($sw_desc))
				{{--<br/>--}}
				<b>Software Description:</b> {{ $sw_desc }}
			@endif
			</div>
			<div>
			@if(!is_null($n_buffers))
				{{--<br/>--}}
				<b>Buffer Max (max packets buffered at once):</b> {{ $n_buffers }}
			@endif
			</div>
			<div>
			@if(!is_null($n_tables))
				{{--<br/>--}}
				<b>Number of Tables:</b> {{ $n_tables }}	
			@endif
			</div>
			<div>
			@if(!is_null($capabilities))
				{{--<br/>--}}
				<b>Capabilities:</b> {{ $capabilities }}
			@endif
			</div>
			{{--
			
			
			<br>Capabilities:</br>--}}
			{{--<b></b>--}}
			
			<div>
			@if (!is_null($ports))
			<b>Ports Description</b>
				<table id="ports" class="table">
					<thead>
						<tr>
							{{--<th>Datapath</th>--}}
							<th>Port No</th>
							<th>Name</th>
							<th>Hw Address</th>
							<th>Current Speed</th>
							<th>Configuration</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>
						@foreach($ports as $port)
						<tr>
							{{--<td>{{ $port->datapath }}</td>--}}
							<td>{{ $port->port_no }}</td>
							<td>{{ $port->name }}</td>
							<td>{{ $port->hw_addr }}</td>
							<td>{{ $port->curr_speed }}</td>
							<td>{{ $port->config }}</td>
							<td>{{ $port->state }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			@else
			
				Either you haven't specified a datapath or there isn't any port on the selected datapath
			@endif
			</div>
			
			<div>
			<b>Flow Table</b>
			@if(!is_null($flows))
			<table id="flows" class="table">
				<thead>
					<tr>
						<th>Table ID</th>
						<th>Priority</th>
						<th>Cookie</th>
						<th>Hard Timeout</th>
						<th>Duration Sec</th>
						<th>Packet Count</th>
						<th>Actions</th>
						<th>In-Port</th>
						<th>Dl-DST</th>
					</tr>
				</thead>
				<tbody>
					@foreach($flows as $flow)
					<tr>
						<td>{{ $flow->table_id }}</td>
						<td>{{ $flow->priority }}</td>
						<td>{{ $flow->cookie }}</td>
						<td>{{ $flow->hard_timeout }}</td>
						<td>{{ $flow->duration_sec }}</td>
						<td>{{ $flow->packet_count }}</td>
						<td>{{ $flow->actions }}</td>
						<td>{{ $flow->in_port }}</td>
						<td>{{ $flow->dl_dst }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@else
				Either you haven't specified a datapath or there isn't any flow on the selected datapath
			@endif
			</div>

			<div>
			<b>Tables with Active Entry</b>
			@if(!is_null($tables))
				<table id="tables" class="table">
				<thead>
					<tr>
						<th>Table ID</th>
						<th>Active Count</th>
						<th>Lookup Count</th>
						<th>Mathced Count</th>
					</tr>
				</thead>
				<tbody>
					@foreach($tables as $table)
					<tr>
						<td>{{ $table->table_id }}</td>
						<td>{{ $table->active_count }}</td>
						<td>{{ $table->lookup_count }}</td>
						<td>{{ $table->matched_count }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@else
			Either you haven't specified a datapath or there isn't any table with active entry on the selected datapath
			@endif
			</div>
			<br/>			 
    </div>
  </form>
</div>
