<?php

namespace App\Http\Controllers;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Cache;

class WeChatController extends Controller
{
    //
    protected $user;
    protected $app;
    protected $server;

    public function __construct()
    {
        $this->app = app('wechat.official_account');
    }


    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {

        $this->app->server->push(function($message){
            switch ($message['MsgType']) {
                case 'event':


                    switch ($message['Event']){
                        case 'subscribe':
                            return  $this->eventSubscribe($message);
                            break ;
                        case 'unsubscribe':
                            $this->eventUnsubscribe($message);
                            break ;
                        case 'SCAN':
                            $this->eventScan($message);
                            break ;
                        case 'LOCATION':
                            $this->eventLocation($message);
                            break ;
                        case 'CLICK':
                            $this->eventClick($message);
                            break ;
                        case 'VIEW':
                            $this->eventView($message);
                            break ;
                        default:
                            return  typeOf($message['Event']);
                    }
                    break;
                case 'text':
                    return $message['MsgType'];
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                case 'file':
                    return '收到文件消息';
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }

        });

        $response = $this->app->server->serve();

        return $response;
    }


    public function login()
    {
        $this->user = session('wechat.oauth_user.default'); // 拿到授权用户资料


        $userSql = User::where('openid',$this->user->getId())->get();

        if($userSql->isEmpty())
        {
            $nickname = $this->user->getNickname();
            $headimgurl = $this->user->getAvatar();
            $openid = $this->user->getId();

            $user = User::create([
                'openid' => $openid,
                'nickname' => $nickname,
                'headimgurl' => $headimgurl,
            ]);
            Auth::login($user);
        }else
        {
            $user_info = $userSql['0'];
            Auth::loginUsingId($user_info->id);
        }

        return redirect()->home();

    }

    public function logout()
    {
        Auth::logout();
    }
    /**
     * 事件处理
     */
    /**创建用户
     * @param $user
     * @param $openid
     */
    public function create($user, $openid)
    {
        $nickname = $user['nickname'];
        $headimgurl = $user['headimgurl'];
        $subscribe = "1";
        $subtime= $user['subscribe_time'];
        $sex = $user['sex'] == "1" ? "男":"女" ;
        $language = $user['language'];
        $city = $user['city'];
        $country = $user['country'];
        $province = $user['province'];
        $subscribe_scene = $user['subscribe_scene'];
        $userSql = User::where('openid',$openid)->get();

        if ($userSql->isEmpty())
        {
            $user = new User();
            $user->openid = $openid;
            $user->save();
        }

        User::where('openid', $openid)
            ->update(
                [
                    'nickname' => $nickname,
                    'headimgurl' => $headimgurl,
                    'subscribe' => $subscribe,
                    'subtime' => $subtime,
                    'language' => $language,
                    'sex' => $sex,
                    'city' => $city,
                    'country' => $country,
                    'province' => $province,
                    'subscribe_scene' => $subscribe_scene,
                ]
            );
    }

    /**
     * @param array $message
     * @return string
     */
    public function eventSubscribe(array $message)
    {

        $openid = $message['FromUserName'];

        $user_info = $this->app->user->get($openid);


        //用户关注后，保存用户信息
        $this->create($user_info,$openid);

        return "感谢您的关注".$openid;
    }

    public function eventUnsubscribe($message)
    {
        $openid = $message['FromUserName'];
        User::where('openid', $openid)
            ->update(
                [
                    'subscribe' => "0"
                ]
            );
    }

    public function eventScan($message)
    {

    }

    public function eventLocation($message)
    {

    }

    public function eventClick($message)
    {

    }

    public function eventView($message)
    {

    }

    public function text($message)
    {
        $content = $message['Content'];

        return $content;
    }

    public function image($message)
    {
        $id = $message['MediaId'];
        $url = $message['PicUrl'];
    }

    public function voice($message)
    {
        $id = $message['MediaId'];
        $format = $message['Format'];
//        $recognition = $message['Recognition']; //开通语音识别

    }

    public function video($message)
    {
        $id = $message['MediaId'];
        $thumbMediaId = $message['ThumbMediaId'];

    }

    public function shortvideo($message)
    {
        $id = $message['MediaId'];
        $thumbMediaId = $message['ThumbMediaId'];
    }

    public function location($message)
    {

    }

    public function link($message)
    {

    }

    public function file($message)
    {

    }

    public function other($message)
    {
        $message->MsgType;
        $message->Title;
        $message->Description;
        $message->FileKey;
        $message->FileMd5;
        $message->FileTotalLen;
    }
}
