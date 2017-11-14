<?php
	$sessions = ['success','warning','info','danger'];
?>

@foreach($sessions as $flash)
	@if(session()->has($flash))
		<div class="alert alert-{{$flash}} fade in">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>{{ucwords($flash)}}!</strong> 
            {!! session()->get($flash) !!}
        </div>
	@endif
@endforeach

@if($errors->any())
  <div class="alert alert-danger alert-dismissible">
  	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-ban"></i> Error Validation!</h4>
    <ul>
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

