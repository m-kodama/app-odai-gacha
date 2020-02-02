<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rarity extends Model
{
    protected $table = 'rarity';
     protected $primaryKey = 'rarity_id';
    public $incrementing = false;
}
