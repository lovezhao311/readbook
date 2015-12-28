<?php

namespace App\Http\Controllers\Admin\Rbac;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Admin\Role;
use App\Models\Admin\Permission;
use App\Models\Admin\Navigation;
use Session;

use App\Foundation\View\ViewAlert;
use App\Http\Requests\Admin\Rbac\CreateRolesRequest;
use App\Http\Requests\Admin\Rbac\UpdateRolesRequest;

class RolesController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        $keywords = $request->input('keywords');
        if($keywords){
            return view('admin.rbac.roles.index')->withPages(Role::where('display_name' , $keywords)->paginate(15)); 
        }else{
            return view('admin.rbac.roles.index')->withPages(Role::paginate(15)); 
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Permission $permission , Navigation $navigation)
    {         
        return view('admin.rbac.roles.create')->with('navigationRows' , $navigation->getAllNavigationForChildren())
                ->with('permissionRows' , $permission->getAllPermissionForChildren());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRolesRequest $rolesRequest)
    {
        $inputs = $rolesRequest->all();
        $roleModel = new Role();
        $result = $roleModel->submitForCreate($inputs);

        return view('admin.common.alert',ViewAlert::getViewInstance()->create($result));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roleModel = new Role();
        $navigationModel = new Navigation();
        $permissionModel = new Permission();

        if(!($roleRow = $roleModel->getForEdit($id))){
            return view('admin.common.alert',[
                'type'=>'warning' ,
                'error'=>[trans('page_404')],
                'location'=>[
                    'url'=>route('admin.rbac.roles.index') , 
                    'name'=>trans('rbac.role').trans('common.list')
                    ]
                 ]);
        }

        return view('admin.rbac.roles.create')->with('navigationRows' , $navigationModel->getAllNavigationForChildren())
                ->with('permissionRows' , $permissionModel->getAllPermissionForChildren())->with('roleRow',$roleRow);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UpdateRolesRequest $rolesRequest , $id)
    {
        $inputs = $rolesRequest->all();
        $roleModel = new Role();
        
        $result = $roleModel->submitForUpdate($id , $inputs);

        return view('admin.common.alert',ViewAlert::getViewInstance()->create($result));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $roleModel = new Role();

        $result = $roleModel->submitForDestroy($id);
     
        return response()->json(ViewAlert::getViewInstance()->create($result));
    }
}
