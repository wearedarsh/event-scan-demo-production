<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LabelFormat;

class LabelFormatSeeder extends Seeder
{
    public function run(): void
    {
        LabelFormat::updateOrCreate(
            ['key_name' => 'avery_80x80'],
            [
                'name' => 'Avery 80×80 mm',
                'rows' => 3,
                'columns' => 2,
                'labels_per_sheet' => 6,
                'label_width_mm' => 80,
                'label_height_mm' => 80,
                'row_gap_mm' => 6,
                'column_gap_mm' => 0,
                'central_gap_mm' => 6,
                'orientation' => 'portrait',
                'active' => true,
            ]
        );
    }
}
