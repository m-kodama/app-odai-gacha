<?php

namespace App\Models;

use Ulid\Ulid;

use Illuminate\Database\Eloquent\Model;

class Gacha extends Model
{
    protected $table = 'gacha_master';
    protected $primaryKey = 'gacha_id';
    protected $keyType = 'char';
    public $incrementing = false;
    protected $fillable = [
        'gacha_id',
        'gacha_name',
        'description',
        'needUsePass',
        'needEditPass',
        'needDeletePass',
        'password',
        'user_id'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->attributes['gacha_id'] = Ulid::generate();
    }

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
