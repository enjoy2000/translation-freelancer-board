<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/19/14
 * Time: 9:37 AM
 */

namespace User\Controller;

use Zend\View\Model\ViewModel;

use Application\Controller\AbstractActionController;
use User\Form\LoginForm;

class LoginController extends AbstractActionController
{

    /**
     * @return LoginForm
     */
    protected function getForm(){
        $form = new LoginForm();
        return $form;
    }

    public function indexAction(){
        $form = $this->getForm();
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                if($form->validate($this->getEntityManager())){
                    return $this->redirect()->toUrl('/user/updateInfo');
                }else{
                    $translator = $this->getServiceLocator()->get('translator');
                    $this->flashMessenger()->addErrorMessage($translator->translate('Wrong username and password'));
                    return $this->redirect()->toUrl('/user/login');
                }
            }
        }
        return new ViewModel(array('form' => $form));
    }
}