<?php

namespace Laratomics\Http\Controllers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\JsonResponse;

class NavigationController extends Controller
{
    private function getNavi($path)
    {
        $data = [];
        $fs = new Filesystem();
        $directories = $fs->directories($path);

        foreach ($directories as $directory) {
            $data[] = [
                'name' => str_after($directory, $path . '/'),
                'path' => str_replace('/', '.', str_after($directory, config('workshop.patternPath') . '/')),
                'items' => $this->getNavi($directory)
            ];
        }

        $files = $fs->files($path);

        foreach ($files as $pattern) {
            if (ends_with($pattern, '.blade.php')) {
                $name = str_after(str_before($pattern, '.blade.php'), $path . '/');
                $patternPath = str_replace('/', '.', str_after(str_before($pattern, '.blade.php'), config('workshop.patternPath') . '/'));
                $data[] = [
                    'name' => $name,
                    'path' => $patternPath,
                    'items' => []
                ];
            }
        }

        return $data;
    }

    /**
     * Get the navigation
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        return JsonResponse::create([
            'data' => $this->getNavi(config('workshop.patternPath'))
        ]);

        return JsonResponse::create(
            [
                'data' => [
                    [
                        'name' => 'atoms',
                        'path' => 'atoms',
                        'items' => [
//                            [
//                                'name' => 'buttons',
//                                'path' => 'atoms.buttons',
//                                'items' => [
//                                    [
//                                        'name' => 'positive',
//                                        'path' => 'atoms.buttons.positive',
//                                        'items' => [
//                                            [
//                                                'name' => 'submit',
//                                                'path' => 'atoms.buttons.positive.submit',
//                                                'items' => []
//                                            ]
//                                        ]
//                                    ]
//                                ]
//                            ],
                            [
                                'name' => 'headlines',
                                'path' => 'atoms.headlines',
                                'items' => [
                                    [
                                        'name' => 'headline1',
                                        'path' => 'atoms.headlines.headline1',
                                        'items' => []
                                    ]
                                ]
                            ],
                        ]
                    ],
//                    [
//                        'name' => 'landingpage',
//                        'path' => 'landingpage',
//                        'items' => []
//                    ],
//                    [
//                        'name' => 'about',
//                        'path' => 'about',
//                        'items' => []
//                    ]
                ]
            ]
        );
    }
}
