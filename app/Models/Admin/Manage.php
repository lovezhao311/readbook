<?php

namespace App\Models\Admin;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Support\Facades\Config;

use DB;

class Manage extends  Model implements AuthenticatableContract, CanResetPasswordContract {
    use Authenticatable, CanResetPassword, EntrustUserTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'manages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    /**
     * @author luffyzhao
     * @todo 因为改了用户表和用户主键字段所以要重写 EntrustUserTrait::roles 方法
     * @return [type] [description]
     */
    public function roles()
    {
        return $this->belongsToMany(Config::get('entrust.role'), Config::get('entrust.role_user_table'), 'manage_id', 'role_id');
    }

    public function getRoles()
    {
        $rolesRows = $this->roles()->where('manage_id' , 1)->get();
        $roles = [];
        if($rolesRows){
            foreach ($rolesRows as $key => $value) {
               $roles[$key] = ($value->id); 
            }  
        }
        return $roles;
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

            $manageRowId = $this->insertGetId([
                'name'=>$inputs['name'],
                'email'=>$inputs['email'],
                'password'=> bcrypt($inputs['password'])
            ]);
            $manageModel = $this->find($manageRowId);
            if(isset($inputs['roles']) && !empty($inputs['roles'])){
                 $manageModel->roles()->sync($inputs['roles']);
            }

            DB::commit();
            return ['status'=>true , 'id'=>$manageRowId];    
        } catch (Exception $e) {            
            DB::rollback();
            return ['status'=>false];
        }

    }

    /**
     * 视图修改角色
     * @param  [type] $id     [description]
     * @param  [type] $inputs [description]
     * @return [type]         [description]
     */
    public function submitForUpdate($id , $inputs)
    {
        $isAble  = $this->where('id','<>' , $id)
            ->whereRaw("(`name`='{$inputs['name']}' OR `email`='{$inputs['email']}')")
            ->count();

        if($isAble > 0){
            return ['status'=>false , 'error'=>trans('auth.usered' , ['name'=>trans('rbac.manage_name')])];
        }

        DB::beginTransaction();
        try{
            $manageRow = $this->find($id);            
            if(isset($inputs['password']) && $inputs['password'] != ''){
                $manageRow->password = bcrypt($inputs['password']);
            }
            $manageRow->name = $inputs['name'];
            $manageRow->email = $inputs['email'];
            $manageRow->save();
            
            $manageRow->roles()->detach();

            if(isset($inputs['roles']) && !empty($inputs['roles'])){
                 $manageRow->roles()->sync($inputs['roles']);
            }

            DB::commit();
            return ['status'=>true , 'id'=>$id];  
        }catch(Exception $e){
            DB::rollback();
            return ['status'=>false];
        }
    }

    /**
     * 删除
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function submitForDestroy($id)
    {
        DB::beginTransaction(); 
        try{
            $manageRow = $this->find($id);
            $manageRow->roles()->detach();
            $manageRow->delete();
            DB::commit();
            return ['status'=>true];
        }catch(Exception $e){
            DB::rollback();
            return ['status'=>false];
        }
    }
}
