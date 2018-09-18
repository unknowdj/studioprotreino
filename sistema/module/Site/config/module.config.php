<?php

namespace Site;

use MainClass\MainController;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'module' => MainController::MODULE_SITE,
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'service' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/servico',
                    'defaults' => [
                        'module' => MainController::MODULE_SITE,
                        'controller' => Controller\IndexController::class,
                        'action' => 'service',
                    ],
                ],
            ],
            'how-it-works' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/como-funciona',
                    'defaults' => [
                        'module' => MainController::MODULE_SITE,
                        'controller' => Controller\IndexController::class,
                        'action' => 'howItWorks',
                    ],
                ],
            ],
            'plans' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/planos',
                    'defaults' => [
                        'module' => MainController::MODULE_SITE,
                        'controller' => Controller\IndexController::class,
                        'action' => 'plans',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'purchase' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/comprar/:planId',
                            'constraints' => [
                                'planId' => '[0-9]*'
                            ],
                            'defaults' => [
                                'action' => 'purchase'
                            ],
                        ],
                    ],
                    'success' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/success',

                            'defaults' => [
                                'action' => 'success'
                            ],
                        ],
                    ],
                ]
            ],
            'about-us' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/sobre-nos',
                    'defaults' => [
                        'module' => MainController::MODULE_SITE,
                        'controller' => Controller\IndexController::class,
                        'action' => 'aboutUs',
                    ],
                ],
            ],
            'contact' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/contato',
                    'defaults' => [
                        'module' => MainController::MODULE_SITE,
                        'controller' => Controller\IndexController::class,
                        'action' => 'contact',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'send' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/send',
                            'defaults' => [
                                'action' => 'send'
                            ],
                        ],
                    ],
                ]
            ],
            'auth' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/auth',
                    'defaults' => [
                        'module' => MainController::MODULE_SITE,
                        'controller' => Controller\LoginController::class,
                        'action' => 'login',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'login' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/entrar',
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
            'accompaniment' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/acompanhamento',
                    'defaults' => [
                        'module' => MainController::MODULE_SITE,
                        'controller' => Controller\AccompanimentController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'signature' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/acompanhamento[/:signatureId]',
                            'defaults' => [
                                'controller' => Controller\AccompanimentController::class,
                                'action' => 'index'
                            ],
                        ],
                    ],
                    'my-trainings' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/meus-treinos',
                            'defaults' => [
                                'controller' => Controller\AccompanimentController::class,
                                'action' => 'my-trainings'
                            ],
                        ],
                    ],
                    'my-account' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/minha-conta',
                            'defaults' => [
                                'controller' => Controller\MyAccountController::class,
                                'action' => 'index'
                            ],
                        ],
                    ],
                    'chart' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/grafico',
                            'defaults' => [
                                'action' => 'chart'
                            ],
                        ],
                    ],
                    'complementary-material' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/material-complementar',
                            'defaults' => [
                                'action' => 'complementaryMaterial'
                            ],
                        ],
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
    'service_manager' => array(
        'factories' => array(
            'Cache' => function ($sm) {
                $config = include __DIR__ . '/../../../config/application.config.php';
                $cache = Zend\Cache\StorageFactory::factory(array(
                    'adapter' => array(
                        'name' => $config['cache']['adapter'],
                        'options' => array(
                            'ttl' => 8600,
                            'cacheDir' => __DIR__ . '/../../../data/cache'
                        )
                    ),
                    'plugins' => array(
                        'exception_handler' => array(
                            'throw_exceptions' => false
                        ),
                        'Serializer'
                    )
                ));
                return $cache;
            }
        )
    ),
    'view_manager' => [
        'display_not_found_reason' => (getenv('APPLICATION_ENV') == 'development'),
        'display_exceptions' => (getenv('APPLICATION_ENV') == 'development'),
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'site/index/index' => __DIR__ . '/../view/site/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy'
        ],
    ],
];
