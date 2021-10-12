@extends('Html')
@section('content')


{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>



<div class="col-md-12">
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="orange titleJudul ">SURAT EXTERNAL</h3>
            <br>

            <form action="/suratExternalRev" method="get">
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
                        class="fa fa-download"></span> &nbsp; Input Surat External </button> </p>
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
            {{-- <div class="col-md-2"></div> --}}


            <div class="col-md-12" id="inputsurat">
                <div class="col-md-4">
                    <form action="simpanSuratExternal" enctype="multipart/form-data" method="post"
                        data-toggle="validator" role="form">
                        @csrf


                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="titleJudul bg-blue"> INPUT SURAT EXTERNAL </h3>

                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Asal Surat</label>

                                    <input name="asalsurat"  class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Tujuan</label>

                                    <input name="tujuan" id="inputName" class="form-control"
                                         required>
                                </div>
                                <div class="form-group">
                                    <label>Nomor Surat</label>
                                    <input name="nosurat" type="text" value="{{ $editsurat->nosurat ?? '' }}"
                                        class="form-control" data-mask required>
                                    {{-- 087/RM-SIMRS/RSUD/III/2020 --}}
                                    {{-- <input name="nosurat" class="form-control" value="@{{nama}}"> --}}
                                </div>



                                <div class="form-group">
                                    <label>Assign To </label>
                                    <select class="form-control select2" multiple="multiple"
                                        style="width: 100%; color:black" name="assignto[]" id="pegawaifk" required>
                                        @foreach ($pejabat as $item)
                                        <option value="{{ $item->id }}"> {{ $item->namajabatansurat  }} - {{ $item->namalengkap}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date"   class="form-control"
                                        name="tanggal" required>
                                </div>
                                <div class="form-group">
                                    <label>Perihal</label>
                                    <input type="text" name="perihal" class="form-control"
                                          required>
                                </div>

                                <div class="form-group">
                                    <label>Disposisi</label>
                                    <input type="checkbox" onclick="langsungDisposisi()" name="isDisposisi" id="iddisposisi"
                                        value="1">
                                </div>

                                <div class="form-group">
                                    <label>No. Agenda</label>
                                    <input type="text" id="noagenda" name="noagenda" class="form-control" >
                                </div>



                                <div class="box-footer">
                                    <div class="pull-right">


                                        <button class="btn btn-info" type="submit" style="width: 100px"> <span
                                                class="fa fa-save"></span>
                                            Simpan</button>

                                        <button onclick='tutup()' class="btn btn-danger" style="width: 100px"> <span
                                                class="fa fa-remove"></span>
                                            Tutup</button>

                                    </div>

                                </div>
                                <input type="file" id="myPdf" name="lampiran" style="visibility: hidden" required />
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
                            <div id="showHere"></div>
                            <script>
                                function showPdf(url) {
                                    PDFObject.embed('SuratExternal/' + url, "#showHere", {
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
                                    <th>Assign To</th>
                                    <th width="20"></th>
                                    <th width="20"></th>
                                    <th width="10"></th>
                                </tr>
                                @foreach ($data as $item)
                                <tr onclick="showPdf('{{ $item->lampiran }}')" class="approve">
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
                                    <td> <a href="#largeModal" class="btn btn-sm btn-primary" data-toggle="modal">
                                            <span class="fa fa-image"></span> Preview</a>
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

<script>
    $("#inputsurat").hide();
    $("#wait").hide();

    function inputSurat() {
        $("#inputsurat").show("fast");
        $("#dataSurat").hide("fast");
        $("#tombolInput").hide("fast");

    }

    // function langsungDisposisi() {
    $("#isdisposisi").click(function () {
        
        // if ($('#isdisposisi').is(':checked')) {
        if($("#isdisposisi").prop("checked") == true){
            $("#noagenda").prop("disabled",true)
            
        } else{
            $("#noagenda").prop("disabled",false)
        }
    })
    

    function tutup() {
        $("#inputsurat").hide("fast");
        $("#dataSurat").show("fast");
        $("#tombolInput").show("fast");
        return false;
    }

    // Loaded via <script> tag, create shortcut to access PDF.js exports.
    var pdfjsLib = window['pdfjs-dist/build/pdf'];
    // The workerSrc property shall be specified.
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';

    $("#myPdf").on("change", function (e) {

        $("#wait").show();

        var file = e.target.files[0]
        if (file.type == "application/pdf") {
            var fileReader = new FileReader();
            fileReader.onload = function () {
                var pdfData = new Uint8Array(this.result);
                // Using DocumentInitParameters object to load binary data.
                var loadingTask = pdfjsLib.getDocument({
                    data: pdfData
                });
                loadingTask.promise.then(function (pdf) {
                    console.log('PDF loaded');

                    // Fetch the first page
                    var pageNumber = 1;
                    pdf.getPage(pageNumber).then(function (page) {
                        console.log('Page loaded');

                        var scale = 1.5;
                        var viewport = page.getViewport({
                            scale: scale
                        });

                        // Prepare canvas using PDF page dimensions
                        var canvas = $("#pdfViewer")[0];
                        var context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        // Render PDF page into canvas context
                        var renderContext = {
                            canvasContext: context,
                            viewport: viewport
                        };
                        var renderTask = page.render(renderContext);
                        renderTask.promise.then(function () {
                            console.log('Page rendered');
                        });
                    });
                }, function (reason) {
                    // PDF loading error
                    console.error(reason);
                });
            };
            fileReader.readAsArrayBuffer(file);
        }
        $("#wait").hide();

    });

</script>


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
