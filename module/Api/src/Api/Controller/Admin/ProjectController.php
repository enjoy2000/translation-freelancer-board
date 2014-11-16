<?php
namespace Api\Controller\Admin;

use Zend\View\Model\JsonModel;
use Zend\Paginator\Paginator;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

use Admin\Model\Helper;
use Api\Controller\AbstractRestfulJsonController;
use User\Entity\Iterm;
use User\Entity\Project;
use User\Entity\UserGroup;

class ProjectController extends AbstractRestfulJsonController
{
    public function create($data)
    {
        $data['field'] = $this->getReference('User\Entity\Field', $data['field']['id']);
        $data['sale'] = $this->getReference('User\Entity\Staff', $data['sale']['id']);
        $data['pm'] = $this->getReference('User\Entity\Staff', $data['pm']['id']);
        $data['client'] = $this->getReference('\User\Entity\Employer', $data['client']['id']);
        $data['sourceLanguage'] = $this->getReference('\User\Entity\Language', $data['sourceLanguage']['id']);
        $data['startDate'] = new \DateTime($data['startDate']);
        $data['dueDate'] = new \DateTime($data['dueDate']);
        $data['status'] = $data['status']['id'];
        $data['priority'] = $data['priority']['id'];
        $data['serviceLevel'] = $data['serviceLevel']['id'];

        $targetLanguages = [];
        foreach($data['targetLanguages'] as $targetLanguage){
            $targetLanguages[$targetLanguage['id']] = $this->getReference('\User\Entity\Language', $targetLanguage['id']);
        }
        $data['targetLanguages'] = $targetLanguages;

        $project = new Project();
        $project->setData($data);
        $project->save($this->getEntityManager());
        $files = [];
        foreach($data['files'] as $file){
            $id = $file['id'];
            $file = $this->find('\User\Entity\File', $id);
            if($file->getProject() == null){
                $file->setProject($project);
                $file->save($this->getEntityManager());
                $files[$file->getId()] = $file;
            }
        }

        foreach($data['data'] as $iterms){
            $identifier = $iterms['identifier'];
            $type = $identifier[0];
            $languageId = $identifier[1]['id'];
            $typeIterms = [];
            foreach($iterms['items'] as $item){
                $iterm = new Iterm();
                $iterm->setData([
                    'file' => $files[$item['file']['id']],
                    'unit' => $item['unit']['id'],
                    'rate' => $item['rate'],
                    'quantity' => $item['quantity'],
                    'language' => $targetLanguages[$languageId],
                ]);
                $iterm->save($this->getEntityManager());
                $typeIterms[] = $iterm;
            }
            $project->setData([
                "{$type}Iterms" => $typeIterms,
            ]);
        }
        $project->save($this->getEntityManager());

        return new JsonModel([
            'project' => $project->getData(),
            'success' => true,
        ]);
    }

    public function getList(){
        $entityManager = $this->getEntityManager();

        // Get freelancer group
        $projectList = $entityManager->getRepository('User\Entity\Project');
        //->findBy(array('group' => $freelancerGroup));
        $queryBuilder = $projectList->createQueryBuilder('project');
        $queryBuilder->andWhere('project.is_deleted = 0');

        /** start filter */
        if($project_id = $this->params()->fromQuery('project_id')){
            $queryBuilder->andWhere($queryBuilder->expr()->eq('project.id', $project_id));
        }
        if($reference = $this->params()->fromQuery('reference')){
            $queryBuilder->andWhere(
                $queryBuilder->expr()->like('project.reference',
                $queryBuilder->expr()->literal("%$reference%")));
        }
        if($field = $this->params()->fromQuery('field')){
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('project.field', $field['id'])
            );
        }
        if($status = $this->params()->fromQuery('status')){
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('project.status', $status['id'])
            );
        }
        if($payStatus = $this->params()->fromQuery('payStatus')){
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('project.payStatus', $payStatus['id'])
            );
        }
        if($sale = $this->params()->fromQuery('sale')){
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('project.sale', $sale['id'])
            );
        }
        if($pm = $this->params()->fromQuery('pm')){
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('project.pm', $pm['id'])
            );
        }
        if($clientId = $this->params()->fromQuery('clientId')){
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq('project.client', $clientId)
            );
        }
        if($startDate = $this->params()->fromQuery('startDate')){
            $queryBuilder->andWhere(
                $queryBuilder->expr()->gte('project.startDate', $startDate)
            );
        }
        if($dueDate = $this->params()->fromQuery('dueDate')){
            $queryBuilder->andWhere(
                $queryBuilder->expr()->gte('project.dueDate', $dueDate)
            );
        }
        if($source = $this->params()->fromQuery('source')){
            $queryBuilder->andWhere(
                $queryBuilder->expr()->gte('project.sourceLanguage', $source['id'])
            );
        }
        if($target = $this->params()->fromQuery('target')){
            // TODO: Many to many problem
        }
        /** end filter */

        $adapter = new DoctrineAdapter(new ORMPaginator($queryBuilder));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);

        $page = (int)$this->getRequest()->getQuery('page');
        if($page) $paginator->setCurrentPageNumber($page);
        $data = array();
        $helper = new Helper();
        foreach($paginator as $user){
            $userData = $user->getData();
            $data[] = $userData;
        }
        //var_dump($paginator);die;
        return new JsonModel(array(
            'projects' => $data,
            'pages' => $paginator->getPages()
        ));
    }

    public function get($id){
        $project = $this->find('\User\Entity\Project', $id);
        return new JsonModel([
            'project' => $project->getData(),
        ]);
    }

    public function delete($id){
        /** @var \User\Entity\Project $project */
        $project = $this->find('\User\Entity\Project', $id);
        $project->setData([
            'is_deleted' => true
        ]);
        $project->save($this->getEntityManager());
        return new JsonModel([
            'project' => $project->getData(),
        ]);
    }
}