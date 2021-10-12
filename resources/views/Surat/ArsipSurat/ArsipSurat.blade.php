@extends('Html')
@section('content')


<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>



<div class="col-md-12">
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="orange titleJudul ">ARSIP SURAT</h3>
            <br>

            <form action="arsipSurat" method="get">
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
                        <input type="text" class="form-control pull-right" name="nosurat"
                        value="{{ isset($_GET['nosurat']) ? $_GET['nosurat'] : '' }}">
                        
                    </div>
                </div>
                <div class="col-md-3 ml-15">
                    <label>Perihal</label>
                    <input type="text" class="form-control pull-right" name="perihal"
                    value="{{ isset($_GET['perihal']) ? $_GET['perihal'] : '' }}">

                </div>


                <div class="col-md-3 ml-15">
                    <br>
                    <button type="submit" class="btn bg-olive btn-flat"> <span class="fa fa-search"></span> OK</button>

                </div>
            </form>


        </div>
        <div class="col-md-12">
            <p> <button class="btn btn-success" id="tombolInput" onclick='inputSurat()'> <span
                        class="fa fa-download"></span> &nbsp; Input </button> </p>
            <br>
            <div class="col-md-12">
                @if (Session::has("berhasil"))

                <div class="alert alert-success alert-dismissible" id="alertBerhasil">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Suksess!</h4>
                    {{ Session('berhasil') }}
                </div>
                @endif

                @if (Session::has("gagal"))
                <div class="alert alert-danger alert-dismissible" id="alertGagal">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Error!</h4>
                    {{ Session('gagal') }}
                </div>
                @endif

            </div>
          

            <div class="col-md-12" id="inputsurat">
                <div class="col-md-4">
                    <form action="UploadArsipSurat" id="formsurat" enctype="multipart/form-data" method="post"
                        data-toggle="validator" role="form">
                        @csrf


                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="titleJudul bg-blue"> INPUT SURAT  </h3>

                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Asal Surat</label>

                                    <input name="asalsurat" id="asalsurat"  class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Tujuan</label>

                                    <input name="tujuan" id="tujuan" class="form-control"
                                         required>
                                </div>
                                <div class="form-group">
                                    <label>Nomor Surat</label>
                                    <input name="nosurat" type="text"  id="nosurat"
                                        class="form-control" data-mask required>
                                </div>



                       

                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" id="tanggalsurat"  class="form-control"
                                        name="tanggal" required>
                                </div>
                                <div class="form-group">
                                    <label>Perihal</label>
                                    <input type="text" name="perihal" id="perihal" class="form-control"
                                          required>
                                </div>

                            
                                <div class="form-group">
                                    <label>No. Agenda</label>
                                    <input type="text" id="noagenda"  name="noagenda" class="form-control" >
                                </div>

                                <input type="hidden" id="norec" name="norec" value="">



                                <div class="box-footer">
                                    <div class="pull-right">


                                        <button id="btnsimpan" class="btn btn-info" type="submit" style="width: 100px"> <span
                                                class="fa fa-save"></span>
                                            Simpan</button>

                                        <button onclick='tutup()' class="btn btn-danger" style="width: 100px"> <span
                                                class="fa fa-remove"></span>
                                            Tutup</button>

                                    </div>

                                </div>
                                <input type="file" id="myPdf" name="lampiran" class="form-control" style="visibility: hidden" required />
                                <p id="wait"> Sedang mempersiapkan file pdf ... </p>
                            </div>
                        </div>
                    </form>

                    <br>
                    <br>
                    <br>
                </div>
                <div class="col-md-8">
                    <canvas class="shadow" id="pdfViewer"></canvas>
                    <br>
                    <label for="myPdf" class="btn btn-app">
                        <i class="fa fa-file-pdf-o"></i> Upload PDF
                    </label>


                </div>
            </div>


            <div id="largeModal" class="modal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            {{-- <h1> <strong> PREVIEW SURAT EXTERNAL</strong> </h1> --}}
                            <button type="button" class="btn btn-primary" data-dismiss="modal"> <span
                                    class="fa fa-remove"></span> Close</button>

                        </div>
                        <div class="modal-body">
                        <!-- <iframe src="/pdf/pdf.pdf" height="100%" width="100%"> -->
                        <!-- <object data="pdf/pdf.pdf" type="pdf/html" width="350" height="250"> -->
                            <div id="showHere"></div>
                            <script>
                                function showPdf(url) {
                                    PDFObject.embed('SuratArsip/' + url, "#showHere", {
                                        width: "100%"
                                    });
                                }

                            </script>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <!-- /.box-header -->
        <div class="box-body no-padding" id="dataSurat">
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

                                @php $no=1; @endphp

                                <tr>
                                    <th class="center" width="50">No</th>
                                    <th>Tujuan</th>
                                    <th>Nomor surat</th>
                                    <th>Perihal</th>
                                    <th>Tanggal</th>
                                    <th width="20"></th>
                                    <th width="20"></th>
                                    <th width="10"></th>
                                </tr>
                                <tbody>
                                @foreach ($data as $item)
                                <tr onclick="showPdf('{{ $item->lampiran }}')" style="background-color:#3c8dbc36">
                                    <td class="center"> {{ $no++ }} </td>
                                    <td> {{ $item->tujuan }} </td>
                                    <td width="220"> {{ $item->nosurat }} </td>
                                    <td> {{ $item->perihal }} <br>
                                        <label class="time f10 f-red">
                                            <i class="fa fa-clock-o"> </i>
                                            {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                        </label>
                                    </td>
                                    <td width="90"> {{ $item->tanggal }} </td>
                                    <td> {{ $item->assignto }} </td>
                                    <td> 
                                        <a href="#largeModal" class="btn btn-sm btn-primary" data-toggle="modal">
                                            <span class="fa fa-image"></span>
                                        </a>
                                    </td>
                                    <td> 
                                        <a onclick="hapusArsipSurat('{{$item->norec }}')" class="btn btn-sm btn-danger" data-toggle="modal">
                                            <span class="fa fa-trash"></span>
                                        </a>
                                    </td>
                                    <td> 
                                        <a onclick="editSurat({{$item}})" class="btn btn-sm btn-warning" data-toggle="modal">
                                            <span class="fa fa-pencil-square-o"></span>
                                        </a>
                                    </td>
                                    <td>
                                        {{-- <td>
                                            <a href="/getTimeline?suratfk={{$item->norec }} ">
                                                <button class="btn btn-xs"> 
                                                    <i class="fa fa-history"></i> 
                                                </button>
                                            </a>

                                        </td> --}}
                                    </td>
                                    {{-- {{  $item->created_at->diffForHumans() }}</span> </td> --}}
                                    <td class="f10 f-red">

                                    </td>


                                </tr>
                                @endforeach
                                
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>

                    
                    {{ $data->appends(request()->query())->links() }}





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



            <!-- /.mail-box-messages -->
        </div>


        <!-- /.box-body -->




    </div>
    <!-- /. box -->
</div>


@include('/Surat/ArsipSurat/ArsipSuratJs') 

<style>
    .modal-open .modal {
        overflow-y: hidden;
    }

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

    .pdfobject-container {
        height: 950px;
        /* border: 1rem solid rgba(0,0,0,.1)  */
    }

</style>


<!-- Button trigger modal -->


@endsection
