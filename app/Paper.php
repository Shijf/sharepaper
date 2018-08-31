<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    //
    protected $fillable = [
        'proxy_id', 'code', 'mac','status','surplus','quantity','out'
    ];

    /**
     * 获取机器属于的代理
     */
    public function proxy()
    {
        return $this->belongsTo('App\Proxy');
    }



}
