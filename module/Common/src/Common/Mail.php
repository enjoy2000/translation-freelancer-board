<?php
/**
 * Created by PhpStorm.
 * User: eastagile
 * Date: 9/24/14
 * Time: 5:43 PM
 */

namespace Common;

use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

class Mail{
    /**
     * @param \Application\Controller\AbstractActionController $controller
     * @param $type
     * @param $sendTo
     * @param $variables
     */
    static public function sendMail($controller, $type, $sendTo, $variables){
        $entityManager = $controller->getEntityManager();
        /**
         * @var $templateType \Admin\Entity\TemplateType
         */
        $templateType = $entityManager->getRepository('Admin\Entity\TemplateType')->findOneBy(
            array(
                'code' => $type,
            )
        );
        /**
         * @var $emailTemplate \Admin\Entity\EmailTemplates
         */
        $emailTemplate = $entityManager->getRepository('Admin\Entity\EmailTemplates')->findOneBy(
            array(
                'type' => $templateType,
                'language' => 0  // TODO: define current language
            )
        );
        if(!$emailTemplate){
            throw new \Exception("Missing email template for type {$type}");
        }
        $emailTemplate->send($controller, $sendTo, $variables);
    }

    /**
     * Send contact mail
     * @param $controller
     * @param $data
     */
    static public function sendContactMail($controller, $data){
        // prepare html content
        $comments = nl2br($data['comments']);  // line break
        $content = '';
        $content .= '<table>';
        $content .= '<tbody>';
        $content .= "<tr><td>First Name:</td><td>{$data['firstName']}</td></tr>";
        $content .= "<tr><td>Last Name:</td><td>{$data['lastName']}</td></tr>";
        $content .= "<tr><td>Phone Number:</td><td>{$data['phone']}</td></tr>";
        $content .= "<tr><td>Email:</td><td>{$data['email']}</td></tr>";
        $content .= "<tr><td>Company:</td><td>{$data['company']}</td></tr>";
        $content .= "<tr><td>Job Title:</td><td>{$data['jobTitle']}</td></tr>";
        $content .= "<tr><td>Comments:</td><td>{$comments}</td></tr>";
        $content .= '</tbody>';
        $content .= '</table>';
        $html = new MimePart($content);
        $html->type = "text/html";

        $body = new MimeMessage();
        $body->setParts(array($html));

        $message = new Message();
        $message->setBody($body);

        // subject
        $subject = 'Contact from Papertask';
        $message->setSubject($subject);

        // get transport
        $transport = $controller->getServiceLocator()->get('mail.transport');
        $message->addTo($transport->mailOptions['contact']);
        $message->addFrom($transport->mailOptions['from']);

        $transport->send($message);
    }
}