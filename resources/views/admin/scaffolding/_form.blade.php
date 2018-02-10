@extends('admin.layouts.layout')
@section('content')
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
                {!! $inputs !!}

                <div id="tabs" style="display:none;">
                    <ul>
                    @foreach(languages() as $key => $val)
                        <li><a href="#tabs-{{ $key }}">{{ $val }}</a></li>
                    @endforeach
                    </ul>
                    @foreach(languages() as $key => $val)
                      <div id="tabs-{{ $key }}">
                            
                      </div>
                    @endforeach
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
{!! $validation->selector('#form') !!}
<script>
    $(document).ready(function(){
        $countMulti = $("div[class*='multi_language']").length;
        if($countMulti > 0)
        {
            $("#tabs").show();
        } 

        $( "#tabs" ).tabs();
    });
</script>
    @foreach(languages() as $key => $val)
        <script>
            $(document).ready(function(){
                if($countMulti > 0)
                {
                    $(".multi_language_{{$key}}").appendTo('#tabs-{{$key}}');   
                } 
            });
        </script>
    @endforeach
@endpush
@push('style')
    <style type="text/css">
        .help-block
        {
            color:red;
            font-size:12px;
        }
    </style>
@endpush
