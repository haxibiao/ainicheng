@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">访问统计</h3>
				</div>
				<div class="panel-body">
					<ul class="list-group">
						@foreach($counts as $name => $count)
						<li class="list-group-item">
							<span class="badge">{{ $count }}</span>
							{{ $name }} {{ ceil( 100 * $count / $all ) }}%
							<div class="progress">
							  <div class="progress-bar" role="progressbar" aria-valuenow="{{ ceil( 100 * $count / $all ) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ ceil( 100 * $count / $all ) }}%;">
							    {{ ceil( 100 * $count / $all ) }}%
							  </div>
							</div>
						</li>
						@endforeach
					</ul>	
				</div>
				<div class="panel-footer">
					<a href="/traffic/log" class="btn btn-default">详细日志</a>
				</div>
			</div>	
		</div>	
	
		@foreach($data as $name => $counts)
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">{{ $name }}</h3>
				</div>
				<div class="panel-body">
					<ul class="list-group">
						@foreach($counts as $key => $count)
						<li class="list-group-item">
							<span class="badge">{{ $count }}</span>
							{{ empty($key) ? '未知': $key }} 
						</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
		@endforeach
	</div>
@stop