<?php

namespace App\Http\Validator;

use Request;
use Validator;
use App\Model\Language;

class LanguageValidator
{
	public static function check($request)
	{
    	$validator = Validator::make($request, [
            'code' => 'required|unique:language,code,'.$this->id,
            'name' => 'required',
        ]);
        
        return $validator;
    }
    

}