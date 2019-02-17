<?php

namespace Blog;

use Zend\Router\Http\Literal;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'aliases' => [
            Model\PostRepositoryInterface::class => Model\ZendDbSqlRepository::class
        ],
        'factories' => [
            Model\PostRepository::class => InvokableFactory::class,
            Model\ZendDbSqlRepository::class => Factory\ZendDbSqlRepositoryFactory::class
        ]
    ],
    'controllers' => [
        'factories' => [
            Controller\ListController::class => Factory\ListControllerFactory::Class
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
                        'action' => 'index'
                    ]
                ]
            ]
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ]
    ]
];
