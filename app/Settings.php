<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settings extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'key',
        'value',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
