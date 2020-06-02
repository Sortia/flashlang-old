<?php

namespace App\Http\Requests;

use App\Models\Deck;

class DeleteDeckRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /** @var Deck $deck */
        $deck = $this->route('deck');

        return $deck->isOwner();
    }

}
