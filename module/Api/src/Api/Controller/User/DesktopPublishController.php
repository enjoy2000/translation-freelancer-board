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

class DesktopPublishController extends AbstractRestfulController
{
    /**
     * @param mixed $id
     * @param array $data
     * @return void|JsonModel
     *
     * Data must contains
     * userDesktopCatTools - array of id
     * userDesktopOperatingSystems - array of id
     */
    public function update($id, $data){
        $entityManager = $this->getEntityManager();

        $userDesktopCatTools = $data['userDesktopCatTools'];
        $userDesktopOperatingSystems = $data['userDesktopOperatingSystems'];

        $user = $this->getCurrentUser();
        $user->updateDesktopCatTools($entityManager, $userDesktopCatTools);
        $user->updateDesktopOperatingSystems($entityManager, $userDesktopOperatingSystems);
        $user->save($entityManager);

        return new JsonModel(array());
    }
}