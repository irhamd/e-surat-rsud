<?php

use Illuminate\Http\Request;

Route::group(['middleware' => ['cors']], function () {

    Route::get("/InboxRes","InboxController@InboxRes");

    Route::post("/createNewUser","Auth\RegisterController@createNew");
    Route::get("/getDataUser","User\UserControllerRev@getDataUser");
    Route::get("/previewSuratRes/{suratfk}","SuratController@previewSuratRes");
    Route::get("/getloginRes","LoginController@getloginRes");


    // PARAF
    Route::get("/parafRes","ParafController@parafRes");
    Route::get("/cekParaf","ParafController@cekParaf");
    Route::get("/setParafRes/{suratfk}/{pegawaifk}","ParafController@setParafRes");

    // TANDA TANGAN
    Route::get("/tandaTanganRes","TandaTanganController@tandaTanganRes");
    Route::get("/setTTDRes/{suratfk}/{pegawaifk}","TandaTanganController@setTTDRes");

    // OUTBOX
    Route::get("/outboxRes","OutboxController@outboxRes");

    // ARSIP SURAT

    Route::get("hapusArsipSurat","ArsipSuratController@hapusArsipSurat");


});




