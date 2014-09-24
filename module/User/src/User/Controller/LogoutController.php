<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link       for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User\Controller;

use Zend\Session\Container;

use Application\Controller\AbstractActionController;

class LogoutController extends AbstractActionController
{
    public function indexAction(){
        $userSession = new Container('user');
        $userSession->user_id = Flase;

        return $this->redirect()->toRoute('home');
    }
}
