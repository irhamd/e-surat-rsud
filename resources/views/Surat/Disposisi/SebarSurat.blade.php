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

    .f18 {
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

<div id="sebarSurat" class="modal">
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> <b> SEBAR SURAT </b>
                    <small class="pull-right"> {{ date('d-M-Y') }} </small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row">
            <div class="col-sm-12">
                <label>Sebarkan Ke  </label>
                <select class="form-control select2" 
                    multiple="multiple" style="width:100%; color:black"
                    name="sebarkan[]" id="sebarkan">
                </select>
            </div>
            <br>
            <br>
            <br>
            <div style="margin-left:50px">
                <button type="button" style="width: 110px" id="tombokOK" onclick="simpanSebarSurat()" class="btn btn-warning">
                    <span class="fa fa-save"></span>
                    Sebar
                </button>
            </div>
        </div>
    </section>
</div>

<script>
    function sebarSurat() {
        $.get("/tujuanSebar", function (response) {
            
            let sebar = response;

            console.log(sebar)
            $("#sebarkan").empty()
            $.each(sebar, function (index, value) {
                $('#sebarkan').append($('<option/>', {
                    value: value.tujuansebar,
                    text: value.diskripsi
                }));
            });
        })
    }

    function simpanSebarSurat() {
        var ket = $('#sebarkan option:selected')
        .toArray().map(item =>" / "+ item.text).join();

        const obj = {
            "norec_disposisi": norec_disposisi,
            "_token": "{{ csrf_token() }}",
            "suratfk":  $("#suratfk").val(),
            "sebarkan": $("#sebarkan").val().toString(),
            "ket" : ket,
            // variabel jenis surat ada di LembarDisposisi = 2 = external / 1 = internal
            "diskripsifk" : jenissurat == 'ex' ? '2' : '1'
        }

        $.post("/simpanSebarSurat", obj, function (res) {
            console.log(res)
            alert(res.msg);
        })
    }

</script>
