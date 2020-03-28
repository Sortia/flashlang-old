<?php

namespace App\Http\Controllers;

trait LayoutResponse
{
    /**
     * Заполнение blade-шаблона значениями и возврашение в виде строки
     */
    protected function prepareLayout(string $view, array $data = []): string
    {
        return view($view, $data)->toHtml();
    }
}
