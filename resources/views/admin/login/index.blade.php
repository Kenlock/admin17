@extends('admin.layouts.auth')
@section('content')
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    {!! Form::open() !!}
      @include("admin.flashes")
      <div class="form-group has-feedback">
        {!! Form::text('email',null,['class'=>'form-control','placeholder'=>'Email']) !!}
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        {!! Form::password('password',['class'=>'form-control','placeholder'=>'Password']) !!}
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <!--label>
              <input type="checkbox"> Remember Me
            </label-->
            <a href="{{ url('login/forgot-password') }}">I forgot my password</a>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    {!! Form::close() !!}
@endsection