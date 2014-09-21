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
use User\Form\UserForm;
use \User\Entity\User;

class RegisterController extends AbstractActionController
{

    public function indexAction(){
        return new ViewModel();
    }

    public function employerAction(){
        return $this->process('employer');
    }

    public function freelancerAction(){
        return $this->process('freelancer');
    }

    protected function getForm(){
        $form = new UserForm();
        $user = new User();
        $form->bind($user);
        return $form;
    }

    public function process($userType){
        $form = $this->getForm();
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid() && $request->getPost('agree') == 1){
                $form->save($this, $userType);

                return $this->redirect()->toUrl('/user/login');
            }
        }
        return new ViewModel(array(
            "u" => $userType,
            "form"=> $form,
            )
        );
    }
}