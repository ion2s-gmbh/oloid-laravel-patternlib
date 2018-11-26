<?php

namespace Laratomics\Http\Controllers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class NavigationController extends Controller
{
    /**
     * Get the navigation
     *
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        return JsonResponse::create([
            'data' => $this->getNavi(pattern_path())
        ]);
    }

    /**
     * Recursive method to build the navigation json structure.
     *
     * @param $path
     * @return array
     */
    private function getNavi($path): array
    {
        $data = [];
        $fs = new Filesystem();

        /*
         * If the given path does not exist, we return immediately
         */
        if (!$fs->exists($path)) {
            return $data;
        }

        /*
         * Check every nested directory for files.
         */
        $directories = $fs->directories($path);
        foreach ($directories as $directory) {
            $data[] = [
                'name' => str_after($directory, $path . '/'),
                'path' => dotted_path(str_after($directory, pattern_path() . '/')),
                'items' => $this->getNavi($directory)
            ];
        }

        /*
         * Process files, that are contained in the current path.
         */
        $files = $fs->files($path);
        foreach ($files as $pattern) {
            if (ends_with($pattern, '.blade.php')) {
                $name = str_after(str_before($pattern, '.blade.php'), $path . '/');
                $patternPath = dotted_path(str_after(str_before($pattern, '.blade.php'), pattern_path() . '/'));
                $data[] = [
                    'name' => $name,
                    'path' => $patternPath,
                    'items' => []
                ];
            }
        }

        return $data;
    }
}
