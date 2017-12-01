@extends('admin.layouts.layout')
@section('content')
@inject('role','App\Models\Role')
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    {!! $titleMenu !!} {{ ucwords(Admin::rawAction()) }}
                </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::model($model,['files'=>'true','id'=>'form']) !!}
            <div class="box-body">
                @include("admin.flashes")
                <div class="form-group">
                    {!! Form::label('title','Title') !!}
                    {!! Form::text('title',null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('description','Description') !!}
                    {!! Form::textarea('description',null,['class'=>'ckeditor']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('image','Image') !!}
                      @component('admin.components.image_preview_create_update',['imageName'=>@$model->image])
                      image
                      @endcomponent
                      @size_recomendation(1903x446)
                </div>
                <div class="form-group">
                    {!! admin()->html->selectStatus() !!}
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                {!! admin()->html->submitLoading() !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\Admin\CrudRequest','#form') !!}
@endpush
