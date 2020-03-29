<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settings extends BaseModel
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    protected $with = [
        'values'
    ];

    /**
     * Значения настройки
     */
    public function values(): HasMany
    {
        return $this->hasMany(SettingsValues::class);
    }
}
