<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model {

  public $incrementing = false;

  //belongsTo設定
    public function rarity()
    {
        return $this->belongsTo('App\Gacha', 'gacha_id');
        return $this->belongsTo('App\Rarity', 'rarity_id');
    }
}
