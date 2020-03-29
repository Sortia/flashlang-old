<?php

namespace App\Http\Requests;

class DeleteFlashcard extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $flashcard = $this->route('flashcard');

        return $flashcard->deck->user_id === user()->id;
    }
}
