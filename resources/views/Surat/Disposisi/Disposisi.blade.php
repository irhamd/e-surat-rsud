@extends('Html')
@section('content')
@php $no=1; @endphp

<div class="col-md-12">
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="orange titleJudul "> DISPOSISI SURAT </h3>
            <br>
            <form action="/disposisi" method="get">
                <div class="col-md-3 ml-15">
                    <div class="form-group">
                        <label>Tanggal</label>

                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input name="tanggal" type="text" class="form-control pull-right" id="tanggal"
                                value="{{ isset($_GET['tanggal']) ? $_GET['tanggal'] : '' }}">
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
                    <input type="text" class="form-control pull-right bg bg-info" name="perihal"
                        value="{{ isset($_GET['perihal']) ? $_GET['perihal'] : '' }}">
                </div>


                <div class="col-md-3 ml-15">
                    <br>
                    <button type="submit" class="btn bg-olive btn-flat"> <span class="fa fa-search"></span> OK</button>

                </div>

                <div class="col-md-12">
                    <label>
                    <input type="checkbox" name="input_agenda" class="minimal" {{ isset($_GET['input_agenda'])? 'checked':'' }} >  Belum Input Agenda &nbsp;
                    </label>
                    
                    
                </div>


                {{-- <div class="col-md-12">
                    <label>
                    <input type="checkbox" name="approve" class="minimal" {{ isset($_GET['approve'])? 'checked':'' }} >
                Approve &nbsp;
                </label>
                <label>
                    <input type="checkbox" name="requ" class="minimal" {{ isset($_GET['requ'])? 'checked':'' }}>
                    Request&nbsp;
                </label>
                <label>
                    <input type="checkbox" name="revisi" class="minimal-red" {{ isset($_GET['revisi'])? 'checked':'' }}>
                    Revisi&nbsp;
                </label>
                <label>
                    <input type="checkbox" name="reject" class="minimal-red" {{ isset($_GET['reject'])? 'checked':'' }}
                        style="background-color: red"> Reject&nbsp;
                </label>
        </div> --}}
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
                                <th> </th>
                                <th>Tujuan</th>
                                <th>Nomor surat</th>
                                <th>Perihal</th>
                                <th>Asal Surat</th>
                                {{-- <th class="center">Tanggal</th> --}}
                                <th class="center">Tanggal TTD</th>
                                <th class="center">Agenda</th>
                            </tr>

                            @foreach ($data as $item)
                            <tr class={{ !$item->noagenda ? "bg-yellow" :"" }}>
                          
                                <td>{{$no++}}</td>
                                <td width="50">  </td>

                                <td> {{ $item->namalengkap }} </td>
                                <td> {{ $item->nosurat }} </td>
                                <td> {{ $item->perihal }} </td>
                                <td> {{ $item->asalsurat }} </td>
                                {{-- <td> {{\Carbon\Carbon::parse( $item->tanggal)->format('d-m-Y') }} </td> --}}
                                <td> {{\Carbon\Carbon::parse( $item->tglttd)->format('d-m-Y') }} </td>
                                <td> 
                                @if($item->noagenda)
                                 {{ $item->noagenda }} 
                                @else
                                    <button type="button" onclick="getNorec('{{ $item->norec }}')" class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target="#modal-default">
                                        No. Agenda
                                    </button>
                                    @endif

                                    &nbsp;
                                    <a href='/previewSurat/{{$item->norecsurat }}/{{ Auth::user()->password }}?back=disposisi'> 
                                        <button class="btn btn-default btn-sm"> <span class="fa fa-envelope"></span>  
                                       </button>
                                   </a>

                                

                                </td>


                            </tr>
                            @endforeach


                            {{-- @foreach ($Disposisi as $item)
                                <tr class="{{ $item->class }} {{ $item->isreadoutbox == '0' ? 'b' :'' }} "
                            ondblclick="window.location='/previewSurat/{{$item->norec }}/{{ Auth::user()->password }}?back=Disposisi'"
                            style="cursor:pointer">
                            <td>{{ $no++ }}</td>

                            <td class="mailbox-name"> <b> {{ $item-> tujuan}} </b> </td>
                            <td>{{ $item-> nosurat}}</td>
                            <td>{{ $item-> perihal}}
                                <br>
                                <label class="f10 f-red">
                                    {{ \App\Tanggal::diff($item->created_at) }}
                                </label>
                            </td>
                            <td class="center"> {{ \App\Tanggal::formatindo($item-> tanggal)}} </td>
                            <td align="center">
                                {{ $item->statussurat }}
                            </td>

                            </tr>
                            @endforeach --}}
                        </table>
                        <br>
                        {{ $data->appends(request()->query())->links() }}
                      
                    </div>

                    <!-- /.box-body -->
                </div>

                <div class="box box-primary">
                    <div class="box-header">
                      <i class="ion ion-clipboard"></i>
        
                      <h3 class="box-title">To Do List</h3>
        
                      <div class="box-tools pull-right">
                        <ul class="pagination pagination-sm inline">
                          <li><a href="#">&laquo;</a></li>
                          <li><a href="#">1</a></li>
                          <li><a href="#">2</a></li>
                          <li><a href="#">3</a></li>
                          <li><a href="#">&raquo;</a></li>
                        </ul>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                      <ul class="todo-list">
                        <li>
                            <div class="row">
                          <!-- drag handle -->
                          <div class="col-md-3">
                          <span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                              </span>
                          <!-- checkbox -->
                          <input type="checkbox" value="">
                          <!-- todo text -->
                          <span class="text">Design a nice theme</span>
                          <!-- Emphasis label -->
                          <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small>
                          <!-- General tools such as edit or delete-->
                        </div>
                        <div class="col-md-2">
                            <span class="text">Design a nice theme</span>
                        </div>

                        <div class="tools">
                            <i class="fa fa-edit"></i>
                            <i class="fa fa-trash-o"></i>
                          </div>

                        </div>
                        </li>
                        <li>
                              <span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                              </span>
                          <input type="checkbox" value="">
                          <span class="text">Make the theme responsive</span>
                          <small class="label label-info"><i class="fa fa-clock-o"></i> 4 hours</small>
                          <div class="tools">
                            <i class="fa fa-edit"></i>
                            <i class="fa fa-trash-o"></i>
                          </div>
                        </li>
                        <li>
                              <span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                              </span>
                          <input type="checkbox" value="">
                          <span class="text">Let theme shine like a star</span>
                          <small class="label label-warning"><i class="fa fa-clock-o"></i> 1 day</small>
                          <div class="tools">
                            <i class="fa fa-edit"></i>
                            <i class="fa fa-trash-o"></i>
                          </div>
                        </li>
                        <li>
                              <span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                              </span>
                          <input type="checkbox" value="">
                          <span class="text">Let theme shine like a star</span>
                          <small class="label label-success"><i class="fa fa-clock-o"></i> 3 days</small>
                          <div class="tools">
                            <i class="fa fa-edit"></i>
                            <i class="fa fa-trash-o"></i>
                          </div>
                        </li>
                        <li>
                              <span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                              </span>
                          <input type="checkbox" value="">
                          <span class="text">Check your messages and notifications</span>
                          <small class="label label-primary"><i class="fa fa-clock-o"></i> 1 week</small>
                          <div class="tools">
                            <i class="fa fa-edit"></i>
                            <i class="fa fa-trash-o"></i>
                          </div>
                        </li>
                        <li>
                              <span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                              </span>
                          <input type="checkbox" value="">
                          <span class="text">Let theme shine like a star</span>
                          <small class="label label-default"><i class="fa fa-clock-o"></i> 1 month</small>
                          <div class="tools">
                            <i class="fa fa-edit"></i>
                            <i class="fa fa-trash-o"></i>
                          </div>
                        </li>
                      </ul>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix no-border">
                      <button type="button" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button>
                    </div>
                  </div>


                <div class="box-footer no-padding">
                    <div class="mailbox-controls">

                        <!-- /.btn-group -->
                        <div class="pull-right">

                            <!-- /.btn-group -->
                        </div>
                        <!-- /.pull-right -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog" style="margin-right: 100px;">
                <div class="modal-content" style="background-color: whitesmoke">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b> Lengkapi Lembar Disposisi </b></h4>
                    </div>
                    <div class="modal-body" style="margin-left: 15px">
                        <form id="formdisposisi" action="post">
                            <label for=""> No. Agenda </label>
                            <input type="text" class="form-control" name="noagenda" style="width: 50%">
                            <input type="hidden" name="" value="" id="norec">



                            <div class="modal-footer" style="padding-right: 100px">
                                <button type="button" class="btn btn-default pull-right"
                                    data-dismiss="modal">Batal</button>
                                &nbsp;
                                <button type="button" onclick="save()" class="btn btn-primary pull-right">Simpan</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
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
<script>
    // $("#formdisposisi").submit(function () {
    //     this.attr('action', )
    //     alert('submit');
    // })

    function save() {
        var no = $("#norec").val();
        // alert(no);
        $("#formdisposisi").attr('action', '/simpanDataDisposisi/' + no);
        $("#formdisposisi").submit();
    }

    function getNorec(norec) {
       $("#norec").val(norec) ;

    }

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
