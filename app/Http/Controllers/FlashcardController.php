<?php

namespace App\Http\Controllers;

use App\Deck;
use App\Flashcard;
use App\Http\Requests\DeleteFlashcard;
use App\Http\Requests\StoreFlashcard;
use App\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FlashcardController extends Controller
{
    /**
     * Сохранение новой карточки
     */
    public function store(StoreFlashcard $request): JsonResponse
    {
        $flashcard =  Flashcard::on()->updateOrCreate(['id' => $request->get('id')], $request->all());

        $flashcard->users->firstOrCreate(['flashcard_id' => $flashcard->id, 'user_id' => user()->id]);

        $layout = view('deck.components.flashcard', ['flashcard' => $flashcard, 'deck' => Deck::class])->toHtml();

        return $this->respond($layout);
    }

    /**
     * Удаление карточки
     *
     * @throws Exception
     */
    public function destroy(DeleteFlashcard $request, Flashcard $flashcard): JsonResponse
    {
        $flashcard->delete();

        return $this->respondSuccess();
    }

    /**
     * Проставление/изменение статуса
     */
    public function updateStatus(Request $request, Flashcard $flashcard): JsonResponse
    {
        $statusId = Status::where('value', $request->value)->value('id');

        $flashcard->statusPivot->update(['status_id' => $statusId]);

        return $this->respondSuccess();
    }
}
