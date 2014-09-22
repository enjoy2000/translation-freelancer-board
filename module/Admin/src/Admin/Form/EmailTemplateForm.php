<?php
/**
 * Created by PhpStorm.
 * User: hat.dao
 * Date: 9/22/2014
 * Time: 3:19 PM
 */

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\InputFilter;
use Zend\Validator;


class EmailTemplateForm extends Form {

    public function __construct(AbstractActionController $controller){
        $this->setAttribute('method', 'post');
        $this->getInputFilter();

        // Add select form element
        $templateTypeOptions = array();
        $entityManager = $controller->getServiceLocator()
                                    ->get('Doctrine\ORM\EntityManager');
        $types = $entityManager->getRepository('Admin\Entity\TemplateType')->findAll();
        foreach($types as $type){
            $templateTypeOptions[$type->getId()] = $type->getName();
        }

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'type',
            'attributes' =>  array(
                'id' => 'type',
                'class' => 'form-control',
                'required' => true,
                'type' => 'select',
                'options' => $templateTypeOptions,
            ),
        ));
        $this->add(array(
            'name' => 'subject',
            'attributes' => array(
                'class' => 'form-control',
                'required' => true,
                'type'  => 'text',
            ),
        ));
        $this->add(array(
            'name' => 'content',
            'attributes' => array(
                'class' => 'form-control textarea',
                'required' => true,
                'type'  => 'textarea',
            ),
        ));
        //$csrf = new Element\Csrf('security');
        //$this->add($csrf);

        $this->setInputFilter($this->createInputFilter());
    }


    public  function createInputFilter()
    {
        $inputFilter = new InputFilter\InputFilter();

        //type
        $type = new InputFilter\Input('type');
        $type->setRequired(true);
        $inputFilter->add($type);

        //subject
        $subject = new InputFilter\Input('subject');
        $subject->setRequired(true);
        $inputFilter->add($subject);

        //content
        $content = new InputFilter\Input('content');
        $content->setRequired(true);
        $inputFilter->add($content);

        return $inputFilter;
    }

    public function save(\Doctrine\ORM\EntityManager $entityManager){
        $data = $this->getData();
        $type = $entityManager->find('Admin\Entity\TemplateType', $data['type']);
        $template = $entityManager->getRepository('Admin\Entity\EmailTemplates')->findOneBy(array('type'=>$data['type']));
        $template->setData($data);
        $entityManager->merge($template);
        $entityManager->flush();
    }
} 