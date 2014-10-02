<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonAdmin for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /admin/:controller/:action
            'admin' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/admin/[:controller[/[:action[/]]]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Dashboard',
                        'action'        => 'index',
                    ),
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                ),
            ),
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
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Dashboard' => 'Admin\Controller\DashboardController',
            'Admin\Controller\Email' => 'Admin\Controller\EmailController',
            'Admin\Controller\Freelancer' => 'Admin\Controller\FreelancerController',
            'Admin\Controller\Employer' => 'Admin\Controller\EmployerController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'admin/dashboard/index' => __DIR__ . '/../view/admin/dashboard/index.phtml',
            'admin/email/index' => __DIR__ . '/../view/admin/email/index.phtml',
            'admin/email/edit' => __DIR__ . '/../view/admin/email/edit.phtml',
            'admin/email/new' => __DIR__ . '/../view/admin/email/new.phtml',
            'admin/freelancer/finish-registration' => __DIR__ . '/../view/admin/freelancer/finish-registration.phtml',
            'admin/freelancer/update-info' => __DIR__ . '/../view/admin/freelancer/finish-registration.phtml',
        ),
        'layout' => 'layout/admin',
        'template_path_stack' => array(
            __DIR__ . '/../view',
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
            'admin_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Admin/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Admin\Entity' => 'admin_entities'
                )
            ))),
);
