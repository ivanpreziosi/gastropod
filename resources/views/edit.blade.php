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
		if($key != 'id'){
		if(array_key_exists($key,$dropdowns)){
		@endphp
		<div class="form-group">
			<label for="exampleFormControlSelect1">Select {{$key}}</label>
			<select class="form-control" name="{{$key}}">
				@php
				foreach($dropdowns[$key] as $option){
				@endphp
				<option value="{{$option['value']}}" @php if($option['value']==$value)echo "selected='selected'"; @endphp  >{{$option['text']}}</option>
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
				<strong>{{$key}}:</strong>
				<input type="text" name="{{$key}}" class="form-control" placeholder="" value="{{$value}}">
			</div>
		</div>
		@php
		}
		}else{
		@endphp
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>{{$key}}:</strong>
				<input type="text" name="{{$key}}" class="form-control" placeholder="" disabled="disabled"
					value="{{$value}}">
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