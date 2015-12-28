<?php

namespace App\Models\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    protected $table = 'navigation';

    public $timestamps = false;

    public function roles()
    {
        return $this->belongsToMany('App\Models\Admin\Role', 'roles_navigation');
    }
    /**
     * 获取用户菜单
     * @author luffyzhao
     * @param Object $user 登陆用户
     * @param Integer $navigationPid
     * @param Integer $level
     * @return Array
     */
    public function getUserNavigationForId($user, $navigationPid = 0, $level = 1)
    {
        $navigationData = array();

        $navigationRows = $this->where('pid', $navigationPid)->orderBy('id', 'ASC')->orderBy('sort', 'ASC')->get();

        if ($navigationRows) {
            // 检查权限
            foreach ($navigationRows as $key => $value) {
                foreach ($value->roles()->get() as $roles) {
                    if ($user->hasRole($roles->name)) {
                        if (($level - 1) > 0) {
                            $value->children = $this->getUserNavigationForId($user, $value->id, $level - 1);
                        }
                        $navigationData[$key] = $value;
                        break;
                    }
                }

            }
        }

        return $navigationData;
    }

    /**
     * 获取导航的无限分类
     * @return [type] [description]
     */
    public function getAllNavigationForChildren($pid = 0)
    {
        $allForChildren = array();
        $navigationRows = $this->orderBy('pid', 'asc')->orderBy('sort', 'asc')->where('pid', $pid)->get();
        if ($navigationRows) {
            foreach ($navigationRows as $key => $value) {
                $value->children = $this->getAllNavigationForChildren($value['id']);
                $allForChildren[$value['id']] = $value;
            }
        }

        return $allForChildren;
    }

    /**
     * 创建导航
     * @param  [type] $inputs [description]
     * @return [type]         [description]
     */
    public function submitForCreate($inputs)
    {
        $navigationId = $this->insertGetId([
            'name' => $inputs['name'],
            'url' => $inputs['url'],
            'pid' => $inputs['pid'],
            'sort' => $inputs['sort'],
        ]);

        if ($navigationId > 0) {
            return ['status' => true, 'id' => $navigationId];
        }
        return ['status' => false];
    }

    public function submitForUpdate($id, $inputs)
    {
        $navigationRow = $this->find($id);

        if (!$navigationRow) {
            return ['status' => false, 'error' => trans('auth.id_not_exists')];
        }

        $navigationRow->name = $inputs['name'];
        $navigationRow->url = $inputs['url'];
        $navigationRow->sort = $inputs['sort'];
        $navigationRow->pid = $inputs['pid'];
        $navigationRow->save();

        return ['status' => true, 'id' => $id];
    }

    /**
     * 删除导航
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function submitForDestroy($id)
    {
        $isAble = $this->where('pid', $id)->count();
        if ($isAble > 0) {
            return ['status' => false, 'error' => trans('rbac.navigation_has_children')];
        }

        $navigationRow = $this->find($id);
        DB::beginTransaction();

        try {
            $navigationRow->roles()->detach();
            $navigationRow->delete();
            DB::commit();
            return ['status' => true];
        } catch (Exception $e) {
            DB::rollback();
            return ['status' => false];
        }
    }

}
