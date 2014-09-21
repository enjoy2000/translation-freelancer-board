<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 9/21/2014
 * Time: 6:14 AM
 */

namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter;
use Zend\Session\Container;


class LoginForm extends Form
{

    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct();
        $this->setAttribute('method', 'post');
        $this->getInputFilter();
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Email',
                'required' => true,
                'type'  => 'email',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Password',
                'required' => true,
                'type'  => 'password',
            ),
        ));

        // set input filter
        $this->setInputFilter($this->createInputFilter());
    }

    public function createInputFilter()
    {
        $inputFilter = new InputFilter\InputFilter();

        //username
        $username = new InputFilter\Input('email');
        $username->setRequired(true);
        $inputFilter->add($username);

        //password
        $password = new InputFilter\Input('password');
        $password->setRequired(true);
        $inputFilter->add($password);

        return $inputFilter;
    }

    public function validate($controller, $email, $password){
        $user = $this->getObject();

        $entityManager = $controller
            ->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');

        $userExist = $entityManager->getRepository('\User\Entity\User')->findOneBy(array('email' => $email));


        $passClass = new \User\Model\Password();
        if($userExist && $passClass->validate_password($password, $userExist->getPasswordHash())){
            // Set logged data session to user session container
            $sessionContainer = new Container('user');
            $sessionContainer->user_id = $userExist->getId();
            return True;
        }else{
            return False;
        }
    }
}