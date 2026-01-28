<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MasterBrandingImagesInitialisationSeeder extends Seeder
{
    public function run(): void
    {
        $sourceFolder = database_path('seeders/Branding/branding_files');

        if (! File::exists($sourceFolder)) {
            $this->command->warn("Source folder {$sourceFolder} does not exist. Skipping image initialisation.");
            return;
        }

        $files = File::files($sourceFolder);

        if (empty($files)) {
            $this->command->warn("No files found in {$sourceFolder}. Nothing to initialise.");
            return;
        }

        $destinationFolder = storage_path('app/public/branding');

        if (! File::exists($destinationFolder)) {
            File::makeDirectory($destinationFolder, 0755, true); // recursive = true
            $this->command->info("Created folder: {$destinationFolder}");
        }

        foreach ($files as $file) {
            $filename = $file->getFilename();
            $destinationPath = $destinationFolder . '/' . $filename;

            if (! File::exists($destinationPath)) {
                Storage::putFileAs('public/branding', $file, $filename);
                $this->command->info("Copied: {$filename}");
            } else {
                $this->command->info("Skipped (already exists): {$filename}");
            }
        }

        $this->command->info("Branding image initialisation complete.");
    }
}
