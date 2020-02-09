<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gacha extends Model
{
    protected $table = 'gacha_master';
    protected $primaryKey = 'gacha_id';
    public $incrementing = false;

    //hasMany設定
    public function topics()
    {
        return $this->hasMany('App\Topic', 'gacha_id');
    }
}
