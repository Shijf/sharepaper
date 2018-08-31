<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'user_id', 'paper_id', 'proxy_id','mac','method','profit'
    ];

    /**获取订单对应的用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * 获取订单属于那家代理
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proxy()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * 获取 订单所属机器
     */
    public function paper()
    {
        return $this->belongsTo('App\Paper');
    }



}
