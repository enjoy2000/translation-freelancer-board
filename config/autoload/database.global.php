<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/22/14
 * Time: 7:26 AM
 */

return array(
    'db' => array(
        'driver'    => 'PdoMysql',
        'hostname'  => 'localhost',
        'database'  => 'papertask',
        'username'  => 'root',
        'password'  => '',
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
);