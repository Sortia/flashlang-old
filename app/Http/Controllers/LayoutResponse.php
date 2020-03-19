<?php

namespace App\Http\Controllers;

trait LayoutResponse
{
    protected function prepareLayout(string $view, array $data = []): string
    {
        return view($view, $data)->toHtml();
    }
}
