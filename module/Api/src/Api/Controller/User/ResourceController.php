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

class ResourceController extends AbstractRestfulController
{
    public function getList()
    {
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

        return new JsonModel(
            array(
                'resources' => $resourcesData,
            )
        );
    }

    public function update($id, $data){
        $entityManager = $this->getEntityManager();
        $resourceIds = $data['resources'];

        $resources = $entityManager->getRepository('\User\Entity\Resource')->findBy(array(
            'id' => $resourceIds
        ));

        $user = $this->getCurrentUser();
        $user->getResources()->clear();

        foreach($resources as $resource){
            $user->getResources()->add($resource);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonModel(array());
    }
}