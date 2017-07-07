<?php

namespace App\Http\Controllers;

use App\Folder;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function createNewfolder(Request $request){
        //validation
        $this->validate($request, [
           'folderName' => 'required|max:1000'
        ]);
        $folder = new Folder();
        $folder->folderName = $request->name;
        $request->belongToUser()->hasFolders()->save($folder);
        return redirect('home');
    }
}
