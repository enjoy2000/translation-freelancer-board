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

class RegisterController extends AbstractActionController
{

    public function indexAction(){
        return new ViewModel();
    }

    public function employerAction(){
        return new ViewModel(array("u"=>'employer'));
    }

    public function freelancerAction(){
        return new ViewModel(array("u"=>'freelancer'));
    }

    public function postAction(){
        if($this->getRequest()->getPost('agree') == 1){
            $data = $this->getRequest()->getPost();

            $objectManager = $this
                ->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');

            /*
             * Validate
             */
            $translator = $this->getServiceLocator()->get('translator');
            $errors = array();
            $user = $objectManager->getRepository('User\Entity\User')->findOneBy(array('email'=>$data['email']));
            if($user){
                $errors = array_push($errors, $translator->translate('Email exist'));
            }

            if(empty($errors)){
                $data['createdTime'] = new \DateTime('now', new \DateTimeZone('America/New_York'));
                $data['lastLogin'] = new \DateTime('now', new \DateTimeZone('America/New_York'));

                $user = new \User\Entity\User();

                // Check register group
                if($this->getRequest()->getPost('u') == 'freelancer'){
                    $user->setGroupId($objectManager->getReference('\User\Entity\Group', 1));
                }else if($this->getRequest()->getPost('u') == 'employer'){
                    $user->setGroupId($objectManager->getReference('\User\Entity\Group', 2));
                }

                $user->setData($data);

                $objectManager->persist($user);

                $objectManager->flush();
            }else{
                die('error');
            }
        }
        return $this->redirect()->toUrl('/user/register');
    }
}