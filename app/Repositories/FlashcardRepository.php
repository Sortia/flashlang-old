<?php

namespace App\Repositories;

use App\Http\Requests\StoreFlashcard;
use App\Models\DeckUser;
use App\Models\Flashcard;
use App\Models\Status;
use Exception;

class FlashcardRepository
{
    /**
     * Получение всех карточек пользователя
     */
    public function get()
    {
        return Flashcard::on()->whereIn('deck_id', DeckUser::userDecks())->get();
    }

    /**
     * Сохранение карточки
     */
    public function store(StoreFlashcard $request): Flashcard
    {
        $flashcard = Flashcard::on()->updateOrCreate(['id' => $request->id], $request->all());

        $flashcard->users()->firstOrCreate(['flashcard_id' => $flashcard->id, 'user_id' => user()->id]);

        return $flashcard;
    }

    /**
     * Удаление карточки
     *
     * @throws Exception
     */
    public function delete(Flashcard $flashcard)
    {
        $flashcard->delete();
    }

    /**
     * Проставление статуса карточке
     */
    public function updateStatus(Flashcard $flashcard, string $value)
    {
        $statusId = Status::where('value', $value)->value('id');

        $flashcard->statusPivot->update(['status_id' => $statusId]);
    }
}

