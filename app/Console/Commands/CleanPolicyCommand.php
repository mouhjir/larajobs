<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CleanPolicyCommand extends Command
{
    protected $signature = 'clean:policy';

    protected $description = 'Remove unused functions policy that contain {{ ... }} in the return value';

    public function handle()
    {
        $policiesPath = app_path('Policies');

        if (!File::isDirectory($policiesPath)) {
            $this->error('Policies directory not found.');
            return;
        }
        $files = File::files($policiesPath);

        foreach ($files as $file) {
            $filePath = $file->getPathname();
            $contents = File::get($filePath);

            // Split the content into lines
            $lines = explode("\n", $contents);

            $newLines = [];

            $insideFunction = false;
            foreach ($lines as $line) {
                // Check if the line contains the function keyword
                if (str_contains($line, 'function ')) {
                    $insideFunction = true;
                }

                // Check if the line contains the placeholder variable
                if ($insideFunction && str_contains($line, '{{')) {
                    // Replace the return statement with "return true"
                    $line = str_replace($line, '        return true;', $line);
                }

                // Add the line to the new lines
                $newLines[] = $line;

                // Check if the line ends the function block
                if ($insideFunction && str_contains($line, '}')) {
                    $insideFunction = false;
                }
            }

            // Join the new lines back into the content
            $newContents = implode("\n", $newLines);

            File::put($filePath, $newContents);
        }

        $this->info('Methods with placeholder variables replaced with "return true" in Policy files.');
    }
}
