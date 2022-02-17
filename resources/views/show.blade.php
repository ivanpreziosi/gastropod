@extends('gastropod.template')

@section('content')
<div class="row">
	<div class="col-lg-12 margin-tb">
		<div class="pull-left">
			<h2> Show {{$name}}</h2>
		</div>
	</div>
</div>

<div class="row">
	<pre>{!!$itemData!!}<pre>
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<div class="d-flex flex-row-reverse bd-highlight">
			<div class="p-2 bd-highlight"><a class="btn btn-secondary" href="{{url('gastropod/'.$name)}}"> Back</a>
			</div>
		</div>
	</div>
</div>
@endsection