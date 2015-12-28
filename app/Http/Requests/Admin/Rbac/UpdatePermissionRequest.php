<?php

namespace App\Http\Requests\Admin\Rbac;

use App\Http\Requests\Request;

class UpdatePermissionRequest extends Request
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
            'name'=>'required|max:255|min:6',
            'display_name'=>'required|max:20|min:3'
        ];
    }

    public function messages($value='')
    {
        $name = trans('rbac.permission_name');
        $display_name = trans('rbac.permission_display_name');    
        
        return [
            'name.required' => trans('auth.not_empty' , ['name'=>$name]),
            'name.max' => trans('auth.max_length' , ['name'=>$name , 'count'=>255]),            
            'name.min' => trans('auth.min_length' , ['name'=>$name , 'count'=>6]),            
            'display_name.required' => trans('auth.not_empty' , ['name'=>$display_name]),
            'display_name.max' => trans('auth.max_length' , ['name'=>$display_name , 'count'=>20]),
            'display_name.min' => trans('auth.min_length' , ['name'=>$display_name , 'count'=>3])
        ];
    }
}
