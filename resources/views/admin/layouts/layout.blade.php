@include('admin.layouts.header')
@include('admin.layouts.menu')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    
      <h1>&nbsp;
        {{-- {{ $titleMenu }} --}}
        <!--small>it all starts here</small-->
      </h1>
    <ol class="breadcrumb">
      @foreach($breadCrumbs as $url=>$label)
        <li><a href="{{$url}}">{{ $label }}</a></li>
      @endforeach
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
  @yield('content')
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@include('admin.layouts.footer')


