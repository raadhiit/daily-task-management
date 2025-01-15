<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ClearCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear application cache';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Clear application cache
        Cache::flush();
        $this->info('Application cache berhasil dihapus!');

        // Clear view cache
        $this->clearViewCache();
        $this->info('View cache berhasil dihapus!');

        // Clear route cache
        $this->clearRouteCache();
        $this->info('Route cache berhasil dihapus!');
    }

    /**
     * Clear view cache.
     */
    private function clearViewCache()
    {
        $viewCachePath = storage_path('framework/views');

        // Delete all files in the view cache directory
        File::deleteDirectory($viewCachePath);

        // Optionally, you can re-create the view cache directory
        // if you want it to exist even if it's empty.
        File::makeDirectory($viewCachePath);

        // Clear the compiled views
        Artisan::call('view:clear');
    }

    /**
     * Clear route cache.
     */
    private function clearRouteCache()
    {
        // Clear the route cache
        Artisan::call('route:clear');
    }
}
