<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController
{
    public function index(Request $request, $w = 0, $h = 0)
    {
        if ($w == 0) $w = null;
        if ($h == 0) $h = null;

        $img = $request->input("img");

        $img = public_path(urldecode($img));

        if (file_exists($img)) {
            $img = $img;
        } else {
            $img =  public_path() . '/images/default.jpg';
        }

        if (!$h) {
            $cache = \Image::cache(function($image) use($img, $w, $h) {
                $image->make($img)->widen($w, function ($constraint) {
                    $constraint->upsize();
                });
            }, 1440, true);
        } elseif (!$w) {
            $cache = \Image::cache(function($image) use($img, $w, $h) {
                $image->make($img)->heighten($h, function ($constraint) {
                    $constraint->upsize();
                });
            }, 1440, true);
        } else {
            $cache = \Image::cache(function($image) use($img, $w, $h) {
                $image->make($img)->fit($w, $h, function ($constraint) {
                    $constraint->upsize();
                });
            }, 1440, true);
        }

        return $cache->response('jpg');
    }
}
