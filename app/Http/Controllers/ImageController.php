<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $user = Auth::user();
    //     $restaurants = Restaurant::get();
    //    return Inertia::render('Restaurant',compact('user','restaurants'));
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Image/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $filePath=$this->uploadFile($request->file('avatar'));
        Restaurant::create([
            "name"=>"test",
            "avatar"=>$filePath
        ]);
        return back();
    }

    public function uploadFile(UploadedFile $file)
    {
        return $file->storePublicly('avatar');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $restaurant=Restaurant::find($id);
        return Inertia::render('Image/Edit',compact('restaurant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $restaurant = Restaurant::find($id);
        if($request->file('avatar')){
            if ($restaurant->avatar && Storage::exists($restaurant->avatar)) {
                Storage::delete($restaurant->avatar);
            }            
            $filePath=$this->uploadFile($request->file('avatar'));
        }
        $restaurant->update([
            "name"=>"test new",
            "avatar"=>$filePath
        ]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
