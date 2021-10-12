<div class="modal fade" id="previewSurat" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {{-- <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="previewSuratLabel">Surat</h4>
      </div> --}}
            <div class="modal-body">
                {{-- @include('Surat/PreviewSurat') --}}
             

                <div id="" class="bodi">
                
                    <div class="kotak-header">
                        <button class="btn btn-primary">Paraf</button>
                        <button class="btn btn-warning">Revisi</button>
                        <button class="btn btn-danger">Reject</button>
                        <button  href="#lembarDisposisi" onclick="lembarDisposisi('surafk')" data-toggle="modal" class="btn btn-info">Disposisi</button>
                
                    </div>
                    <br>
                    <br>
                    <br>
                
                    
                   
                
                    <page size="F4">
                        <div id="printThis">
                            <img class="autosize" src="{{ asset('images/data/KopSurat.png') }}" alt="" srcset="">
                            <table style="border-collapse: collapse; width: 100%; height: auto; border-style: none;" border="1">
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
                                            <p ng-bind="tgl | date:'dd MMMM yyyy'"></p>
                                    </tr>
                
                
                                    <tr>
                                        <td>No</td>
                                        <td>:</td>
                                        <td>
                                            <strong id="nosuratA"> </strong>
                                        </td>
                                        <td style="width: 27%; ">Kepada</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 7.4633%; ">Lampiran</td>
                                        <td style="width: 1.27613%; ">:</td>
                                        <td style="width: 38.558%;" id="lampiranA"></td>
                                        <td style="width: 27%; "> Yth . <span id="tujuanA"></span> </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 7.4633%; ">Hal</td>
                                        <td style="width: 1.27613%; ">:</td>
                                        <td style="width: 38.558%; ">
                                            <strong id="perihalA"></strong>
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
                                        <td class="setSpasi" style=" text-align: justify; width: 53.4278%; " colspan="2">
                                            <div id="html"> </div>
                
                                           
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
            </div>
        </div>
    </div>
</div>

<script>
    function previewSurat(suratfk, key) {


        $.get("/previewSurat/"+suratfk+"/"+key+"?response=1", function (res) {

            const item = res.datasurat;

            var $log = $("#html");
            str = res.datasurat.bodysurat;
            html = $.parseHTML( str );
            $log.append( html );


            $("#tujuanA").html( item.namajabatansurat )


        console.log(res.datasurat)
        })
        
    }
</script>