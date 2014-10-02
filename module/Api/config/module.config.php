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
                    'user_child' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/user/:user_id/:controller/:id[/]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'user_id' => '[0-9]*',
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
            'Api\Controller\Common\Company' => 'Api\Controller\Common\CompanyController',
            'Api\Controller\Common\Country' => 'Api\Controller\Common\CountryController',
            'Api\Controller\Index' => 'Api\Controller\IndexController',
            'Api\Controller\User\DesktopPrice' => 'Api\Controller\User\DesktopPriceController',
            'Api\Controller\User\Employer' => 'Api\Controller\User\EmployerController',
            'Api\Controller\User\EmployerData' => 'Api\Controller\User\EmployerDataController',
            'Api\Controller\User\Freelancer' => 'Api\Controller\User\FreelancerController',
            'Api\Controller\User\FreelancerData' => 'Api\Controller\User\FreelancerDataController',
            'Api\Controller\User\Index' => 'Api\Controller\User\IndexController',
            'Api\Controller\User\InterpretingPrice' => 'Api\Controller\User\InterpretingPriceController',
            'Api\Controller\User\PriceData' => 'Api\Controller\User\PriceDataController',
            'Api\Controller\User\Resource' => 'Api\Controller\User\ResourceController',
            'Api\Controller\User\TranslationPrice' => 'Api\Controller\User\TranslationPriceController',
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
