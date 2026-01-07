<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HandlesDisplayOrder
{
    protected function moveUp(Model $model): void
    {
        if ($model->display_order <= 1) {
            return;
        }

        $model->decrement('display_order');
    }

    protected function moveDown(Model $model): void
    {
        $model->increment('display_order');
    }

    protected function updateOrder(Model $model, int $order): void
    {
        $model->update([
            'display_order' => max(1, $order),
        ]);
    }
}
