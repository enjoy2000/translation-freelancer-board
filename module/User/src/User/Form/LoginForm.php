<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 9/21/2014
 * Time: 6:14 AM
 */

namespace User\Form;

use Zend\Form\Element;
use Zend\InputFilter;
use Zend\Validator;

use Common\Form;


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

    /**
     * @param \Application\Controller\AbstractActionController $controller
     * @return bool
     */
    public function validate($controller){
        $entityManager = $controller->getEntityManager();
        $translator = $controller->getTranslator();

        $data = $this->getData();
        $email = $data['email'];
        $password = $data['password'];

        $user = $entityManager->getRepository('\User\Entity\User')->findOneBy(array('email' => $email));

        if($user && $user->checkPassword($password)){
            if($user->isActivated()){
                $user->authenticate();
                return true;
            } else {
                $msg = $translator->translate('You must confirm your email to be able to login');
                $controller->flashMessenger()->addErrorMessage($msg);
                $controller->redirect()->toUrl("/user/register/confirm?email=" . $email);
                return false;
            }
        } else {
            $this->addNonElementMessage('danger', $translator->translate('Wrong username or password'));
        }
        return False;
    }
}