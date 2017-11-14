@extends('admin.layouts.layout')
@section('content')
<div class="col-md-12">
   <div class="box">
        <div class="box-header with-border">
          Media Library
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="elfinder"></div>
        </div>
        
    </div>
          <!-- /.box -->
</div>          
@endsection

@push('scripts')
 <script type="text/javascript" charset="utf-8">
    // Documentation for client options:
    // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
    $().ready(function() {
        $('#elfinder').elfinder({
            // set your elFinder options here
            lang: 'en', // locale
            customData: { 
                _token: '{{ csrf_token() }}'
            },
            uiOptions: {
                    toolbar : [
                        // toolbar configuration
                        ['open'],
                        ['back', 'forward'],
                        ['reload'],
                        ['home', 'up'],
                        ['mkdir', 'mkfile', 'upload'],
                        ['info'],
                        ['quicklook'],
                        ['copy', 'cut', 'paste'],
                        ['rm'],
                        ['duplicate', 'rename', 'edit'],
                        ['extract', 'archive'],
                        //['search'],
                        ['view'],
                        ['help']
                    ]
                },
            url : '{{ route("elfinder.connector") }}',  // connector URL
            soundPath: '{{ asset($elfinderPath.'/sounds') }}'
        });
    });
</script>
@endpush