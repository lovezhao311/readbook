<?php

namespace App\Models\Admin;

use Zizaco\Entrust\EntrustPermission;
use DB;
use Cache;

class Permission extends EntrustPermission
{
    /**
     * 获取权限的无限分类
     * @return [type] [description]
     */
	public function getAllPermissionForChildren()
	{
		$allForChildren = [];
		$permissionRows = $this->orderBy('pid' , 'asc')->get()->toArray();
		
		foreach ($permissionRows as $key => $value) {
			if($value['pid'] == 0){
				$allForChildren[$value['id']]	=	$value;
			}else{				
				$allForChildren[$value['pid']]['children'][$value['id']] = $value;
			}
			if(! Cache::has("permissionRows[{$value['name']}]")){
				Cache::forever("permissionRows[{$value['name']}]" , $value);
			}
		}
		
		return $allForChildren;
	}

	/**
	 * 创建
	 * @param  [type] $inputs [description]
	 * @return [type]         [description]
	 */
	public function submitForCreate($inputs)
	{
		$permissionId = $this->insertGetId([
            'name'=>$inputs['name'] , 
            'display_name'=>$inputs['display_name'] , 
            'pid'   =>  $inputs['pid'],
            'description'=>$inputs['description']
        ]);

        if($permissionId > 0){
        	Cache::forever("permissionRows[{$inputs['name']}]",$this->find($permissionId)->toArray());        	
			return ['status'=>true , 'id'=>$permissionId];    
		}
		return ['status'=>false];
	}

	/**
	 * 修改
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function submitForUpdate($id , $inputs)
	{
		$isAble = $this->where('id', '<>', $id)->where('name', $inputs['name'])->count();

		if($isAble > 0){
			return ['status'=>false , 'error'=>trans('common.unique' , ['name'=>trans('rbac.permission')])];
		}

		$permissionRow = $this->find($id);

		if(Cache::has("permissionRows[{$permissionRow['name']}]")){
        	Cache::forget("permissionRows[{$permissionRow['name']}]");
    	}

		if(!$permissionRow){
			return ['status'=>false , 'error'=>trans('auth.id_not_exists')];
		}

		$this->where('id', $id)->update([
            'name'=>$inputs['name'],
            'display_name' => $inputs['display_name'],
            'pid'   =>  $inputs['pid'],
            'description' => $inputs['description']
        ]);
		Cache::forever("permissionRows[{$inputs['name']}]" , $this->find($id)->toArray());       

        return ['status'=>true , 'id'=>$id];   
	}

	/**
	 * 删除导航
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function submitForDestroy($id)
	{
		$permissionRow = $this->find($id);
		$permissionRow->delete();
		if(Cache::has("permissionRows[{$permissionRow->name}]")){
    		Cache::forget("permissionRows[{$permissionRow->name}]");
    	}
		return ['status'=>true];
	}
}
