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
use Zend\Json\Json;

class EmailController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    protected function getForm(){
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $form = new EmailTemplateForm($entityManager);

        return $form;
    }

    public function createAction(){
        //$this->layout('layout/admin');
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

    public function loadTemplateAction(){
        $request = $this->getRequest();
        if($request->isXmlHttpRequest()){
            $json = array();
            $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
            $type = $entityManager->find('Admin\Entity\TemplateType', $request->getPost('type'));
            $template = $entityManager->getRepository('Admin\Entity\EmailTemplates')->findOneBy(
                array(
                    'type' => $type,
                    'language' => (int)$request->getPost('language'),
                )
            );

            // Check template exist or not, if exist return subject and content of templtae
            if($template){
                $json['result'] = true;
                $json['subject'] = $template->getSubject();
                $json['content'] = $template->getContent();
            }else{
                $json['result'] = false;
            }

            // Set content type to json
            $this->getResponse()->getHeaders()->addHeaders(array('Content-Type'=>'application/json;charset=UTF-8'));
            return $this->getResponse()->setContent(Json::encode($json));
        }

        return $this->redirect()->toRoute('email');
    }

    public function newAction(){
        $form = new TemplateTypeForm();
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
                $form->save($entityManager);
                return $this->redirect()->toRoute('email');
            }
        }
        return new ViewModel(array('form' => $form));
    }
}
