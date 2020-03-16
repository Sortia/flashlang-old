<?php

use App\Settings;
use App\SettingsValues;
use App\User;
use App\UserSettings;
use Illuminate\Support\Facades\DB;

function percent(float $progress, float $total): float
{
    return ($progress / ($total == 0 ? 1 : $total)) * 100;
}

function settings(string $key, string $value = null): string
{
    if (!is_null($value)) {
        $keyId = Settings::on()->where('name', $key)->value('id');
        $valueId = SettingsValues::on()->where('value', $value)->value('id');

        UserSettings::on()->updateOrCreate([
            'settings_id' => $keyId,
            'user_id' => user()->id
        ], [
            'settings_value_id' => $valueId
        ]);
    }

    $query = "
        select
            sv.value
        from settings as s
        inner join user_settings as us on us.settings_id = s.id
        inner join settings_values as sv on us.settings_value_id = sv.id
    ";

    return DB::selectOne($query)->value;
}

/**
 * @return User|null
 */
function user()
{
    return auth()->user();
}

/**
 * @param string $view
 * @param array $data
 * @return string
 */
function ajax_view(string $view, array $data = []): string
{
    return view($view, $data)->toHtml();
}

function to_array($object)
{
    return json_decode(json_encode($object), true);
}
