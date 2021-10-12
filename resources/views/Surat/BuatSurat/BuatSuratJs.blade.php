<script>
    $("#preview1").hide();
    var editor_config = {
        path_absolute: "/",
        selector: "textarea#formsurat",
        plugins: 'tabfocus',
        forced_root_block : 'div',
        tabfocus_elements: ':prev,:next',
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        content_css: "tinymce.css",
        toolbar: "insertfile undo redo | image | fontselect fontsizeselect | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
        relative_urls: false,
        file_browser_callback: function (field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                'body')[0].clientWidth;
            var y = window.innerHeight || document.documentElement.clientHeight || document
                .getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
            if (type == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.open({
                file: cmsURL,
                title: 'Cari Gambar',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no"
            });
        }
    };

    var editor_lampiran = {
        path_absolute: "/",
        selector: "textarea#lampiransurat",
        forced_root_block : 'div',
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        content_css: "tinymce.css",
        toolbar: "insertfile undo redo | image | fontselect fontsizeselect | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
        relative_urls: false,
        file_browser_callback: function (field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                'body')[0].clientWidth;
            var y = window.innerHeight || document.documentElement.clientHeight || document
                .getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_lampiran.path_absolute + 'laravel-filemanager?field_name=' + field_name;
            if (type == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.open({
                file: cmsURL,
                title: 'Cari Gambar',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no"
            });
        }
    };


    tinymce.init(editor_config);
    tinymce.init(editor_lampiran);

    $("#ket").hide();

    function cekNoSurat(nosurat) {
        $("#ket").hide();
        // return true;
        // var nosurat = $(this).val();
        $.ajax({
            type: "GET",
            url: "/cekNomorSUratRev?nosurat=" + nosurat
        }).done(function (msg) {
            if (msg === '1') {
                $("#ket").show();
                return false;
            }
        });
    }

    $('#nosurat').change(function () {
        if (!cekNoSurat($(this).val())) {
            $('#nosurat').focus();
            return false;

        }
    });




    $("#formsurat").keydown(function (e) {
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


    function getVal(source, output) {
        var str = document.getElementById(source).value; 
                // document.write(nama) 
                document.getElementById(output).innerHTML = str;
                // return false;
    }

    document
        .getElementById("btnPrint")
        .onclick = function () {
                // document.getElementById("nosuratA").innerHTML = document.getElementById("nosurat").value;
                // document.getElementById("lampiranA").innerHTML = document.getElementById("lampiran").value;
                // if()
                document.getElementById("ttdbyA").innerHTML = ttdby.options[ttdby.selectedIndex].text;
                getVal("nosurat",'nosuratA');
                getVal("lampiran",'lampiranA');
                getVal("perihal",'perihalA');
                // getVal("tujuan",'tujuanA');

                data = $('#tujuan').select2('data')
                var res = data[0].text.split(" == ");
                document.getElementById("tujuanA").innerHTML =res[0];

                data = $('#ttdby').select2('data')
                var res = data[0].text.split(" == ");
                document.getElementById("ttdbyA").innerHTML =res[1];                


                data = $('#ttdby').select2('data')
                var res = data[0].text.split(" == ");
                document.getElementById("approve").innerHTML =res[0];


                // getVal("ttdby",'ttdbyA');

                // $("#contentMce").html(tinyMCE.activeEditor.getContent());
                $("#contentMce").html(tinymce.get("formsurat").getContent());

                printElement(document.getElementById("printThis"));
                return false;
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

    $(".btn-success").click(function () {
        var html = $(".clone").html();
        $(".increment").after(html);
    });
    $("body").on("click", ".btn-danger", function () {
        $(this).parents(".control-group").remove();
    });

    $(document).on("change", "#file", function(e) {
    if(this.files[0].size > 7244183)  //set required file size 2048 ( 2MB )
    { 
        alert("The file size is too larage");
        $('#elemendId').value = ""; 
    }
    });

    $('#ttdby').val('');
    // $('#tujuan').val('');
    // alert('dddd');

    $('#ttdby').val("{{ $pejabatTTD != "" ? $pejabatTTD->pegawaifk :'' }}");
    $('#tujuan').val("{{ $editsurat != "" ? $editsurat->tujuan :'' }}");

    $("#parafby").select2().val(["{{ isset($pejabatParaf) ? $pejabatParaf : ''}}"]);
    $("#tembusan").select2().val(["{{ $tembusanPejabat ? $tembusanPejabat : ''}}"]);


        // $("#parafby").select2().val([{{ $pejabatParaf }}]);
    

 


    /**
     * Binds a TinyMCE widget to <textarea> elements.
     */
    angular.module('ui.tinymce', [])
        .value('uiTinymceConfig', {})
        .directive('uiTinymce', ['uiTinymceConfig', function (uiTinymceConfig) {
            uiTinymceConfig = uiTinymceConfig || {};
            var generatedIds = 0;
            return {
                require: 'ngModel',
                link: function (scope, elm, attrs, ngModel) {
                    var expression, options, tinyInstance;
                    // generate an ID if not present
                    if (!attrs.id) {
                        attrs.$set('id', 'uiTinymce' + generatedIds++);
                    }
                    options = {
                        // Update model when calling setContent (such as from the source editor popup)
                        setup: function (ed) {
                            ed.on('init', function (args) {
                                ngModel.$render();
                            });
                            // Update model on button click
                            ed.on('ExecCommand', function (e) {
                                ed.save();
                                ngModel.$setViewValue(elm.val());
                                if (!scope.$$phase) {
                                    scope.$apply();
                                }
                            });
                            // Update model on keypress
                            ed.on('KeyUp', function (e) {
                                console.log(ed.isDirty());
                                ed.save();
                                ngModel.$setViewValue(elm.val());
                                if (!scope.$$phase) {
                                    scope.$apply();
                                }
                            });
                        },
                        mode: 'exact',
                        elements: attrs.id
                    };
                    if (attrs.uiTinymce) {
                        expression = scope.$eval(attrs.uiTinymce);
                    } else {
                        expression = {};
                    }
                    angular.extend(options, uiTinymceConfig, expression);
                    setTimeout(function () {
                        tinymce.init(options);
                    });


                    ngModel.$render = function () {
                        if (!tinyInstance) {
                            tinyInstance = tinymce.get(attrs.id);
                        }
                        if (tinyInstance) {
                            tinyInstance.setContent(ngModel.$viewValue || '');
                        }
                    };
                }
            };
        }]);

</script>
