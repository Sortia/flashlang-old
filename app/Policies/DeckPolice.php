<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class DeckPolice extends BasePolice
{
    use HandlesAuthorization;

    public function edit($user, $model = null)
    {
        return is_null($model) || $model->user_id === $user->id;
    }
}
