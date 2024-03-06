<?php

namespace App\Http\Controllers\ujian\uts;

use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\SettingUjian;




class SettingtimeUjianController extends Controller
{
    public function __construct()
    {
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = SettingUjian::get();
        return view('admin.ujian.uts.baak.setting.index',compact('setting'));
    }

  
}
