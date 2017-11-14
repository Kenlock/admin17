@extends('admin.layouts.layout')
@section('content')
<div class="col-md-12">
   <div class="box box-primary">
        <div class="box-header with-border">
              <h3 class="box-title">{!! $titleMenu !!} {{ ucwords(Admin::rawAction()) }}</h3>
        </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::model($model) !!}
              <div class="box-body">
                @include("admin.flashes")
                <div class="form-group">
                  {!! Form::label('role','Role') !!}
                  {!! Form::text('role',null,['class'=>'form-control']) !!}
                </div>
                <hr/>
                <h4>Permission</h4>
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menus as $menu)
                          <tr>
                            <td>{{ $menu->label }}</td>
                            <td>
                              @foreach($menu->methods()->where('menu_id',$menu->id)->get() as $m)
                                {{ $m->method }} {!! Form::checkbox('method[]',$m->pivot->id,$cek($m)) !!} {!! Form::hidden('method_code[]',$m->method) !!} {!! Form::hidden('menu_slug[]',$menu->slug) !!} | 
                              @endforeach
                            </td>
                          </tr>
                          {!! admin()->html->childMenuPermission($menu,$cek) !!}

                        @endforeach
                    </tbody>
                </table>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                 @submit_loading
              </div>
            {!! Form::close() !!}
     </div>

</div>          
@endsection
