<?php

namespace App\Http\Controllers\Admin\Common;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Auth\Guard;

use App\Http\Controllers\Controller;
use App\Models\Admin\Navigation;

class LeftController extends Controller
{

    public function __construct(Guard $guard)
    {
        if (!$guard->guest()) {
            return redirect()->guest('admin/index');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request , Navigation $navigation)
    {   
        $navigations = $navigation->getUserNavigationForId($request->user() , $request->input('id' , 1) , 2);
        return view('admin.common.left'  , compact('navigations'));
    }

   
}
