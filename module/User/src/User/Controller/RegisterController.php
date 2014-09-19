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
            if($this->getRequest()->get('u') == 'freelancer'){
                $data['group_id'] = 1;
            }else if($this->getRequest()->get('u') == 'employer'){
                $data['group_id'] = 2;
            }
            $data['created_time'] = date('Y-m-d H:i:s');

            $objectManage = $this
                ->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');

            $user = new \User\Entity\User();
            $user->setData($data);

            $objectManage->persist($user);
            $objectManage->flush();
        }

        return $this->redirect()->toRoute('user');
    }
}