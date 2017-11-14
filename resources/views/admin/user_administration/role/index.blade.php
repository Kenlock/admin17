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
            <table class="table table-bordered" id="table">
		        <thead>
		            <tr>
		                <th>Code</th>
		                <th>Role</th>
		                <th>Action</th>
		            </tr>
		        </thead>
		    </table>
        </div>
        
    </div>
          <!-- /.box -->

</div>          
@endsection
@push('scripts')
<script>
$(function() {
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! urlBackendAction('data') !!}',
        columns: [
            { data: 'code', name: 'code' },
            { data: 'role', name: 'role' },
            { data: 'action', name: 'action',"searchable": false ,'orderable' : false },
        ]
    });
});
</script>
@endpush