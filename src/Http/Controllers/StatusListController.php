<?php

namespace Oloid\Http\Controllers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class StatusListController extends Controller
{
    /**
     * Get a list with all Patterns grouped by their status.
     * @return JsonResponse
     */
    public function get () {
        $fs = new Filesystem();

        $files = $fs->allFiles(pattern_path());

        $statusList = [
            'todo' => [],
            'review' => [],
            'rejected' => [],
            'done' => []
        ];

        foreach ($files as $file) {
            if (ends_with($file, '.md')) {
                $patternName = dotted_path(str_before($file->getRelativePathname(), '.md'));
                $yaml = YamlFrontMatter::parseFile($file);
                $statusList[$yaml->matter('status')][] = $patternName;
            }
        }

        return JsonResponse::create([
            'data' => $statusList
        ]);
    }
}
