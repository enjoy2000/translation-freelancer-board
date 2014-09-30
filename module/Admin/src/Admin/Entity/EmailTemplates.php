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
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

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

    /**
     * @ORM\ManyToOne(targetEntity="TemplateType")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
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
        $keys = array('content', 'subject', 'language', 'createdTime', 'updateTime');
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

    protected $mailContent = null;

    /**
     * Format messages by data from variables
     * @param $variables
     */
    public function format($variables){
        $variables = $this->wrap($variables);
        $search = array_keys($variables);
        $replace = array_values($variables);
        $this->mailContent = str_replace($search, $replace, $this->content);
    }

    /**
     * Wrap array to {{key}} => value
     * @param $variables
     * @return array
     */
    public function wrap($variables){
        $newArray = array();
        foreach($variables as $key => $value){
            $key = '{{' . $key . '}}';
            if(!is_scalar($value)){
                $value = $this->wrap($value);
            }
            $newArray[$key] = $value;
        }
        return $newArray;
    }

    /**
     * @param \Application\Controller\AbstractActionController $controller
     * @param $sendTo
     * @param $variables
     */
    public function send($controller, $sendTo, $variables){
        $this->format($variables);
        $transport = $controller->getServiceLocator()->get('mail.transport');
        $message = $this->getMailMessage();

        $message->addTo($sendTo);
        $message->addFrom($transport->mailOptions['from']);

        $transport->send($message);
    }

    public function getMailMessage(){

        $html = new MimePart($this->mailContent);
        $html->type = "text/html";

        $body = new MimeMessage();
        $body->setParts(array($html));

        $message = new Message();
        $message->setBody($body);
        $message->setSubject($this->subject);

        return $message;
    }
}

