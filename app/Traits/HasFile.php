<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HasFile
{
    public function hasFile($request)
    {
        $pathToFile = null;
        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = "image/" . $filename . "_" . time() . "." . $extension;
            $request->file('image')->storeAs('public', $fileNameToStore);

            $pathToFile = "storage/" . $fileNameToStore;

            return $pathToFile;
        } else if ($request->hasFile('image_profile')) {
            $path = $request->file('image_profile')->getRealPath();
            $image = file_get_contents($path);
            $pathEncoded = base64_encode($path);
            $imageType = explode('/', $request->image_type);
            $imageFormat = end($imageType);
            $pathStorage = '/public/profiles/' .  $pathEncoded . "." . $imageFormat;
            Storage::put($pathStorage, $image);

            $pathToFile = "storage/profiles/" . $pathEncoded . "." . $imageFormat;

            return $pathToFile;
        } else {
            return null;
        }
    }
}