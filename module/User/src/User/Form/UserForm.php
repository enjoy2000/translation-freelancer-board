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

    /**
     * @param \Application\Controller\AbstractActionController $controller
     * @param $userType
     */
    public function save($controller, $userType){
        /**
         * @var $user \User\Entity\User
         */
        $user = $this->getObject();
        $entityManager = $controller->getEntityManager();
        $data = array();

        $data['createdTime'] = new \DateTime('now');
        $data['lastLogin'] = new \DateTime('now');

        $user->setData($data);
        $user->setGroupByName($userType, $entityManager);

        // Create password hash
        $user->encodePassword();
        $user->generateToken();
        $user->save($entityManager);

        $user->sendConfirmationEmail($controller);
    }
}