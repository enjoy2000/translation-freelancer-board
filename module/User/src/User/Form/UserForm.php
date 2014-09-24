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


class UserForm extends Form
{

    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('freelancer');
        $this->setAttribute('method', 'post');
        $this->getInputFilter();
        $this->add(array(
            'name' => 'lastName',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Last Name',
                'required' => true,
                'type'  => 'text',
            ),
        ));
        $this->add(array(
            'name' => 'firstName',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'First Name',
                'required' => true,
                'type'  => 'text',
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Email',
                'type'  => 'email',
                'required' => true,
            ),
        ));
        $this->add(array(
            'name' => 'phone',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Phone',
                'required' => true,
                'type'  => 'text',
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
    }

    public function save($entityManager, $userType){
        /**
         * @var $user \User\Entity\User
         */
        $user = $this->getObject();
        $data = array();

        $data['createdTime'] = new \DateTime('now', new \DateTimeZone('America/New_York'));
        $data['lastLogin'] = new \DateTime('now', new \DateTimeZone('America/New_York'));

        $user->setData($data);

        if($userType == 'freelancer'){
            $user->setGroup($entityManager->getReference('\User\Entity\Group', 1));
        }else if($userType == 'employer'){
            $user->setGroup($entityManager->getReference('\User\Entity\Group', 2));
        }

        // Create password hash
        $user->encodePassword();
        $user->generateToken();

        $entityManager->persist($user);
        $entityManager->flush();

        $user->sendConfirmationEmail($entityManager);
    }
}