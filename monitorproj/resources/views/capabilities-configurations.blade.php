@extends('layouts.base')
@section('title','Capabilities and Configurations')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				{{-- <div class="card-header">
					Card Header
				</div> --}}
						<div class="card-header row">
							{{--<div class="col-md-6">All FlowStat Records</div>--}}
							{{--<div class="col-md-6"><span class="pull-right"><a href="/flowstat/delete-all" class="btn btn-danger">Delete All FlowStats</a></span></div>--}}
						</div>

				<div class="card-body">
					@livewire('capabilities-configurations')
				</div>
			</div>
		</div>
		
	</div>
@endsection