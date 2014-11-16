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

class FreelancerDataController extends AbstractRestfulController
{
    public function getList()
    {
        $data = [
            'catTools' => [],
            'operatingSystems' => [],
            'resources' => [],
            'specialisms' => [],
            'ratings' => [],
        ];

        $countries = $this->getEntityManager()->getRepository('\User\Entity\Country')
                        ->findBy([],['id' => 'desc']);


        $data['catTools'] = $this->getAllData('\User\Entity\CatTool');
        $data['operatingSystems'] = $this->getAllData('\User\Entity\OperatingSystem');
        $data['resources'] = $this->getGroupResources();
        $data['specialisms'] = $this->getAllData('\User\Entity\Specialism');
        $data['ratings'] = $this->getAllData('\User\Entity\Rating');
        $data['countries'] = $this->getDataList($countries);

        return new JsonModel($data);
    }

    public function getGroupResources(){
        $resources = $this->getEntityManager()->getRepository('\User\Entity\Resource')->findAll();
        $resourceGroups = $this->getEntityManager()->getRepository('\User\Entity\ResourceGroup')->findAll();

        $resourcesData = array();
        foreach($resourceGroups as $resourceGroup){
            /** @var \User\Entity\ResourceGroup $resourceGroup */
            $resourceData = array(
                'group' => $resourceGroup->getData(),
                'resources' => [],
            );
            foreach($resources as $resource){
                /** @var \User\Entity\Resource $resource */
                if($resource->getGroup()->getId() == $resourceGroup->getId()){
                    $resourceData['resources'][] = $resource->getData();
                }
            }
            $resourcesData[] = $resourceData;
        }
        return $resourcesData;
    }
}