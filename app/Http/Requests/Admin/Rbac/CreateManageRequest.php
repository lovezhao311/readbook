<?php

namespace App\Http\Requests\Admin\Rbac;

use App\Http\Requests\Request;

class CreateManageRequest extends Request
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
            'name' => 'required|max:20|alpha_dash|unique:manages,name',
            'email' => 'required|email|unique:manages,email',
            'password' => 'required|max:20|confirmed',
            'password_confirmation'=>'required|max:20'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('auth.user_not_empty'),
            'name.alpha_dash' => trans('auth.user_alpha_dash'),
            'name.max' => trans('auth.user_max'),
            'name.unique' => trans('auth.user_unique'),
            'email.required' => trans('auth.email_not_empty'),
            'email.email' => trans('auth.email_verify'),
            'email.unique' => trans('auth.email_unique'),
            'password.max' => trans('auth.password_max'),
            'password_confirmation.required'=>trans('auth.not_empty' , ['name'=>trans('auth.confirm')])
        ];
    }
}
