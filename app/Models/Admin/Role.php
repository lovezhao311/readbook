<?php

namespace App\Models\Admin;

use Zizaco\Entrust\EntrustRole;

use DB;
// use PermissionRole;

class Role extends EntrustRole
{
    public $timestamps = true;
    /**
     * 多对多关联导航表
     * @return [type] [description]
     */
    public function navigation()
    {
        return $this->belongsToMany('App\Models\Admin\Navigation', 'roles_navigation','role_id','navigation_id');
    }


    /**
     * 多对多关联权限表
     * @return [type] [description]
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Models\Admin\Permission', 'permission_role','role_id','permission_id');
    }

    /**
     * 多对多关联用户表
     * @return [type] [description]
     */
    public function manage()
    {
        return $this->belongsToMany('App\Models\Admin\Manage', 'role_manages','role_id','manage_id');
    }

    /**
     * 视图编辑数据
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getForEdit($id)
    {
        $roleRow = $this->find($id);
        if(!$roleRow){
            return false;
        }
        $navigationRows = array_fetch( $roleRow->navigation->toArray() ,'id');
        
        $permissionRows = array_fetch( $roleRow->permissions->toArray() , 'id');

       
        return [
           'navigationRows'=> $navigationRows,
           'permissionRows'=> $permissionRows,
           'roleRow' => $roleRow->toArray()
        ];    
    }

    /**
     * 视图创建角色
     * @param  [type] $inputs [description]
     * @return [type]         [description]
     */
    public function submitForCreate($inputs)
    {

    	DB::beginTransaction();    	
    	try {
    		$roleID = $this->insertGetId([
    			'name'=>$inputs['name'] , 
    			'display_name'=>$inputs['display_name'] , 
    			'description'=>$inputs['description']
			]);
    		if(!$roleID){
    			throw new Exception("Error Processing Request", 1);    			
    		}
            $roleModel = $this->find($roleID);
    		if(isset($inputs['permission_id']) && !empty($inputs['permission_id'])){    
                $roleModel->permissions()->sync($inputs['permission_id']);	
    		}

    		if(isset($inputs['navigation_id']) && !empty($inputs['navigation_id'])){ 
                $roleModel->navigation()->sync($inputs['navigation_id']);   
    		}
    		DB::commit();
			return ['status'=>true , 'id'=>$roleID];    		
    	} catch (Exception $e) {
    		DB::rollback();
    		return [
    			'status'=>false    			
    		];
    	}
    }

    /**
     * 视图修改角色
     * @param  [type] $inputs [description]
     * @return [type]         [description]
     */
    public function submitForUpdate($id,$inputs)
    {   
        $isAble = $this->where('id' , '<>' , $id)->where('name' , $inputs['name'])->count();

        if($isAble > 0){
            return [
                'status'=>false,
                'id'=>$id,
                'error' => trans('auth.usered' , ['name'=>trans('rbac.role')])
            ];
        }

        DB::beginTransaction(); 
        try {
            $roleRow = $this->find($id);
            $roleRow->name = $inputs['name'];
            $roleRow->display_name = $inputs['display_name'];
            $roleRow->description = $inputs['description'];
            $roleRow->save();
            
            //下面的操作好像可以用 updateExistingPivot
            $roleRow->permissions()->detach();
            $roleRow->navigation()->detach();

            if(isset($inputs['permission_id']) && !empty($inputs['permission_id'])){    
                $roleRow->permissions()->sync($inputs['permission_id']);  
            }

            if(isset($inputs['navigation_id']) && !empty($inputs['navigation_id'])){ 
                $roleRow->navigation()->sync($inputs['navigation_id']);   
            }

            DB::commit();

            return ['status'=>true , 'id'=>$id];  
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status'=>false               
            ];
        }
    }

    /**
     * 视图删除角色
     * @return [type] [description]
     */
    public function submitForDestroy($id)
    {
        $roleRow = $this->find($id);
        if(!$roleRow){
            return [
                'status'=>false,
                'error' => trans('common.page_404')
            ];
        }
        // 有用户在此角色下不能删除
        if(count($roleRow->manage) > 0){
            return [
                'status'=>false,
                'error' => trans('rbac.role_has_manage')
            ];
        }
        DB::beginTransaction(); 
        try {
            $roleRow->permissions()->detach();
            $roleRow->navigation()->detach();
            $roleRow->delete();
            DB::commit();
            return ['status'=>true];
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status'=>false                
            ];
        }
        
    }
    
}
