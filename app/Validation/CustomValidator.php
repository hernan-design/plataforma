<?php

namespace App\Validation;

use Illuminate\Validation\Validator;
use GuzzleHttp\Client, Log;

use App\Models\Param\Institucion, App\RegistroSesion;

class CustomValidator extends Validator
{   
    public function validateWords($attribute, $value, $parameters)
    {
        $min = isset($parameters[0]) ? $parameters[0] : false; 
        $max = isset($parameters[1]) ? $parameters[1] : false; 
        
        if($min) {
            if(str_word_count(trim($value)) < $min){
                return false;
            }
        }
        if($max) {
            if(str_word_count(trim($value)) > $max){
                return false;
            }
        }
        return true;
    }

    public function validateRecaptcha($attribute, $value, $parameters)
    {
        $client = new Client();
        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify', [
                'verify' => false,
                'form_params'=> [
                    'secret' => RegistroSesion::institution()->clave_secreta_captcha ?: config('tuproyecto.grecatcha_secret_key'),
                    'response' => $value
                ]
            ]
        );        
        $body = json_decode((string)$response->getBody());
        return $body->success;
    }

    public function validateSmaller($attribute, $value, $parameters)
    {
                
        if(is_numeric($value)){
            $value = (double)  $value;
        }

        $comparator = isset($parameters[0]) ? $parameters[0] : false;
        if(is_numeric($comparator)){
            $comparator = (double)  $comparator;
        }
        
        if($comparator && $value <= $comparator){

            return true;
        }
        return false;
        
    }

    public function validateSmallerPrice($attribute, $value, $parameters)
    {
        if(is_numeric($value)){
            $value = (float)  $value*100;
            $value = (int) $value;
        }else{
            $return =  false;
        }

        $comparator = isset($parameters[0]) ? $parameters[0] : false;
        if(is_numeric($value)){
            $comparator = (float)  $comparator*100;
            $comparator = (int) $comparator;          
        }else{
            $return =  false; 
        }

        if(isset($comparator) && $value <= $comparator){
            return true;
        }

        return false;
    }
}
