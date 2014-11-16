<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonAdmin for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\View\Model\ViewModel;

use Application\Controller\AbstractActionController;

class StaffController extends AbstractActionController
{
    protected $requiredLogin = true;

    public function indexAction(){
        return new ViewModel();
    }

    public function viewAction(){
        $entityManager = $this->getEntityManager();
        $id = $this->getRequest()->getQuery('id');
        $user = $entityManager->find('\User\Entity\User', (int)$id);
        if($entityManager->find('\User\Entity\Staff', $user->getStaff())){
            return new ViewModel([
                "user" => $user->getData()
            ]);
        }
    }

    public function newAction(){
        return new ViewModel(array(
            "user" => '',
        ));
    }

    public function editProfileAction(){
        $entityManager = $this->getEntityManager();
        $id = $this->getRequest()->getQuery('id');
        $user = $entityManager->find('\User\Entity\User', (int)$id);
        if($entityManager->find('\User\Entity\Staff', $user->getStaff())){
            return new ViewModel([
                "user" => $user->getData()
            ]);
        }
    }

    public function editPaymentInfo(){
        $entityManager = $this->getEntityManager();
        $id = $this->getRequest()->getQuery('id');
        $user = $entityManager->find('\User\Entity\User', (int)$id);
        if($entityManager->find('\User\Entity\Staff', $user->getStaff())){
            return new ViewModel([
                "user" => $user->getData()
            ]);
        }
    }
}
