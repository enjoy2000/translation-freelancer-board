<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link       for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Landing\Controller;

use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Common\Mail;
use Application\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function indexAction(){
        return new ViewModel();
    }

    public function freelancerAction(){
        return new ViewModel();
    }

    public function languagesAction(){
        return new ViewModel();
    }

    public function contactAction(){
        return new ViewModel();
    }

    public function contactPostAction(){
        $data = $this->params()->fromQuery();

        $json = [
            'result' => false,
            'message' => $this->getTranslator()->translate('There is some error, please try again later.'),
            'data' => null
        ];
        // check data
        if($data['firstName'] && $data['lastName'] && $data['email']){
            // validate email
            if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                Mail::sendContactMail($this, $data);
                $json['result'] = true;
                $json['data'] = $data;
                $json['message'] = $this->getTranslator()->translate('Your contact has been sent.');
            }
        }
        return new JsonModel($json);
    }

    public function orderAction(){
        return new ViewModel();
    }

    public function termsAction(){
        return new ViewModel();
    }

    public function privacyAction(){
        return new ViewModel();
    }
}
