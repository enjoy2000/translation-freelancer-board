<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/21/14
 * Time: 9:30 PM
 */

namespace User\Model;

use Zend\Session\Container;

class UserSession {

    protected $user_id;

    public function __construct(){
        $sessionUser = new Container('user');
        $this->user_id = $sessionUser->user_id;
    }

    public function isLoggedIn(){
        return ($this->user_id > 0);
    }

    public function getCurrentUser($entityManager){
        $user = $entityManager->getRepository('User\Entity\User')->findOneBy(array('id'=>$this->user_id));
        return $user;
    }
} 