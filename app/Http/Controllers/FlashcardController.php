<?php

namespace App\Http\Controllers;

use App\Flashcard;
use Illuminate\Http\Request;

class FlashcardController extends Controller
{
    /**
     * Ajax response
     *
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        return response()->json(view('block.components.flashcard', [
            'flashcard' => Flashcard::on()->updateOrCreate(['id' => $request->get('id')], $request->all())
        ])->toHtml());
    }

    public function destroy(Flashcard $flashcard)
    {
        return $flashcard->delete();
    }
}
