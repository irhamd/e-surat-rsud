@extends('Html')
@section('content') 

<style>
    .select2{
        color: black;
    }
    multiple{
        color: black;
    }
    .tengah {
        margin-left: auto;
        margin-right: auto;
        width: 90%;
        border: 3px solid grey;
        padding: 10px;
    }

    
</style>
 
<div class="col-md-10">

    @if (Session::has("berhasil"))

    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        Berhasil buat surat baru ,
      </div>
        
    @endif

    @if (Session::has("gagal"))

    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
            Gagal buat surat ...!
      </div>
        
    @endif
    
    <form action="/prosesBuatSurat" method="post"  enctype="multipart/form-data">
        @csrf

        <div class="box box-primary" style="height: 100%">
            <div class="box-header with-border" >
                <h3 class="titleJudul"> SURAT MASUK </h3>
                <small style='text-align:center'> Surat Masuk ke dalam Rumah Sakit </small>
            </div>
            <!-- /.box-header -->
            <div class = "box-body" > <div class="form-group">
        <label>Tujuan</label>

        <input name="tujuan" class="form-control">
    </div>
    <div class="form-group">
        <label>Nomor Surat</label>
        <input name="nosurat" class="form-control">
    </div>
 

    <div class="form-group">
        <label>Tanggal</label>
        <input type="date" class="form-control" name="tgl">
        </div>
        <div class="form-group">
        <label>Perihal</label>
        <input type="text" name="perihal" class="form-control">
    </div>




 
                   
    <div class="form-group">

        <div class="col-md-12">

            <label for="myPdf" class="btn btn-success" >Attach</label>
           <input   id="myPdf" style="visibility:hidden;" type="file">
            {{-- <input type="file" width="50" id="myPdf" name="lampiran" height="50"> --}}
            
            <canvas class="tengah" id="pdfViewer"></canvas>
        </div>
        
    </div>
                                    <!-- /.box-body -->
    <div class="box-footer">
        <div class="pull-right">
            <button type="button" class="btn btn-default btn-lg">
                <i class="fa fa-pencil"></i>
                Draft</button>
            <button style="width: 200px" type="submit" class="btn btn-primary btn-lg">
                <i class="fa fa-envelope-o"></i>
                Kirim</button>
        </div>

         
            
        
    </div>
                                    <!-- /.box-footer -->
        </div>
    </form>
    <!-- /. box -->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>

<script> 
$(function () {
    // Loaded via <script> tag, create shortcut to access PDF.js exports.
    var pdfjsLib = window['pdfjs-dist/build/pdf'];
    // The workerSrc property shall be specified.
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';

    $("#myPdf").on("change", function (e) {
        var file = e
            .target
            .files[0]
        if (file.type == "application/pdf") {
            var fileReader = new FileReader();
            fileReader.onload = function () {
                var pdfData = new Uint8Array(this.result);
                // Using DocumentInitParameters object to load binary data.
                var loadingTask = pdfjsLib.getDocument({data: pdfData});
                loadingTask
                    .promise
                    .then(function (pdf) {
                        console.log('PDF loaded');

                        // Fetch the first page
                        var pageNumber = 1;
                        pdf
                            .getPage(pageNumber)
                            .then(function (page) {
                                console.log('Page loaded');

                                var scale = 1.5;
                                var viewport = page.getViewport({scale: scale});

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
                                renderTask
                                    .promise
                                    .then(function () {
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
    });

}) 

</script>
                    <!-- /.col -->
    @endsection