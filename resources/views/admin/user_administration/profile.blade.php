@extends('admin.layouts.layout')
@section('content')
@inject('role','App\Models\Role')

<div class="col-md-12">
   <div class="box box-primary">
        <div class="box-header with-border">
              <h3 class="box-title">{!! $titleMenu !!} {{ ucwords(Admin::rawAction()) }}</h3>
        </div>
            <!-- /.box-header -->
            <!-- form start -->

            {!! Form::model($model,['files'=>'true']) !!}
              <div class="box-body">
                @include("admin.flashes")
                <div class="form-group">
                  {!! Form::label('username','Username') !!}
                  {!! Form::text('username',null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('name','Name') !!}
                  {!! Form::text('name',null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('email','Email') !!}
                  {!! Form::text('email',null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('old_password','Old Password') !!}
                  {!! Form::password('old_password',['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('password','Password') !!}
                  {!! Form::password('password',['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('verify_password','Verify Password') !!}
                  {!! Form::password('verify_password',['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('avatar','Avatar') !!}
                  @component('admin.components.image_preview_create_update',['imageName'=>$model->avatar])
                  avatar
                  @endcomponent
                  @size_recomendation(300x300)
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                @submit_loading
              </div>
            {!! Form::close() !!}
     </div>

</div>
@endsection
