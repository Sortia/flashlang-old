<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftCascadeTrait;
    use SoftDeletes;

    protected array $softCascade = [];

    public static function current()
    {
        return self::where('user_id', user()->id);
    }

    public static function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        return parent::on()->where($column, $operator, $value, $boolean);
    }
}
