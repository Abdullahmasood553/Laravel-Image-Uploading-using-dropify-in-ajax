<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Storage;
use URL;
use DB;
use Input;

class UserController extends Controller
{
    
    
public function index() {
    return view('index');
}


public function save_image(Request $request)
{
    $user = new User;
    if ($request->hasFile('picture')) {
        
        $completeFileName = $request->file('picture')->getClientOriginalName();
        $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
        $extension = $request->file('picture')->getClientOriginalExtension();
        $compPic = str_replace(' ', '_', $fileNameOnly).'-'. rand() .'_'.time().'.'.$extension;
        $path = $request->file('picture')->storeAs('public/users', $compPic);
        $user->picture = $compPic;
    }
    
    if ($user->save()) {
        return ['status' => true, 'message' => 'Image Uploaded Successful'];
    } else {
        return ['status' => false, 'message' => 'Something went wrong'];
    }
}

}
