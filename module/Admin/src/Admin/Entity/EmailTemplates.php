<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/19/14
 * Time: 12:14 AM
 */
namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Mail\Message;

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

    /**
     * 0 => English, 1 => Chinese
     * @ORM\Column(type="boolean")
     */
    protected $language;

    /** @ORM\ManyToOne(targetEntity="TemplateType") */
    protected $type;

    /**
     * Set Template type
     * @param TemplateType $type
     */
    public function setTemplateType(\Admin\Entity\TemplateType $type){
        $this->type = $type;
    }

    /**
     * Set data to object
     * @param array $arr
     * @return $this
     */
    public function setData(array $arr){
        $keys = array('content', 'subject', 'language');
        foreach($keys as $key){
            if(isset($arr[$key])){
                $this->$key = $arr[$key];
            }
        }
        return $this;
    }

    /**
     * Get subject of email template
     * @return string
     */
    public function getSubject(){
        return $this->subject;
    }

    /**
     * Get content of email template
     * @return text
     */
    public function getContent(){
        return $this->content;
    }
}

