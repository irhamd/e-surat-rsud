<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TesController extends Controller {
    public function tesUploadMultiFile() {
        return view("tes/tesUploadMultiFile");
    }

    public function uploadSubmit(Request $request) {
        $this->validate($request, [ 'name'=> 'required',
            'photos'=>'required',
            ]);

        if($request->hasFile('photos')) {
            $allowedfileExtension=['pdf',
            'jpg',
            'png',
            'docx'];
            $files=$request->file('photos');

            foreach($files as $file) {
                $filename=$file->getClientOriginalName();
                $extension=$file->getClientOriginalExtension();
                $check=in_array($extension, $allowedfileExtension);

                //dd($check);
                if($check) {
                    $items=Item::create($request->all());

                    foreach ($request->photos as $photo) {
                        $filename=$photo->store('photos');
                        ItemDetail::create([ 'item_id'=> $items->id,
                                'filename'=> $filename]);
                    }

                    echo "Upload Successfully";
                }

                else {
                    echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
                }
            }
        }


    }
}
