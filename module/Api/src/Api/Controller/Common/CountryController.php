<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/28/14
 * Time: 7:23 AM
 */
namespace Api\Controller\Common;

use Zend\View\Model\JsonModel;

use Application\Controller\AbstractRestfulController;

class CountryController extends AbstractRestfulController
{
    public function getList()
    {
        $config = $this->getServiceLocator()->get('Config');
        $countries = $config['countries'];

        $data = array('countries' => []);
        foreach($countries as $code => $name){
            $data['countries'][] = array('select' => $code, 'label' => $name);
        }

        return new JsonModel($data);
    }
}