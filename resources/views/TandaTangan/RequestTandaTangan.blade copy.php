@extends('Html')
@section('contenutama')

<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="titleJudul">REQUEST TANDA TANGAN</h3>

            <div class="box-tools pull-right">
                <div class="has-feedback">
                    <div class="col-md-12">
                        <div class="col-md-10">
                            <input type="text" class="form-control input-sm" style="margin-top:15px;width: 300px"
                                id="carisurat" placeholder="Cari Nomor Surat ...">
                        </div>
                        <div class="col-md-2">
                            <button onclick="cariSurat()" class="input-sm btn-primary"
                                style="margin-top:15px; margin-left:-15px"> Cari
                            </button>


                        </div>
                    </div>
                    {{-- <input class="glyphicon glyphicon-search form-control-feedback" type="submit" > --}}
                </div>
            </div>
            <script>
                function cariSurat() {
                    window.location = '/requestttd?no=' + document.getElementById('carisurat').value;
                }

            </script>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
  






            <div class="">

                <!-- /.box-header -->
                <div class="box-body">
                    

                

                  <div class="col-md-4">
                    <ul class="products-list product-list-in-box">
                        <li class="item">
                            <div class="product-img">
                                <img src="images/img/proses.png" alt="Product Image">
                            </div>
                            <div class="product-info">
                                <a href="javascript:void(0)" class="product-title">Samsung TV
                                    <span class="label label-warning pull-right">$1800</span></a>
                                <span class="product-description">
                                    Samsung 32" 1080p 60Hz LED Smart HDTV.
                                </span>
                            </div>
                        </li>
                        <!-- /.item -->
                        <!-- /.item -->
                    </ul>
                </div>

                <div class="col-md-4">
                  <ul class="products-list product-list-in-box">
                      <li class="item">
                          <div class="product-img">
                              <img src="images/img/proses.png" alt="Product Image">
                          </div>
                          <div class="product-info">
                              <a href="javascript:void(0)" class="product-title">Samsung TV
                                  <span class="label label-warning pull-right">$1800</span></a>
                              <span class="product-description">
                                  Samsung 32" 1080p 60Hz LED Smart HDTV.
                              </span>
                          </div>
                      </li>
                      <!-- /.item -->
                      <!-- /.item -->
                  </ul>
              </div>

              <div class="col-md-4">
                <ul class="products-list product-list-in-box">
                    <li class="item">
                        <div class="product-img">
                            <img src="images/img/proses.png" alt="Product Image">
                        </div>
                        <div class="product-info">
                            <a href="javascript:void(0)" class="product-title">Samsung TV
                                <span class="label label-warning pull-right">$1800</span></a>
                            <span class="product-description">
                                Samsung 32" 1080p 60Hz LED Smart HDTV.
                            </span>
                        </div>
                    </li>
                    <!-- /.item -->
                    <!-- /.item -->
                </ul>
            </div>
            <div class="col-md-4">
              <ul class="products-list product-list-in-box">
                  <li class="item">
                      <div class="product-img">
                          <img src="images/img/proses.png" alt="Product Image">
                      </div>
                      <div class="product-info">
                          <a href="javascript:void(0)" class="product-title">Samsung TV
                              <span class="label label-warning pull-right">$1800</span></a>
                          <span class="product-description">
                              Samsung 32" 1080p 60Hz LED Smart HDTV.
                          </span>
                      </div>
                  </li>
                  <!-- /.item -->
                  <!-- /.item -->
              </ul>
          </div>
          <div class="col-md-4">
            <ul class="products-list product-list-in-box">
                <li class="item">
                    <div class="product-img">
                        <img src="images/img/proses.png" alt="Product Image">
                    </div>
                    <div class="product-info">
                        <a href="javascript:void(0)" class="product-title">Samsung TV
                            <span class="label label-warning pull-right">$1800</span></a>
                        <span class="product-description">
                            Samsung 32" 1080p 60Hz LED Smart HDTV.
                        </span>
                    </div>
                </li>
                <!-- /.item -->
                <!-- /.item -->
            </ul>
        </div>
        <div class="col-md-4">
          <ul class="products-list product-list-in-box">
              <li class="item">
                  <div class="product-img">
                      <img src="images/img/proses.png" alt="Product Image">
                  </div>
                  <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">Samsung TV
                          <span class="label label-warning pull-right">$1800</span></a>
                      <span class="product-description">
                          Samsung 32" 1080p 60Hz LED Smart HDTV.
                      </span>
                  </div>
              </li>
              <!-- /.item -->
              <!-- /.item -->
          </ul>
      </div>
                    <!-- /.box-body -->
                </div>


                <!-- /.box-footer -->
            </div>









            @foreach ($ttd as $datas)
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box bg-{{ $datas->class }}">
                    <span class="info-box-icon"> <img src=" {{ asset('images/img/ttd.png') }} " alt="" srcset="">
                        </i></span>
                    <div class="info-box-content">
                        <div class="col-md-9" style="margin-left:-15px">
                            <span class="info-box-text"> {{ $datas->nosurat }} </span>
                        </div>
                        <div class="col-md-3" style="float: right">
                            <span style="margin-left:-15px" class="info-box-text btn-primary" align="center">
                                {{ $datas->ket }} </span>
                        </div>
                        <span class="info-box-number"> {{ strtoupper($datas->perihal) }}</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>

                        <div class="col-md-6">
                            <a href="/previewSurat/{{$datas->norec }}/{{ Auth::user()->password }}" style="color:white">
                                <span class="progress-description">
                                    <i class="fa fa-arrow-circle-right"></i> lihat Selengkapnya
                                </span>
                            </a>
                        </div>
                        <div class="col-md-6">

                            <span class="progress-description">
                                @if ($datas->isread == 1)
                                <img style="height: 15px; width:15px;" src=" {{ asset('images/img/checklist.png') }} "
                                    alt="" srcset="">
                                @else
                                <img style="height: 15px" src=" {{ asset('images/img/uncheck.png') }} " alt=""
                                    srcset="">
                                @endif
                                <span style="color:#4863A0"> 1 Jam 15 Menit yang lalu </span>
                            </span>

                            <span class="progress-description">
                            </span>

                        </div>


                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            @endforeach



            <!-- /.mail-box-messages -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer no-padding">
            <div class="mailbox-controls">

                <!-- /.btn-group -->
                <div class="pull-right">
                    1-50/200
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                        <button type="button" class="btn btn-default btn-sm"><i
                                class="fa fa-chevron-right"></i></button>
                    </div>
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
    .modal {
        font-family: 'Tahoma', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 16px;
    }

    .modal-dialog {
        width: 100%;
        margin: 10px;
        height: 100% !important;
    }

    .modal-content {
        background: rgb(204, 204, 204);
        margin: -10px;
        margin-left: -30px;
    }

    .modal-header {
        background-color: #367fa9;
    }


    .bodysurat {
        margin-left: 37.7px;
        /* margin-right: 113px; */
    }

    .nospasi {
        margin: 0px;
    }

    .kanan {
        flat: right;
    }

    .flatt {
        display: flex;
        justify-content: space-between;
        width: 20%;
        padding: 10px;
        margin-left: auto;
        margin-right: auto;
        background-color: burlywood;

    }

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

@endsection
