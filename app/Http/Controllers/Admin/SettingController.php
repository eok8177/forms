<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.setting', [
            'settings' => Setting::all()
        ]);
    }


    public function update(Request $request)
    {
        Setting::updateSettings($request->except('_token'));
        return redirect()->route('admin.settings')->with('success', 'Updated');
    }

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
