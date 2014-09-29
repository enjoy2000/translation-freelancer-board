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
            'catTools' => [],
            'operatingSystems' => [],
            'specialisms' => [],
            'languages' => [],
        );

        $data['catTools'] = $this->getAllData('\User\Entity\CatTool');
        $data['operatingSystems'] = $this->getAllData('\User\Entity\OperatingSystem');
        $data['specialisms'] = $this->getAllData('\User\Entity\Specialism');
        $data['languages'] = $this->getAllData('\User\Entity\Language');

        return new JsonModel($data);
    }
}