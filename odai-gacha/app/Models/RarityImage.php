<?php

namespace App\Models;

use Ulid\Ulid;

use Illuminate\Database\Eloquent\Model;

class RarityImage extends Model
{
    protected $table = 'rarity_images';
    protected $primaryKey = 'rarity_image_id';
    protected $keyType = 'char';
    public $incrementing = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->attributes['rarity_image_id'] = Ulid::generate();
    }
}
