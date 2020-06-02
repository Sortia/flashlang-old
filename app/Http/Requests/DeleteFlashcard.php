<?php

namespace App\Http\Requests;

use App\Models\Flashcard;

class DeleteFlashcard extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var Flashcard $flashcard */
        $flashcard = $this->route('flashcard');

        return $flashcard->deck->user_id === user()->id;
    }
}
