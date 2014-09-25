<?php
/**
 * Created by PhpStorm.
 * User: eastagile
 * Date: 9/25/14
 * Time: 8:11 PM
 */

namespace Common;

use Zend\Form\Form as ZendForm;
use Zend\Form\Element;
use Zend\InputFilter;
use Zend\Validator;


class Form extends ZendForm{

    protected $nonElementMessages = array(
        'danger' => array(),
        'info' => array(),
        'warning' => array(),
    );

    protected $hasNonElementMessages = false;

    public function addNonElementMessage($scope, $message){
        if(!isset($this->nonElementMessages[$scope])){
            $this->nonElementMessages[$scope] = array();
        }
        $this->nonElementMessages[$scope][] = $message;
        $this->hasNonElementMessages = true;
    }

    public function getNonElementMessages(){
        return $this->nonElementMessages;
    }

    public function isHasNonElementMessages(){
        return $this->hasNonElementMessages;
    }
}