<?php

use App\Models\Settings;
use App\Models\SettingsValues;
use App\Models\User;
use App\Models\UserSettings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * Расчитать процент
 */
function percent(float $progress, float $total): float
{
    return ($progress / ($total == 0 ? 1: $total)) * 100;
}

/**
 * Установить значение настроек
 */
function set_settings(string $key, string $value): string
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
 */
function get_settings(string $key, string $default = null): string
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
 */
function user(): ?User
{
    return auth()->user();
}

/**
 * Преобразовать stdClass в массив
 *
 * @param mixed $object
 */
function to_array($object): array
{
    return json_decode(json_encode($object), true);
}

/**
 * Получить название стороны карточки, которая должна быть скрыта
 */
function get_hidden_side_name(): string
{
    return get_settings('study_show_side', 'back_text') === 'front_text' ? 'back_text' : 'front_text';
}

/**
 * Хелпер для отметки чекбокса
 */
function checkbox(Model $model, string $field, string $value): string
{
    return (isset($model->$field) && $model->$field === $value) ? 'checked' : '';
}

/**
 * Get array of values
 */
function array_get(array $collection, string $key): array
{
    $result = [];

    foreach ($collection as $item) {
        $result[] = Arr::get($item, $key);
    }

    return $result;
}
