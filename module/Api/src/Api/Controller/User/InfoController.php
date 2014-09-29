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

class InfoController extends AbstractRestfulController
{
    public function getList()
    {
        $user = $this->getCurrentUser();

        $userData = $user->getData();
        $userData['country'] = array(
            'select' => $userData['country'],  # ng-option
        );

        return new JsonModel(
            array(
                'user' => $userData,
            )
        );
    }

    public function update($id, $data){
        $data['country'] = $data['country']['select'];

        $user = $this->getCurrentUser();
        $user->updateData($data);

        $entityManager = $this->getEntityManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonModel(array());
    }
}