<?php


namespace Laratomics\Services;

use Illuminate\Support\Facades\Storage;

class NavbarService
{
    public function sections()
    {
        $directories = collect(Storage::disk('patterns')
            ->directories());

        $sections = $directories->filter(function ($dir) {
            return !empty(Storage::disk('patterns')
                    ->files($dir))
                && !starts_with($dir, ['.git', 'assets']);
        });

        return $sections;
    }

    public function slug($pattern)
    {
        return str_replace('/', '.', $pattern);
    }

    public function patterns($section)
    {
        $patterns = Storage::disk('patterns')
            ->files($section, true);

        $filtered = [];
        foreach ($patterns as $pattern) {
            if (ends_with($pattern, '.blade.php')) {
                $filtered[] = str_before($pattern, '.blade.php');
            }
        }

        return $filtered;
    }
}