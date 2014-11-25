<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link       for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'landding' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/landing/[:controller[/[:action[/]]]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Landing\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                ),
            ),
            'home' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Landing\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'freelancer' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/freelancer/',
                    'defaults' => array(
                        'controller' => 'Landing\Controller\Index',
                        'action'     => 'freelancer',
                    ),
                ),
            ),
            'languages' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/languages/',
                    'defaults' => array(
                        'controller' => 'Landing\Controller\Index',
                        'action'     => 'languages',
                    ),
                ),
            ),
            'contact' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/contact/',
                    'defaults' => array(
                        'controller' => 'Landing\Controller\Index',
                        'action'     => 'contact',
                    ),
                ),
            ),
            'order' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/order/',
                    'defaults' => array(
                        'controller' => 'Landing\Controller\Index',
                        'action'     => 'order',
                    ),
                ),
            ),
            'terms' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/terms/',
                    'defaults' => array(
                        'controller' => 'Landing\Controller\Index',
                        'action'     => 'terms',
                    ),
                ),
            ),
            'privacy' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/privacy/',
                    'defaults' => array(
                        'controller' => 'Landing\Controller\Index',
                        'action'     => 'privacy',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Landing\Controller\Index' => 'Landing\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'landing/index/index' => __DIR__ . '/../view/landing/index/index.phtml',
            'landing/index/freelancer' => __DIR__ . '/../view/landing/index/freelancer.phtml',
            'landing/index/languages' => __DIR__ . '/../view/landing/index/languages.phtml',
            'landing/index/order' => __DIR__ . '/../view/landing/index/order.phtml',
            'landing/index/contact' => __DIR__ . '/../view/landing/index/contact.phtml',
            'landing/index/terms' => __DIR__ . '/../view/landing/index/terms.phtml',
            'landing/index/privacy' => __DIR__ . '/../view/landing/index/privacy.phtml',
            'error/404'               => __DIR__ . '/../../Application/view/error/404.phtml',
            'error/index'             => __DIR__ . '/../../Application/view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),

    // Doctrine
    'doctrine' => array(
        'driver' => array(
            'landing_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Landing/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Landing\Entity' => 'landing_entities'
                )
            ))),
);