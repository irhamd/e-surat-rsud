@extends('Html')
@section('content')
@php $no=1; @endphp
 
<div class="col-md-12">
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="orange titleJudul " >OUTBOX</h3>
            <br>

        <form action="/Outbox" method="get">
            <div class="col-md-3 ml-15">
              <div class="form-group">
                <label>Tanggal</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input name="tanggal" type="text"   class="form-control pull-right" id="tanggal"
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
                <input type="text" class="form-control pull-right bg bg-info" name="perihal" value="{{ isset($_GET['perihal']) ? $_GET['perihal'] : '' }}" >
            </div>

       
            <div class="col-md-3 ml-15">
              <br>
                <button type="submit" class="btn bg-olive btn-flat"> <span class="fa fa-search"></span> OK</button>

            </div>

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

        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
            <div class="">
                <div class="col-xs-12">
                    <div class="">
                        <div class="">
                            <div class="box-tools">
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">

                                <tr style="background-color: whitesmoke">
                                    <th width="50">No</th>
                                    <th >Tujuan</th>
                                    <th width="20"></th>
                                    <th >Nomor surat</th>
                                    <th >Perihal</th>
                                    <th class="center">Tanggal</th>
                                    <th class="center">Status</th>
                                    <th class="center">Rev</th>
                                    <th class="center"></th>
                                </tr>
                            
                                @foreach ($outbox as $item)
                                <tr class="{{ $item->class }} {{ $item->isreadoutbox == '0' ? 'b' :'' }} "

                                    
                                    ondblclick="window.location='/previewSurat/{{$item->norec }}/{{ Auth::user()->pegawaifk }}?back=Outbox'" 
                                    style="cursor:pointer">
                                        <td>{{ $no++ }}</td>

                                        <td  class="mailbox-name">  <b> {{ $item-> namajabatansurat}} </b> </td>
                                        <td> @if ($item->lembarlampiran)
                                            <span class="fa fa-at"></span> </td>
                                            @endif 
                                        <td>{{ $item-> nosurat}}</td>
                                        <td>{{ $item-> perihal}}
                                            <br>              
                                            <label class="f10 f-red">
                                                {{ \App\Tanggal::diff($item->created_at) }}
                                            </label>
                                        </td>
                                        <td class="center"> {{ \App\Tanggal::formatindo($item-> tanggal)}}  </td>
                                        {{-- <td> {{ \Carbon\Carbon::parse($item-> tanggal)->format('d-m-Y')}}  </td> --}}
                                        <td align="center">
                                                {{ $item->statussurat }}
                                        </td>
                                        

                                        <td width="70"> 
                                            @if ($item->statussurat =="RV")
                                                <a href="buatSurat?edit= {{ $item->norec }} ">
                                                    <button class="btn btn-xs btn-info"> 
                                                        <i class="fa fa-edit"></i> 
                                                        Revisi 
                                                    </button>
                                                </a>                                                
                                            @endif 

                                        </td>
                                        <td>
                                            <a href="/getTimeline?suratfk={{$item->norec }} ">
                                                <button class="btn btn-xs"> 
                                                    <i class="fa fa-history"></i> 
                                                </button>
                                            </a>

                                        </td>

                                    </tr>
                                @endforeach

                            </table>
                            <br>
                            <p style="float: right">   <strong> RJ  </strong>: Reject, <strong> Rv </strong> : Revisi, 
                                <strong> Rq  </strong> : Request </p>
                        </div>

                        @if(count($outbox) == 0)
                        <div class="box-body">
                                
                            <div class="alert alert-info alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <h4><i class="icon fa fa-info"></i> Alert!</h4>
                              Tidak ada data  ...
                            </div>
                          </div>
                
                        @endif


                        <!-- /.box-body -->
                    </div>

                    <div class="box-footer no-padding">
                        <div class="mailbox-controls">

                            <!-- /.btn-group -->
                            <div class="pull-right">
                                {{-- {{ $outbox->links() }} --}}

                                <!-- /.btn-group -->
                            </div>
                            <!-- /.pull-right -->
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>



            <!-- /.mail-box-messages -->
        </div>
        <!-- /.box-body -->




    </div>
    <!-- /. box -->
</div>




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
