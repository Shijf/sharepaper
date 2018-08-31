<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    //
    /**获取分润表对应的代理
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proxy()
    {
        return $this->belongsTo('App\Proxy');
    }
}
