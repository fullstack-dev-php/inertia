<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class VisitController extends Controller
{
    public function upload(Request $request)
    {
        if ($file = $request->file('image')) {
            $this->uploadFile($file);
        }
    }
}
