<?php

namespace App\Http\Controllers;

use App\Order;
use App\Paper;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Auth;
class SharePaperController extends Controller
{

    protected $mac;
    protected $paper;
    protected $msg = [];
    /**
     * 出纸
     * @param PaperStatusController $paperStatusController
     * @param Request $request
     * @return mixed
     */
    public function getPaper(PaperStatusController $paperStatusController,Request $request)
    {

        if ($this->isStatus($request->echostr)){
            $response = $paperStatusController->scout($this->mac);
            return $this->Order();
        }else{
            return $this->msg;
        }

//        if ($response['code']){
//            $order = Order::create([
//                'user_id' => Auth::user()->id,
//                'proxy_id' => Auth::user()->id,
//                'paper_id' => $mac->id,
//                '$mac' => $mac->mac,
//            ]);
//        }
    }

    /**
     * @param array $response
     */
    public function Order()
    {
        $paper =  Paper::find($this->paper->id)->first();
        $paper->increment('out');
        $paper->decrement('surplus');

        Order::create([
            'user_id' => Auth::user()->id,
            'paper_id' => $this->paper->id,
            'mac' => $this->mac,
        ]);

        Cache::remember('limit_daily'.Auth::user()->openid,1,function (){
            return [
                'openid' => Auth::user()->openid,
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
        return $this->getMac($code) &&  $this->isPaperEmpty($code) && $this->isFirst() ? true : false;
    }
    /**
     * 当天是否领取
     * @return array | bool
     */
    public function isFirst()
    {
        if (Cache::has('limit_daily'.Auth::user()->openid)){
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
