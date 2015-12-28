<?php

namespace App\Http\Requests\Admin\Rbac;

use App\Http\Requests\Request;

class CreateNavigationRequest extends Request
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

    
    public function rules()
    {
        return [
            'name' => 'required|max:20|min:2',  
            // 'url'   =>  'url',
            'pid'   =>  'numeric'       
        ];
    }

    public function messages()
    {
        $name = trans('rbac.navigation');
        $url  = trans('common.url');
        $pid  = trans('common.belong_to').$name;
        return [
            'name.required' => trans('auth.not_empty',['name'=>$name]),            
            'name.max'      =>  trans('auth.max_length' , ['name'=>$name , 'count'=>20]),
            'name.min'      =>  trans('auth.min_length' , ['name'=>$name , 'count'=>2]),
            'url.url'       =>  trans('auth.url' , ['name'=>$name]),
            'pid.numeric'   =>  trans('auth.numeric' ,['name'=>$name])
        ];
    }
}
