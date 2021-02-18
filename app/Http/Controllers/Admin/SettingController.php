<?php

/**
* Description:
* Controller (based on MVC architecture) for the settings management
* All the methods are available only for the admin
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - index() | Show the list of available settings
* - update(Request $request) | Update settings
* - crypt($value) | testing crypting (debug purposes) 
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    /**
    * Description:
    * Show the list of available settings
    *
    * List of parameters:
    * - none
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/settings
    */
    public function index()
    {
        $dateFormats = [
            'dd/mm/yy' => 'dd/mm/yy',
            'dd-mm-yy' => 'dd-mm-yy',
            'mm/dd/yy' => 'mm/dd/yy',
            'mm-dd-yy' => 'mm-dd-yy',
            'yy/mm/dd' => 'yy/mm/dd',
            'yy-mm-dd' => 'yy-mm-dd',
        ];
        return view('admin.setting', [
            'settings' => Setting::all(),
            'dateFormats' => $dateFormats
        ]);
    }


    /**
    * Description:
    * Update settings
    *
    * List of parameters:
    * - $request : Request
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - go to <baseUrl>/admin/settings and click "Save"
    */
    public function update(Request $request)
    {
        Setting::updateSettings($request->except('_token'));
        return redirect()->route('admin.settings')->with('success', 'Updated');
    }


    /**
    * Description:
    * testing crypting (debug purposes)
    *
    * List of parameters:
    * - $value : string
    *
    * Return:
    * 
    *
    * Examples of usage:
    * - 
    */
    public function crypt($value)
    {
        $ciphering = "AES-128-CTR"; // Store the cipher method
        $iv_length = openssl_cipher_iv_length($ciphering); // Use OpenSSl Encryption method
        $iv = '1234567887654321'; // Non-NULL Initialization Vector for encryption
        $key = "key0123456789"; // Store the encryption key 

        $encryption = openssl_encrypt($value, $ciphering, $key, 0, $iv); // Use openssl_encrypt() function to encrypt the data 

        echo "Encrypted String: " . $encryption . "\n"; // Display the encrypted string 

        // Use openssl_decrypt() function to decrypt the data 
        $decryption=openssl_decrypt ($encryption, $ciphering, $key, 0, $iv); 

        echo "Decrypted String: " . $decryption; // Display the decrypted string 
    }
}
