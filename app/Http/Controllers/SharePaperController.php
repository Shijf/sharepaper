<?php

namespace App\Http\Controllers;

use App\Order;
use App\Paper;
use App\Proxy;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\OrderController;
use Auth;
class SharePaperController extends Controller
{

    protected $mac;
    protected $user;
    protected $paper;
    protected $user_id;
    protected $user_openid;
    protected $msg = [];

    /**
     * 出纸
     * @param PaperStatusController $paperStatusController
     * @param Request $request
     * @return mixed
     */
    public function getPaper(PaperStatusController $paperStatusController,OrderController $order,Request $request)
    {
        $this->user_id = $request->user_id;
        $status = $this->isStatus($request->echostr);
        if ($status){
            $response = $paperStatusController->scout($this->mac);
            if ($response['resultCode']=="0")
            {
                $this->AfterSuccessOutPaper($order);
                $this->msg = [
                    'code' => 1,
                    'msg' => "出纸成功",
                ];
                return $this->msg;

            }

        }else{
            return $this->msg;
        }
    }

    /**
     * @param array $response
     */
    public function AfterSuccessOutPaper($order)
    {

        $paper =  Paper::where('mac',$this->mac)->first();
        $paper->increment('out');
        $paper->decrement('surplus');
//        $proxy = Proxy::where('user_id',$this->user_id)->first();
//        dd($proxy);
        //创建订单
        $order->create($this->user_id,$this->paper->id,$this->mac,1,"0.3");


        Cache::remember('limit_daily'.$this->user_id,3,function (){
            return [
                'openid' => $this->user_openid,
                'time' => Carbon::now()->day,
            ];
        });

    }

    /**
     * @param $code
     * @return bool
     */
    public function isStatus($code)
    {
        return $this->getMac($code) =="ok" &&  $this->isPaperEmpty($code) =="ok" && $this->isFirst()  =="ok"? true : false;
    }
    /**
     * 当天是否领取
     * @return array | bool
     */
    public function isFirst()
    {
        $openid = $this->user_openid ;
        $cache = Cache::has('limit_daily'.$openid);
        if ($cache){
            $this->msg = [
                'code' => 0,
                'msg' => "今天您已经领取过了，明天再来吧"
            ];
            return "0";
        }else{
            return "ok";
        }
    }


    /**
     * @param $code
     * @return bool
     */
    public function isPaperEmpty($code)
    {
        $paper = Paper::where('code',$code)->first();
        if ($paper->surplus == "0"){
            $this->msg = [
                'code' => 0,
                'msg' => "本机纸巾已全部领完"
            ];
            return "0";
        }else{
            return "ok";
        }
    }

    /**
     * 获取真实MAc
     *
     */
    public function getMac($code)
    {
        $mac = Paper::where('code',$code)->first();
        if ($mac != null)
        {
            $this->paper = $mac;
            $this->mac = $mac->mac;
            return "ok";
        }else{
            $msg = "您所在的机器还未注册，请您稍后再试";
            $this->msg = [
                'code' => 0,
                'msg' =>$msg,
            ];

            return "0";
        }

    }


}
