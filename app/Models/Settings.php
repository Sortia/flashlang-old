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

    /**
     * Сохранение настроек пользовател
     */
    public static function store($settings)
    {
        foreach ($settings as $key => $value) {
            UserSettings::updateOrCreate([
                'user_id' => user()->id,
                'settings_id' => Settings::where('name', $key)->value('id')
            ], [
                'settings_value_id' => $value
            ]);
        }
    }

    /**
     * Сохранение идной настройки
     */
    public static function set($key, $value)
    {
        $value = SettingsValues::where('value', $value)->value('id');

        self::store([$key => $value]);

        return settings($key);
    }
}
