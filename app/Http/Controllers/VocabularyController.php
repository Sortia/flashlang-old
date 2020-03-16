<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    public function index()
    {
        return view('vocabulary');
    }
}
