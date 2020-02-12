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
      'created_at',
      'updated_at',
  ];

  //belongsTo設定
    public function rarity()
    {
        return $this->belongsTo('App\Models\Rarity', 'rarity_id');
    }
    public function gacha() {
        return $this->belongsTo('App\Models\Gacha', 'gacha_id');
    }
}
