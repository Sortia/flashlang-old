<?php

namespace App\Repositories;

use App\Models\Settings;
use App\Models\SettingsValues;
use App\Models\UserSettings;

class SettingsRepository extends Repository
{
    /**
     * Сохранение настроек пользовател
     */
    public function store($settings)
    {
        foreach ($settings as $key => $value) {
            UserSettings::on()->updateOrCreate([
                'user_id' => user()->id,
                'settings_id' => Settings::on()->where('name', $key)->value('id')
            ], [
                'settings_value_id' => $value
            ]);
        }
    }

    /**
     * Сохранение идной настройки
     */
    public function set($key, $value)
    {
        $value = SettingsValues::on()->where('value', $value)->value('id');

        $this->store([$key => $value]);

        return settings($key);
    }
}
