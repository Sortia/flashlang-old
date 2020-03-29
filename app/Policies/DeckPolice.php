<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class DeckPolice extends BasePolice
{
    use HandlesAuthorization;

    public function edit($user, $model)
    {
        return !$model->id || $model->user_id === $user->id;
    }

    public function createFlashcard($user, $model)
    {
        return $model->id;
    }
}
