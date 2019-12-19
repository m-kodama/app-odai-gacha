<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gacha extends Model
{
    protected $table = 'gacha_master';

    //hasMany設定
    public function topics()
    {
        return $this->hasMany('App\Topic');
    }
}
