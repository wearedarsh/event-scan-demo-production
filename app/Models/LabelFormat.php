<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabelFormat extends Model
{
    protected $fillable = [
        'name',
        'key_name',
        'rows',
        'columns',
        'labels_per_sheet',
        'label_width_mm',
        'label_height_mm',
        'row_gap_mm',
        'column_gap_mm',
        'central_gap_mm',
        'orientation',
        'active',
    ];

    public function positionForSlot(int $slot): array
    {
        $slot = max(1, min($slot, $this->labels_per_sheet));
        $index = $slot - 1;

        $row = intdiv($index, $this->columns);
        $col = $index % $this->columns;

        $x = $col * ($this->label_width_mm + $this->central_gap_mm);

        $y = $row * ($this->label_height_mm + $this->row_gap_mm);
        return compact('x', 'y');
    }


    public function slots()
    {
        return $this->rows * $this->columns;
    }
}
