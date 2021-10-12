@extends('Html')
@section('content')

<div id="" class="bodi">



 


    <page size="F4" style="font-size: 18px">
        <div id="printThis">
            <img class="autosize" src="{{ asset('images/data/KopSurat.png') }}" alt="" srcset="">
            <table style="border-collapse: collapse; width: 100%; height: auto; border-style: none;" border="1">
                <tbody>

                    <tr>
                        <td style="width: 7.4633%; ">&nbsp;</td>
                        <td style="width: 1.27613%; ">&nbsp;</td>
                        <td style="width: 38.558%; ">&nbsp;</td>
                        <td style="width: 20%; ">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="width: 7.4633%; ">&nbsp;</td>
                        <td style="width: 1.27613%; ">&nbsp;</td>
                        <td style="width: 38.558%; ">&nbsp;</td>
                        <td style="width: 20%; padding-bottom: 20px;">Mataram,
                            <p ng-bind="tgl | date:'dd MMMM yyyy'"></p>
                    </tr>


                    <tr >
                        <td rowspan="4" colspan="3">
                            
                            <div class="row">
                            
                                .col-sm-
                                
                            </div>
                            <div> No </div>
                            <div> No </div>
                            
                        </td>
                        <td>:</td>
                        <td>
                            <strong id="nosuratA"> </strong>
                        </td>
                        <td style="width: 20%; ">Kepada</td>
                    </tr>
                    <tr>
                        <td style="width: 7.4633%; ">Lampiran</td>
                        <td style="width: 1.27613%; ">:</td>
                        <td style="width: 38.558%;" id="lampiranA"></td>
                        <td style="width: 20%; "> Yth . <span id="tujuanA"></span> </td>
                    </tr>
                    <tr>
                        <td style="width: 7.4633%; ">Hal</td>
                        <td style="width: 1.27613%; ">:</td>
                        <td style="width: 38.558%; ">
                            <strong id="perihalA"></strong>
                        </td>
                        <td style="width: 20%; ">di -</td>
                    </tr>
                    <tr>
                        <td style="width: 7.4633%; ">&nbsp;</td>
                        <td style="width: 1.27613%; ">&nbsp;</td>
                        <td style="width: 38.558%; ">&nbsp;</td>
                        <td style="width: 20%; ">&nbsp; &nbsp; &nbsp; Tempat</td>
                    </tr>
                    <tr>
                        <td style="width: 7.4633%; ">&nbsp;</td>
                        <td style="width: 1.27613%; ">&nbsp;</td>
                        <td style="width: 38.558%; "></td>
                        <td style="width: 20%; ">&nbsp;</td>
                    </tr>

                    <tr>
                        <td style="width: 7.4633%; ">&nbsp;</td>
                        <td style="width: 1.27613%; ">&nbsp;</td>
                        <td class="setSpasi" style=" text-align: justify; width: 53.4278%; " colspan="2">
                            <p id="contentMce"></p>

                            {{-- <script> $("#contentMce").html(tinyMCE.activeEditor.getContentMce()); </script> --}}
                            {{-- @{{isisurat}} --}}
                            {{-- {!!html_entity_decode($data->bodysurat )!!} --}}
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
                                <p id="approve"> </p>
                                <p>RSUD Kota Mataram</p>


                                <br>
                                <br>
                                <br>
                                <br>

                                <p> <span style="text-decoration: underline;">
                                        <strong id="ttdbyA"> </strong>
                                    </span>
                                </p>
                                <p>NIP ...................</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <br>
        <br>
    </page>
</div>
@endsection
