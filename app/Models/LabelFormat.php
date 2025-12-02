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

    public function slots()
    {
        return $this->rows * $this->columns;
    }
}
