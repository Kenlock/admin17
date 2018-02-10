@extends('admin.layouts.layout')
@section('content')
<div class="col-md-12">
   <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{!! admin()->html->linkCreate() !!}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @include("admin.flashes")
            {!! Form::open(['id'=>'form']) !!}
            {{-- <small>Dragg the row to change the order</small> --}}
            <table class="table table-bordered" id="table">
		        <thead>
		            <tr>
                    {!! $table_headers !!}
                </tr>
		        </thead>
		    </table>
            {!! Form::close() !!}
        </div>

    </div>
          <!-- /.box -->

</div>
@endsection
@push('scripts')
<script>
$(function() {

    // $("#table").DataTable();

    var table = $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! urlBackendAction('data') !!}',
        ordering:false,
        // rowReorder:true,
        columns: {!! $columns !!}
    });

    // table.on( 'row-reorder', function ( e, diff, edit ) {
    //        $.ajax({
    //            url: '{{ urlBackendAction("update-order") }}',
    //            type: 'get',
    //            data: $("#form").serialize(),
    //            success:function(){
    //                table.ajax.reload();
    //            },
    //        });
    //    } );
});



</script>
@endpush
