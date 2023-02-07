<?php

namespace App\Traits;

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
        }
        // } else {
        //     return response()->json(['error' => 'Empty file']);
        // }
        if ($request->hasFile('image_profile')) {
            $filenameWithExt = $request->file('image_profile')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image_profile')->getClientOriginalExtension();
            $fileNameToStore = "image_profile/" . $filename . "_" . time() . "." . $extension;
            $request->file('image_profile')->storeAs('public', $fileNameToStore);

            $pathToFile = "storage/" . $fileNameToStore;
            return $pathToFile;
        } else {
            return response()->json(['error' => 'Empty file']);
        }
    }
}