<?php

namespace App;

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

    public function values()
    {
        return $this->hasMany(SettingsValues::class);
    }
}
