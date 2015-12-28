<?php

namespace App\Http\Requests\Admin\Rbac;

use App\Http\Requests\Request;

class UpdateManageRequest extends Request
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
            'name' => 'required|max:20|alpha_dash',
            'email' => 'required|email',
            'password' => 'sometimes|max:20|confirmed'            
        ];
    }


    public function messages()
    {
        return [
            'name.required' => trans('auth.user_not_empty'),
            'name.alpha_dash' => trans('auth.user_alpha_dash'),
            'name.max' => trans('auth.user_max'),           
            'email.required' => trans('auth.email_not_empty'),
            'email.email' => trans('auth.email_verify'),
            'password.max' => trans('auth.password_max'),
        ];
    }
}
