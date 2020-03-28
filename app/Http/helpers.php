<?php

use App\Settings;
use App\SettingsValues;
use App\User;
use App\UserSettings;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * Расчитать процент
 *
 * @param float $progress
 * @param float $total
 * @return float
 */
function percent(float $progress, float $total): float
{
    return ($progress / ($total ?: 0)) * 100;
}

/**
 * Установить значение настроек
 *
 * @param $key
 * @param $value
 *
 * @return string
 */
function set_settings($key, $value)
{
    $keyId = Settings::on()->where('name', $key)->value('id');
    $valueId = SettingsValues::on()->where('value', $value)->value('id');

    UserSettings::on()->updateOrCreate([
        'settings_id' => $keyId,
        'user_id' => user()->id
    ], [
        'settings_value_id' => $valueId
    ]);

    return get_settings($key);
}

/**
 * Получить значение настроек
 *
 * @param  string  $key
 * @param  string  $default
 *
 * @return string
 */
function get_settings(string $key, string $default = null)
{
    $query = "
        select
            sv.value
        from settings as s
        inner join user_settings as us on us.settings_id = s.id
        inner join settings_values as sv on us.settings_value_id = sv.id
        where s.name = '$key'
          and us.user_id = " . user()->id . ";
    ";

    return DB::selectOne($query)->value ?? $default;
}

/**
 * Получить авторизованого пользователя
 *
 * @return User|null
 */
function user()
{
    return auth()->user();
}

/**
 * Преобразовать stdClass в массив
 *
 * @param $object
 * @return mixed
 */
function to_array($object)
{
    return json_decode(json_encode($object), true);
}

/**
 * Получить название стороны карточки, которая должна быть скрыта
 *
 * @return string
 */
function get_hidden_side_name()
{
    return get_settings('study_show_side', 'back_text') === 'front_text' ? 'back_text' : 'front_text';
}

/**
 * Хелпер для отметки чекбокса
 *
 * @param $model
 * @param  string  $field
 * @param  string  $value
 *
 * @return string
 */
function checkbox($model, string $field, string $value)
{
    return (isset($model->$field) && $model->$field === $value) ? 'checked' : '';
}

/**
 * Get array of values
 *
 * @param array $collection
 * @param string $key
 * @return array
 */
function array_get(array $collection, string $key): array
{
    $result = [];

    foreach ($collection as $item) {
        $result[] = Arr::get($item, $key);
    }

    return $result;
}
