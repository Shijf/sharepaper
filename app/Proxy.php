<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proxy extends Model
{
    //
    /**
     * 获取代理对应的用户
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * 获取代理所有的机器
     */
    public function papers()
    {
        return $this->hasMany('App\Paper');
    }

    /**
     * 获取代理机器下所有的订单
     */

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    /**
     * 获取代理下的分润表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profits()
    {
        return $this->hasMany('App\Profit');
    }
}
