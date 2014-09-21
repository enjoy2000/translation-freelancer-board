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


class ForgotPasswordForm extends Form
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
                'placeholder' => 'Please enter your registered email',
                'required' => true,
                'type'  => 'email',
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

        return $inputFilter;
    }
}