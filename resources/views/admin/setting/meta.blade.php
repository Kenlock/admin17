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
                  @foreach($metas as $key)
                    <div class="col-md-6">
                        <div class="form-group">
                          {!! Form::label($key,ucwords($key)) !!}
                          {!! Form::textarea($key,@$setting[$key],['class'=>'form-control']) !!}
                        </div>
                    </div>
                  @endforeach
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                 @submit_loading
              </div>
            {!! Form::close() !!}
     </div>

</div>          
@endsection
