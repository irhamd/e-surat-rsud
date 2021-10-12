@extends('Html')
@section('content')

<?php
  function getDif($d2){
      $datetime1 = new DateTime();
      $datetime2 = new DateTime($d2);
      
      $interval = $datetime1->diff($datetime2);
      $elapsed = $interval->format('%a Hari %h Jam %i Menit');

      return $elapsed;
  }
?>
 
<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="titleJudul hijau">REQUEST PARAF</h3>
            <br>
            
            <form action="requestParaf" method="get">
                <div class="col-md-3 ml-15">
                <div class="form-group">
                    <label>Tanggal</label>

                    <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input name="tanggal" type="text"   class="form-control pull-right" id="tanggal" autocomplete="off"
                    value="{{ isset($_GET['tanggal']) ? $_GET['tanggal'] : '' }}" >
                    </div>
                </div>
                </div>


                <div class="col-md-3 ml-15">
                <div class="form-group">
                    <label>Nomor Surat</label>
                    <input type="text" class="form-control pull-right" name="nomorsurat" 
                    value="{{ isset($_GET['nomorsurat']) ? $_GET['nomorsurat'] : '' }}">
                    </div>
                </div>
                <div class="col-md-3 ml-15">
                    <label>Perihal</label>
                    <input type="text" class="form-control pull-right" name="perihal" 
                    value="{{ isset($_GET['perihal']) ? $_GET['perihal'] : '' }}" autocomplete="off">
                </div>

        
                <div class="col-md-3 ml-15">
                <br>
                    <button type="submit" class="btn bg-olive btn-flat"> <span class="fa fa-search"></span> OK</button>

                </div>
                <br>
                <div class="col-md-12">
                    <label>
                    <input type="checkbox" name="approve" class="minimal" {{ isset($_GET['approve'])? 'checked':'' }} >   Approve &nbsp;
                    </label>
                    <label>
                    <input type="checkbox" name="requ" class="minimal" {{ isset($_GET['requ'])? 'checked':'' }} > Request&nbsp;
                    </label>
                    <label>
                    <input type="checkbox" name="revisi" class="minimal-red" {{ isset($_GET['revisi'])? 'checked':'' }} > Revisi&nbsp;
                    </label>            
                    <label>
                    <input type="checkbox"  name="reject" class="minimal-red" {{ isset($_GET['reject'])? 'checked':'' }} style="background-color: red" > Reject&nbsp;
                    </label>
                    
                </div>

            </form>



 
            <script>
                function cariSurat() {
                    window.location = '/requestParaf?no=' + document.getElementById('carisurat').value;
                }

            </script>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">

            @if(count($paraf) == 0)
            <div class="box-body">
                    
                <div class="alert alert-info alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h4><i class="icon fa fa-info"></i> Alert!</h4>
                  Tidak ada permintaan paraf dari manapun ...
                </div>
              </div>

            @endif
    


            @foreach ($paraf as $datas)
            <a href="/previewSurat/{{$datas->norec }}/$dj7783l721!u3kd9jhd40?back=requestParaf"
                style="color:white">

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="info-box bg-{{ $datas->class}}">
                        <span class="info-box-icon"> <img src=" {{ asset('images/img/proses.png') }} " alt="" srcset="">
                            </i></span>
                        <div class="info-box-content">
                            <div class="col-md-9" style="margin-left:-15px">
                                <span class="info-box-text"> {{ $datas->nosurat }} </span>
                            </div>
                            <div class="col-md-3" style="float: right">
                                <span style="margin-left:-15px" class="info-box-text btn-primary" align="center">
                                    {{ $datas->ket }} </span>
                            </div>
                            {{-- <span class="info-box-number"> {{ strtoupper($datas->perihal) }}</span> --}}
                            <span class="info-box-number" > {{ mb_strimwidth($datas->perihal, 0, 40, "..") }}</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: 70%"></div>
                            </div>

                            {{-- <div class="col-md-3">
                                <a href="/previewSurat/{{$datas->norec }}/$dj7783l721!@(40"
                                    style="color:white">
                                    <span class="progress-description">
                                        <i class="fa fa-arrow-circle-right"></i> Detail
                                    </span>
                                </a>
                            </div> --}}
                            <div class="col-md-6">

                                <span class="progress-description">
                                    @if ($datas->read == 1)
                                    <img style="height: 15px; width:15px;" src=" {{ asset('images/img/checklist.png') }} "
                                        alt="" srcset="">
                                    @else
                                    <img style="height: 15px" src=" {{ asset('images/img/uncheck.png') }} " alt=""
                                        srcset="">
                                    @endif
                                    {{ \Carbon\Carbon::parse($datas->tanggal)->format('d-M-Y') }} &nbsp;
                                        <span class="label label-warning pull-right float-right">
                                            {{ \Carbon\Carbon::parse($datas->updated_at)->diffForHumans() }}
                                        </span>

                                    
                                     

                                    {{-- {{ $datas->tanggal }} --}}
                                    {{-- <span style="color:#4863A0"> {{ getDif($datas->updatesurat) }} </span> --}}
                                    {{-- <span style="color:#4863A0"> {{ getDif($datas->updatesurat) }} </span> --}}
                                </span>

                                <span class="progress-description">
                                </span>

                            </div>


                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </a>
            @endforeach






            <!-- /.mail-box-messages -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer no-padding">
            <div class="mailbox-controls">

                <!-- /.btn-group -->
                <div class="pull-right">

                    {{ $paraf->appends(request()->query())->links() }}
                    {{-- {{ $paraf->links() }} --}}

                    <!-- /.btn-group -->
                </div>
                <!-- /.pull-right -->
            </div>
        </div>



    </div>
    <!-- /. box -->
</div>

<script>
    $(function () {
       
        //Enable iCheck plugin for checkboxes
        //iCheck for checkbox and radio inputs
        $('.mailbox-messages input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });

        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function () {
            var clicks = $(this).data('clicks');
            if (clicks) {
                //Uncheck all checkboxes
                $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
            } else {
                //Check all checkboxes
                $(".mailbox-messages input[type='checkbox']").iCheck("check");
                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
            }
            $(this).data("clicks", !clicks);
        });

        //Handle starring for glyphicon and font awesome
        $(".mailbox-star").click(function (e) {
            e.preventDefault();
            //detect type
            var $this = $(this).find("a > i");
            var glyph = $this.hasClass("glyphicon");
            var fa = $this.hasClass("fa");

            //Switch states
            if (glyph) {
                $this.toggleClass("glyphicon-star");
                $this.toggleClass("glyphicon-star-empty");
            }

            if (fa) {
                $this.toggleClass("fa-star");
                $this.toggleClass("fa-star-o");
            }
        });
    });

</script>


<style>
 

</style>


<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {{-- <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Surat</h4>
      </div> --}}
            <div class="modal-body">



                {{-- @include('Surat/PreviewSurat') --}}
                <div class="flatt">
                    <button class="btn btn-primary">Paraf</button>
                    <button class="btn btn-warning">Revisi</button>
                    <button class="btn btn-danger">Reject</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(function (params) {
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        })

    })

</script>
@endsection
