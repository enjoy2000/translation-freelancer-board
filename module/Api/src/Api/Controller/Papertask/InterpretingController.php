<?php
/**
 * Created by PhpStorm.
 * User: hat.dao
 * Date: 10/22/2014
 * Time: 9:55 AM
 */

namespace Api\Controller\Papertask;

use Admin\Entity\ProfileServiceInterpreting;
use Zend\View\Model\JsonModel;

use Application\Controller\AbstractRestfulController;

class InterpretingController extends AbstractRestfulController{

    public function getList(){
        $profileServiceInterpreting = $this->getAllData('\Admin\Entity\ProfileServiceInterpreting');
        $data = [
            'interpreting' => $profileServiceInterpreting
        ];

        return new JsonModel($data);
    }

    public function update($id, $option){
        $entityManager = $this->getEntityManager();
        $profileServiceInterpreting = $entityManager->find('\Admin\Entity\ProfileServiceInterpreting', (int)$id);
        $profileServiceInterpreting->setData($option);
        $profileServiceInterpreting->setData([
            'sourceLanguage' => $entityManager->find('\User\Entity\Language',
                (int)$option['sourceLanguage']['id']),
            'targetLanguage' => $entityManager->find('\User\Entity\Language',
                (int)$option['targetLanguage']['id']),
            'interpretingService' => $entityManager->find('\User\Entity\InterpretingService',
                (int)$option['interpretingService']['id']),
        ]);
        $entityManager->merge($profileServiceInterpreting);
        $entityManager->flush();

        return new JsonModel([]);
    }

    public function create($data){
        $entityManager = $this->getEntityManager();
        $profileServiceInterpreting = new ProfileServiceInterpreting();
        $profileServiceInterpreting->setData($data);
        $profileServiceInterpreting->setData([
            'sourceLanguage' => $entityManager->find('\User\Entity\Language',
                (int)$data['sourceLanguage']['id']),
            'targetLanguage' => $entityManager->find('\User\Entity\Language',
                (int)$data['targetLanguage']['id']),
            'interpretingService' => $entityManager->find('\User\Entity\InterpretingService',
                (int)$data['interpretingService']['id']),
        ]);
        $profileServiceInterpreting->save($entityManager);

        return new JsonModel([
            'softwarePrice' => $profileServiceInterpreting->getData(),
        ]);
    }

    public function delete($id){
        $entityManager = $this->getEntityManager();
        $profileServiceInterpreting = $entityManager->find('\Admin\Entity\ProfileServiceInterpreting', $id);
        $entityManager->remove($profileServiceInterpreting);
        $entityManager->flush();

        return new JsonModel([]);
    }
} 