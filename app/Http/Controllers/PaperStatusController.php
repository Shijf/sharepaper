<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;

class PaperStatusController extends Controller
{
    //指令约束
    protected $sc_out = 2;
    protected $cs_out = 3;

    protected $sc_search_work = 4;
    protected $cs_search_status = 5;

    protected $sc_search_net = 6;
    protected $cs_search_net_status = 7;

    protected $sc_search_reset = 8;
    protected $cs_search_reset_status = 9;

    protected $guzzleOptions = [];

    /**
     * 查询MAC地址
     * @param $code
     * @return mixed
     */
    public function getMac($code)
    {
        return $code;
    }
    /**
     * 服务器下发出货指令
     */

    public function scout($code)
    {
        //获取真实mac
        $mac = $this->getMac($code);
        //构建MQTT发送消息
        $message = $this->buildMessage($mac);
        //执行出纸
        $result =  $this->todo($message,$mac);

        return $result;

    }

    /**
     * 服务器下发设备上报服务器出货状态
     */
    public function sc_search_work()
    {
        $message = $this->buildMessage($this->sc_search_work,"123",2,21);
    }

    /**
     *
     */
    public function cs_search_status()
    {

    }

    /**
     * 设备网络状态
     */
    public function sc_search_net()
    {

    }
    public function cs_search_net()
    {

    }
    /**
     * 复位设备
     */
    public function sc_search_reset()
    {

    }

    /**
     * 复位反馈
     */
    public function cs_search_reset_status()
    {

    }
    /**
     * @param $message
     * @param string $topicName
     * @return array|mixed
     */
    public function todo($message)
    {
        $url = env('PAPER_GET_API_URL');
        $response = $this->getHttpClient()->post($url, [
            'query' => $message,
        ]);

        $status = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        $jsonBody = \json_decode($body, true);
        if ($status == 200){
            return $jsonBody;
        }else{
//            网络错误
            return $this->response(0,"网络错误",'danger');
        }
    }
    /**
     * @return Client
     * 创建客户端
     */
    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    /**
     * @param array $potions
     * 配置客户端参数
     */
    public function setGuzzleOptions(array $potions)
    {
        $this->guzzleOptions = $potions;
    }


    /**
     * @param int $c 指令
     * @param string $f 发送方
     * @param string $t 接收方
     * @param string $m 消息
     * @param int $mi 消息ID
     * @return array
     */
    public function buildMessage(string $code)
    {
        $arr = array ("c"=>2,"f"=>"ZHZN001","t"=>$code,"m"=>"1","mi"=>2); //出纸
        $message = json_encode($arr);
        $query = array();
        $query['topicName'] = "ZHZN"."/".$code;
        $query['message'] = $message;
        return $query;
    }

    /**
     * @param int $code 响应码
     * @param string $msg 提示信息
     * @param string $class 情景类别
     * @return array
     */
    public function response(int $code,string $msg,string $class = 'success')
    {
        return [
            'code' => $code,
            'msg' => $msg,
            'class' => $class,
        ];
    }

}
