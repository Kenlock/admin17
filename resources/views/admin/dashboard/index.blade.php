@extends('admin.layouts.layout')
@section('content')
<div class="col-md-12">
   	 <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">&nbsp;</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
           <div id="container" style="width:100%; height:400px;"></div>
        </div>
        
    </div>
   	<div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Visitors</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @include("admin.flashes")
            <table class="table table-bordered" id="table">
		        <thead>
		            <tr>
		                <th>IP</th>
		                <th>Clicks</th>
		                <th>Information</th>
		                <th>Country</th>
		                <th>City</th>
		                <th>Date</th>
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
        ordering:false,
        columns: [
            { data: 'ip', name: 'ip' },
            { data: 'clicks', name: 'clicks' },
            { data: 'information', name: 'information' },
            { data: 'country', name: 'country' },
            { data: 'city', name: 'city' },
            { data: 'created_at', name: 'created_at' },
        ]
    });
});


$(function () { 
    var myChart = Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        credits: false,
        title: {
            text: 'Last 7 Days Visitor'
        },
        xAxis: {
            categories: {!! $categories !!}
        },
        plotOptions: {
	        series: {
	            color: 'orange'
	        }
	    },
        yAxis: {
            title: {
                text: 'Visitors'
            }
        },
        series: [{
            name: 'Visitor',
            data: {!! $data !!}
        }]
    });
});

</script>
@endpush