<?php

namespace App\Http\Controllers\Admin\Rbac;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Admin\Permission;
use App\Foundation\View\ViewAlert;
use App\Http\Requests\Admin\Rbac\CreatePermissionRequest;
use App\Http\Requests\Admin\Rbac\UpdatePermissionRequest;
use Session;
class PermissionController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Permission $permissionModel)
    {
        return view('admin.rbac.permission.index')->with('permissionRows' , $permissionModel->getAllPermissionForChildren());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Permission $permissionModel)
    {
        // print_r(Session::all());
        return view('admin.rbac.permission.create')
            ->with('permissionRows' , $permissionModel->where('pid',0)->get()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Permission $permissionModel , CreatePermissionRequest $permissionRequest)
    {

        $inputs = $permissionRequest->all();

        $result = $permissionModel->submitForCreate($inputs);

        return view('admin.common.alert',ViewAlert::getViewInstance()->create($result));
    }
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permissionModel, $id)
    {
        $permissionRow = $permissionModel->find($id)->toArray();
        if(!$permissionRow){
            return view('admin.common.alert' , [
                'type'=>'warning',
                'data'=>trans('rbac.permission_not_exist'),
                'location'=>['url'=>route('admin.rbac.permission.index') , 'name'=>trans('rbac.permission').trans('common.list')]
            ]);
        }
        // print_r($permissionRow);die();
        return view('admin.rbac.permission.create')->with('permissionRow' , $permissionRow)
                ->with('permissionRows' , $permissionModel->where('pid',0)->get()->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $permissionRequest , Permission $permissionModel , $id)
    {
        $inputs = $permissionRequest->all();      
     
        $result  = $permissionModel->submitForUpdate($id , $inputs);

        return view('admin.common.alert',ViewAlert::getViewInstance()->create($result));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permissionModel , $id)
    {
        $result = $permissionModel->submitForDestroy($id);        

        return response()->json(ViewAlert::getViewInstance()->create($result));
    }
}
