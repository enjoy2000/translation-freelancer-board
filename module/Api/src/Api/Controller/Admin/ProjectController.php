<?php
namespace Api\Controller\Admin;

use User\Entity\Project;
use Zend\View\Model\JsonModel;

use Api\Controller\AbstractRestfulJsonController;

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
            $targetLanguages[] = $this->getReference('\User\Entity\Language', $targetLanguage['id']);
        }
        $data['targetLanguages'] = $targetLanguages;

        $project = new Project();
        $project->setData($data);
        $project->save($this->getEntityManager());

        return new JsonModel([
            'project' => $project->getData(),
        ]);
    }

}