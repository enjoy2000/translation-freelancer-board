<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link       for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User\Controller;

use Zend\View\Model\ViewModel;

use Application\Controller\AbstractActionController;
use User\Entity\User;
use User\Model\UserSession;
use User\Form\ForgotPasswordForm;

class ForgotPasswordController extends AbstractActionController
{
    /**
     * @return ForgotPasswordForm
     */
    protected function getForm(){
        $form = new ForgotPasswordForm();
        return $form;
    }
    public function indexAction(){
        $userSession = new UserSession();
        $form = $this->getForm();
        $request = $this->getRequest();
        if(!$userSession->isLoggedIn()){
            if($request->isPost()){
                if($form->isValid()){
                    $form->process($this);
                }
            }
        }

        return new ViewModel(array('form' => $form));
    }
}
