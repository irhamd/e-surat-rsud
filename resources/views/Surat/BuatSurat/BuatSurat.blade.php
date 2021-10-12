@extends('Html')
@section('content')


    <div class="col-md-12">

        @if (Session::has("berhasil"))

        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Suksess!</h4>
            {{ Session('berhasil') }}
        </div>
        @endif

        @if (Session::has("gagal"))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Gagal simpan surat ...!</h4>
            {{ Session('gagal') }}
        </div>

        @endif
        <div class="col-md-12">
            <form action="/prosesBuatSurat" id="formBuatSurat" method="post" data-toggle="validator" role="form"
                enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="edit" value="{{ isset($_GET['edit'])? $_GET['edit'] :'' }} ">

                <div class="box box-primary" style="height: 1000px">
                    <div class="box-header with-border">
                        <h3 class="titleJudul bg-blue"> {{isset($_GET['edit'])?"REVISI SURAT":"BUAT SURAT BARU" }} </h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-md-7">
                            {{-- <div class="form-group">
                            <label>Tujuan</label>

                            <input name="tujuan" id="tujuan" class="form-control"
                                value="{{ $editsurat->tujuan ?? '' }}" required>
                        </div> --}}




                        <div class="form-group">
                            <label>Tujuan</label>
                            <select class="form-control select2" id="tujuan" name="tujuan" style="width: 100%;">
                                @foreach ($pejabat as $item)
                                <option value="{{ $item->id }}">{{ $item->namajabatansurat ." == ". $item->namalengkap}}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nomor Surat</label>
                            <input name="nosurat" id="nosurat" type="text" value="{{ $editsurat->nosurat ?? '' }}"
                                class="form-control" required autocomplete="on">
                            <p class="f-red" id="ket"> <span class="fa fa-times-circle-o"></span> Nomor surat sudah di
                                gunakan ! </p>
                            {{-- 087/RM-SIMRS/RSUD/III/2020 --}}
                            {{-- <input name="nosurat" class="form-control" value="@{{nama}}"> --}}
                        </div>
 
                        <div class="form-group">
                            <label>Lampiran</label>
                            <input name="lamp" type="text" id="lampiran" value="{{ $editsurat->lamp ?? '' }}" autocomplete="off"
                                class="form-control" required>
                        </div>


                        <div class="form-group">
                            <label>Tanda Tangan Oleh </label>
                            <select class="form-control select2" id="ttdby" style="width: 100%; color:black"
                                name="ttdby[]">
                                @foreach ($pejabat as $item)
                                <option value="{{ $item->id }}">{{ $item->namajabatansurat ." == ". $item->namalengkap}}
                                </option>
                                @endforeach

                            </select>
                        </div>

                        <button id="btnPrint" class="float-kiri button  orange" style="width: 200px"> <span
                                class="fa fa-file-pdf-o"></span> Preview Surat</button>


                        <button class="button  float-kiri hijau" style="width: 300px; margin-right: 210px">
                            <span class="fa fa-send"></span>
                            Kirim
                        </button>





                        <div class="form-group">
                            <label>Paraf Oleh </label>
                            <select class="form-control select2" multiple="multiple" style="width: 100%; color:black"
                                name="parafby[]" id="parafby">
                                @foreach ($pejabat as $item)
                                <option value="{{ $item->id }}">{{ $item->namajabatansurat ." == ". $item->namalengkap}}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Tanggal</label>

                            <input type="date" value="{{ $editsurat->tanggal ?? '' }}" class="form-control" name="tgl"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Perihal</label>
                            <input type="text" id="perihal" name="perihal" class="form-control" autocomplete="off"
                                value="{{ $editsurat->perihal ?? '' }}" required>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Tembusan </label>
                            <select class="form-control select2" id="tembusan" multiple="multiple"
                                style="width: 100%; color:black" name="tembusan[]" id="tembusan">
                                @foreach ($pejabat as $item)
                                <option value="{{ $item->id }}">{{ $item->namajabatansurat}}</option>
                                @endforeach
                            </select>
                        </div>

                        <strong> Lampiran Max (2MB) </strong>
                        <div class="input-group control-group increment">
                            <input type="file" id="file" name="lampiran[]" class="form-control">
                            <div class="input-group-btn">
                                <button class="btn btn-success" type="button"><i
                                        class="glyphicon glyphicon-plus"></i>Tambah</button>
                            </div>
                        </div>

                        <div class="clone hide">
                            <div class="control-group input-group" style="margin-top:10px">
                                <input type="file" id="file" name="lampiran[]" class="form-control">
                                <div class="input-group-btn">
                                    <button class="btn btn-danger" type="button"><i
                                            class="glyphicon glyphicon-remove"></i> Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        textarea div{
                            text-indent: 40px;
                        }
                    </style>

                    <div class="col-md-12">
                        <div class="form-group">

                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active bg-yellow"><a class="approve" href="#tab_1" data-toggle="tab"
                                            class=""><b> Buat Surat Baru </b></a></li>
                                    <li class="bg-yellow"><a href="#tab_2" data-toggle="tab"><b> Buat Lampiran </b></a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">

                                        <textarea name="isisurat"  required id="formsurat" class="form-control"
                                            style="height: 800px">
                                            <!-- <div style="text-indent: 40px;" > Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa Oke apa aja yang bisa </div> -->
                                        {{$editsurat->bodysurat?? $tamplate }}
                                    </textarea>

                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2">
                                        <b>
                                            <h3> LAMPIRAN </h3>
                                        </b>
                                        <hr>
                                        <textarea name="lampiransurat" required id="lampiransurat" class="form-control"
                                            style="height: 800px">
                                            {{ isset($editsurat->lembarlampiran) ?? $editsurat->lembarlampiran }}


                                    </textarea>

                                    </div>

                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>



                            <script>
                                $("#textarea").keydown(function (e) {
                                    if (e.keyCode === 9) { // tab was pressed
                                        // get caret position/selection
                                        var start = this.selectionStart;
                                        var end = this.selectionEnd;

                                        var $this = $(this);
                                        var value = $this.val();

                                        // set textarea value to: text before caret + tab + text after caret
                                        $this.val(value.substring(0, start) +
                                            "\t" +
                                            value.substring(end));

                                        // put caret at right position again (add one for the tab)
                                        this.selectionStart = this.selectionEnd = start + 1;

                                        // prevent the focus lose
                                        e.preventDefault();
                                    }
                                });

                            </script>
                        </div>

                    </div>

                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="pull-right">
                        </div>

                    </div>
                    <!-- /.box-footer -->
                </div>
        </div>
        </form>
    </div>






    <!-- /. box -->
</div>



<div id="preview1" class="bodi">
    <br>


    <div class="kotakBawah">



    </div>
    <br>
    <br>

    <br>
    <br>
    <br>

    <page size="F4">
        <div id="printThis">
            <img class="autosize" src="{{ asset('images/data/KopSurat.png') }}" alt="" srcset="">
            <table style="border-collapse: collapse; width: 100%; height: auto; border-style: none;" border="0">
                <tbody>

                    <tr>
                        <td style="width: 7.4633%; ">&nbsp;</td>
                        <td style="width: 1.27613%; ">&nbsp;</td>
                        <td style="width: 38.558%; ">&nbsp;</td>
                        <td style="width: 27%; ">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="width: 7.4633%; ">&nbsp;</td>
                        <td style="width: 1.27613%; ">&nbsp;</td>
                        <td style="width: 38.558%; ">&nbsp;</td>
                        <td style="width: 27%; padding-bottom: 20px;">Mataram,
                            <p ng-bind="tgl | date:'dd MMMM yyyy'"></p>
                    </tr>


                    <tr>
                        <td>No</td>
                        <td>:</td>
                        <td>
                            <strong id="nosuratA"> </strong>
                        </td>
                        <td style="width: 27%; ">Kepada</td>
                    </tr>
                    <tr>
                        <td style="width: 7.4633%; ">Lampiran</td>
                        <td style="width: 1.27613%; ">:</td>
                        <td style="width: 38.558%;" id="lampiranA"></td>
                        <td style="width: 27%; "> Yth . <span id="tujuanA"></span> </td>
                    </tr>
                    <tr>
                        <td style="width: 7.4633%; ">Hal</td>
                        <td style="width: 1.27613%; ">:</td>
                        <td style="width: 38.558%; ">
                            <strong id="perihalA"></strong>
                        </td>
                        <td style="width: 27%; ">di -</td>
                    </tr>
                    <tr>
                        <td style="width: 7.4633%; ">&nbsp;</td>
                        <td style="width: 1.27613%; ">&nbsp;</td>
                        <td style="width: 38.558%; ">&nbsp;</td>
                        <td style="width: 27%; ">&nbsp; &nbsp; &nbsp; Tempat</td>
                    </tr>
                    <tr>
                        <td style="width: 7.4633%; ">&nbsp;</td>
                        <td style="width: 1.27613%; ">&nbsp;</td>
                        <td style="width: 38.558%; "></td>
                        <td style="width: 27%; ">&nbsp;</td>
                    </tr>

                    <tr>
                        <td style="width: 7.4633%; ">&nbsp;</td>
                        <td style="width: 1.27613%; ">&nbsp;</td>
                        <td class="setSpasi" style=" text-align: justify; width: 53.4278%; " colspan="2">
                            <p id="contentMce"></p>

                            {{-- <script> $("#contentMce").html(tinyMCE.activeEditor.getContentMce()); </script> --}}
                            {{-- @{{isisurat}} --}}
                            {{-- {!!html_entity_decode($data->bodysurat )!!} --}}
                            {{-- {!! $data->bodysurat !! } --}}
                        </td>
                    </tr>

                    <tr>
                        <td style="width: 7.4633%; ">&nbsp;</td>
                        <td style="width: 1.27613%; ">&nbsp;</td>
                        <td style="text-align: justify; " colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="width: 7.4633%; margin-left:27%">&nbsp;</td>
                        <td style="width: 1.27613%; ">&nbsp;</td>
                        <td style="width: 53.4278%;; " colspan="2">
                            <div class="tab">
                                <p id="approve"> </p>
                                <p>RSUD Kota Mataram</p>


                                <br>
                                <br>
                                <br>
                                <br>

                                <p> <span style="text-decoration: underline;">
                                        <strong id="ttdbyA"> </strong>
                                    </span>
                                </p>
                                <p>NIP ...................</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <br>
        <br>
    </page>
</div>


@include('Surat/BuatSurat/BuatSuratJs')

<!-- /.col -->
@endsection
