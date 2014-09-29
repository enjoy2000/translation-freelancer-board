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

class InterpretingController extends AbstractRestfulController
{
    public function getList()
    {
        $data = array(
            'interpretingSpecialisms' => [],
        );

        $entityManager = $this->getEntityManager();
        $interpretingSpecialisms = $entityManager->getRepository('\User\Entity\InterpretingSpecialism')->findAll();

        foreach($interpretingSpecialisms as $interpretingSpecialism){
            $data['interpretingSpecialisms'][] = $interpretingSpecialism->getData();
        }

        return new JsonModel($data);
    }

    /**
     * @param mixed $id
     * @param array $data
     * @return void|JsonModel
     *
     * Data must contains
     * userInterpretingSpecialisms - array of id
     */
    public function update($id, $data){
        $entityManager = $this->getEntityManager();

        $userInterpretingSpecialisms = $data['userInterpretingSpecialisms'];

        $user = $this->getCurrentUser();
        $user->updateInterpretingSpecialisms($entityManager, $userInterpretingSpecialisms);
        $user->save($entityManager);

        return new JsonModel(array());
    }
}