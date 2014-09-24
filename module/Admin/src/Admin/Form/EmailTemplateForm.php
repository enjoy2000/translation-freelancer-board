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
use Admin\Entity\EmailTemplates;


class EmailTemplateForm extends Form {

    public function __construct(\Doctrine\ORM\EntityManager $entityManager){

        parent::__construct();
        $this->setAttribute('method', 'post');
        $this->getInputFilter();

        // Add select form element
        $templateTypeOptions = array();
        $types = $entityManager->getRepository('Admin\Entity\TemplateType')->findAll();
        foreach($types as $type){
            $templateTypeOptions[$type->getId()] = $type->getName();
        }

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'type',
            'attributes' => array(
                'class' => 'form-control',
                'required' => true,
            ),
             'options' => array(
                'label' => 'Template type?',
                'value_options' => $templateTypeOptions,
            )
         ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'language',
             'options' => array(
                'value_options' => array(
                    '0' => 'Female',
                    '1' => 'Male',
                ),
            ),
            'attributes' => array(
                'required' => true,
            ),
        ));
        $this->add(array(
            'name' => 'subject',
            'attributes' => array(
                'class' => 'form-control',
                'required' => true,
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Email subject',
            )
        ));
        $this->add(array(
            'name' => 'content',
            'attributes' => array(
                'class' => 'form-control summernote',
                'type'  => 'textarea',
                'placeholder' => 'Email body'
            ),
            'options' => array(
                'label' => 'Email body',
            )
        ));
        $csrf = new Element\Csrf('security');
        $this->add($csrf);

        $this->setInputFilter($this->createInputFilter());
    }


    protected  function createInputFilter()
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

        //language
        $language = new InputFilter\Input('content');
        $language->setRequired(true);
        $validatorChain = new Validator\ValidatorChain();
        $validatorChain->attach(
            new Validator\Between(array('min' => 0, 'max' => 1)));
        $language->setValidatorChain($validatorChain);
        $inputFilter->add($language);

        return $inputFilter;
    }

    public function save(\Doctrine\ORM\EntityManager $entityManager){
        $data = $this->getData();
        $type = $entityManager->find('Admin\Entity\TemplateType', $data['type']);
        $template = $entityManager->getRepository('Admin\Entity\EmailTemplates')->findOneBy(
            array(
                'type'=>$type,
                'language'=>$data['language'],
            )
        );

        // If template exist update content, if not create new one
        if($template){
            $template->setData($data);
            $template->setTemplateType($type);
            $entityManager->merge($template);
        }else{
            $data['createdTime'] = new \DateTime('now');
            $newTemplate = new EmailTemplates();
            $newTemplate->setData($data);
            $newTemplate->setTemplateType($type);
            $entityManager->persist($newTemplate);
        }
        $entityManager->flush();
    }
} 