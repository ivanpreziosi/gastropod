@extends('gastropod.template')

@section('content')
<div class="row">
	<div class="col-lg-12 margin-tb">
		<div class="pull-left">
			<h2>Edit {{$name}}</h2>
		</div>
		<div style="float:right">

		</div>
	</div>
</div>

@if ($errors->any())
<div class="alert alert-danger">
	<strong>Whoops!</strong> There were some problems with your input.<br><br>
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif

<form action="{{url('gastropod/'.$name.'/'.$item['id'])}}" method="POST">
	@csrf
	@method('PUT')
	<div class="row">
		@php
		foreach($item as $key => $value){
			$isWidget = false;
            if ($key != 'id') {
                foreach ($widgets as $widget) {
                    if ($widget->columnName == $columnName) {
                        $isWidget = true;
                        echo $widget->render();
                    }
                }
            }



			if(!$isWidget){
			
			@endphp
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<strong>{{$key}}:</strong>
					<input type="text" name="{{$key}}" class="form-control" placeholder="" value="{{$value}}">
				</div>
			</div>
			@php
			}
		}
		@endphp

		<div class="col-xs-12 col-sm-12 col-md-12 text-center">
			<div class="d-flex flex-row-reverse bd-highlight">
				<div class="p-2 bd-highlight"><button type="submit" class="btn btn-primary">Submit</button></div>
				<div class="p-2 bd-highlight"><a class="btn btn-secondary" href="{{url('gastropod/'.$name)}}"> Back</a>
				</div>
			</div>
		</div>
	</div>

</form>
@endsection