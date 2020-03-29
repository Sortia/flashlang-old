<?php

namespace App\Repositories;

use App\Http\Requests\StoreDeck;
use App\Models\Deck;
use App\Models\DeckUser;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class DeckRepository extends Repository
{
    use AddDeck;

    /**
     * Получение всех колод пользователя
     */
    public function get(): Collection
    {
        return Deck::on()->whereIn('id', DeckUser::userDecks())->get();
    }

    /**
     * Сохранение колоды
     */
    public function store(StoreDeck $request): Deck
    {
        $deckData = array_merge($request->all(), ['user_id' => user()->id]);

        $deck = Deck::on()->updateOrCreate(['id' => $request->id, 'user_id' => user()->id], $deckData);

        $deck->users()->create(['user_id' => user()->id]);

        return $deck;
    }

    /**
     * Проставление рейтинга колоде
     */
    public function updateStatus(Deck $deck, string $value)
    {
        $deck->rate()->updateOrCreate(['user_id' => user()->id], compact('value'));

        $deck->update(['rating' => $deck->rates->pluck('value')->avg()]);
    }

    /**
     * Удаление колоды.
     * Если публичная - только у текущего пользователя.
     * Если приватная - насовсем
     *
     * @throws Exception
     */
    public function delete(Deck $deck)
    {
        ($deck->isOwner() && $deck->isPrivate()) ? $deck->delete() : $deck->user->delete();
    }
}
