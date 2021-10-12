@extends('Html')
@section('content')
@php $no=1; @endphp

 
<div class="col-md-12">
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="orange titleJudul ">INBOX</h3>
            <br>

            <form action="/InboxRev" method="get">
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
                    <input type="checkbox" name="isread" id="isread">
                    <label for="isread"> Belum dibaca </label>
                </div>

                <div class="col-md-3 ml-15">
                    <button type="submit" class="btn bg-olive btn-flat"> <span class="fa fa-search"></span> OK</button>
                </div>
            </form>
        </div>
        {{-- @include('Surat/Disposisi/LembarDisposisi'); --}}

        <div class="box">
            <div class="box-body">
                <ul class="products-list product-list-in-box">
                    {{-- <button href="#lembarDisposisi" data-toggle="modal"> Disposisi </button> --}}

                    @foreach ($inbox as $item)

                    <li class="item col-md-6 ml10 {{ $item->isreadinbox == '0' ? 'b' :'' }}" style="padding: 5px">

                        <a 
                        @if ($item->diskripsifk == '4')
                            href="#lembarDisposisi" onclick="lembarDisposisi('{{ $item->norec }}','{{ $item->jenissurat }}')" data-toggle="modal"
                        @endif
 



                            @if ($item->diskripsifk == '2')
                                href="#largeModal" onclick="showPdf('{{ $item->lamp }}', '{{ $item->norec }}')" data-toggle="modal"
                            @else
                                onclick="previewSurat('{{ $item->norec }}','{{ $item->ket}}')"
                            @endif>

                            <div class="product-img">
                                <img src="/images/inbox.png" alt="Product Image">
                            </div>
                            <div class="product-info bg-info" style="padding: 3px 7px 0 5px">
                                <p class="product-title">{{ $item->nosurat }}
                                    <span class="label label-warning pull-right b">
                                        {{ $item->isreadinbox == '1' ? '-' :'Belum Dibaca' }}
                                    </span>
                                    <span
                                        class="label label-warning pull-right">{{ \Carbon\Carbon::parse($item->created_atinbox)->diffForHumans() }}
                                    </span>
                                </p>


                                <p class="product-title">
                                    <span class="label label-default pull-right b"> {{ $item->diskripsi }}
                                    </span>

                                </p>

                                <span class="product-description">
                                    {{ $item->perihal }}
                                </span>
                                <span class="product-description-small">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d - m - Y') }}
                                </span>
                            </div>
                        </a>
                    </li>
                    @endforeach

                    <!-- /.item -->
                </ul>
                {{-- {{ $inbox->links() }} --}}

            </div>
        </div>
        @if(count($inbox) == 0)
        <div class="box-body">
                
            <div class="alert alert-info alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-info"></i> Alert!</h4>
              Tidak ada inbox ...
            </div>
          </div>

        @endif

</div>



<!-- /. box -->
</div>




 
<!-- Button trigger modal -->


<!-- Modal -->

{{-- @include('Surat/PreviewSurat/PreviewModal-Surat'); --}}

 


<div id="largeModal" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h1> <strong> PREVIEW SURAT EXTERNAL</strong> </h1> --}}
                <button type="button" class="btn btn-danger  btn-lg"  data-dismiss="modal"> <span class="fa fa-remove"></span>
                    Tutup
                </button>

                @if ( Auth::user()->jabatanesurat == 'dir' )
                <a href="#lembarDisposisi" data-toggle="modal">
                    <button type="button" class="btn btn-warning btn-lg" onclick="lembarDisposisi($('#suratfk').val(),'ex')" style="width: 300px"> <span class="fa fa-share-alt"></span>
                        Disposisikan ke 
                    </button>
                </a>
                @endif
                
            </div>
            <div class="modal-body">
                <div id="showHere"></div>
                <script>
                    function showPdf(url,suratfk) {
                        $("#suratfk").val(suratfk)
                        PDFObject.embed('SuratExternal/' + url, "#showHere", {
                            width: "100%"
                        });
                    }

                </script>
            </div>

        </div>
    </div>
</div>

@include('Surat/Disposisi/LembarDisposisi');


{{-- @include('Surat/Disposisi/LembarDisposisiExternal'); --}}


<script>
    function previewSurat(nosurat, ket) {
        var st = "/previewSurat/" + nosurat + "/{{ Auth::user()->key }}?back=InboxRev";

        if (ket != 'Surat External') {
            window.location = st;
        }

        // var stt = st.replace(/\s/g, '');
        // alert(stt);
        // alert(replaceAll("\\s+","/"+nosurat+"/{{ Auth::user()->pegawaifk }}?back=InboxRev"));
    }


    $(function () {

        const belumdibaca = "{{ isset($_GET['isread']) ? $_GET['isread'] : '' }}";

        if(belumdibaca =="on"){
            $('#isread').prop('checked', true);
        } else{
            $('#isread').prop('checked', false);
        }

        $(':checkbox[readonly]').click(function(){
            return false;
        });

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
