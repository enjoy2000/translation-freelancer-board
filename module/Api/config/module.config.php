<?php

return array(
    'router' => array(
        'routes' => array(
            'api' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/api',
                    'constraints' => array(
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Api\Controller',
                        'controller' => 'Index',
                    ),
                ),
                'child_routes' => array(
                    'common' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/common/[:controller[/]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Api\Controller\Common',
                            ),
                        ),
                    ),
                    'user' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/user/[[:id[/]][:controller[/]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Api\Controller\User',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Api\Controller\Common\Country'         => 'Api\Controller\Common\CountryController',
            'Api\Controller\Index'                  => 'Api\Controller\IndexController',
            'Api\Controller\User\DesktopPublish'    => 'Api\Controller\User\DesktopPublishController',
            'Api\Controller\User\Info'              => 'Api\Controller\User\InfoController',
            'Api\Controller\User\Interpreting'      => 'Api\Controller\User\InterpretingController',
            'Api\Controller\User\PriceData'         => 'Api\Controller\User\PriceDataController',
            'Api\Controller\User\Resource'          => 'Api\Controller\User\ResourceController',
            'Api\Controller\User\Translation'       => 'Api\Controller\User\TranslationController',
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'countries' => array(
        'US' => 'United State',
        'VN' => 'Vietnam',
        'CN' => 'China',
        'EN' => 'England',
    )
);
