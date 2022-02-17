@extends('gastropod.template')

@section('content')
<div class="row">
	<div class="col-lg-12 margin-tb">
		<div class="pull-left">
			<h2>Add New {{$name}}</h2>
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

<form action="{{url('gastropod/'.$name)}}" method="POST">
	@csrf

	<div class="row">
		@php
		foreach($columnNames as $columnName){
		if($columnName != 'id'){
		//print_r($dropdowns);die();
		if(array_key_exists($columnName,$dropdowns)){
		@endphp

		<div class="form-group">
			<label for="exampleFormControlSelect1">Select {{$columnName}}</label>
			<select class="form-control" name="{{$columnName}}">
				<option value="-1">Select something!</option>
				@php  
				foreach($dropdowns[$columnName] as $option){
				@endphp
				<option value="{{$option['value']}}">{{$option['text']}}</option>
				@php
				}
				@endphp
			</select>
		</div>

		@php
		}else{
		@endphp
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>{{$columnName}}:</strong>
				<input type="text" name="{{$columnName}}" class="form-control" placeholder="" value="">
			</div>
		</div>
		@php
		}
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