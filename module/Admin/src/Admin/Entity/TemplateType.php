<?php
/**
 * Created by PhpStorm.
 * User: hat.dao
 * Date: 9/22/2014
 * Time: 2:22 PM
 */

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Admin\Model\Helper;

/** @ORM\Entity */
class TemplateType {
    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    protected $code;

    /** @ORM\Column(type="datetime", nullable=true) */
    protected $updateTime;

    /** @ORM\Column(type="datetime") */
    protected $createdTime;

    /**
     * Get id
     * @return integer
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Get type name
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * Get type name
     * @return string
     */
    public function getDescription(){
        return $this->description;
    }

    /**
     * Set data to object
     * @param array $arr
     * @return $this
     */
    public function setData(array $arr){
        $keys = array('name', 'description','createdTime', 'updateTime');
        foreach($keys as $key){
            if(isset($arr[$key])){
                $this->$key = $arr[$key];
            }
        }
        return $this;
    }

    public function getCode(){
        return $this->code;
    }

    public function getTouchTime(){
        return $this->updateTime ? Helper::formatDate($this->updateTime) : Helper::formatDate($this->createdTime);
    }

    public function getEditUrl(){
        $url = '/admin/email/edit?type=' . $this->id . '&language=0';  // TODO: get current language here
        return $url;
    }

    public function getDeleteUrl(){
        $deleteUrl = '/admin/email/delete?type=' . $this->id;
        return $deleteUrl;
    }
}
