<?php

namespace Oloid\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CleanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workshop:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes the package\'s base folder and all patterns from your project.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = config('workshop.basePath');
        $sure = $this->confirm("Are you sure, you want to remove all created patterns ({$path}) from your project?", false);

        if ($sure) {
            return File::deleteDirectory($path);
        }

        File::makeDirectory(config('workshop.patternPath'), 0755, true);

        return -1;
    }
}
