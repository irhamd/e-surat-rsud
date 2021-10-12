



<script src=" {{asset('angular/angular.min.js')}}"></script>

<script src="{{asset('tinymce/tinymce.min.js')}}"></script>

{{-- <script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script> --}}


<!-- jQuery 3 -->
<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Slimscroll -->
<script
src="{{asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script
src="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>

<script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<!-- InputMask -->
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<!-- date-range-picker -->
<script src="{{ asset('bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap datepicker -->
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- bootstrap color picker -->
<script src="{{ asset('bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
<!-- bootstrap time picker -->
<script src="{{ asset('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{ asset('js/pdfobject.min.js')}}"></script>
<script src="{{ asset('dist/js/pages/dashboard.js')}}"></script>
<script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>




<script>
    tinymce.init({
        selector: 'textarea#formsurat1',
        tabfocus_elements:'prev,:next',
        plugins: 'print preview table imagetools textpattern  lists, advlist,autoresize',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect fo' +
                'rmatselect | alignleft aligncenter alignright alignjustify | outdent indent | ' +
                ' numlist bullist checklist | forecolor backcolor casechange permanentpen forma' +
                'tpainter removeformat | pagebreak | charmap emoticons | fullscreen sa' +
                've print | insertfile image media pageembed template link anchor codesample | ' +
                'a11ycheck ltr rtl | showcomments addcomment | table',
        paste_enable_default_filters: false,
        content_css : "tinymce.css",
        // font_formats: 'Arial=arial,helvetica,sans-serif; Courier New=courier new,courier,monospace; AkrutiKndPadmini=Akpdmi-n',


        setup: function(ed) {
            ed.on('keydown', function(event) {
                if (event.keyCode == 9) { // tab pressed
                    if (event.shiftKey) {
                        ed.execCommand('Outdent');
                    }
                    else {
                        ed.execCommand('Indent');
                    }

                event.preventDefault();
                return false;
                }
            });
        }
       

    });

    tinymce.init({
        selector: 'textarea#formsurat2',
        tabfocus_elements:'prev,:next',
        plugins: 'print preview table imagetools textpattern  lists, advlist,autoresize',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect fo' +
                'rmatselect | alignleft aligncenter alignright alignjustify | outdent indent | ' +
                ' numlist bullist checklist | forecolor backcolor casechange permanentpen forma' +
                'tpainter removeformat | pagebreak | charmap emoticons | fullscreen sa' +
                've print | insertfile image media pageembed template link anchor codesample | ' +
                'a11ycheck ltr rtl | showcomments addcomment | table',
        paste_enable_default_filters: false,
        content_css : "tinymce.css",
        // font_formats: 'Arial=arial,helvetica,sans-serif; Courier New=courier new,courier,monospace; AkrutiKndPadmini=Akpdmi-n',


        setup: function(ed) {
            ed.on('keydown', function(event) {
                if (event.keyCode == 9) { // tab pressed
                if (event.shiftKey) {
                    ed.execCommand('Outdent');
                }
                else {
                    ed.execCommand('Indent');
                }

                event.preventDefault();
                return false;
                }
            });
        }
       

    });


    $(document).delegate('#formsurat', 'keydown', function(e) {
    var keyCode = e.keyCode || e.which;

    if (keyCode == 9) {
        e.preventDefault();
        var start = this.selectionStart;
        var end = this.selectionEnd;

        // set textarea value to: text before caret + tab + text after caret
        $(this).val($(this).val().substring(0, start)
                    + "\t"
                    + $(this).val().substring(end));

        // put caret at right position again
        this.selectionStart =
        this.selectionEnd = start + 1;
    }
    });





    $(function () {

        $("input[required], select[required]").attr("oninvalid", "this.setCustomValidity('Silahkan dilengkapi !')");
        $("input[required], select[required]").attr("oninput", "setCustomValidity('')");


        //Initialize Select2 Elements
        $('.select2').select2()

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'})
        //Money Euro
        $('[data-mask]').inputmask()

        //Date range picker
        $('#tanggal').daterangepicker({
            locale: { 
                format: 'YYYY-MM-DD',
                separator: " -- ",
            }
        })
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker({
            ranges: {
                'Today': [
                    moment(), moment()
                ],
                'Yesterday': [
                    moment().subtract(1, 'days'),
                    moment().subtract(1, 'days')
                ],
                'Last 7 Days': [
                    moment().subtract(6, 'days'),
                    moment()
                ],
                'Last 30 Days': [
                    moment().subtract(29, 'days'),
                    moment()
                ],
                'This Month': [
                    moment().startOf('month'), moment().endOf('month')
                ],
                'Last Month': [
                    moment()
                        .subtract(1, 'month')
                        .startOf('month'),
                    moment()
                        .subtract(1, 'month')
                        .endOf('month')
                ]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment()
        }, function (start, end) {
            $('#daterange-btn span').html(
                start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY')
            )
        })

        //Date picker
        $('#datepicker').datepicker({autoclose: true})

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck(
            {checkboxClass: 'icheckbox_minimal-blue', radioClass: 'iradio_minimal-blue'}
        )
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck(
            {checkboxClass: 'icheckbox_minimal-red', radioClass: 'iradio_minimal-red'}
        )
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck(
            {checkboxClass: 'icheckbox_flat-green', radioClass: 'iradio_flat-green'}
        )

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        //Timepicker
        $('.timepicker').timepicker({showInputs: false})
    })
</script>