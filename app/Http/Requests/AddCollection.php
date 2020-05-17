<?php

namespace App\Http\Requests;

class AddCollection extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $collection = $this->route('collection');

        return $collection->isPublic();
    }
}
