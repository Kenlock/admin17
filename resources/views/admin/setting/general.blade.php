@extends('admin.layouts.layout')
@section('content')
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
                  {!! Form::label('phone','Phone') !!}
                  {!! Form::text('phone',@$setting['phone'],['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('email','Email') !!}
                  {!! Form::text('email',@$setting['email'],['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('footer','Footer Description') !!}
                  {!! Form::textarea('footer',@$setting['footer'],['class'=>'form-control ckeditor']) !!}
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
