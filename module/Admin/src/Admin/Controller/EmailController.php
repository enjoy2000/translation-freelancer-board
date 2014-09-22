<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonAdmin for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Form\EmailTemplateForm;

class EmailController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    protected function getForm(){
        $form = new EmailTemplateForm($this);

        return $form;
    }

    public function createAction(){
        $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $request = $this->getRequest();
        $form = $this->getForm();
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                $form->save($entityManager);

                return $this->redirect()->toUrl('/admin/email');
            }
        }

        return new ViewModel(array('form' => $form));
    }
}
