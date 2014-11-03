<?php
namespace Api\Controller\Admin;

use Zend\View\Model\JsonModel;

use Api\Controller\AbstractRestfulJsonController;
use User\Entity\Iterm;
use User\Entity\Project;

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
        ]);
    }

}