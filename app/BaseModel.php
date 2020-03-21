<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public static function current()
    {
        return static::on()->where('user_id', user()->id)->get();
    }
}
