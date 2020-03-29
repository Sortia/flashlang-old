<?php

namespace App\Http\Requests;

class StoreFlashcard extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $flashcard = $this->route('flashcard');

        return $flashcard->deck->user_id === user()->id;
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
