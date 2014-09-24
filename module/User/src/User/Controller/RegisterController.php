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

    public function getEntityManager(){
        return $entityManager = $this
                                    ->getServiceLocator()
                                    ->get('Doctrine\ORM\EntityManager');
    }

    public function process($userType){
        $form = $this->getForm();
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid() && $request->getPost('agree') == 1){
                $translator = $this->getServiceLocator()->get('translator');
                $entityManager = $this->getEntityManager();
                $userExist = $entityManager
                    ->getRepository('User\Entity\User')
                    ->findOneBy(array(
                        'email'=>$request->getPost('email')
                    ));
                if($userExist){
                    $this->flashMessenger()->addErrorMessage($translator->translate('This email has been registered already.'));
                } else {
                    $form->save($entityManager, $userType);
                    return $this->redirect()->toUrl('/user/register/confirm?email=' . $request->getPost('email'));
                }

            }
        }
        return new ViewModel(array(
            "u" => $userType,
            "form"=> $form,
            )
        );
    }

    public function confirmAction(){
        $request = $this->getRequest();
        $email = $request->getQuery('email');
        $token = $request->getQuery('token');

        if(!$email){
            return $this->redirect()->toUrl('/user/login');
        }

        if($token){
            $entityManager = $this->getEntityManager();
            $user = $entityManager->getRepository('User\Entity\User')
                                    ->findOneBy(array(
                                        'email'=>$request->getPost('email'))
                                    );
            if($user && $user->activate($token)){
                $user->authenticate();
                // TODO: send welcome email
                return $this->redirect()->toUrl("/user/updateInfo");
            }
        }

        return new ViewModel(array(
            'email' => $email
            )
        );
    }
}