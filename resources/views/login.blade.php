@extends('gastropod.template')

@section('content')
<div id="title" class="container-fluid">
	<div class="row">
		<div class="col-lg">

		</div>
		<div class="col">
			<div class="" style="cursor:pointer" onclick="window.location.href='{{ url('/gastropod/users') }}'">

				<pre>  @@@@@     @     @@@@@  @@@@@@@ @@@@@@  @@@@@@@ @@@@@@  @@@@@@@ @@@@@@
 @     @   @ @   @     @    @    @     @ @     @ @     @ @     @ @     @
 @        @   @  @          @    @     @ @     @ @     @ @     @ @     @
 @  @@@@ @     @  @@@@@     @    @@@@@@  @     @ @@@@@@  @     @ @     @
 @     @ @@@@@@@       @    @    @   @   @     @ @       @     @ @     @
 @     @ @     @ @     @    @    @    @  @     @ @       @     @ @     @
  @@@@@  @     @  @@@@@     @    @     @ @@@@@@@ @       @@@@@@@ @@@@@@</pre>
			</div>

		</div>
		<div class="col-lg">

		</div>
	</div>
</div>
<br>
<div class="container">
	<div class="row">
		<div class="col-12 text-center">
			<img src="{{ asset('/gastropod_assets/img/gastropod.jpg') }}" class="img-fluid" style="width:200px;" />
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12 col-md-6 offset-md-3  margin-tb">
			<div class="pull-left">
				<h2>LOGIN</h2>
			</div>
		</div>
	</div>

	@if (isset($errors) && $errors->any())
	<div class="alert alert-danger">
		<strong>Whoops!</strong> There were some problems with your input.<br><br>
		<ul>
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif

	<div class="row">
		<div class="col-sm-12 col-md-6 offset-md-3  margin-tb">
			<form action="{{url('gastropod/login')}}" method="POST">
				@csrf

				<div class="form-group">
					<label for="email">Email address</label>
					<input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
						placeholder="Enter email">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Password">
				</div>
				<br>
				<button style="float:right" type="submit" class="btn btn-primary">Submit</button>

			</form>
		</div>
	</div>
</div>
@endsection