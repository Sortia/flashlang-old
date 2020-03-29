<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends BaseModel
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
