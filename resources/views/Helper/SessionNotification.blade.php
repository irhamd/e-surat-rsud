
<link
rel="stylesheet"
href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
<link rel="stylesheet" href="/lobibox/dist/css/lobibox.min.css"/>

<script src="/lobibox/js/lobibox.js"></script>


<script>
    $.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};


function msgsuccess(msg) {
    Lobibox.notify('success', {
            position:'top right',
            size: 'mini',
            delay: 15000,
            title :'Sukses',
            msg: msg
        });

}
$(function () {
    @if (Session::has("success"))
    // ini otomatis
        Lobibox.notify('success', {
            position:'top right',
            size: 'mini',
            delay: 15000,
            title :'Sukses',
            msg: "{{ Session('success') }}"
        });

    @endif

    @if (Session::has("error"))
    // ini otomatis
        Lobibox.notify('error', {
            position:'top right',
            size: 'mini',
            delay: 15000,
            title :'Gagal',
            msg: "{{ Session('error') }}"
        });

    @endif

    @if (Session::has("warning"))
    // ini otomatis
        Lobibox.notify('warning', {
            position:'top right',
            size: 'mini',
            delay: 15000,
            title :'Warning',
            msg: "{{ Session('warning') }}"
        });
    @endif

    @if (Session::has("info"))
    // ini otomatis
        Lobibox.notify('info', {
            position:'top right',
            size: 'mini',
            delay: 15000,
            title :'Info',
            msg: "{{ Session('info') }}"
        });
    @endif

});


</script>
