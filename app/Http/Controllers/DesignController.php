<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DesignController extends Controller
{
   public function save(Request $request)
{
    $image = $request->input('image');
    $imageName = time() . '.png';

    $image = str_replace('data:image/png;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    \Storage::disk('public')->put("designs/$imageName", base64_decode($image));

    return response()->json(['message' => 'Design saved', 'path' => "/storage/designs/$imageName"]);
}

}
