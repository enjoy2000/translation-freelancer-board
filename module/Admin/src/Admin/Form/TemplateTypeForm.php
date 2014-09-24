<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/23/14
 * Time: 9:13 AM
 */

namespace Admin\Form;

use Admin\Entity\TemplateType;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter;
use Zend\Validator;

class TemplateTypeForm extends Form {

    public function __construct(){
        parent::__construct();
        $this->setAttribute('method', 'post');
        $this->getInputFilter();

        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'class' => 'form-control',
                'required' => true,
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Name',
            )
        ));

        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'class' => 'form-control',
                'required' => true,
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Description',
            )
        ));

        $csrf = new Element\Csrf('security');
        $this->add($csrf);

        $this->setInputFilter($this->createInputFilter());
    }

    protected function createInputFilter(){
        $inputFilter = new InputFilter\InputFilter();

        // name
        $name = new InputFilter\Input('name');
        $name->setRequired(true);
        $inputFilter->add($name);

        // description
        $description = new InputFilter\Input('description');
        $description->setRequired(true);
        $inputFilter->add($description);

        return $inputFilter;
    }

    public function save(\Doctrine\ORM\EntityManager $entityManager){
        $data = $this->getData();
        $data['createdTime'] = new \DateTime('now');
        $templateType = new TemplateType();
        $templateType->setData($data);
        $entityManager->persist($templateType);
        $entityManager->flush();
        return $this;
    }
} 