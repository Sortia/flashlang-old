<?php

use App\Settings;
use App\SettingsValues;
use App\User;
use App\UserSettings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * Calc percent
 *
 * @param float $progress
 * @param float $total
 * @return float
 */
function percent(float $progress, float $total): float
{
    return ($progress / ($total == 0 ? 1 : $total)) * 100;
}

/**
 * Get / Set settings value
 *
 * @param string $key
 * @param string|null $value
 * @return string
 */
function settings(string $key, string $value = null): ?string
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
        where s.name = '$key'
          and us.user_id = " . user()->id . ";
    ";

    return DB::selectOne($query)->value ?? null;
}

/**
 * Get auth user
 *
 * @return User|null
 */
function user()
{
    return auth()->user();
}

/**
 * Get rendered view
 *
 * @param string $view
 * @param array $data
 * @return string
 */
function ajax_view(string $view, array $data = []): string
{
    return view($view, $data)->toHtml();
}

/**
 * Convert stdClass to array
 *
 * @param $object
 * @return mixed
 */
function to_array($object)
{
    return json_decode(json_encode($object), true);
}

/**
 * Get array of values
 *
 * @param array $collection
 * @param string $key
 * @return array
 */
function arrayGet(array $collection, string $key): array
{
    $result = [];

    foreach ($collection as $item) {
        $result[] = Arr::get($item, $key);
    }

    return $result;
}

function getHiddenSideName()
{
    return settings('study_show_side') === 'front_text' ? 'back_text' : 'front_text';
}

function checkbox($model, string $field, string $value)
{
    return (isset($model->$field) && $model->$field === $value) ? 'checked' : '';
}
