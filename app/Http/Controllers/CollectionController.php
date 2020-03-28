<?php

namespace App\Http\Controllers;

use App\Collection;
use Illuminate\View\View;

class CollectionController extends Controller
{
    /**
     * Страница колекций
     */
    public function index(): View
    {
        return view('collections', ['collections' => Collection::getAll()]);
    }
}
