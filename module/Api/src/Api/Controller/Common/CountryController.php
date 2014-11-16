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
        $countries = $this->getEntityManager()->getRepository('\User\Entity\Country')
            ->findBy(array(),array('name'=>'ASC'));
        $countries = $this->getDataList($countries);

        return new JsonModel(['countries' => $countries]);
    }
}