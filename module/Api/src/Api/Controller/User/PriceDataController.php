<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/27/14
 * Time: 9:19 PM
 */
namespace Api\Controller\User;

use Zend\View\Model\JsonModel;

use Application\Controller\AbstractRestfulController;

class PriceDataController extends AbstractRestfulController
{

    public function getList()
    {
        $data = array(
            'languages' => [],
            'softwares' => [],
            'services' => [],
        );

        $data['languages'] = $this->getAllData('\User\Entity\Language');
        $data['softwares'] = $this->getAllData('\User\Entity\DesktopSoftware');
        $data['services'] = $this->getAllData('\User\Entity\InterpretingService');

        return new JsonModel($data);
    }
}