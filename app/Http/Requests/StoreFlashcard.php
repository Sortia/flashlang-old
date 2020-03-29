<?php

namespace App\Http\Requests;

use App\Models\Deck;

class StoreFlashcard extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $deckId = $this->request->get('deck_id');
        $userId = Deck::on()->whereKey($deckId)->value('user_id');

        return $userId === user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'front_text' => 'required|max:50',
            'back_text' => 'required|max:50'
        ];
    }
}
