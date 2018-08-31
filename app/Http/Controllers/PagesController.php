<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            return redirect('/login');
        }

    }
}
