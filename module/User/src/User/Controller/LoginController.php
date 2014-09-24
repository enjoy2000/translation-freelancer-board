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

    /**
     * @return LoginForm
     */
    protected function getForm(){
        $form = new LoginForm();
        return $form;
    }
    public function getEntityManager(){
        return $entityManager = $this
            ->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
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