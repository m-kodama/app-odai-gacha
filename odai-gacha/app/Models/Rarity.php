<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ulid\Ulid;

class Rarity extends Model
{
    protected $table = 'rarity';
    protected $primaryKey = 'rarity_id';
    protected $keyType = 'char';
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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->attributes['rarity_id'] = Ulid::generate();
    }
}
