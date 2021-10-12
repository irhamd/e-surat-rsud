@extends('Html')
@section('content')
<div style="margin-left:10px">
    <div> Jumlah Pesanan</div>
    <div><a href="/tambah/athar">  <button>Tambah Ke keranjang</button>  </a> </div>
    <div><a href="/reset">  <button>Bayar</button>  </a> </div>
    <p>
        {{\Session('keranjang')}}
    </p>    
    
    

        {{json_encode(\Session('detail'))}}
    <div>
        <ol>
            @foreach (Session("detail") as $item)
                <li> {{$item}} </li>
            @endforeach
        </ol>
    </div>

</div>


@endsection
