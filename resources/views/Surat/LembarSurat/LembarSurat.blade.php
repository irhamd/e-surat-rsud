
        <page style="font-size: 18px" size="F4" >
            <div id="printThis">
                <img class="autosize" src="{{ asset('images/data/KopSurat.png') }}" alt="" srcset="">
                <table style="border-collapse: collapse; width: 100%; height: auto; border-style: none;" border="0">
                    <tbody>

                        <tr>
                            <td style="width: 7.4633%; ">&nbsp;</td>
                            <td style="width: 1.27613%; ">&nbsp;</td>
                            <td style="width: 38.558%; ">&nbsp;</td>
                            <td style="width: 27%; ">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="width: 7.4633%; ">&nbsp;</td>
                            <td style="width: 1.27613%; ">&nbsp;</td>
                            <td style="width: 38.558%; ">&nbsp;</td>
                            <td style="width: 27%; padding-bottom: 20px;">Mataram,
                                {{$tanggal }}</td>
                        </tr>
                        <tr>
                            <td>No</td>
                            <td>:</td>
                            <td>
                                <strong>{{ $data->nosurat }}</strong>
                            </td>
                            <td style="width: 27%; ">Kepada</td>
                        </tr>
                        <tr>
                            <td style="width: 7.4633%; ">Lampiran</td>
                            <td style="width: 1.27613%; ">:</td>
                            <td style="width: 38.558%; ">{{ $data->lamp }}</td>
                            <td style="width: 27%; ">Yth.&nbsp;{{ $data->namajabatansurat }}</td>
                        </tr>
                        <tr>
                            <td style="width: 7.4633%; ">Hal</td>
                            <td style="width: 1.27613%; ">:</td>
                            <td style="width: 38.558%; ">
                                <strong>{{ $data->perihal }}</strong>
                            </td>
                            <td style="width: 27%; ">di -</td>
                        </tr>
                        <tr>
                            <td style="width: 7.4633%; ">&nbsp;</td>
                            <td style="width: 1.27613%; ">&nbsp;</td>
                            <td style="width: 38.558%; ">&nbsp;</td>
                            <td style="width: 27%; ">&nbsp; &nbsp; &nbsp; Tempat</td>
                        </tr>
                        <tr>
                            <td style="width: 7.4633%; ">&nbsp;</td>
                            <td style="width: 1.27613%; ">&nbsp;</td>
                            <td style="width: 38.558%; "></td>
                            <td style="width: 27%; ">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="width: 7.4633%; ">&nbsp;</td>
                            <td style="width: 1.27613%; ">&nbsp;</td>
                            <td class="setSpasi" id="contentMce" style=" text-align: justify; width: 53.4278%;" colspan="2">
                                {!!html_entity_decode($data->bodysurat )!!}
                                {{-- {!! $data->bodysurat !! } --}}
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 7.4633%; ">&nbsp;</td>
                            <td style="width: 1.27613%; ">&nbsp;</td>
                            <td style="text-align: justify; " colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="width: 7.4633%; margin-left:20%">&nbsp;</td>
                            <td style="width: 1.27613%; ">&nbsp;</td>
                            <td style="width: 53.4278%;; " colspan="2">
                                <div class="tab">
                                    <p> {{ $ttd->namajabatan }} </p>
                                    <p>RSUD Kota Mataram</p>
                                    
                                    @if ($ttd->isttd==1)
                                    <div style=";margin-left: 120px;  " id="qrCodeTTD"></div>
                                    {{-- <img class="ta" src="{{ asset('images/qrcode.png') }}" alt="" srcset=""> --}}
                                      {{-- <p style="font-size: 10px">  {{ $TTDSingle->tandatangankey }}</p> --}}
                                    @else
                                        @if ( $ttd->statusttd =="RJ" )
                                            <div style=";margin-left: 120px;  " id="qrCodeTTDreject"></div>

                                        {{-- qrCodeTTDreject --}}
                                        {{-- <img src="/images/rejected.png" width="180" alt=""> --}}
                                            <h2 style="color: red; margin-top: -6px "> REJECT </h2>
                                        @else                                        
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                        @endif
                                    @endif
                                    
                                    <p style="  text-decoration: underline;"> <span >
                                            <strong>{{$ttd->namalengkap}}</strong>
                                        </span>
                                    </p>
                                    <p>NIP. {{$ttd->nip}}</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>


                <div style="float:right; padding-top:10%;">
                    <table style="border-collapse: collapse; width: 100%; height: auto; border-style: none;" border="1">
                        <tr>
                            @foreach ($paraf as $pf)

                                @if ($pf->isparaf == 1)
                                    <td align="center" style="padding:5px"> <img src="{{ asset('images/img/checklist.png') }}"> </td>
                                @else
                                    @if ($pf->status == "RJ")
                                        <td align="center" style="padding:5px;"> <img style="width:30px" src="{{ asset('images/img/reject1.png') }}"> </td>
                                    @else
                                        <td align="center" style="padding:5px"> </td>
                                    @endif
                                @endif
                                {{-- <td align="center" style="padding:5px" > {{ $pf->namaexternal }}</td> --}}
                            @endforeach
                        </tr>
                        <tr>
                            @foreach ($paraf as $pf)
                            {{-- <td align="center"> {{ $pf->status }}</td> --}}
                            <td align="center" style="padding:5px"> {{ $pf->namaexternal }}</td>
                            @endforeach
                        </tr>
                    </table>

                </div>
            </div>
            <br>
            <br>
            <br>
            @if ( isset($statusparaf) && $statusparaf->statusparaf == "RJ")
            <div>
                <div class="reject">
                    <p> <b> Reject by : {{  $statusparaf->namalengkap }} </b></p>
                </div>
                <div class="reject">
                <p>{{ $statusparaf->komentar }}</p>
                </div>
            </div>
            @endif

            @if (isset($statusparaf) && $statusparaf->statusparaf == "RV" )
            <div>
                <div class="revisi">
                    <p> <b> Revisi by : {{ $statusparaf->namalengkap }} </b></p>
                </div>
                <div class="revisi">
                <p>{{ $statusparaf->komentar }}</p>
                </div>
            </div>
            @endif
            {{-- {{ $ada }} --}}
            @if ($tembusan )
            {{-- {{ $tembusan }} --}}
            <br>
                <p> <strong> Tembusan : </strong> </p>
                <ul>
                    @foreach ($tembusan as $item)
                    <li> {{ $item->namajabatansurat }} </li>
                    @endforeach
                </ul>
            
            @endif

        </page>