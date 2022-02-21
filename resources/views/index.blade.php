@extends('gastropod.template')

@section('content')
<div class="row">
	<div class="col-lg-12 margin-tb">
		<form method="GET" action="?" class="d-flex" style="float:right;margin-left:20px;">
			<input class="form-control me-2" value="{{session('gastropod-index-search-key','')}}" name="search-key"
				type="search" placeholder="Search" aria-label="Search">
			<div class="form-group" style="margin-top:15px;">in&nbsp;&nbsp;</div>
			<div style="margin-right:5px;">
				<select class="form-control" name="search-field" style="min-width:100px;">
					<option value="" @php echo (session('gastropod-index-search-field')=='' )?"selected='selected'":"";  @endphp>Field</option>

					@php
			if(count($items)>0){
			$item = $items[0];
			$item = $item->toArray();

			foreach($item as $key => $value){
			if(!is_array($value) && strpos($key, " __REMOTE")==false){ @endphp <option value="{{$key}}" @php echo
						(session('gastropod-index-search-field')==$key )?"selected='selected'":"";  @endphp>{{$key}}</option>

			@php
			}
			}
			}
			@endphp

				</select>
			</div>
			<button class=" btn btn-outline-success" type="submit">Search</button>
		</form>
		<div style="float:right;font-size:2em;margin-top:-10px;">
			&nbsp;&nbsp;<img src="{{ asset('/gastropod_assets/img/gastropod.png') }}" class="img-fluid" style="width:50px;" />
		</div>
		<div style="float:left;">
			<a class="btn btn-success" href="{{ url('gastropod/'.$name.'/create') }}">Create New</a>
		</div>
		<div style="float:left;margin-left:10px;">
			<h2>{{$name}}</h2>
		</div>
	</div>
</div>

@if ($message = Session::get('success'))
<div class="alert alert-success">
	<p>{{ $message }}</p>
</div>
@endif

<table class="table table-bordered table-hover  table-striped">
	<thead>
		<tr>
			@php
			if(count($items)>0){
			$item = $items[0];
			$item = $item->toArray();

			foreach($item as $key => $value){
			if(!is_array($value)){
			@endphp

			<th>{{$key}}</th>

			@php
			}
			}
			}
			@endphp
		</tr>
	</thead>
	@php
	foreach($items as $item){
	$item = $item->toArray();
	echo "<tr>";
		foreach($item as $key => $value){

		@endphp



		<td>
			@if (!is_array($value))
			@php
			$truncatedString = $value;
			if (strlen($truncatedString)>20 && !str_contains($key,'__REMOTE')) {
			$truncatedString = substr($truncatedString, 0, 17).'...';
			}
			@endphp
			<div title="{{$value}}">{!! $truncatedString !!}</div>
			@endif
		</td>

		@php
		}
		@endphp
		<td style="text-align:right">
			<form id="actions-form-item-{{$item['id']}}" action="{{ url('gastropod/'.$name.'/'.$item['id']) }}"
				method="POST">

				<a class="btn btn-info" href="{{ url('gastropod/'.$name.'/'.$item['id']) }}">Show</a>

				<a class="btn btn-primary" href="{{ url('gastropod/'.$name.'/'.$item['id'].'/edit') }}">Edit</a>

				@csrf
				@method('DELETE')

				<button type="button" onclick="openDeleteRecordModal({{$item['id']}})"
					class="btn btn-danger">Delete</button>
			</form>
		</td>
	</tr>
	@php

	}
	@endphp
</table>

<div class="d-flex flex-row-reverse bd-highlight">
	<div class="p-2 bd-highlight">
		<form method="GET" action="?" id="ipp-form" class="d-flex" style="float:right;margin-left:20px;">
			<div class="form-group">
				<select class="form-control" name="ipp" onchange="$('#ipp-form').submit();">
					<option value="10" @php echo (session('gastropod-index-ipp',10)==10)?"selected='selected'":"";  @endphp>Items x page: 10</option>
					<option value=" 25" @php echo (session('gastropod-index-ipp',10)==25)?"selected='selected'":"";  @endphp>Items x page: 25</option>
					<option value=" 50" @php echo (session('gastropod-index-ipp',10)==50)?"selected='selected'":"";  @endphp>Items x page: 50</option>
					<option value=" 100" @php echo (session('gastropod-index-ipp',10)==100)?"selected='selected'":"";  @endphp>Items x page: 100</option>
				</select>
			</div>
		</form>
	</div>
	<div class="p-2 bd-highlight">
		{{ $items->links() }}
	</div>
</div>
<!-- Modal -->
<div class=" modal fade" id="delete-record-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
	aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				So you want to delete it? Are you sure?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Nope</button>
				<button type="button" class="btn btn-danger" onclick="doDeleteRecord();">DELETE!</button>
			</div>
		</div>
	</div>
</div>
@endsection