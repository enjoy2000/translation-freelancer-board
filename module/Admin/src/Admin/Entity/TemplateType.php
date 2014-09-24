<?php
/**
 * Created by PhpStorm.
 * User: hat.dao
 * Date: 9/22/2014
 * Time: 2:22 PM
 */

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * Set data to object
     * @param array $arr
     * @return $this
     */
    public function setData(array $arr){
        $keys = array('name', 'description');
        foreach($keys as $key){
            if(isset($arr[$key])){
                $this->$key = $arr[$key];
            }
        }
        return $this;
    }
}