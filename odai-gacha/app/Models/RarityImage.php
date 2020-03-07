<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ulid\Ulid;

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
