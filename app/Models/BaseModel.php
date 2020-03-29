<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftCascadeTrait;
    use SoftDeletes;

    protected array $softCascade = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Условие для поиска по автризованому пользователю
     */
    public static function scopeCurrent(Builder $query): Builder
    {
        return $query->where('user_id', user()->id);
    }

    /**
     * Просто чтобы where не подсвечивалась
     */
    public static function where($column, $operator = null, $value = null, $boolean = 'and'): Builder
    {
        return parent::on()->where($column, $operator, $value, $boolean);
    }

}
