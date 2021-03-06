<?php

namespace App\Models;

use Exception;

trait SoftCascadeTrait
{
    /**
     * Каскадное удаление
     *
     * @throws Exception
     */
    public function delete(): void
    {
        foreach ($this->softCascade as $relation) {
            if (is_a($this->$relation, 'Illuminate\Database\Eloquent\Model')) {
                $this->$relation->delete();
            }

            if (is_a($this->$relation, 'Illuminate\Support\Collection')) {
                foreach ($this->$relation as $item) {
                    $item->delete();
                }
            }
        }

        parent::delete();
    }
}
