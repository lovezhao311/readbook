<?php

namespace App\Http\Controllers\Admin;

use Route;
use Session;
use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Permission;


class AdminController extends Controller
{
   public function __construct()
   {    
      //获取面包屑
      $this->userIndex();
      //如果session有存在errors
      if($erros = Session::get('errors')){
        view()->share('errors' , $erros->toArray());
      }      
   }

   /**
    * 当前面包屑
    * @return [type] [description]
    */
   private function userIndex()
   {
        $permission = new Permission();
        $current = Route::currentRouteName();
        $name = '';
        if (Cache::has("permissionRows[{$current}]")){
            $permissionRow = Cache::get("permissionRows[{$current}]");
            $name =    isset($permissionRow['display_name']) && $permissionRow['display_name'] ? $permissionRow['display_name'] : '';         
        }
        if($name == ''){
          $name = $permission->whereName($current)->pluck('display_name');
        }
        view()->share('userIndex' , $name);
   }

   
}
