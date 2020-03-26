<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Deck;

class CollectionController extends Controller
{
    public function index()
    {
        return view('collections', [
            'collections' => Collection::getAll()
        ]);
    }
}
