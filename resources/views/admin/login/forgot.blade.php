@extends('admin.layouts.auth')
@section('content')
  <div class="login-box-body">
    <p class="login-box-msg">Forgot Password</p>
    {!! Form::open() !!}
      @include("admin.flashes")
      <div class="form-group has-feedback">
        {!! Form::text('email',null,['class'=>'form-control','placeholder'=>'Email']) !!}
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <!--label>
              <input type="checkbox"> Remember Me
            </label-->
            <a href="{{ url('login') }}">Back to Login Page</a>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Reset</button>
        </div>
        <!-- /.col -->
      </div>
    {!! Form::close() !!}
@endsection