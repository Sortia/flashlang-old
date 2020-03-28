<?php

namespace App;

class Rate extends BaseModel
{
    protected $fillable = [
        'deck_id',
        'user_id',
        'value'
    ];
}
