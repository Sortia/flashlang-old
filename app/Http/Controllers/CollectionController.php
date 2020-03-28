<?php

namespace App\Http\Controllers;

use App\Collection;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class CollectionController extends Controller
{
    /**
     * Страница колекций
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('collections', ['collections' => Collection::getAll()]);
    }
}
