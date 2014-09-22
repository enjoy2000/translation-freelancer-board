<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/19/14
 * Time: 12:14 AM
 */
namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class EmailTemplates{

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(type="text") */
    protected $content;

    /** @ORM\Column(type="string") */
    protected $subject;

    /** @ORM\OneToOne(targetEntity="TemplateType") */
    protected $type;

    public function setTemplateType(\Admin\Entity\TemplateType $type){
        $this->type = $type;
    }

    public function setData(array $arr){
        $keys = array('content', 'subject');
        foreach($keys as $key){
            if(isset($arr[$key])){
                $this->$key = $arr[$key];
            }
        }
        return $this;
    }
}

