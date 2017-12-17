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
                <div id="tabs">
                    <ul>
                    @foreach(languages() as $key => $val)
                        <li><a href="#tabs-{{ $key }}">{{ $val }}</a></li>
                    @endforeach
                    </ul>
                    @foreach(languages() as $key => $val)
                      <div id="tabs-{{ $key }}">
                            <div class="form-group">
                                {!! Form::label('title','Title ') !!}
                                {!! Form::text($key.'[title]',@$data->$key->title,['class'=>'form-control']) !!}
                            </div>
                             <div class="form-group">
                                {!! Form::label('description','Description ') !!}
                                {!! Form::textarea($key.'[description]',@$data->$key->description,['class'=>'form-contro ckeditor']) !!}
                            </div>
                      </div>
                    @endforeach
                      
                </div>
                <p>&nbsp;</p>
                <div class="form-group">
                    {!! admin()->html->selectStatus(@$data->status) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('image','Image') !!}
                      @component('admin.components.image_preview_create_update',['imageName'=>@$data->image])
                      image
                      @endcomponent
                      {!! Form::hidden('old_image',@$data->image) !!}
                      @size_recomendation(1903x446)
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
{!! JsValidator::formRequest('App\Http\Requests\Admin\DimsavRequest','#form') !!}
<script type="text/javascript">
    $( function() {
    $( "#tabs" ).tabs();
  } );
</script>
@endpush
