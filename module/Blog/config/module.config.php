<?php

namespace Blog;

use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'service_manager' => [
        'aliases' => [
            Model\PostRepositoryInterface::class => Model\ZendDbSqlRepository::class,
            Model\PostCommandInterface::class => Model\ZendDbSqlCommand::class
        ],
        'factories' => [
            Model\PostRepository::class => InvokableFactory::class,
            Model\ZendDbSqlRepository::class => Factory\ZendDbSqlRepositoryFactory::class,
            Model\PostCommand::class => InvokableFactory::class,
            Model\ZendDbSqlCommand::class => Factory\ZendDbSqlCommandFactory::class,
        ]
    ],
    'controllers' => [
        'factories' => [
            Controller\ListController::class => Factory\ListControllerFactory::Class,
            Controller\WriteController::class => Factory\WriteControllerFactory::class,
            Controller\DeleteController::class => Factory\DeleteControllerFactory::class
        ]
    ],
    //Esta línea abre la configuración 
    //para el RouteManager.
    'router' => [
        //Configuración abierta para 
        //todas las rutas posibles.
        'routes' => [
            //Definir la nueva ruta llamada "blog"
            'blog' => [
                //Definir la ruta de tipo "liteal"
                'type' => Literal::class,
                //Configurar la ruta en sí
                'options' => [
                    'route' => '/blog',
                    //Defina el controlador y la acción predeterminados 
                    //que se llamarán cuando esta ruta coincida
                    'defaults' => [
                        'controller' => Controller\ListController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'detail' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/:id',
                            'defaults' => [
                                'action' => 'detail',
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*',
                            ],
                        ],
                    ],
                    'add' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/add',
                            'defaults' => [
                                'controller' => Controller\WriteController::class,
                                'action' => 'add',
                            ],
                        ],
                    ],
                    'edit' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/edit/:id',
                            'defaults' => [
                                'controller' => Controller\WriteController::class,
                                'action' => 'edit',
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*',
                            ]
                        ]
                    ],
                    'delete' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/delete/:id',
                            'defaults' => [
                                'controller' => Controller\DeleteController::class,
                                'action' => 'delete',
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*',
                            ],
                        ],
                    ]
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ]
    ]
];
