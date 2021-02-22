<?php

/**
* Description:
* Image processor
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - index(Request $request, $w = 0, $h = 0) | Generate JPG file based on the input image file and optionally passed new width or height params
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController
{
    /**
    * Description:
    * Generate JPG file based on the input image file and optionally passed new width or height params
    *
    * List of parameters:
    * - $request : Request
    * - $w: integer (optional) - resizes the current image to new height, constraining aspect ratio
    * - $h: integer (optional) - resizes the current image to new width, constraining aspect ratio
    * if both $w and $h are setup, priority is set to $h
    * - if $w and $h are not setup - combine cropping and resizing to format image in a smart way.
    * The method will find the best fitting aspect ratio of your given width and height on the current image automatically.
    *
    * Return:
    * JPG image
    *
    * Examples of usage:
    * - <baseUrl>/admin/news - list of news are shown within image thumnail associated for each news article 
    * - <baseUrl>/resize/0/56/?img=<imageFileName> - resizes original imageFileName to new width=56px
    */
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
