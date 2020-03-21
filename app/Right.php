<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Right extends BaseModel
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];
}
