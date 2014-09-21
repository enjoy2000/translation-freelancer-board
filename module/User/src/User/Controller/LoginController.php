<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/19/14
 * Time: 9:37 AM
 */

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Form\LoginForm;
use \User\Entity\User;

class LoginController extends AbstractActionController
{

    protected function getForm(){
        $form = new LoginForm();
        $user = new User();
        $form->bind($user);

        return $form;
    }

    public function indexAction(){
        $form = $this->getForm();
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->validate($this, $request->getPost('email'), $request->getPost('password'))){
                $this->redirect()->toUrl('/user/updateInfo');
            }else{
                $translator = $this->getServiceLocator()->get('translator');
                $this->flashMessenger()->addErrorMessage($translator->translate('Wrong username and password'));
                $this->redirect()->toUrl('/user/login');
            }
        }
        return new ViewModel(array('form' => $form));
    }
}