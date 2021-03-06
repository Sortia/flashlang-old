<?php

namespace App\Http\Requests;

use App\Models\Deck;

class AddCollection extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var Deck $collection */
        $collection = $this->route('collection');

        return $collection->isPublic();
    }
}
