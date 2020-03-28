<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSettings extends BaseModel
{
    protected $fillable = [
        'settings_id',
        'settings_value_id',
        'user_id'
    ];

    /**
     * Пользователь
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Настройка
     */
    public function key(): BelongsTo
    {
        return $this->belongsTo(Settings::class);
    }

    /**
     * Значение настройки
     */
    public function value(): BelongsTo
    {
        return $this->belongsTo(SettingsValues::class);
    }
}
