<div class="form-group">
	<label for="dropdown-{{$columnName}}">Select {{$columnName}}</label>
	<select class="form-control" id="dropdown-{{$columnName}}" name="{{$columnName}}">
		<option value="-1">Select something!</option>
		@php  
		foreach($options as $option){
		@endphp
		<option value="{{$option['value']}}" @php if($selectedOption == $option['value]){echo 'selected=\'selected\'';} @endphp>{{$option['text']}}</option>
		@php
		}
		@endphp
	</select>
</div>