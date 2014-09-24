<?php
/**
 * Created by PhpStorm.
 * User: eastagile
 * Date: 9/24/14
 * Time: 5:43 PM
 */

namespace Common;

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
}