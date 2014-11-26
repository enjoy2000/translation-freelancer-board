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
use User\Entity\UserInterpretingPrice;

class InterpretingPriceController extends AbstractRestfulController
{

    public function create($data){
        $entityManager = $this->getEntityManager();
        $user = $this->getUserById($data['userId']);
        unset($data['userId']);

        $interpretingPrice = new UserInterpretingPrice();
        $interpretingPrice->setData([
            'user' => $user,
            'priceDay' => $data['priceDay'],
            'priceHalfDay' => $data['priceHalfDay'],
            'sourceLanguage' => $entityManager->getReference('\User\Entity\Language', $data['sourceLanguageId']),
            'targetLanguage' => $entityManager->getReference('\User\Entity\Language', $data['targetLanguageId']),
            'service' => $entityManager->getReference('\User\Entity\InterpretingService', $data['serviceId']),
        ]);

        $interpretingPrice->save($entityManager);

        return new JsonModel([
            'interpretingPrice' => $interpretingPrice->getData(),
        ]);
    }

    public function delete($id){
        $entityManager = $this->getEntityManager();
        $interpretingPrice = $entityManager->find('\User\Entity\UserInterpretingPrice', $id);
        $entityManager->remove($interpretingPrice);
        $entityManager->flush();

        return new JsonModel([]);
    }

    public function update($id, $data) {
        $entityManager = $this->getEntityManager();
        $user = $this->getUserById($data['userId']);
        unset($data['userId']);
        
        $interpretingPrice = $entityManager->find('\User\Entity\UserInterpretingPrice', $id);
        $interpretingPrice->setData([
                'user' => $user,
                'priceDay' => $data['priceDay'],
                'priceHalfDay' => $data['priceHalfDay'],
                'sourceLanguage' => $entityManager->getReference('\User\Entity\Language', $data['sourceLanguageId']),
                'targetLanguage' => $entityManager->getReference('\User\Entity\Language', $data['targetLanguageId']),
                'service' => $entityManager->getReference('\User\Entity\InterpretingService', $data['serviceId']),
                ]);
        
        $interpretingPrice->save($entityManager);
        
        return new JsonModel([
            'interpretingPrice' => $interpretingPrice->getData(),
        ]);
    }
}