<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settings extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function values()
    {
        return $this->hasMany(SettingsValues::class);
    }
}
