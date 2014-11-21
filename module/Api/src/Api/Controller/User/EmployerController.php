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
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use User\Entity\UserGroup;
use Admin\Model\Helper;
use User\Entity\UserDesktopPrice;
use User\Entity\UserTranslationPrice;
use User\Entity\UserInterpretingPrice;
use User\Entity\UserTmRatio;
use User\Entity\UserEngineeringPrice;
use User\Entity\Company;

class EmployerController extends AbstractRestfulController
{
    public function get($id){
        $user = $this->getUserById($id);
        $employerData = $user->getEmployer()->getData();

        return new JsonModel([
            'employer' => $employerData,
        ]);
    }
    
    public function update($id, $data){
        $userId = $this->getRequest()->getQuery('user_id');
        $entityManager = $this->getEntityManager();
        $user = $this->getUserById($userId);

        $employer = $user->getEmployer();
        $employer->updateData(array(
        		'position'=>$data['position'], 
        		'company'=>$entityManager->getRepository('User\Entity\Company')->findOneBy(array('id' => $data['company'])), 
        		'defaultServiceLevel'=>$data['defaultServiceLevel']));
		$employer->save($entityManager);

        return new JsonModel([]);
    }
    
    public function delete($id) {
    	$userId = $this->getEvent()->getRouteMatch()->getParam('id');
    	$entityManager = $this->getEntityManager();
    	
    	$user = $this->getUserById($userId);
    	
    	$employer = $user->getEmployer();
    	
    	// Remove Interpreting Price
    	$repository = $entityManager->getRepository('User\Entity\UserInterpretingPrice');
    	$interPretingPrices = $repository->findBy( array('user'=>$user) );
    	foreach ($interPretingPrices as $k=>$v) {
    		$interPretingPrice = $repository->find($v->getId());
    		$entityManager->remove($interPretingPrice);
    		$entityManager->flush();
    	}
    	
    	// Remove EngeeringPrice
    	$repository = $entityManager->getRepository('User\Entity\UserEngineeringPrice');
    	$engineeringPrices = $repository->findBy(array('user'=>$user));
    	foreach ($engineeringPrices as $k=>$v) {
    		$engineeringPrice = $repository->find($v->getId());
    		$entityManager->remove($engineeringPrice);
    		$entityManager->flush();
    	}
    	
    	// Remove Translation Price
    	$repository = $entityManager->getRepository('User\Entity\UserTranslationPrice');
    	$translationPrices = $repository->findBy(array('user'=>$user));
    	foreach ($translationPrices as $k=>$v) {
    		$translationPrice = $repository->find($v->getId());
    		$entityManager->remove($translationPrice);
    		$entityManager->flush();
    	}
    	
    	// Remove DesktopPrices
    	$repository = $entityManager->getRepository('User\Entity\UserDesktopPrice');
    	$dtpPrices = $repository->findBy(array('user'=>$user));
    	foreach ($dtpPrices as $k=>$v) {
    		$dtpPrice = $repository->find($v->getId());
    		$entityManager->remove($dtpPrice);
    		$entityManager->flush();
    	}
    	
    	// Remove Translation Ratio
    	$repository = $entityManager->getRepository('User\Entity\UserTmRatio');
    	$tmRatios = $repository->findBy(array('user'=>$user));
    	foreach ($tmRatios as $k=>$v) {
    		$tmRatio = $repository->find($v->getId());
    		$entityManager->remove($tmRatio);
    		$entityManager->flush();
    	}
    	$entityManager->remove($user);
    	$entityManager->flush();
    	$entityManager->remove($employer);
    	$entityManager->flush();
    	return new JsonModel([]);
    }
    
    public function getList( ) {
    	$entityManager = $this->getEntityManager();
    	
    	// Get employer group
    	$employerGroup = $entityManager->find('User\Entity\UserGroup', UserGroup::EMPLOYER_GROUP_ID);
    	$employerList = $entityManager->getRepository('User\Entity\User');
    	$queryBuilder = $employerList->createQueryBuilder('user')->where("user.group = ?1")->setParameter(1, $employerGroup);
    	$adapter = new DoctrineAdapter(new ORMPaginator($queryBuilder));
    	$paginator = new Paginator($adapter);
    	$paginator->setDefaultItemCountPerPage(10);
    	$page = (int)$this->getRequest()->getQuery('page');
    	if($page) $paginator->setCurrentPageNumber($page);
    	$data = array();
    	$helper = new Helper();
    	foreach($paginator as $user){
    		$userData = $user->getData();
    		$userData['createdTime'] = $helper->formatDate($userData['createdTime']);
    		$data[] = $userData;
    	}
    	return new JsonModel(array(
    		'employers'=>$data,
    		'pages' => $paginator->getPages()
    	));
    }
}