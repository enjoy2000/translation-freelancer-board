<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/23/14
 * Time: 11:30 AM
 */
return array(
    'mail' => array(
        'options' => array(
            'from' => 'papertask.dev@gmail.com',
            'contact' => 'contact@gmail.com',
        ),
        'transport' => array(
            'class' => 'Zend\Mail\Transport\Smtp',
            'options' => array(
                'class'=> '\Zend\Mail\Transport\SmtpOptions',
                'options' => array(
                    'name' => 'gmail.com',
                    'host' => 'smtp.gmail.com',
                    'connection_class' => 'plain',
                    'port' => 587,
                    'connection_config' => array(
                        'ssl' => 'tls',
                        'username' => 'papertask.dev@gmail.com',
                        'password' => '',  # add here
                    ),
                ),
            ),
        ),
    ),
);