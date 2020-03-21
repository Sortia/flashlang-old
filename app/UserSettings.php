<?php

namespace App;

class UserSettings extends BaseModel
{
    protected $fillable = [
        'settings_id',
        'settings_value_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function key()
    {
        return $this->belongsTo(Settings::class);
    }

    public function value()
    {
        return $this->belongsTo(SettingsValues::class);
    }
}
