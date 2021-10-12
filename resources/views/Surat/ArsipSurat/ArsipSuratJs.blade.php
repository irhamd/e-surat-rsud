<script>
    function hapusArsipSurat(norec){
        if(confirm('Hapus surat ???')){
            $.get("/api/hapusArsipSurat?norec=" + norec, function(data){
                    alert(data.status)
                    location.reload();
            })
        }
    }

    $("#inputsurat").hide();
    $("#wait").hide();

    function inputSurat() {
        $("#inputsurat").show("fast");
        $("#dataSurat").hide("fast");
        $("#tombolInput").hide("fast");

    }

    function editSurat(row) {
        console.log(row);

        $("#asalsurat").val(row.asalsurat)
        $("#nosurat").val(row.nosurat)
        $("#perihal").val(row.perihal)
        $("#tujuan").val(row.tujuan)
        $("#noagenda").val(row.noagenda)
        // $("#tanggal").val('2020-02-02')

        $("#tanggalsurat").val(row.tanggal);

        // document.getElementById("tanggal").value = '2020-02-01'
        
        $("#inputsurat").show("fast");
        $("#dataSurat").hide("fast");
        $("#tombolInput").hide("fast");
        $("#norec").val(row.norec);

        $("#formsurat").attr("action", "editArsipSurat");

        $(".form-control").removeAttr("required");
        

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
        $("#btnsimpan").attr("disabled", true);


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

                    // Fetch the first page
                    var pageNumber = 1;
                    pdf.getPage(pageNumber).then(function (page) {

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
                            $("#btnsimpan").removeAttr("disabled");
                            $("#wait").hide();
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