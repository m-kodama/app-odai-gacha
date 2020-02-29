<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ulid\Ulid;

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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->attributes['topic_id'] = Ulid::generate();
    }

    //belongsTo設定
    public function rarity()
    {
        return $this->belongsTo('App\Models\Rarity', 'rarity_id');
    }
    public function gacha() {
        return $this->belongsTo('App\Models\Gacha', 'gacha_id');
    }
}
