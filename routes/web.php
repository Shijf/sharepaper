<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//use Overtrue\Socialite\User as SocialiteUser;

Route::get('/', 'PagesController@root')->name('home');

Route::any('/wechat', 'WeChatController@serve');

//$user = [
//
//    'openid' => 'sjshjkchakjsh',
//    'nickname' => 'shijf',
//    'headimgurl' => 'https://www.baidu.com/link?url=pOVLZ2iiWuaF0d34Iam0M7IsyLuHyVstXuEzC3D08omhqwkEM-ghcMdDKTcQu_wY0iMoSyT3E3t9mS3Vfh_D9EhqEv0OEBsBpb72MdvA4-pTFfMWr_F532s5JbOUb-Kj_OdPAG-2sWu6ihtpNZGc6J66Pc4qHT4JPzdk1W6Wq_4pT6cfP1knPk0cm2dVOFEIFUFstyLOJsxA4QpMgMb4bx0ZNU_GPLQKso1acIpffa8-weCkH8A_gDDeKdqYVUeFHw-JaXLS9GLgolSDTJj8K9sGLf3E46A7_8SLim8zpdLYL2k1uonL1bs_47wUw2ctNAgg5MZCfRVKUSS1XpnEBw1ELJueEccdfi62MUxydYtHrOcMcAoiDS4kK1pwgLXmUf5xqB8fLYt5UoPmfO8aI1P2WkCTERWnFf1H1SIiz2MJgB84GOpFUVBoJlMFE3tY9UNE8EhZx_Gzcgi6ACXvocISw3RjHH0SEK9jy8m2CSd6v5xaRHldcUVehH3-PGqL1qa4i4S56ZoqdN73SRmxdCygdBZIbsaJ0HGgcE50MRaltP4QK3oozm6rvVEIsC2JBVUG6bANpNXHdWInHSC3uK&wd=&eqid=9805421000013bee000000035b88f93e'
//];
//
//
//$user = new SocialiteUser([
//    'id' => array_get($user, 'openid'),
//    'name' => array_get($user, 'nickname'),
//    'nickname' => array_get($user, 'nickname'),
//    'avatar' => array_get($user, 'headimgurl'),
//    'email' => null,
//    'original' => [],
//    'provider' => 'WeChat',
//]);
//
//session(['wechat.oauth_user.default' => $user]);


Route::group(['middleware' => ['web', 'wechat.oauth']], function () {

    Route::get('/login','WeChatController@login')->name('login');

    Route::get('/getpaper','SharePaperController@getPaper');

});
Route::get('/wechat/logout', 'WeChatController@logout')->name('logout');

Route::get('/clearCache',function (){
    \Illuminate\Support\Facades\Cache::flush();
});

