<?php

namespace App\Http\Requests\Admin\Rbac;

use App\Http\Requests\Request;

class CreateRolesRequest extends Request
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
            'name'=>'required|max:20|alpha_dash|min:3|unique:roles,name',
            'display_name'=>'required|max:20|min:3',
            'permission_id'=>'array',
            'navigation_id'=>'array'
        ];
    }

    public function messages($value='')
    {
        $name = trans('rbac.role_name');
        $display_name = trans('rbac.role_display_name');
        $role_navigation    =   trans('rbac.role_navigation');
        $role_permissions    =   trans('rbac.role_permissions');
        
        return [
            'name.required' => trans('auth.not_empty' , ['name'=>$name]),
            'name.max' => trans('auth.max_length' , ['name'=>$name , 'count'=>20]),
            'name.alpha_dash' => trans('auth.name_alpha_dash' , ['name'=>$name]),
            'name.min' => trans('auth.min_length' , ['name'=>$name , 'count'=>3]),
            'name.unique' => trans('auth.unique',['name'=>$name]),
            'display_name.required' => trans('auth.not_empty' , ['name'=>$display_name]),
            'display_name.max' => trans('auth.max_length' , ['name'=>$display_name , 'count'=>20]),
            'display_name.min' => trans('auth.min_length' , ['name'=>$display_name , 'count'=>3]),
            'permission_id.array' => trans('auth.array', ['name'=>$role_permissions]),
            'navigation_id.array' => trans('auth.array' , ['name'=>$role_navigation])
        ];
    }
}
