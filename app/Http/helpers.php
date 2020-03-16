<?php

use App\Settings;
use App\User;

function percent(float $progress, float $total): float {
    return ($progress / ($total == 0 ? 1 : $total)) * 100;
}

function settings(string $key, string $value = null): string {

    if (!is_null($value)) {
        Settings::on()->updateOrCreate([
            'user_id' => user()->id,
            'key' => $key
        ], [
            'value' => $value
        ]);
    }

    return user()->settings->where('key', $key)->first()->value;
}

/**
 * @return User|null
 */
function user() {
    return auth()->user();
}

/**
 * @param string $view
 * @param array $data
 * @return string
 */
function ajax_view(string $view, array $data = []): string {
    return view($view, $data)->toHtml();
}

