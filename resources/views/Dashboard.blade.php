@extends('Html')
@section('content') 
<section class="content">
 <div class="row">
   <div class="col-md-12" style="margin:-10px; margin-bottom: 4px" >
    
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box bg-aqua">
        <span class="info-box-icon"> <img src=" {{ asset('images/img/memo.png') }} " alt="" srcset=""> </i></span>

        <div class="info-box-content">
          <span class="info-box-text">Surat Keluar</span>
          <span class="info-box-number">6 Surat</span>

          <div class="progress">
            <div class="progress-bar" style="width: 70%"></div>
          </div>
          <a href="" style="color:white">
              <span class="progress-description">
                >> lihat Selengkapnya
              </span> 
            </a>
             

        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box bg-green">
        <span class="info-box-icon"> <img src=" {{ asset('images/img/ttd.png') }} " alt="" srcset=""> </i></span>
        <div class="info-box-content">
          <span class="info-box-text">Surat Di Setujui</span>
          <span class="info-box-number"> 
            @if (Session::has("totalParaf"))
                {{ Session::get("totalParaf") }}
            @endif
            Surat</span>

          <div class="progress">
            <div class="progress-bar" style="width: 70%"></div>
          </div>
          <a href="" style="color:white">
            <span class="progress-description">
              >> lihat Selengkapnya
            </span>
          </a>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>

 


    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box bg-yellow">
        <span class="info-box-icon"> <img src=" {{ asset('images/img/proses.png') }} " alt="" srcset=""> </i></span>
        <div class="info-box-content">
          <span class="info-box-text">Request Paraf / Tandatangan</span>
          <span class="info-box-number">
            @if (Session::has("getJumlahRequest"))
                {{ Session::get("getJumlahRequest") }}
            @endif

            Surat
          </span>

          <div class="progress">
            <div class="progress-bar" style="width: 70%"></div>
          </div>
          <a href="" style="color:white">
            <span class="progress-description">
              <i class="fa fa-arrow-circle-right"></i> lihat Selengkapnya
            </span>
          </a>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>


    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box bg-red">
        <span class="info-box-icon"> <img src=" {{ asset('images/img/reject.png') }} " alt="" srcset=""> </i></span>

        <div class="info-box-content">
          <span class="info-box-text">Surat Di Reject</span>
          <span class="info-box-number">
            @if (Session::has("totalReject"))
                {{ Session::get("totalReject") }}
            @endif
            Surat</span>

          <div class="progress">
            <div class="progress-bar" style="width: 70%"></div>
          </div>
          <a href="" style="color:white">
            <span class="progress-description">
              >> lihat Selengkapnya
            </span>
          </a>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> Pencapaian E-Surat</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <div class="btn-group">
            <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-wrench"></i></button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li class="divider"></li>
              <li><a href="#">Separated link</a></li>
            </ul>
          </div>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-8">
            <p class="text-center">
              <strong>Priode Tahun {{ date('Y') }}</strong>
            </p>

            <div class="chart">
              <!-- Sales Chart Canvas -->
              <canvas id="salesChart" style="height: 180px;"></canvas>
            </div>
            <!-- /.chart-responsive -->
          </div>
          <!-- /.col -->
          <div class="col-md-4">
            <p class="text-center">
              <strong>Goal E-Surat</strong>
            </p>
            <div class="progress-group">
              <span class="progress-text">Surat Ditanda Tangani</span>
              <span class="progress-number"><b>480</b>/800</span>

              <div class="progress active">
                <div class="progress-bar progress-bar-success progress-bar-striped" 
                role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 87%">
                </div>
            </div>
            </div>

            <div class="progress-group">
              <span class="progress-text">Surat Direvisi</span>
              <span class="progress-number"><b>160</b>/200</span>

              <div class="progress progress-sm active">
                <div class="progress-bar progress-bar-info progress-bar-striped" 
                role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 23%">
                </div>
            </div>

            </div>
            <!-- /.progress-group -->
            <div class="progress-group">
              <span class="progress-text">Surat Direject</span>
              <span class="progress-number"><b>310</b>/400</span>

              <div class="progress progress-sm active">
                <div class="progress-bar progress-bar-danger progress-bar-striped" 
                role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 5%">
                </div>
            </div>
            </div>
            <!-- /.progress-group -->

            <!-- /.progress-group -->
            <div class="progress-group">
              <span class="progress-text">Surat Masuk</span>
              <span class="progress-number"><b>250</b>/500</span>

              <div class="progress progress-sm active">
                <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                </div>
            </div>
            </div>
            <!-- /.progress-group -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- ./box-body -->
      <div class="box-footer">
        <div class="row">
          <div class="col-sm-3 col-xs-6">
            <div class="description-block border-right">
              <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
              <h5 class="description-header">35,210</h5>
              <span class="description-text">TOTAL SURAT</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-3 col-xs-6">
            <div class="description-block border-right">
              <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
              <h5 class="description-header">10,390</h5>
              <span class="description-text">TOTAL SURAT EXTERNAL</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-3 col-xs-6">
            <div class="description-block border-right">
              <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
              <h5 class="description-header">24,813.53</h5>
              <span class="description-text">TOTAL SURAT DITANDA TANGANI</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-3 col-xs-6">
            <div class="description-block">
              <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
              <h5 class="description-header">1200</h5>
              <span class="description-text">SURAT DIREJECT</span>
            </div>
            <!-- /.description-block -->
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-footer -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>



<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Order Surat Berdasarkan Devisi</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="table-responsive">
      <table class="table no-margin">
        <thead>
        <tr>
          <th>Kode</th>
          <th>Ruangan</th>
          <th>Status</th>
          <th>Total Surat</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td><a href="pages/examples/invoice.html">OR9842</a></td>
          <td><b> SIMRS</b></td>
          <td><span class="label label-success">Shipped</span></td>
          <td>
            <div class="progress sm">
              <div class="progress progress-bar progress-bar-green" style="width: 80%">   </div>
            </div>

            <div class="progress sm">
              <div class="progress progress-bar progress-bar-aqua" style="width: 50%">  > </div>
            </div>

            <div class="progress sm">
              <div class="progress progress-bar progress-bar-red" style="width: 92%">  </div>
            </div>

            <div class="progress sm">
              <div class=" progress progress-bar progress-bar-yellow" style="width: 63%"></div>
            </div>

            {{-- <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div> --}}
          </td>
        </tr>
         
        <tr>
          <td><a href="pages/examples/invoice.html">OR9842</a></td>
          <td><b> SIMRS</b></td>
          <td><span class="label label-success">Shipped</span></td>
          <td>
            <div class="progress sm">
              <div class="progress progress-bar progress-bar-green" style="width: 80%">   </div>
            </div>

            <div class="progress sm">
              <div class="progress progress-bar progress-bar-aqua" style="width: 50%">  > </div>
            </div>

            <div class="progress sm">
              <div class="progress progress-bar progress-bar-red" style="width: 92%">  </div>
            </div>

            <div class="progress sm">
              <div class=" progress progress-bar progress-bar-yellow" style="width: 63%"></div>
            </div>

            {{-- <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div> --}}
          </td>
        </tr>
        <tr>
          <td><a href="pages/examples/invoice.html">OR9842</a></td>
          <td><b> SIMRS</b></td>
          <td><span class="label label-success">Shipped</span></td>
          <td>
            <div class="progress sm">
              <div class="progress progress-bar progress-bar-green" style="width: 80%">   </div>
            </div>

            <div class="progress sm">
              <div class="progress progress-bar progress-bar-aqua" style="width: 50%">  > </div>
            </div>

            <div class="progress sm">
              <div class="progress progress-bar progress-bar-red" style="width: 92%">  </div>
            </div>

            <div class="progress sm">
              <div class=" progress progress-bar progress-bar-yellow" style="width: 63%"></div>
            </div>

            {{-- <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div> --}}
          </td>
        </tr>
        </tbody>
      </table>
    </div>
    <!-- /.table-responsive -->
  </div>
  <!-- /.box-body -->
  <div class="box-footer clearfix">
    <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
    <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
  </div>
  <!-- /.box-footer -->
</div>





  {{-- <div class="col-md-12" style="margin:-10px">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
  
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
        <div class="item active">
        <img src="{{ asset('images/data/slide1.png') }}" style="width:100%;">
        </div>
  
        <div class="item">
        <img src="{{ asset('images/data/slide2.png') }}" style="width:100%;">
        </div>
      
        <div class="item">
          <img src="{{ asset('images/data/slide3.png') }}" style="width:100%;">

        </div>
      </div>
  
      <!-- Left and right controls -->
      <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div> --}}


  <div class="modal orange" id="exGantiPassword">
    <form>
        @csrf
        <p style="font-family: Verdana, Geneva, Tahoma, sans-serif"> Ganti Password </p>
        <a>
            <input type="submit" class="button button1 orange" value="OK">
        </a>
    </form>
</div>



</section>


<script src="bower_components/jquery/dist/jquery.min.js"></script>
 
<script src="bower_components/chart.js/Chart.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="dist/js/pages/dashboard2.js"></script> --}}
<!-- AdminLTE for demo purposes -->
{{-- <script src="dist/js/demo.js"></script> --}}

<script>

$(function() {

  'use strict';
  
  var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
  var salesChart = new Chart(salesChartCanvas);

  var salesChartData = {
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [{
              label: 'Surat Disetujui',
              fillColor: '#00a65a',
              strokeColor: '#00a65a',
              pointColor: '#00a65a',
              pointStrokeColor: '#c1c7d1',
              pointHighlightFill: '#fff',
              pointHighlightStroke: 'rgb(220,220,220)',
              data: [65, 59, 80, 81, 56, 55, 40]
          },
          {
              label: 'Surat Direject',
              fillColor: '#dd4b39',
              strokeColor: '#dd4b39',
              pointColor: '#dd4b39',
              pointStrokeColor: '#dd4b39',
              pointHighlightFill: '#fff',
              pointHighlightStroke: '#3b8bba)',
              data: [28, 48, 40, 19, 86, 27, 90]
          },
          {
              label: 'Surat Pending',
              fillColor: '#f39c12',
              strokeColor: '#f39c12',
              pointColor: '#f39c12',
              pointStrokeColor: '#f39c12',
              pointHighlightFill: '#fff',
              pointHighlightStroke: 'rgba(60,141,188,1)',
              data: [38, 18, 30, 29, 46, 17, 50]
          }

      ]
  };

  var salesChartOptions = {
      // Boolean - If we should show the scale at all
      showScale: true,
      // Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: false,
      // String - Colour of the grid lines
      scaleGridLineColor: 'rgba(0,0,0,.05)',
      // Number - Width of the grid lines
      scaleGridLineWidth: 1,
      // Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      // Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      // Boolean - Whether the line is curved between points
      bezierCurve: true,
      // Number - Tension of the bezier curve between points
      bezierCurveTension: 0.3,
      // Boolean - Whether to show a dot for each point
      pointDot: false,
      // Number - Radius of each point dot in pixels
      pointDotRadius: 4,
      // Number - Pixel width of point dot stroke
      pointDotStrokeWidth: 1,
      // Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius: 20,
      // Boolean - Whether to show a stroke for datasets
      datasetStroke: true,
      // Number - Pixel width of dataset stroke
      datasetStrokeWidth: 2,
      // Boolean - Whether to fill the dataset with a color
      datasetFill: true,
      // String - A legend template
      legendTemplate: '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<datasets.length; i++){%><li><span style=\'background-color:<%=datasets[i].lineColor%>\'></span><%=datasets[i].label%></li><%}%></ul>',
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      // Boolean - whether to make the chart responsive to window resizing
      responsive: true
  };

  // Create the line chart
  salesChart.Line(salesChartData, salesChartOptions);
  
});

</script>


  @endsection
