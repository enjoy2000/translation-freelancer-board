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
use Zend\Validator;


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
        $validatorChain = new Validator\ValidatorChain();
        $validatorChain->attach(
            new Validator\EmailAddress());
        $username->setValidatorChain($validatorChain);
        $inputFilter->add($username);

        //password
        $password = new InputFilter\Input('password');
        $password->setRequired(true);
        $inputFilter->add($password);

        return $inputFilter;
    }

    public function validate($entityManager){
        $data = $this->getData();
        $email = $data['email'];
        $password = $data['password'];

        $user = $entityManager->getRepository('\User\Entity\User')->findOneBy(array('email' => $email));

        if($user && $user->checkPassword($password)){
            // Set logged data session to user session container
            $user->authenticate();
            return True;
        }else{
            return False;
        }
    }
}