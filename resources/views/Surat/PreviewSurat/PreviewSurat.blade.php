<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Preview Surat</title>

</head>
{{-- <link rel="stylesheet" href="suratcss.css"> --}}

<script src=" {{asset('angular/angular.min.js')}}"></script>
<script src=" {{asset('plugins/iCheck/icheck.min.js')}}"></script>
{{-- <link rel="stylesheet"   href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}"> --}}

 
<link rel="icon" href="{{  asset('images/icon.png') }}">
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}
<link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/iCheck/all.css')}}">



{{-- <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script> --}}


<link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">

<!-- bootstrap wysihtml5 - text editor -->

<!-- Remember to include jQuery :) -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script> --}}


{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" /> --}}


<!-- jQuery Modal -->
<script src="/js/preview/jquery.min.js"></script>
<script src="/js/preview/jquery.modal.min.js"></script>
<link rel="stylesheet" href="/js/preview/jquery.modal.min.css" />

<link rel="stylesheet" href="/custom/manual.css">

@if (Session::has('errorr'))

<script>
    alert("Gagal Paraf ..."
    }
    })

</script>
@endif

<body>

    <div class="bodi">
        <br>
        <div class="preload">
            <img width="400" src=" {{ asset('images/img/loading4.gif') }}" />
        </div>


        <div class="kotakBawah">

            <div>
                <a href="/logouta">
                    <button class="button button1 hitam"> <span class="fa fa-sign-out"></span> Logout</button>
                </a>
                <a href="/{{ Session::get('back') }} "> <button class="button button1 hitam"> <span
                            class="fa fa-mail-reply"></span> Back</button> </a>
                <button id="btnPrint" class="button button1 hitam"> <span class="fa fa-file-pdf-o"></span> Export
                    PDF</button>

                @if ($data->tujuan == Auth::user()->pegawaifk && $data->statussurat == "TTD" && 
                        \App\ManageSurat::cekDisposisi( $data->disNorec ))
                <a href="#exDisposisi" rel="modal:open">
                    <button id="show" class="button button1 hijau"> Disposisi</button>
                </a>
                @endif

                @if ($TTDSingle)
                @if ( $TTDSingle->tujuan == Auth::user()->pegawaifk )
  
                @endif

                @if (($TTDSingle->isttd == 0 || $TTDSingle->isttd == null) && ($TTDSingle->status !="RJ" &&
                $TTDSingle->status !="RV" ) )
                <a class="tab button hijau" style="width: 200px" align="center"
                    onclick="aHref('/setTTD/{{ $data->norec}}')"> <span class="fa fa-gg"></span> APPROVE
                </a>
                <a href="#exRejectTTD" rel="modal:open">
                    <button class="button button1 orangered"> <span class="fa fa-remove"></span> Reject</button>
                </a>
                @endif

                @if (($TTDSingle->isttd == "1" && $TTDSingle->status =="TTD") && ($TTDSingle->disposisi == null ||
                $TTDSingle->disposisi == "" ) )




                {{-- <label style="font-size: 18px; color: white"><b> _Disposisi Ke : </b></label>
                            <select class=" select2" style="width: 60%;" id="disposisi">
                             @foreach ($pejabat as $item)
                                <option value="{{ $item->id }}"> {{ $item->namalengkap }}- <b>
                    {{ $item->namajabatansurat }}</b> </option>
                @endforeach

                </select>

                <button style="font-size: 19px; border-radius: 0%" class="btn btn-info b" id="send"> <b> OK </b>
                </button>


                <link rel="stylesheet" href="{{asset('bower_components/select2/dist/css/select2.min.css') }}">
                <script src="{{asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>


                <script>
                    $('.select2').select2();
                    $("#jabatanId").select2().select2('val', '22376');

                </script>
                --}}
                @endif

                @endif

                @if ($parafSingle)
                @if (($parafSingle->isparaf == 0 || $parafSingle->isparaf == null ) && ($parafSingle->status !="RJ" &&
                $parafSingle->status !="RV" ) )
                <a>
                    <button class="button button1 hijau" onclick="aHref('/setParaf/{{ $data->norec}}')">
                        <span class="fa fa-gg"></span>Approve / Paraf</button>
                </a>

                <a href="#ex1" rel="modal:open">
                    <button id="show" class="button button1 orange"> Revisi</button>
                </a>

                <a href="#exReject" rel="modal:open">
                    <button class="button button1 orangered"> <span class="fa fa-remove"></span> Reject</button>
                </a>
                @endif
                @endif


                <div class="modal orange" id="ex1">
                    <form action="/revisiByParaf/{{ $data->norec }}" method="post">
                        @csrf
                        <input type="hidden" name="nomorsurat" value=" {{ $data->nosurat }} ">
                        <input type="hidden" name="perihalsurat" value=" {{ $data->perihal }} ">
                        <p style="font-family: Verdana, Geneva, Tahoma, sans-serif"> Komentar </p>
                        <p>
                            <textarea name="komentar" class="textd" id="komentar" cols="30" rows="10"></textarea>
                        </p>
                        <a>
                            <input type="submit" class="button button1 orange" value="Revisi">
                        </a>
                    </form>
                </div>

                <div class="modal" id="exDisposisi">
                    <form action="/simpanDataDisposisi/{{ $data->norec}}" method="get">
                        <div class="col-md-12">
                            <h2 class="orange tengah"> Disposisi </h2>
                          

                            @foreach ($getWadirForDisposisi as $item)
                            <label class="container-checkbox"> {{ strtoupper($item->namajabatansurat) }}
                                <input type="checkbox" name="disposisiW[]" value="{{$item->id}}">
                                <span class="checkmark"></span>
                            </label>
                            @endforeach
                            <h2 class="orange tengah"> Dengan Hormat Harap : </h2>
                            <div class="form-group">
                                <label class="container-radio">Tanggapi dan Saran
                                    <input type="radio" checked="checked" name="denganhormat" value="Tanggapi dan Saran">
                                    <span class="checkmark"></span>
                                  </label>


                                  <label class="container-radio">Proses Lebih Lanjut
                                    <input type="radio" checked="checked" name="denganhormat" value="Proses Lebih Lanjut">
                                    <span class="checkmark"></span>
                                  </label>                                  
                                  
                                  <label class="container-radio">Koordinasi / Informasi
                                    <input type="radio" checked="checked" name="denganhormat" value="Koordinasi / Informasi">
                                    <span class="checkmark"></span>
                                  </label>

                              
                             
                            </div>
                            <input type="submit" class="button button1 orange" value="OK">
                        </div>
                    </form>

                </div>


                <div class="modal orangered" id="exReject">
                    <form action="/rejectByParaf/{{ $data->norec }}" method="post">
                        @csrf
                        <input type="hidden" name="nomorsurat" value=" {{ $data->nosurat }} ">
                        <input type="hidden" name="perihalsurat" value=" {{ $data->perihal }} ">

                        <p style="font-family: Verdana, Geneva, Tahoma, sans-serif"> Komentar </p>
                        <p>
                            <textarea name="komentar" class="textd" id="komentar" cols="30" rows="10"></textarea>
                        </p>
                        <a>
                            <input type="submit" class="button button1 orangered" value="Reject">
                        </a>

                    </form>
                </div>

                <div class="modal orangered" id="exRejectTTD">
                    <h1> Reject Tanda Tangan </h1>
                    <form action="/rejectByTandaTangan/{{ $data->norec }}" method="post">
                        @csrf
                        <p style="font-family: Verdana, Geneva, Tahoma, sans-serif"> Komentar </p>
                        <p>
                            <textarea name="komentar" class="textd" id="komentar" cols="30" rows="10"></textarea>
                        </p>
                        <a>
                            <input type="submit" class="button button1 orangered" value="Reject">
                        </a>

                    </form>
                </div>
            </div>
        </div>

        <br>
        <br>
        <br>
        <br>
        <br>

        @include('Surat/LembarSurat/LembarSurat')
        @if ($data->lembarlampiran)
        @include('Surat/LembarSurat/LembarLampiran')

        @endif
        <br>


        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
            No. Agenda
        </button>



        <div class="modal fade" id="modal-default">
            <div class="modal-dialog" style="margin-right: 100px;">
                <div class="modal-content" style="background-color: whitesmoke">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b> Lengkapi Lembar Disposisi </b></h4>
                    </div>
                    <div class="modal-body">
                        <form id="formdisposisi" action="post">
                            <label for=""> No. Agenda </label>
                            <input type="text" class="form-control" name="noagenda" style="width: 50%">



                            <div class="modal-footer" style="padding-right: 100px">
                                <button type="button" class="btn btn-default pull-right"
                                    data-dismiss="modal">Batal</button>
                                &nbsp;
                                <button type="button" onclick="save('dddd')"
                                    class="btn btn-primary pull-right">Simpan</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>




            <!-- /.mail-box-messages -->
        </div>



        <div class="box box-primary" style=" margin-left: auto ;width: 98%; padding-right:auto;">
            <div style="margin: 0px auto 60px auto; width: 80%">
                <div class="box-header">
                    <i class="ion ion-clipboard"></i>

                    <h3 class="box-title">Lampiran</h3>


                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                    <ul class="todo-list">
                        @foreach ($lampiran as $item)
                        <li>
                            <!-- drag handle -->
                            <span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                            </span>
                            <!-- checkbox -->
                            <!-- todo text -->
                            <a target="_blank" href="/Lampiran/{{$item->filename}}"> <span
                                    class="text">{{ $item->originalname }}</span> </a>
                            {{-- <span class="text">{{ filesize("/Lampiran/{{$item->filename}}") }}</span> --}}

                            <div class="tools" style="cursor: pointer">
                                <a target="_blank" href="/Lampiran/{{$item->filename}}">
                                    <i class="fa fa-download"></i> Download / Preview </a>
                            </div>
                        </li>
                        @endforeach


                    </ul>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>









</body>

</html>

@include('Helper/SessionNotification')



<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/kendo.all.min.js') }} "></script>


<script>
    function aHref(url) {
        // alert('dddd')
        $(".preload").show();
        window.location.href = url;
        // $(".preload").hide();
    }


    $(document).ready(function () {
        $(".preload").hide();
        $("#disposisi").hide();
        // $("#jabatanId").val({{ $TTDSingle->disposisi ?? '' }});
        // $("#jabatanId").val("23288");
        // $('#jabatanId').trigger('change');


        $("#btndisposisi").click(function () {
            $("#disposisi").show();
        })

        $("#send").click(function () {
            $(".preload").show();
            var url = "/setDisposisiRes?suratfk={{ $ttd->norec }}&pegawaifk=" + $("#disposisi").val();
            $.get(url, function (data) {
                // $(".preload").hide();
                alert(data.msg + "\n");
                window.location.href = "/{{ Session::get('back') }}";

            });
            // });

        });



        $("#qrCodeTTD").kendoQRCode({
            value: "{{ $ttd->tandatangankey }}",
            errorCorrection: "H",
            size: 170,
            color: "#166a83"
        });

        $("#qrCodeTTDreject").kendoQRCode({
            value: "{{ $ttd->tandatangankey }}",
            errorCorrection: "H",
            size: 170,
            color: "red"
        });
    });



    document
        .getElementById("btnPrint")
        .onclick = function () {
            printElement(document.getElementById("printThis"));
        }

    function printElement(elem) {
        var domClone = elem.cloneNode(true);

        var $printSection = document.getElementById("printSection");

        if (!$printSection) {
            var $printSection = document.createElement("div");
            $printSection.id = "printSection";
            document.body.appendChild($printSection);
        }

        $printSection.innerHTML = "";
        $printSection.appendChild(domClone);
        window.print();
    }

</script>
