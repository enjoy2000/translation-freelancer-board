<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link       for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Landing\Controller;

use Zend\View\Model\ViewModel;

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
