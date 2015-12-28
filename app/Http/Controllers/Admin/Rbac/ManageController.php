<?php

namespace App\Http\Controllers\Admin\Rbac;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Admin\Manage;
use App\Models\Admin\Role;
use App\Foundation\View\ViewAlert;
use App\Http\Requests\Admin\Rbac\CreateManageRequest;
use App\Http\Requests\Admin\Rbac\UpdateManageRequest;

class ManageController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->input('name');
        if($name == '')
            return view('admin.rbac.manage.index')->withPages(Manage::paginate(15));
        else
            return view('admin.rbac.manage.index')->withPages(Manage::where('name'  , "{$name}")->paginate(15));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.rbac.manage.create')->with('roleRows',Role::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateManageRequest $request , Manage $manageModel)
    {
        $inputs = $request->all();

        $result = $manageModel->submitForCreate($inputs); 

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
        $manageRow = Manage::find($id);
        return view('admin.rbac.manage.create')
            ->with('manageRow',$manageRow)
            ->with('roleRows',Role::all())
            ->with('roleCheckeds' , array_fetch($manageRow->roles->toArray() , 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateManageRequest $request, Manage $manageModel , $id)
    {
        $inputs = $request->all();

  
        $result = $manageModel->submitForUpdate($id , $inputs);

        return view('admin.common.alert',ViewAlert::getViewInstance()->create($result));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manage $manageModel , $id)
    {
        $result = $manageModel->submitForDestroy($id);       

        return response()->json(ViewAlert::getViewInstance()->create($result));
    }
}
