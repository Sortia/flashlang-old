<?php

namespace App;

class Rate extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'deck_id',
        'user_id',
        'value'
    ];
}
