<?php
/**
 * Created by PhpStorm.
 * User: hat.dao
 * Date: 10/22/2014
 * Time: 9:55 AM
 */

namespace Api\Controller\Papertask;

use Admin\Entity\ProfileServiceEngineering;
use Zend\View\Model\JsonModel;

use Application\Controller\AbstractRestfulController;

class EngineeringController extends AbstractRestfulController{

    public function getList(){
        $profileServiceEngineering = $this->getAllData('\Admin\Entity\ProfileServiceEngineering');
        $data = [
            'engineering' => $profileServiceEngineering
        ];

        return new JsonModel($data);
    }

    public function update($id, $option){
        $entityManager = $this->getEntityManager();
        $profileServiceEngineering = $entityManager->find('\Admin\Entity\ProfileServiceEngineering', (int)$id);
        $profileServiceEngineering->setData($option);
        $profileServiceEngineering->setData([
            'languageGroup' => $entityManager->find('\User\Entity\LanguageGroup', (int)$option['languageGroup']['id']),
            'desktopSoftware' => $entityManager->find('\User\Entity\DesktopSoftware', (int)$option['desktopSoftware']['id']),
        ]);
        $entityManager->merge($profileServiceEngineering);
        $entityManager->flush();

        return new JsonModel([]);
    }

    public function create($data){
        $entityManager = $this->getEntityManager();
        $profileServiceEngineering = new ProfileServiceEngineering();
        $profileServiceEngineering->setData($data);
        $profileServiceEngineering->setData([
            'engineeringCategory' => $entityManager->find('\Common\Entity\EngineeringCategory',
                (int)$data['engineeringCategory']['id']),
            'unit' => $entityManager->find('\Common\Entity\Unit', (int)$data['unit']['id']),
        ]);
        $profileServiceEngineering->save($entityManager);

        return new JsonModel([
            'softwarePrice' => $profileServiceEngineering->getData(),
        ]);
    }

    public function delete($id){
        $entityManager = $this->getEntityManager();
        $profileServiceEngineering = $entityManager->find('\Admin\Entity\ProfileServiceEngineering', $id);
        $entityManager->remove($profileServiceEngineering);
        $entityManager->flush();

        return new JsonModel([]);
    }
} 