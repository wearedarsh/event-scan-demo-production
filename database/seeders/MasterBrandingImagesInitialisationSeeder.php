<?php

namespace Database\Seeders\Branding;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MasterBrandingImagesInitialisationSeeder extends Seeder
{
    public function run(): void
    {
        $sourceFolder = database_path('seeders/branding/branding_files');
        $destinationFolder = 'public/branding';

        if (! File::exists($sourceFolder)) {
            $this->command->warn("Source folder {$sourceFolder} does not exist. Skipping image initialisation.");
            return;
        }

        $files = File::files($sourceFolder);

        if (empty($files)) {
            $this->command->warn("No files found in {$sourceFolder}. Nothing to initialise.");
            return;
        }

        foreach ($files as $file) {
            $filename = $file->getFilename();
            $destinationPath = $destinationFolder . '/' . $filename;

            if (! Storage::exists($destinationPath)) {
                Storage::putFileAs($destinationFolder, $file, $filename);
                $this->command->info("Copied: {$filename}");
            } else {
                $this->command->info("Skipped (already exists): {$filename}");
            }
        }

        $this->command->info("Branding image initialisation complete.");
    }
}
