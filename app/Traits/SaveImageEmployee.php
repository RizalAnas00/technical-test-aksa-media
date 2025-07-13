<?php

namespace App\Traits;

trait SaveImageEmployee
{
    public function saveImage($request, $employee = null)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $baseName = $request->name ?? $employee?->name ?? 'employee';
            $timestamp = time() ?? $image->getCTime(); 

            $extension = $image->getClientOriginalExtension() ?? 'jpg';

            $filename = $baseName . $timestamp . '.' . $extension;

            $image->storeAs('public/employees', $filename);

            $path = 'storage/employees/' . $filename;
            $request->image = $path;
        }

        return $request;
    } 
}
