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
                        <th>Role</th>
		                <th>Username</th>
                        <th>Name</th>
		                <th>Email</th>
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
            { data: 'role', name: 'roles.role' },
            { data: 'username', name: 'username' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'action', name: 'action',"searchable": false ,'orderable' : false },
        ]
    });
});
</script>
@endpush