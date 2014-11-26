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
use User\Entity\UserDesktopPrice;

class DesktopPriceController extends AbstractRestfulController
{

    public function create($data){
        $entityManager = $this->getEntityManager();
        $user = $this->getUserById($data['userId']);
        unset($data['userId']);

        $desktopPrice = new UserDesktopPrice();
        $desktopPrice->setData([
            'user' => $user,
            'language' => $entityManager->getReference('\User\Entity\Language', $data['languageId']),
            'software' => $entityManager->getReference('\User\Entity\DesktopSoftware', $data['softwareId']),
            'priceMac' => $data['priceMac'],
            'pricePc' => $data['pricePc'],
            'priceHourMac' => $data['priceHourMac'],
            'priceHourPc' => $data['priceHourPc']
        ]);

        $desktopPrice->save($entityManager);

        return new JsonModel([
            'desktopPrice' => $desktopPrice->getData(),
        ]);
    }

    public function delete($id){
        $entityManager = $this->getEntityManager();
        $desktopPrice = $entityManager->find('\User\Entity\UserDesktopPrice', $id);
        $entityManager->remove($desktopPrice);
        $entityManager->flush();

        return new JsonModel([]);
    }
    
    public function update( $id, $data ) {
           $entityManager = $this->getEntityManager();
           $user = $this->getUserById($data['userId']);
           unset($data['userId']);
           
           $desktopPrice = $entityManager->find('\User\Entity\UserDesktopPrice', $id);
           $desktopPrice->setData([
               'user' => $user,
               'language' => $entityManager->getReference('\User\Entity\Language', $data['languageId']),
               'software' => $entityManager->getReference('\User\Entity\DesktopSoftware', $data['softwareId']),
               'priceMac' => $data['priceMac'],
               'pricePc' => $data['pricePc'],
               'priceHourMac' => $data['priceHourMac'],
               'priceHourPc' => $data['priceHourPc']
           ]);
           
           $desktopPrice->save($entityManager);
           
           return new JsonModel([
               'desktopPrice' => $desktopPrice->getData(),
           ]);
       }

}