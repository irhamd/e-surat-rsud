@extends('Html')
@section('content')

 

    <!-- Main content -->
    <section class="content">
        <h3 class="orange titleJudul ">TIMELINE SURAT</h3>
        <br>
    
        <div class="col-md-12">
            <div class="col-md-2">
                <span class="pull-right b"> Nomor surat  </span> 
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control" id="nosurat"  value=" {{$single->nosurat}}  ">
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-2">
                <span class="pull-right b"> Perihal  </span> 
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control" disabled value=" {{$single->perihal}}" >
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-2">
                <span class="pull-right b"> Tanggal  </span> 
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control" disabled value=" {{$single->tanggal}}" >
            </div>
        </div>


        <div class="col-md-12">
            <div class="col-md-2">
                <span class="pull-right b"> Asal Surat  </span> 
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control" disabled value=" {{$single->asalsurat}}">
            </div>
        </div>

     

     
        <br>
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <br>
                <!-- The time line -->
                <ul class="timeline">
                    <!-- timeline time label -->
                    @foreach ($hari as $tgl)
                        <li class="time-label">
                            <span class="bg-red">
                                Tanggal : &nbsp; {{\Carbon\Carbon::parse( $tgl->tanggalinput)->translatedFormat('d F Y')}}
                            </span>
                        </li>
                            @foreach ($data as $item)
                            @if ( $item->tanggalinput == $tgl->tanggalinput )
                                <li>
                                    <i class="fa fa-envelope bg-blue"></i>

                                    <div class="timeline-item">
                                        <span class="time label bg-yellow"><i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($item->tglinput)
                                            ->format('H:i:s') }} </span>

                                        <h3 class="timeline-header"><a href="#">{{ $item->namalengkap }}</a> / {{ $item->namajabatansurat }} </h3>

                                        <div class="timeline-body b" style="font-size: 20px">
                                            {{ $item->keterangan }}
                                        </div>
                                        
                                    </div>
                                </li>
                            @endif
                            @endforeach
                    @endforeach
                    <li>
                        <i class="fa fa-clock-o bg-gray"></i>
                    </li>
                </ul>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

 
        <!-- /.row -->

    </section>
    <!-- /.content -->
 

@endsection
