<?php

namespace Laratomics\Http\Controllers;

use Illuminate\Http\JsonResponse;

class NavigationController extends Controller
{
    /**
     * Get the navigation
     *
     */
    public function get()
    {
        return JsonResponse::create(
            [
                'data' => [
                    [
                        'name' => 'atoms',
                        'path' => 'atoms',
                        'items' => [
                            [
                                'name' => 'buttons',
                                'path' => 'atoms.buttons',
                                'items' => [
                                    [
                                        'name' => 'positive',
                                        'path' => 'atoms.buttons.positive',
                                        'items' => [
                                            [
                                                'name' => 'submit',
                                                'path' => 'atoms.buttons.positive.submit',
                                                'items' => []
                                            ]
                                        ]
                                    ]
                                ]
                            ],
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
                    [
                        'name' => 'landingpage',
                        'path' => 'landingpage',
                        'items' => []
                    ],
                    [
                        'name' => 'about',
                        'path' => 'about',
                        'items' => []
                    ]
                ]
            ]
        );


//        return JsonResponse::create([
//            'data' => [
//                'name' => 'atoms',
//                'path' => 'atoms',
//                'items' => [
//                    'name' => 'buttons',
//                    'path' => 'atoms.buttons',
//                    'items' => [
//                        'name' => 'positive',
//                        'path' => 'atoms.buttons.positive',
//                        'items' => [
//                            [
//                                'name' => 'submit',
//                                'path' => 'atoms.buttons.positive.submit',
//                                'items' => []
//                            ],
//                            [
//                                'name' => 'order',
//                                'path' => 'atoms.buttons.positive.order',
//                                'items' => []
//                            ]
//                        ],
//                        [
//                            'name' => 'negative',
//                            'path' => 'atoms.buttons.negative',
//                            'items' => [
//                                [
//                                    'name' => 'cancel',
//                                    'path' => 'atoms.buttons.negative.cancel',
//                                    'items' => []
//                                ],
//                                [
//                                    'name' => 'abort',
//                                    'path' => 'atoms.buttons.negative.abort',
//                                    'items' => []
//                                ]
//                            ],
//                        ]
//                    ],
//                    [
//                        'name' => 'headline1',
//                        'path' => 'atoms.headline1',
//                        'items' => []
//                    ]
//                ],
//                [
//                    'name' => 'pages',
//                    'path' => 'pages',
//                    'items' => [
//                        [
//                            'name' => 'about',
//                            'path' => 'pages.about',
//                            'items' => []
//                        ],
//                        [
//                            'name' => 'home',
//                            'path' => 'pages.home',
//                            'items' => []
//                        ],
//                    ],
//                    [
//                        'name' => 'landingpage',
//                        'path' => 'landingpage',
//                        'items' => [],
//                    ],
//                    [
//                        'name' => 'about',
//                        'path' => 'about',
//                        'items' => []
//                    ]
//                ]
//            ]
//        ]);
    }
}
