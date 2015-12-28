<?php 
namespace App\Foundation\View;

use Route;
use Cache;
use App\Models\Admin\Permission;

class ViewAlert {
	static $_viewClass = null;
	private $current;
	private $method;
	private $alert = [];
	

	static function getViewInstance()
	{
		if(is_null(self::$_viewClass)){
			self::$_viewClass = new ViewAlert();
		}
		return self::$_viewClass;
	}

	public function __construct(){
		$current = Route::currentRouteName();      
  		$this->current = substr ($current , 0 , strrpos ($current , '.')+1 );
  		$this->method  = substr ($current , strrpos ($current , '.')+1 );
	}

	/**
	 * 根据type生成数组
	 * @param  [type]  $type [description]
	 * @param  integer $id   [description]
	 * @return [type]        [description]
	 */
	public function create($result)
	{
		$method = 'get'.ucfirst($this->method);	

		if($result['status']){
			$this->alert['type'] = 'success';
			$method .= 'SuccessMessage';
		}else{
			$this->alert['type'] = 'warning';
			$method .= 'FailMessage';
		}
		$id = isset($result['id']) ? $result['id'] : 0;
		$this->$method($id);

		if(isset($result['error'])){
			$this->alert['message'] .= ' '.$result['error'];
		}
		

		return $this->alert;
	}	
	

	/**
	 * 添加成功反馈
	 * @param Permission $permission [description]
	 * @param [type]     $id         [description]
	 */
	private function getStoreSuccessMessage($id)
	{	
		$this->alert['hrefs'][]  = $this->getHrefByMethod('edit',$id);
		$this->alert['hrefs'][]  = $this->getHrefByMethod('index');	
		$this->alert['message'] = trans('common.add').trans('common.success');
	}

	/**
	 * 添加失败
	 * @param  string $id [description]
	 * @return [type]     [description]
	 */
	private function getStoreFailMessage($id)
	{	
		$this->alert['hrefs'][]  = $this->getHrefByMethod('create');
		$this->alert['hrefs'][]  = $this->getHrefByMethod('index');		
		$this->alert['message'] = trans('common.add').trans('common.fail');		
	}

	/**
	 * 修改成功
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	private function getUpdateSuccessMessage($id)
	{
		$this->alert['hrefs'][]  = $this->getHrefByMethod('edit' , $id);
		$this->alert['hrefs'][]  = $this->getHrefByMethod('index');	
		$this->alert['message'] = trans('common.edit').trans('common.success');
	}

	/**
	 * 修改失败
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	private function getUpdateFailMessage($id)
	{
		$this->alert['hrefs'][]  = $this->getHrefByMethod('edit' , $id);
		$this->alert['hrefs'][]  = $this->getHrefByMethod('index');
		$this->alert['message'] = trans('common.edit').trans('common.fail');
	}

	/**
	 * 删除成功
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	private function getDestroySuccessMessage($id)
	{
		$this->alert['message'] = trans('common.delete').trans('common.success');
	}

	/**
	 * 删除失败
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	private function getDestroyFailMessage($id)
	{
		$this->alert['message'] = trans('common.delete').trans('common.fail');
	}
	/**
	 * 生成url数组
	 * @param  string  $method [description]
	 * @param  integer $id     [description]
	 * @return [type]          [description]
	 */
	private function getHrefByMethod($method='index' , $id = 0){
		

		$current = $this->getCurrentForParam($method);
		$name = '';
		if (Cache::has("permissionRows[{$current}]")){
		    $permissionRow = Cache::get("permissionRows[{$current}]");
		    $name =    isset($permissionRow['display_name']) && $permissionRow['display_name'] ? $permissionRow['display_name'] : '';         
		}

		if($name == ''){
			$permission = new Permission();
			$name = $permission->whereName($current)->pluck('display_name');
		}
		
		if($id == 0){
			return ['url'=>route($current) , 'name'=>$name];	
		}
		else {

			return ['url'=>route($current , ['id'=>$id]) , 'name'=>$name];	
		}	
	}


	/**
	 * 拼接权限名称
	 * @param  string $method [description]
	 * @return [type]         [description]
	 */
	private function getCurrentForParam($method='index')
	{
		return $this->current . $method;
	}

	
}