<?php

namespace Admin;

use MainClass\MainController;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'admin' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/admin',
                    'defaults' => [
                        'module' => MainController::MODULE_ADMIN,
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'auth' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/auth',
                            'defaults' => [
                                'controller' => Controller\AuthController::class,
                                'action' => 'login',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'login' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/login',
                                    'defaults' => [
                                        'action' => 'login'
                                    ],
                                ],
                            ],
                            'logout' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/logout',
                                    'defaults' => [
                                        'action' => 'logout'
                                    ],
                                ],
                            ],
                        ]
                    ],
                    'plan' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/plan',
                            'defaults' => [
                                'controller' => Controller\PlanController::class,
                                'action' => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'add' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/add',
                                    'defaults' => [
                                        'action' => 'add'
                                    ],
                                ],
                            ],
                            'edit' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/edit/[:id]',
                                    'constraints' => [
                                        'id' => '[0-9]*'
                                    ],
                                    'defaults' => [
                                        'action' => 'edit'
                                    ],
                                ],
                            ],
                        ]
                    ],
                    'customer' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/customer',
                            'defaults' => [
                                'controller' => Controller\CustomerController::class,
                                'action' => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'add' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/add',
                                    'defaults' => [
                                        'action' => 'add'
                                    ],
                                ],
                            ],
                            'edit' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/edit/[:id]',
                                    'constraints' => [
                                        'id' => '[0-9]*'
                                    ],
                                    'defaults' => [
                                        'action' => 'edit'
                                    ],
                                ],
                            ],
                        ]
                    ],
                    'movie' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/movie',
                            'defaults' => [
                                'controller' => Controller\MovieController::class,
                                'action' => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'add' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/add',
                                    'defaults' => [
                                        'action' => 'add'
                                    ],
                                ],
                            ],
                            'edit' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/edit/[:id]',
                                    'constraints' => [
                                        'id' => '[0-9]*'
                                    ],
                                    'defaults' => [
                                        'action' => 'edit'
                                    ],
                                ],
                            ],
                        ]
                    ],
                    'signature' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/signature',
                            'defaults' => [
                                'controller' => Controller\SignatureController::class,
                                'action' => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'list' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/list[/:customerId][/:modal]',
                                    'constraints' => [
                                        'customerId' => '[0-9]*',
                                        'modal' => '[0-1]*'
                                    ],
                                    'defaults' => [
                                        'action' => 'index',
                                    ],
                                ],
                            ],
                            'add' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/add[/:customerId][/:modal]',
                                    'constraints' => [
                                        'customerId' => '[0-9]*',
                                        'modal' => '[0-1]*'
                                    ],
                                    'defaults' => [
                                        'action' => 'add'
                                    ],
                                ],
                            ],
                            'edit' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/edit[/:id][/:modal]',
                                    'constraints' => [
                                        'id' => '[0-9]*',
                                        'modal' => '[0-1]*'
                                    ],
                                    'defaults' => [
                                        'action' => 'edit'
                                    ],
                                ],
                            ],
                        ]
                    ],
                    'physical-evaluation' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/physical-evaluation',
                            'defaults' => [
                                'controller' => Controller\PhysicalEvaluationController::class,
                                'action' => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'list' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/list[/:signatureId][/:modal]',
                                    'constraints' => [
                                        'signatureId' => '[0-9]*',
                                        'modal' => '[0-1]*'
                                    ],
                                    'defaults' => [
                                        'action' => 'index',
                                    ],
                                ],
                            ],
                            'add' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/add[/:signatureId][/:modal]',
                                    'constraints' => [
                                        'signatureId' => '[0-9]*',
                                        'modal' => '[0-1]*'
                                    ],
                                    'defaults' => [
                                        'action' => 'add'
                                    ],
                                ],
                            ],
                            'edit' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/edit[/:id[/:modal]]',
                                    'constraints' => [
                                        'id' => '[0-9]*'
                                    ],
                                    'defaults' => [
                                        'action' => 'edit'
                                    ],
                                ],
                            ],
                        ]
                    ],
                    'training' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/training',
                            'defaults' => [
                                'controller' => Controller\TrainingController::class,
                                'action' => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'add' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/add[/:id]',
                                    'constraints' => [
                                        'customerId' => '[0-9]*'
                                    ],
                                    'defaults' => [
                                        'action' => 'add'
                                    ],
                                ],
                            ],
                            'edit' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/edit[/:id]',
                                    'constraints' => [
                                        'id' => '[0-9]*'
                                    ],
                                    'defaults' => [
                                        'action' => 'edit'
                                    ],
                                ],
                            ],
                        ]
                    ],
                ]
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            #Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => (getenv('APPLICATION_ENV') == 'development'),
        'display_exceptions' => (getenv('APPLICATION_ENV') == 'development'),
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../../Site/view/layout/layout.phtml',
            'layout/modal' => __DIR__ . '/../../Site/view/layout/modal.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'translator' => [
        'locale' => 'pt_BR',
        'translation_file_patterns' => [
            [
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../../Language',
                'pattern' => '%s.mo'
            ]
        ]
    ],
    'view_helpers' => [
        'invokables' => [
            'translate' => \Zend\I18n\View\Helper\Translate::class
        ]
    ]
];
