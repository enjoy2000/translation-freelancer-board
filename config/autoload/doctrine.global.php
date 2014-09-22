<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/18/14
 * Time: 11:59 PM
 */

$dbParams = array(
    'hostname' => 'localhost',
    'port'     => 3006,
    'username' => 'root',
    'password' => '',
    'database' => 'papertask',
);

return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'params' => array(
                    'host' => $dbParams['hostname'],
                    'port' => $dbParams['port'],
                    'user' => $dbParams['username'],
                    'password' => $dbParams['password'],
                    'unix_socket' => '/tmp/mysql.sock',
                    'dbname' => $dbParams['database'],
                    'driverOptions' => array(
                        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                    ),
                )
            )
        )
    )
);