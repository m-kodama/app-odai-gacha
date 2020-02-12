<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model {

  //belongsTo設定
    public function rarity()
    {
        return $this->belongsTo('App\Rarity');
    }
}
