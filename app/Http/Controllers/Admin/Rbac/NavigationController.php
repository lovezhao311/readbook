<?php

namespace App\Http\Controllers\Admin\Rbac;

use App\Http\Controllers\Admin\AdminController;
use Route;
use App\Models\Admin\Navigation;
use App\Http\Requests\Admin\Rbac\CreateNavigationRequest;
use App\Foundation\View\ViewAlert;

class NavigationController extends AdminController
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Navigation $navigationModel)
    {   
        return view('admin.rbac.navigation.index')
            ->with('navigationRows' , $navigationModel->getAllNavigationForChildren());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Navigation $navigationModel)
    {
        return view('admin.rbac.navigation.create')->with('navigationRows' , $navigationModel->getAllNavigationForChildren());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateNavigationRequest $request , Navigation $navigationModel)
    {
        $inputs = $request->all();      

        $result = $navigationModel->submitForCreate($inputs);
      
        return view('admin.common.alert',ViewAlert::getViewInstance()->create($result));       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Navigation $navigationModel , $id)
    {
        return view('admin.rbac.navigation.create')
            ->with('navigationRow' , $navigationModel->find($id))
            ->with('navigationRows' , $navigationModel->getAllNavigationForChildren());
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateNavigationRequest $request, Navigation $navigationModel ,$id)
    {
        $inputs = $request->all();

        $result = $navigationModel->submitForUpdate($id , $inputs);

        return view('admin.common.alert',ViewAlert::getViewInstance()->create($result));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Navigation $navigationModel , $id)
    {
        $result = $navigationModel->submitForDestroy($id);

        return response()->json( ViewAlert::getViewInstance()->create($result) );
    }
}
