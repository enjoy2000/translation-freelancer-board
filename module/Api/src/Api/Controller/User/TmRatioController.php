<?php
/********************************************************************************************
 * Page				: 
 * Author			: G
 * ------------------------------------------------------------------------------------------
 * File Name		: file_name
 * Description		: 
 * Date				: Nov 21, 2014 4:42:32 AM
 * Version			: 1.0
 ********************************************************************************************/
namespace Api\Controller\User;

use Zend\View\Model\JsonModel;

use Application\Controller\AbstractRestfulController;
use User\Entity\UserTmRatio;
use User\Entity\User;
use Zend\Db\Sql\Update;

class TmRatioController extends AbstractRestfulController
{
	public function create($data){
		$entityManager = $this->getEntityManager();
		$user = $this->getUserById($data['userId']);
		unset($data['userId']);

		$tmRatio = new UserTmRatio();
		$tmRatio->setData([
			'user' => $user,
			'repetitions' => $data['repetitions'],
			'yibai' => $data['yibai'],
			'jiuwu' => $data['jiuwu'],
			'bawu'	=> $data['bawu'],
			'qiwu'	=> $data['qiwu'],
			'wushi'	=> $data['wushi'],
			'nomatch' => $data['nomatch']
		]);

		$tmRatio->save($entityManager);

		return new JsonModel([]);
	}

	public function delete($id){
		$entityManager = $this->getEntityManager();
		$tmRatio = $entityManager->find('\User\Entity\TmRatio', $id);
		$entityManager->remove($tmRatio);
		$entityManager->flush();

		return new JsonModel([]);
	}

	public function update( $id, $data) {
		$entityManager = $this->getEntityManager();
		$user = $this->getUserById($data['userId']);
		unset($data['userId']);

		$tmRatio = $entityManager->find('\User\Entity\UserTmRatio', $id);
		$tmRatio->setData([
			'user' => $user,
			'repetitions' => $data['repetitions'],
			'yibai' => $data['yibai'],
			'jiuwu' => $data['jiuwu'],
			'bawu'	=> $data['bawu'],
			'qiwu'	=> $data['qiwu'],
			'wushi'	=> $data['wushi'],
			'nomatch' => $data['nomatch']
		]);

		$tmRatio->save($entityManager);

		return new JsonModel([]);
	}

}