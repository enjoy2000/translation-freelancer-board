<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonAdmin for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Application\Controller\AbstractActionController;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

use Admin\Model\Helper;
use User\Entity\User;
use User\Entity\UserGroup;
use User\Entity\UserDesktopPrice;
use User\Entity\UserTranslationPrice;
use User\Entity\UserInterpretingPrice;
use User\Entity\UserTmRatio;
use User\Entity\UserEngineeringPrice;
use Zend\View\Model\JsonModel;
use User\Entity\Company;


class EmployerController extends AbstractActionController {
	protected $requiredLogin = true;
	public function editAction() {
		$userId = $this->getRequest()->getQuery('userId');
		return new ViewModel( array (
				"user" => $this->getUserById($userId)->getData()
		));
	}
	
	public function profileAction() {
		$user = $this->getCurrentUser();
		$employer = $user->getEmployer();
		$entityManager = $this->getEntityManager();
		$pCompanies = $entityManager->getRepository('User\Entity\Company')->findAll();
		$companies = array();
		foreach ($pCompanies as $k => $v) {
			$companies[$k] = $v->getData();
		}
		return new ViewModel( array (
				"user" => $user->getData(),
				"employer" => $employer->getData(),
				'companies' => $companies
		));
	}
	
	public function newAction() {
		return new ViewModel ( array () );
	}

	// Added by Gao
	public function newclientAction() {
		$request = $this->getRequest();
		$content = $request->getContent();
		 
		$jsondata = json_decode($content);
		 
		$data = array();
		$data['isActive'] = $jsondata->isActive;
		$data['profileUpdated'] = $jsondata->profileUpdated;
		$data['city'] = $jsondata->city;
		$data['country'] = $jsondata->country;
		$data['currency'] = $jsondata->currency;
		$data['createdTime'] = new \DateTime('now');
		$data['email'] = $jsondata->email;
		$data['firstName'] = $jsondata->firstname;
		$data['lastName'] = $jsondata->surname;
		$data['password'] = $jsondata->password;
		$data['phone'] = $jsondata->phone;
		$data['gender'] = $jsondata->gender;
		$data['comments'] = $jsondata->comments;
		$data['position'] = $jsondata->position;
		 
		 
		$entityManager = $this->getEntityManager();
		$data['company_id'] = $entityManager->getRepository('User\Entity\Company')->findOneBy(array('id' => $jsondata->company));
		$userExist = $entityManager->getRepository('User\Entity\User')->findOneBy(array('email'=>$jsondata->email));
		 
		if ( $userExist ) {
	
		} else {
			$user = new User();
			$user->createEmployer($data, $entityManager);
			$employer = $user->getEmployer();
	
			$employer->updateData(array('position'=>$jsondata->position, 'company'=>$data['company_id'], 'defaultServiceLevel'=>$jsondata->defaultServiceLevel));
			$employer->save($entityManager);
	
			$ret_data = $employer->getData();
	
			// Set Translation Price
			$pTranslationPrice = new UserTranslationPrice();
			foreach ( $jsondata->translationPrices as $k => $v ) {
				$translationPrice = array(
						'user' => $user,
						'sourceLanguage' => $entityManager->getRepository('User\Entity\Language')->findOneBy(array('id' => $v->sourceLanguage->id)),
						'targetLanguage' => $entityManager->getRepository('User\Entity\Language')->findOneBy(array('id' => $v->targetLanguage->id)),
						'price' => $v->price
				);
				 
				$pTranslationPrice->setData( $translationPrice );
				$pTranslationPrice->save( $entityManager );
			}
	
			// Set Desktop Prices
			$pDesktopPrice = new UserDesktopPrice();
			foreach ( $jsondata->desktopPrices as $k => $v) {
				$desktopPrice = array (
						'user'=> $user,
						'language' => $entityManager->getRepository('User\Entity\Language')->findOneBy(array('id'=>$v->language->id)),
						'software' => $entityManager->getRepository('User\Entity\DesktopSoftware')->findOneBy(array('id'=>$v->language->id)),
						'priceMac' => $v->priceMac,
						'pricePc' => $v->pricePc,
						'priceHourMac' => $v->priceHourMac,
						'priceHourPc' => $v->priceHourPc
				);
				 
				$pDesktopPrice->setData( $desktopPrice );
				$pDesktopPrice->save( $entityManager );
			}
	
			// Set Interpreting Price
			$pInterpretingPrice = new UserInterpretingPrice();
			foreach ( $jsondata->interpretingPrices as $k=>$v) {
				$interpretingPrice = array(
						'user' => $user,
						'sourceLanguage' => $entityManager->getRepository('User\Entity\Language')->findOneBy(array('id' => $v->sourceLanguage->id)),
						'targetLanguage' => $entityManager->getRepository('User\Entity\Language')->findOneBy(array('id' => $v->targetLanguage->id)),
						'service' => $entityManager->getRepository('User\Entity\InterpretingService')->findOneBy(array('id' => $v->service->id)),
						'priceDay' => $v->priceDay,
						'priceHalfDay' => $v->priceHalfDay
				);
				$pInterpretingPrice->setData( $interpretingPrice );
				$pInterpretingPrice->save( $entityManager );
			}
	
			// Set TM Ratio
			$pTmRatio = new UserTmRatio();
			$tmRatio = array(
					'repetitions'	=> $jsondata->tmRatio->repetition,
					'yibai'			=> $jsondata->tmRatio->yibai,
					'jiuwu'			=> $jsondata->tmRatio->jiuwu,
					'bawu'			=> $jsondata->tmRatio->bawu,
					'qiwu'			=> $jsondata->tmRatio->qiwu,
					'wushi'			=> $jsondata->tmRatio->wushi,
					'nomatch'		=> $jsondata->tmRatio->nomatch,
					'user'			=> $user
			);
			 
			$pTmRatio->setData( $tmRatio );
			$pTmRatio->save( $entityManager );
	
			// Set Engineering Price
			$pEngineeringPrices = new UserEngineeringPrice();
			foreach ( $jsondata->engineeringPrices as $k=>$v ) {
				$engineeringPrice = array(
						'engineeringcategory'=> $entityManager->getRepository('Common\Entity\EngineeringCategory')->findOneBy(array('id' => $v->engineeringCategory->id)),
						'unit'=> $entityManager->getRepository('Common\Entity\Unit')->findOneBy(array('id' => $v->unit->id)),
						'price'=> $v->price,
						'user'=> $user
				);
				$pEngineeringPrices->setData( $engineeringPrice );
				$pEngineeringPrices->save( $entityManager );
			}
	
			return new JsonModel($ret_data);
		}
		return new JsonModel([]);
	}
	
	public function listAction() {
    	return new ViewModel(array());
	}
	
	public function detailAction() {
		$userId = (int)$this->getRequest()->getQuery('id');
		$entityManager = $this->getEntityManager();
		$user = $this->getUserById($userId);
		
		// Get Interpreting Price
		$repository = $entityManager->getRepository('User\Entity\UserInterpretingPrice');
		$interPretingPrices = $repository->findBy( array('user'=>$user) );
		$pInterPretingPrices = array();
		foreach ( $interPretingPrices as $k => $v ) {
			$pInterPretingPrices[$k] = $v->getData();
		}		 
		// Get EngeeringPrice
		$repository = $entityManager->getRepository('User\Entity\UserEngineeringPrice');
		$engineeringPrices = $repository->findBy(array('user'=>$user));
		$pEngineeringPrices = array();
		foreach ($engineeringPrices as $k => $v ) {
			$pEngineeringPrices[$k] = $v->getData();
		}
		 
		// Get Translation Price
		$repository = $entityManager->getRepository('User\Entity\UserTranslationPrice');
		$translationPrices = $repository->findBy(array('user'=>$user));
		$pTranslationPrices = array();
		foreach ( $translationPrices as $k => $v ) {
			$pTranslationPrices[$k] = $v->getData();
		}
		 
		// Get DesktopPrices
		$repository = $entityManager->getRepository('User\Entity\UserDesktopPrice');
		$dtpPrices = $repository->findBy(array('user'=>$user));
		$pDtpPrices = array();
		foreach ( $dtpPrices as $k => $v) {
			$pDtpPrices[$k]=$v->getData();
		}
		 
		// Get Translation Ratio
		$repository = $entityManager->getRepository('User\Entity\UserTmRatio');
		$tmRatios = $repository->findBy(array('user'=>$user));
		$pTmRatios = array();
		foreach ( $tmRatios as $k => $v) {
			$pTmRatios[$k] = $v->getData();
		}
		
		return new ViewModel(array('user'=>$user->getData(), 
				'interpretingPrices'=>$pInterPretingPrices,
				'engineeringPrices'=>$pEngineeringPrices,
				'translationPrices'=>$pTranslationPrices,
				'dptPrices'=>$pDtpPrices,
				'tmRatios'=>$pTmRatios
		));
	}
}
