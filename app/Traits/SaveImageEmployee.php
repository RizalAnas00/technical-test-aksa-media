<?php

namespace App\Traits;

trait SaveImageEmployee
{
    public function saveImage($request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $request->name . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/employees', $filename);
            $path = 'storage/employees/' . $filename;
            $request->image = $path;
        }

        return $request;
    }    
}
