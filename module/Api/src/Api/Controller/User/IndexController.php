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

class IndexController extends AbstractRestfulController
{
    public function get($id){
        $user = $this->getUserById($id);
        $userData = $user->getData();

        $desktopPriceData = $this->getAllDataBy('\User\Entity\UserDesktopPrice', [
            'user' => $user,
        ]);
        $interpretingPriceData = $this->getAllDataBy('\User\Entity\UserInterpretingPrice', [
            'user' => $user,
        ]);
        $translationPriceData = $this->getAllDataBy('\User\Entity\UserTranslationPrice', [
            'user' => $user,
        ]);

        return new JsonModel([
            'user' => $userData,
            'desktopPrices' => $desktopPriceData,
            'interpretingPrices' => $interpretingPriceData,
            'translationPrices' => $translationPriceData,
        ]);
    }

    public function update($id, $data){
        $data['country'] = $data['country']['select'];

        $data['profileUpdated'] = true;
        $user = $this->getCurrentUser();
        $user->updateData($data);

        $entityManager = $this->getEntityManager();
        $user->save($entityManager);

        return new JsonModel([]);
    }
}