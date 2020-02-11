<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model {

  public $incrementing = false;
  protected $fillable = [
      'topic_id',
      'topic',
      'gacha_id',
      'rarity_id',
  ];

  //belongsTo設定
    public function rarity()
    {
        return $this->belongsTo('App\Gacha', 'gacha_id');
        return $this->belongsTo('App\Rarity', 'rarity_id');
    }
}
