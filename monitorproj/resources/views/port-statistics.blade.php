@extends('layouts.base')
@section('title','Port Statistical Information')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				{{-- <div class="card-header">
					Card Header
				</div> --}}
						<div class="card-header row">
							
							<div class="col-md-12">
								{{-- <span class="pull-right"><a href="/flowstat/delete-all" class="btn btn-danger">Collect and Show Filtered Data</a>
								</span> --}}
								<span class="pull-left">
									{{-- <h3 class="card-title">YO</h3> --}}
									{{-- @livewire('port-statistical-functions') --}}
									{{-- @livewire('flow-statistical-functions') --}}
									@livewire('port-statistical-functions')
								</span>
							</div>
						</div>

				<div class="card-body">
				
				</div>
			</div>
		</div>
		
	</div>
@endsection