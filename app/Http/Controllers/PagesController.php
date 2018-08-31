<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class PagesController extends Controller
{
    //
    public function root()
    {

        if (Auth::check())
        {
            $config = app('wechat.official_account')->jssdk->buildConfig(array('onMenuShareQQ', 'onMenuShareWeibo','scanQRCode'));
            return view('pages.root',compact('config'));
        }else{
            dd("未登录");
        }

    }
}
