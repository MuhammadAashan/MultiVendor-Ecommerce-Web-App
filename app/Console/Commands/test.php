<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        ini_set('memory_limit', '2048M');
        set_time_limit(0);
        $extensions = ['.csv', '.xlsx', '.xls'];
        $fileExist = false;
        $filenameBase = "eBay_Active_Listings_Item";

        foreach ($extensions as $extension) {
            $filename = $filenameBase . $extension;
            // Build the full path to the file using DIRECTORY_SEPARATOR
            $filePath = "C:/Users/Ashan/Downloads/$filename";
            if (file_exists($filePath)) {
                $fileExist = true;
                try {
                    $counter = 0;
                    Excel::filter('chunk')->load($filePath)->chunk(10, function ($results) use (&$counter) {
                        foreach ($results->toArray() as $row) {
                            $title = $row['Title'];

                            // Your processing logic for the specific column value
                            dd($title);
                            $counter++;

                            // Check if we've processed ten rows
                            if ($counter >= 10) {
                                break; // exit the loop if we've processed ten rows
                            }
                        }
                    });
                } catch (\Exception $e) {
                    Log::error("Exception during file processing: " . $e->getMessage());
                }
                // No need to continue checking other extensions if the file is found
                exit();
            }
        }
        if ($fileExist) {
            dd("File exists: " . $filePath);
            dd($filePath);
        } else {
            dd("File not found");
        }
    }
}
