<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftCascadeTrait;
    use SoftDeletes;

    protected array $softCascade = [];

    /**
     * Условие для поиска по автризованому пользователю
     *
     * @param $query
     *
     * @return mixed
     */
    public static function scopeCurrent(Builder $query)
    {
        return $query->where('user_id', user()->id);
    }

    /**
     * Просто чтобы where не подсвечивалась
     *
     * @param $column
     * @param  null  $operator
     * @param  null  $value
     * @param  string  $boolean
     *
     * @return Builder
     */
    public static function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        return parent::on()->where($column, $operator, $value, $boolean);
    }
}
