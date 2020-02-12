<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rarity extends Model
{
    protected $table = 'rarity';
    protected $primaryKey = 'rarity_id';
    public $incrementing = false;
    protected $fillable = [
      'rarity_id',
      'rarity',
      'rarity_name',
      'probability',
      'gacha_id',
      'created_at',
      'updated_at'
  ];
}
