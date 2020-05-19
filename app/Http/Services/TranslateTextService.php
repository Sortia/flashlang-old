<?php

namespace App\Http\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TranslateTextService
{
    const API_URL = 'https://translate.yandex.net/api/v1.5/tr.json/translate';

    const LANGUAGE_DIRECTION = 'en-ru';

    public function translate($text)
    {
        $translated = "";

        foreach ($this->split($text) as $segment) {
            $response = Http::asForm()->post(self::API_URL, [
                'key'  => config('services.yandex.key'),
                'lang' => self::LANGUAGE_DIRECTION,
                'text' => $segment,
            ]);

            $translated .= Arr::first($response->json()['text']);
        }

        return $translated;
    }

    private function split($text, $countSymbols = 9000)
    {
        $segments = collect();

        do {
            $splits = Str::of($text)->split("/(?<=[\w\W]{$countSymbols})\.\s/");

            $segments->add($splits->shift());
            $text = $splits->implode('. ');
        } while ($splits->count() > 1);

        return $segments;
    }
}
