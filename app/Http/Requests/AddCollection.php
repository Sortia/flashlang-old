<?php

namespace App\Http\Requests;

class AddCollection extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $deck = $this->route('deck');

        return $deck->isPublic();
    }
}
