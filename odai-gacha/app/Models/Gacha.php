<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gacha extends Model
{
    protected $fillable = [
        'gacha_id',
        'gacha_name',
        'description',
        'needUsePass',
        'needEditPass',
        'needDeletePass',
        'password',
        'user_id',
    ];
    protected $table = 'gacha_master';
    protected $primaryKey = 'gacha_id';
    public $incrementing = false;

    //hasMany設定
    public function topics()
    {
        return $this->hasMany('App\Models\Topic', 'gacha_id');
    }
    public function rarity()
    {
        return $this->hasMany('App\Models\Rarity', 'gacha_id');
    }

    // list()を呼んだらscopeList()が呼ばれる
    public static function scopeList($query)
    {
        return $query->select([
            'gacha_id',
            'gacha_name',
            'needUsePass',
            'needEditPass',
            'needDeletePass',
            'description',
            'created_at',
            'updated_at'
        ]);
    }
}