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
use Zend\View\Model\JsonModel;

use Application\Controller\AbstractActionController;
use User\Entity\User;
use User\Model\UserSession;
use User\Form\ForgotPasswordForm;
use User\Form\ResetForm;

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
        $translator = $this->getTranslator();
        $userSession = new UserSession();
        $form = $this->getForm();
        $request = $this->getRequest();
        if(!$userSession->isLoggedIn()){
            if($request->isPost()){
                $form->setData($request->getPost());
                if($form->isValid()){
                    $form->process($this);

                    // create message send email success
                    $this->flashMessenger()->addSuccessMessage($translator->translate('Please check your email.'));
                }
            }
        }

        return new ViewModel(array('form' => $form));
    }

    public function resetAction(){
        $request = $this->getRequest();
        $form = new ResetForm();
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                $form->reset($this);
            }
        }

        return new ViewModel(array('form' => $form));
    }

    public function resetpasswordAction(){
        $request = $this->getRequest();
        if($request->isPost()){
            $user = $this->getUserById((int)$request->getPost('user_id'));
            $user->setData(['password' => $request->getPost('password')]);
            $user->save($this->getEntityManager());

            return new JsonModel(['success' => true]);
        }
    }
}
