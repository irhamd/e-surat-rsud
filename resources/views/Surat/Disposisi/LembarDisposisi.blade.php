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
    .f18{
        font-size: 18px;
        font-weight: bolder;
        text-transform: uppercase;
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

<div id="lembarDisposisi" class="modal">
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> <b> LEMBAR DISPOSISI </b>
                    <small class="pull-right"> {{ date('d-M-Y') }} </small>
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
            <form id="formexternal">
                <div class="col-sm-12 ">
                    <div class="col-sm-6">
                        <div><b> Diteruskan kepada sudara : </b> </div>
                        @foreach ($getWadirForDisposisi as $item)
                        <div class="col-sm-12">
                            <label class="container-checkbox">
                                {{ strtoupper($item->namajabatansurat) }} &emsp;
                                <input type="checkbox" id="{{ $item->id  }}" name="disposisiW[]" value="{{ $item->id  }}" >
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        @endforeach
    
                    </div>

                    <div class="col-sm-6">
                        <div><b> Dengan Hormat Harap : </b> </div>

                        <div class="col-sm-12">
                            {{-- <label>
                                <input type="checkbox" class="" id="tanggapan" >
                                TANGGAPAN DAN SARAN &emsp;
                            </label> --}}
                            <label class="container-checkbox">TANGGAPAN DAN SARAN
                                <input type="checkbox" value="Tanggapi dan Saran" id="tanggapan" name="denganhormat[]">
                                <span class="checkmark"></span>
                            </label>

                        </div>
                        <div class="col-sm-12">

                            <label class="container-checkbox"> PROSES LEBIH LANJUT
                                <input type="checkbox" value="Proses Lebih Lanjut" id="proses" name="denganhormat[]">
                                <span class="checkmark"></span>
                            </label>
                        </div>

                        <div class="col-sm-12">
                            <label class="container-checkbox"> KOORDINASI / INFORMASI
                                <input type="checkbox" value="Koordinasi / Informasi"  id="koordinasi" name="denganhormat[]">
                                <span class="checkmark"></span>
                            </label>


                        </div>



                    </div>


                </div>
                
                
                <div class="col-sm-12">
                    <div> <b> Komentar : </b> </div>  
                   <div style=" margin-left : 20px; " class="col-sm-11">
                         <div  id="historikomentar">

                         </div>
                    </div>
                </div>


                <div class="col-sm-12 ">
                    <div><b> Berikan Komentar  </b> </div>
                    <textarea  class="form-control" id="komentar" name="catatan"  rows="3"></textarea>
                
                    
                </div>

                {{-- @if ( Auth::user()->jabatanesurat != 'dir' ) --}}
                <div class="col-sm-12">
                    <label>Assign To </label>
                    <select class="form-control select2" multiple="multiple" style="width: 100%; color:black"
                        name="assignto[]" id="assignto">
                    </select>
                </div>
            {{-- @endif --}}
        </form>

            <div class="col-sm-12 ">
                <br>
                <div class="col-sm-8 ">
                    <a href="#sebarSurat" data-toggle="modal">
                        <button type="button" onclick="sebarSurat()" class="btn btn-info"> <span
                            class="fa fa-share"></span> 
                                Sebarkan
                        </button>
                    </a>
                </div>
                <div class=" col-sm-4">
                    <div class="pull-right">
                    <button type="button"  onclick="showSurat()" class="btn btn-primary">
                        <span class="fa fa-save"></span>
                        Preview Surat
                    </button>

                    <button type="button" id="tombokOK" onclick="simpanSisposisi()" class="btn btn-primary">
                        <span class="fa fa-save"></span>
                        Simpan
                    </button>
 

                    <button type="button" class="btn btn-danger" id="close" data-dismiss="modal"> <span
                            class="fa fa-remove"></span> 
                        Close
                    </button>
                </div>
            </div>
            </div>
 
            


            <input type="hidden" id="suratfk">

    </section>
</div>
@include('Helper/SessionNotification')



<script>
    const suratfkk = ""
    let pejabat = []
    var norec_disposisi, mark_pegawaifk
    var jenissurat
    var lampiran
    var jabatan = '{{ Auth::user()->jabatanesurat}}';

    @if (isset($_GET['modal']))  
            $('#lembarDisposisi').modal('show');
   
    @endif

    // $("#tombokOK").hide();

    function lembarDisposisi(suratfk, jenis) {
        $('#assignto')[0].options.length = 0;

        jenissurat = jenis

        // const norec_esurat = suratfk;
        // alert( "Sebelum "+  suratfk)

        var url = "/InboxRev?getResponse=on&suratfk="

        
        if(jenis == "ex"){
            url ="getLembarDisposisiSuratExternal/"
           
        }  
        // alert( "Setelah "+ suratfk)

        $.get(url + suratfk, function (res) {
            
            console.log(res[0])
            lampiran = res[0].lampiran

            norec_disposisi = res[0].norec_disposisiesurat;

            // alert( "Norec disposisi :"+ norec_disposisi)

           @if(Auth::user()->jabatanesurat != 'dir') 
                $.get("/getPejabat", function (response) {
                    pejabat = response;
                    $("#assignto").empty()
                    $.each(pejabat, function (index, value) {
                        $('#assignto').append($('<option/>', {
                            value: value.id,
                            text: value.namajabatansurat
                        }));
                    });
                })
           @endif 

            $.get("/komentarDisposisi?suratfk="+suratfk, function (res) {
                var komentars = res.data;
                console.log( "komentarrr ", komentars)
                $("#komentar").html("")


                $("#historikomentar").empty()
                $.each(komentars, function (index, value) {
                    let textarea = "<textarea  style='margin-bottom: 15px' class='form-control f18' disabled   rows='1'> "
                    +value.catatan  +" \r\n </textarea>";
                    let namaKoment = "<p> <b> "+value.namajabatansurat+" </b> </p>";
                    $("#historikomentar").append( namaKoment + textarea );  
                    if(value.tujuanfk == {{  Auth::user()->pegawaifk }}){
                        $("#komentar").html(value.catatandisposisi)
                    }
                });
  

            })



            $("#dari").html(": " + res[0].asalsurat)
            $("#perihal").html(res[0].perihal.toUpperCase())
            $("#nosurat").html(": " + res[0].nosurat)
            $("#tglsurat").html(": " + res[0].tanggal)
            $("#terimatgl").html(": " + res[0].tanggal)
            $("#noagenda").html(": " + res[0].noagenda)
            // $("#komentar").html(res[0].catatandisposisi)


            // MANUAL AMBIL ID PEGAWAI DIREKTUR 
            // 22362 = drg. Devy Eka Hartini, MM. => wadir pelayanan
            // 22370 = H. Zuhhad, S.Kep.Ners.M.Kes. = > wadir umum keuangan

            $('#tanggapan').attr('checked', false);
            $('#proses').attr('checked', false);
            $('#koordinasi').attr('checked', false);

            $('#tanggapan').attr('disabled', true);
            $('#proses').attr('disabled', true);
            $('#koordinasi').attr('disabled', true);


            // PENTING => ID 22370, 22362 di ambil manual di id pegawai_m wadir pelayanan dan wadir umum 
            $('#22370').attr('checked', false);
            $('#22370').attr('disabled', true);

            $('#22362').attr('checked', false);
            $('#22362').attr('disabled', true);
            
            var dir = ' {{ Auth::user()->jabatanesurat }} ';

            if( dir == 'dir' ){
                $('#22370').attr('disabled', false);
                $('#22362').attr('disabled', false);
                $('#tanggapan').attr('disabled', false);
                $('#proses').attr('disabled', false);
                $('#koordinasi').attr('disabled', false);
            }

            const ket = res[0].ket;
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
            var cek = -1;
            if(  res[0].assignto ){
                let assigntoEx =  res[0].assignto.split(",");
                cek =  assigntoEx[0].indexOf({{ Auth::user()->pegawaifk }})
            }

            // alert(res[0].tujuanfk+ " "+{{ Auth::user()->pegawaifk }})
            
            if(res[0].tujuanfk == {{ Auth::user()->pegawaifk }} || cek >=0 || jabatan == 'wadir' ){
                $("#tombokOK").show();
                $("#assignto").attr("disabled",false);
                // $("#komentar").attr("disabled",false);
            } else{
                // $("#tombokOK").hide();
                // $("#assignto").attr("disabled",true);
                // $("#komentar").attr("disabled",true);
            }

        })

    }


    function showSurat() {

        // return
        // alert(this.jenissurat)

        if(this.jenissurat == 'ex'){
            $('#largeModal').modal('toggle');
            PDFObject.embed('SuratExternal/' + this.lampiran, "#showHere", {
                width: "100%"
            });
                $("#lembarDisposisi #close").click()
                $(".modal-backdrop").hide()

            return

        }

        var st = "/previewSurat/" + $("#suratfk").val() + "/{{ Auth::user()->key }}?back=InboxRev";
            // window.location = st;
            window.open(st, '_blank');

        // var stt = st.replace(/\s/g, '');
        // alert(stt);
        // alert(replaceAll("\\s+","/"+nosurat+"/{{ Auth::user()->pegawaifk }}?back=InboxRev"));
    }

    function simpanSisposisi() {

        // alert($("#suratfk").val())
        // alert(jenissurat)
        // alert($('#assignto').select2('data').lenght)
        var ket = $('#assignto option:selected')
        .toArray().map(item =>"| "+ item.text).join();

        // alert("ket  " + ket)

        
        
         



        // alert( $("#komentar").val());

        const obj = {
            "norec_disposisi": norec_disposisi,
            "_token": "{{ csrf_token() }}",
            "komentar": $("#komentar").val(),
            "suratfk":  $("#suratfk").val(),
            "mark_pegawaifk": $("#assignto").val().toString(),
            "ket" : ket
        }

        $.post("/updateKomentarDisposisi", obj, function (res) {
            alert(res)
            // msgsuccess(res.msg)
            // $('#close').click();
            $('#lembarDisposisi').modal("hide");
            $(".modal-backdrop").hide()


        }) 

        if (this.jenissurat == 'ex') {
            $("#formexternal").attr("action","/simpanDataDisposisiExternal/"+$("#suratfk").val());
            $("#formexternal").submit();
            // return
        }


         
        // const arr = $("#assignto").val(this.mark_pegawaifk);

        // $.each(arr, function (index, value) {
        //     alert(value)
        // });
    }

    function DisposisiSuratExternal() {
       $("#formexternal").attr("action","/simpanDataDisposisiExternal/"+$("#suratfk").val());
       $("#formexternal").submit();

    }

</script>
@include('Surat/Disposisi/SebarSurat');
