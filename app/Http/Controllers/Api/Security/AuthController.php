<?php

namespace App\Http\Controllers\Api\Security;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Tymon\JWTAuth\Exceptions\JWTException;

use JWTAuth;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $key = 'zdk8Q7EzeCHYiyABbVDOgwOvS8b547R1';
        
        $request_correo_electronico = $request->only('correo_electronico');
        $correo_electronico = $request_correo_electronico['correo_electronico'];
        $request_password = $request->only('password');
        $password = $request_password['password'];

        $correo_electronico = $this->my_decrypt($correo_electronico, $key);
        $password = $this->my_decrypt($password, $key);
        
        // $credentials = $request->only('correo_electronico', 'password');
        $credentials = array(
            "correo_electronico" => $correo_electronico,
            "password" => $password
        );

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function my_decrypt($data, $key) {
		// Remove the base64 encoding from our key
        $encryption_key = base64_decode($key);
        
		// To decrypt, split the encrypted data from our IV - our unique separator used was "::"
		list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
		return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }
    
    public function my_encrypt($data, $key) {
		// Remove the base64 encoding from our key
		$encryption_key = base64_decode($key);
		// Generate an initialization vector
		// $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
		$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
		// Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
		$encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
		// The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
		return base64_encode($encrypted . '::' . $iv);
	}
}