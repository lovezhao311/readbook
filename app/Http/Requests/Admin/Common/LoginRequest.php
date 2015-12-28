<?php

namespace App\Http\Requests\Admin\Common;

use App\Http\Requests\Request;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Session;

class LoginRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'password' => 'required',
            'verify'  => 'required|captcha',
        ];
    }

    public function messages(){
        return [
            'name.required' => trans('auth.user_not_empty'),
            'password.required' =>  trans('auth.password_not_empty'),
            'verify.required' =>  trans('auth.verify_not_empty'),
            'verify.captcha' =>  trans('auth.verify_not_success'),
        ];
    }
    
}
