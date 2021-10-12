<style>
    /* The container */
    .container-checkbox {
        display: block;
        position: relative;
        padding-left: 35px;
        /* margin-bottom: 5px; */
        cursor: pointer;
        /* font-size: 22px; */
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Create a custom checkbox */
    .container-checkbox .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #eee;
    }

    /* On mouse-over, add a grey background color */
    .container-checkbox:hover input~.checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container-checkbox input:checked~.checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .container-checkbox .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-checkbox input:checked~.checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container-checkbox .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }


    /* The container */
    .container-radio {
        display: block;
        position: relative;
        padding-left: 35px;
        /* margin-bottom: 3px; */
        cursor: pointer;
        /* font-size: 22px; */
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default radio button */
    .container-radio input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Create a custom radio button */
    .container-radio .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #eee;
        border-radius: 50%;
    }

    /* On mouse-over, add a grey background color */
    .container-radio:hover input~.checkmark {
        background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .container-radio input:checked~.checkmark {
        background-color: #2196F3;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .container-radio .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .container-radio input:checked~.checkmark:after {
        display: block;
    }

    /* Style the indicator (dot/circle) */
    .container-radio .checkmark:after {
        top: 9px;
        left: 9px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
    }

</style>

<div id="LembarDisposisiExternal" class="modal">
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> LEMBAR DISPOSISI EXTERNAL
                    <small class="pull-right">Date: 2/10/2014</small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row">
            <div class="col-sm-12 ">
                <div class="col-sm-1 "></div>

                <div class="col-sm-2 ">
                    <address>
                        <b> Surat Dari </b><br>
                        <b> No. Surat </b><br>
                        <b> Tgl. Surat </b><br>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-3 ">
                    <address>
                        <label id="dari"> :_____________________ </label> <br>
                        <label id="nosurat"> :_____________________ </label> <br>
                        <label id="tglsurat"> :_____________________ </label> <br>


                    </address>
                </div>

                <div class="col-sm-2 ">
                    <address>
                        <b> Diterima Tanggal </b><br>
                        <b> No. Agenda</b><br>
                        <b> Sifat </b><br>

                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-3 ">
                    <address>
                        <label id="terimatgl"> :_____________________ </label> <br>
                        <label id="noagenda"> :_____________________ </label> <br>
                        <label id="sifat"> : - </label> <br>

                    </address>

                    <!-- /.col -->
                </div>
            </div>
            <div class="col-sm-12 " style="align-items: center; text-align: center;">
                <label>
                    <input type="checkbox" class="minimal">
                    SANGAT SEGERA &emsp;
                </label>
                <label>
                    <input type="checkbox" onclick="return false;" onkeydown="return false;" class="minimal">
                    SEGERA &emsp;
                </label>
                <label>
                    <input type="checkbox" class="minimal">
                    RAHASIA &emsp;
                </label>
            </div>
            <div class="col-sm-2 "></div>


            <div class="col-sm-12 ">
                <div><b> Perihal : </b> </div>
                <b> <p class="form-control" id="perihal"> &emsp;  </p></b>

            </div>

            <div class="col-sm-12 ">
                <div class="col-sm-6">
                    <div><b> Diteruskan kepada sudara : </b> </div>
                    @foreach ($getWadirForDisposisi as $item)
                    <div class="col-sm-12">
                        <label class="container-checkbox">
                            {{ strtoupper($item->namajabatansurat) }} &emsp;
                            <input type="checkbox" id="{{ $item->id  }}" value="{{ $item->id  }}" >
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    @endforeach
{{--                     
                    <label class="container-checkbox"> {{ strtoupper($item->namajabatansurat) }}
                        <input type="checkbox" name="disposisiW[]" value="{{$item->id}}">
                        <span class="checkmark"></span>
                    </label> --}}
                    
                    {{-- <div class="col-sm-12">
                        <label class="container-checkbox">
                            WAKIL DIREKTUR UMUM DAN KEUANGAN &emsp;
                            <input type="checkbox" id="wadirumum" value="22370" disabled>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="col-sm-12">
                        <label class="container-checkbox">
                            WAKIL DIREKTUR PELAYANAN
                            <input type="checkbox" id="22362" value="22362" disabled>
                            <span class="checkmark"></span>
                        </label>
                    </div> --}}
                </div>

                <div class="col-sm-6">
                    <div><b> Dengan Hormat Harap : </b> </div>

                    <div class="col-sm-12">
                        {{-- <label>
                            <input type="checkbox" class="" id="tanggapan" >
                            TANGGAPAN DAN SARAN &emsp;
                        </label> --}}
                        <label class="container-checkbox">TANGGAPAN DAN SARAN
                            <input type="checkbox" id="tanggapan" disabled>
                            <span class="checkmark"></span>
                        </label>

                    </div>
                    <div class="col-sm-12">

                        <label class="container-checkbox"> PROSES LEBIH LANJUT
                            <input type="checkbox" id="proses" id="proses" disabled>
                            <span class="checkmark"></span>
                        </label>
                    </div>

                    <div class="col-sm-12">
                        <label class="container-checkbox"> KOORDINASI / INFORMASI
                            <input type="checkbox" id="koordinasi" id="koordinasi" disabled>
                            <span class="checkmark"></span>
                        </label>


                    </div>
                </div>



            </div>



            <div class="col-sm-12 ">
                <div><b> Komentar : </b> </div>
                <textarea name="" class="form-control" id="komentar"  rows="3"></textarea>

            </div>
            <div class="col-sm-12">
                <label>Assign To </label>
                <select class="form-control select2" multiple="multiple" style="width: 100%; color:black"
                    name="assignto[]" id="assignto">

                </select>
            </div>

            <div class="col-sm-12 ">
                <br>
                <div class="col-sm-10 "></div>
                <div class="pull-right">
                    <button type="button"  onclick="showSurat()" class="btn btn-primary">
                        <span class="fa fa-save"></span>
                        Preview Surat
                    </button>

                    <button type="button" id="tombokOK" onclick="simpanSisposisi()" class="btn btn-primary" data-dismiss="modal">
                        <span class="fa fa-save"></span>
                        OK
                    </button>

                    <button type="button" class="btn btn-danger" id="close" data-dismiss="modal"> <span
                            class="fa fa-remove"></span> 
                        Close
                    </button>
                </div>


            </div>


            <input type="hidden" id="suratfk">



            <!-- /.row -->

            <!-- Table row -->

            <!-- /.row -->


    </section>
</div>
@include('Helper/SessionNotification')


<script>
    const suratfkk = ""
    let pejabat = []
    var norec_disposisi, mark_pegawaifk
    $("#tombokOK").hide();

    function lembarDisposisiExternal() {
        $('#assignto')[0].options.length = 0;

        // const norec_esurat = suratfk;
        // alert( "Sebelum "+  suratfk)

        suratfk = $("#suratfk").val()
        // alert( "Setelah "+ suratfk)

        $.get("/InboxRev?getResponse=on&suratfk=" + suratfk, function (res) {
            
            console.log(res[0])

            norec_disposisi = res[0].norec_disposisiesurat;

            // alert( "Norec disposisi :"+ norec_disposisi)

            $.get("/getPejabat", function (response) {
                pejabat = response;

                $.each(pejabat, function (index, value) {
                    $('#assignto').append($('<option/>', {
                        value: value.id,
                        text: value.namalengkap
                    }));
                });
                // alert(res[0].mark_pegawaifk)
                // $("#assignto").val(res[0].mark_pegawaifk);
                const a = res[0].mark_pegawaifk
                if(a){
                    $("#assignto").val(a.split(","));
                }

            })




            $("#dari").html(": " + res[0].asalsurat)
            $("#perihal").html(res[0].perihal.toUpperCase())
            $("#nosurat").html(": " + res[0].nosurat)
            $("#tglsurat").html(": " + res[0].tanggal)
            $("#terimatgl").html(": " + res[0].tanggal)
            $("#noagenda").html(": " + res[0].noagenda)
            $("#komentar").html(res[0].catatandisposisi)

            const ket = res[0].ket;

            // MANUAL AMBIL ID PEGAWAI DIREKTUR 
            // 22362 = drg. Devy Eka Hartini, MM. => wadir pelayanan
            // 22370 = H. Zuhhad, S.Kep.Ners.M.Kes. = > wadir umum keuangan

            $('#tanggapan').attr('checked', false);
            $('#proses').attr('checked', false);
            $('#koordinasi').attr('checked', false);
            $('#22370').attr('checked', false);
            $('#22362').attr('checked', false);

            switch (ket) {
                case "Koordinasi / Informasi":
                    $('#koordinasi').attr('checked', true);
                    break;
                case "Proses Lebih Lanjut":
                    $('#proses').attr('checked', true);
                    break;
                case "Tanggapi dan Saran":
                    $('#tanggapan').attr('checked', true);
                    break;
            }

            switch (res[0].tujuanfk) {
                case "22370":
                    $('#22370').attr('checked', true);
                    break;
                case "22362":
                    $('#22362').attr('checked', true);
                    break;
            }


            // $('#tanggapan').attr('aria-checked', true);

            $("#suratfk").val(suratfk)
            // sessionStorage.setItem("suratfk", suratfk)

            // alert(res[0].tujuanfk)
            let assigntoEx =  res[0].assignto.split(",");
            console.log(assigntoEx[0])

            var cek =  assigntoEx[0].indexOf({{ Auth::user()->pegawaifk }})

            // alert(cek)
            

            if(res[0].tujuanfk == {{ Auth::user()->pegawaifk }} || cek >0 ){
                $("#tombokOK").show();
                $("#assignto").attr("disabled",false);
                $("#komentar").attr("disabled",false);
            } else{
                $("#tombokOK").hide();
                $("#assignto").attr("disabled",true);
                $("#komentar").attr("disabled",true);
            }

        })

    }


    function showSurat() {
        var st = "/previewSurat/" + $("#suratfk").val() + "/{{ Auth::user()->key }}?back=InboxRev";
            // window.location = st;
            window.open(st, '_blank');

        // var stt = st.replace(/\s/g, '');

        // alert(stt);
        // alert(replaceAll("\\s+","/"+nosurat+"/{{ Auth::user()->pegawaifk }}?back=InboxRev"));
    }

    function simpanSisposisi() {

        // alert( sessionStorage.getItem("suratfk");

        const obj = {
            "norec_disposisi": norec_disposisi,
            "_token": "{{ csrf_token() }}",
            "komentar": $("#komentar").val(),
            "suratfk":  $("#suratfk").val(),
            "mark_pegawaifk": $("#assignto").val().toString()
        }

        $.post("/updateKomentarDisposisi", obj, function (res) {
            console.log(res)
            // msgsuccess(res.msg)
            // $('#close').click();
        }) 

         
        // const arr = $("#assignto").val(this.mark_pegawaifk);

        // $.each(arr, function (index, value) {
        //     alert(value)
        // });




                }

</script>
