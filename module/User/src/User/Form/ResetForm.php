<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/24/14
 * Time: 9:40 PM
 */

namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter;
use Zend\Validator;

class ResetForm  extends Form{

    public function __construct(){
        parent::__construct();
        $this->setAttribute('method', 'post');
        $this->getInputFilter();
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Password',
                'required' => true,
                'type'  => 'password',
            ),
        ));
        $this->add(array(
            'name' => 'confirmation',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Confirm your password',
                'required' => true,
                'type'  => 'password',
            ),
            'validators' => array(
                array(
                    'name' => 'Identical',
                    'options' => array(
                        'token' => 'password', // name of first password field
                    ),
                ),
            ),
        ));

        $this->setInputFilter($this->createInputFilter());
    }

    protected function createInputFilter(){
        $inputFilter = new InputFilter\InputFilter();

        // password
        $password = new InputFilter\Input('password');
        $password->setRequired(true);
        // Generate password validator chain
        $validatorPasswordChain = new Validator\ValidatorChain();
        $validatorPasswordChain->attach(
            new Validator\StringLength(array('min' => 6)));
        $password->setValidatorChain($validatorPasswordChain);
        $inputFilter->add($password);

        // confirmation
        $confirmation = new InputFilter\Input('confirmation');
        $confirmation->setRequired(true);
        $confirmation->setValidatorChain($validatorPasswordChain);
        $inputFilter->add($confirmation);

        return $inputFilter;
    }

    public function reset($controller){
        $data = $this->getData();
        $token = $data['token'];
        if($data['password'] == $data['confirmation']){
            $entityManager = $controller->getEntityManager();
            $user = $controller->getUser(array('token' => $token));
            if($user){
                $user->reset($token, $data['password'], $entityManager);
            }
            return false;
        }
    }

} 