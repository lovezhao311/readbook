<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\Navigation;

class IndexController extends Controller
{

    public function __construct()
    {
        $this->middleware('authLogin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request , Navigation $navigation)
    {
        $navigations = $navigation->getUserNavigationForId($request->user());
        
        return view('admin.index' , compact('navigations'));
    }

    public function main()
    {
        return view('admin.common.main');
    }    
    
}
