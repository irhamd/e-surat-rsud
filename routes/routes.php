<?php

 

Route::get("/suratExternalRes","SuratController@suratExternalRes");
Route::get("/cekNomorSUratRev","SuratController@cekNomorSUratRev");

Route::get("/getDataUser","User\UserControllerRev@getDataUser");
Route::get("/getGuzzleRequest","Guzzle\GuzzleController@getGuzzleRequest");


Route::get("/sentNotification","NotifikasiController@sentNotification");
Route::get("/sentNotificationFromApache/{token}/{tujuan}/{msg}","NotifikasiController@sentNotificationFromApache");

Route::get("/komentarDisposisi","InboxController@komentarDisposisi");

Route::get("/getLembarDisposisiSuratExternal/{norec_external}","SuratExternalController@getLembarDisposisiSuratExternal");


// PENTING :: NAMA ROUTE INBOX & OUTBOX TIDAK BOLEH DI GANTI

Route::group(['middleware' => ['auth','cors']], function () {
    // COVIDDD

    Route::get("/inputPasienCovid","Covid\LaporanCovidController@inputPasienCovid");



    // end covidd




    // PEJABAT
    Route::get("/getPejabat","Pejabat\PejabatController@getPejabat");
    Route::get("/tujuanSebar","Pejabat\PejabatController@tujuanSebar");
    
    
    Route::get('/BuatLampiran', function(){
        return view("Surat/Lampiran/BuatLampiran");
    });
    
    Route::get("/buatSurat","SuratController@buatSurat");//->name('home');
    Route::get("/home","SuratController@home")->name('home');
    // Route::get("/buatSurat","SuratController@buatSurat")->name('buatSurat');
    Route::post("/prosesBuatSurat","SuratController@prosesBuatSurat");
    Route::get("/suratMasuk","SuratController@suratMasuk");
    Route::get("/arsipSurat","SuratController@suratMasuk");

    Route::get("/InboxRev","InboxController@InboxRev");


    Route::get("/arsipSurat","ArsipSuratController@ArsipSuratBlade");
    Route::post("/UploadArsipSurat","ArsipSuratController@UploadArsipSurat");
    Route::post("/editArsipSurat","ArsipSuratController@editArsipSurat");
    // Route::get("/komentarDisposisi","InboxController@komentarDisposisi");
    


    Route::get("/setParaf/{suratfk}","ParafController@setParaf");
    Route::get("/setParafRes/{suratfk}/{pegawifk}","ParafController@setParafRes");
    
    Route::get("/previewSurat/{suratfk}/{t}","SuratController@previewSurat");
    // Route::get("/previewSuratRes/{suratfk}/{t}","SuratController@previewSuratRes");
    Route::get("/requestParaf","ParafController@requestParaf");
    Route::get("/requestttd","TandaTanganController@requestttd");
    Route::get("/setDisposisiRes","TandaTanganController@setDisposisiRes");
    Route::get("/setTTD/{suratfk}","TandaTanganController@setTTD");
    Route::get("/setTTDRes/{suratfk}/{pegawaifk}","TandaTanganController@setTTDRes");

    Route::get("/suratExternalRev","SuratExternalController@suratExternalRev");
    // Route::get("/getLembarDisposisiSuratExternal/{norec_external}","SuratExternalController@getLembarDisposisiSuratExternal");
    Route::post("simpanSuratExternal","SuratExternalController@simpanSuratExternal");

    Route::get("/disposisi","DisposisiController@Disposisi");
    Route::post("/updateKomentarDisposisi","DisposisiController@updateKomentarDisposisi");


    Route::get("/lembarDisposisi","DisposisiController@lembarDisposisi");
    Route::get("/simpanDataDisposisi/{norec}","DisposisiController@simpanDataDisposisi");
    Route::post("/simpanSebarSurat","DisposisiController@simpanSebarSurat");
    Route::get("/simpanDataDisposisiExternal/{norec}","DisposisiController@simpanDataDisposisiExternal");
    Route::get("/getSingleDataDisposisi","DisposisiController@getSingleDataDisposisi");


    Route::post("/revisiByParaf/{suratfk}","ParafController@revisiByParaf");
    Route::post("/rejectByParaf/{suratfk}","ParafController@rejectByParaf");
    Route::post("/rejectByTandaTangan/{suratfk}","TandaTanganController@rejectByTandaTangan");
    Route::get("/Outbox","OutboxController@Outbox");
    Route::get("tesUploadMultiFile","TesController@tesUploadMultiFile");
    
    Route::post("gantipassword","PasswordController@gantipassword");

    // TIMELINE
    Route::get("/getTimeline","TimelineController@getTimeline");
    // Route::get("/getTimeline",function(){
    //    return view("Timeline/Timeline");
    // });

    // Route::get("/history/{suratfk}/{ket}","ManageSurat@saveHistory");

    // Route::get("suratExternalRev","SuratExternalController@suratExternalRev");
    // Route::post('upload_data', 'FormController@store');

    // Route::group(["layout"=>"Html"], function(){
    //     Route::livewire("/buat","bebas");
    //     Route::livewire("/buatsuratbaru","surat.buat-surat-baru");
    // });
    
    // Route::livewire("/inputbaru/{id}","karyawan.create");


});
Route::get("/logouta","ManageSuratContoller@logouta")->name("logout");
Route::get("/logouta","ManageSuratContoller@logouta");

Route::group(['middleware' => ['guest']], function () {

    Route::post("/getLogin","SuratController@getLogin");
    Route::get("/login","SuratController@login")->name("login");
});


// TESSSSSS ========================================================================================================================

Route::get("/tes", function(){
    return view("tes/notifikasi");
});



Route::get("/tesSession", function(){
    return view("tes/Session");
});

Route::get("/getBase", function(){
    $url =  url("/");

    $arr =  explode(":", $url);
    return $arr[1];
});




Route::get("/tambah/{barang}","Tes\TesController@tambah");
Route::get("/reset","Tes\TesController@reset");

Route::get("/pre", function(){
    return view("Surat/PreviewSurat/PreviewSuratRev");
});

 
 
