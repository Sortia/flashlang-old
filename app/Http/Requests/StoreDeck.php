<?php

namespace App\Http\Requests;

class StoreDeck extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:20',
            'description' => 'required|max:50',
        ];
    }
}
