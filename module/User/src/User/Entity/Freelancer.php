<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 10/1/14
 * Time: 6:17 AM
 */

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

use Common\Entity;
use Common\Func;

/** @ORM\Entity */
class Freelancer extends Entity{

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var \Doctrine\ORM\PersistentCollection
     * @ORM\ManyToMany(targetEntity="Resource")
     */
    protected $Resources = null;

    /**
     * @var \Doctrine\ORM\PersistentCollection
     * @ORM\ManyToMany(targetEntity="CatTool")
     * @ORM\JoinTable(name="UserDesktopCatTools")
     */
    protected $DesktopCatTools = null;

    /**
     * @var \Doctrine\ORM\PersistentCollection
     * @ORM\ManyToMany(targetEntity="OperatingSystem")
     * @ORM\JoinTable(name="UserOperatingSystem")
     */
    protected $DesktopOperatingSystems = null;

    /**
     * @var \Doctrine\ORM\PersistentCollection
     * @ORM\ManyToMany(targetEntity="Specialism")
     * @ORM\JoinTable(name="UserInterpretingSpecialisms")
     */
    protected $InterpretingSpecialisms = null;

    /**
     * @var \Doctrine\ORM\PersistentCollection
     * @ORM\ManyToMany(targetEntity="CatTool")
     * @ORM\JoinTable(name="UserTranslationCatTools")
     */
    protected $TranslationCatTools = null;

    /**
     * @var \Doctrine\ORM\PersistentCollection
     * @ORM\ManyToMany(targetEntity="Specialism")
     * @ORM\JoinTable(name="UserTranslationSpecialisms")
     */
    protected $TranslationSpecialisms = null;


    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param array $userTranslationCatTools
     */
    public function updateTranslationCatTools($entityManager, $userTranslationCatTools){

        $values = $entityManager->getRepository('\User\Entity\CatTool')->findBy([
            'id' => $userTranslationCatTools
        ]);

        $this->TranslationCatTools->clear();

        foreach($values as $value){
            $this->TranslationCatTools->add($value);
        }
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param array $userTranslationSpecialisms
     */
    public function updateTranslationSpecialisms($entityManager, $userTranslationSpecialisms){

        $values = $entityManager->getRepository('\User\Entity\Specialism')->findBy([
            'id' => $userTranslationSpecialisms
        ]);

        $this->TranslationSpecialisms->clear();

        foreach($values as $value){
            $this->TranslationSpecialisms->add($value);
        }
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param array $userDesktopCatTools
     */
    public function updateDesktopCatTools($entityManager, $userDesktopCatTools){

        $values = $entityManager->getRepository('\User\Entity\CatTool')->findBy([
            'id' => $userDesktopCatTools
        ]);

        $this->DesktopCatTools->clear();

        foreach($values as $value){
            $this->DesktopCatTools->add($value);
        }
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param array $userDesktopOperatingSystems
     */
    public function updateDesktopOperatingSystems($entityManager, $userDesktopOperatingSystems){

        $values = $entityManager->getRepository('\User\Entity\OperatingSystem')->findBy([
            'id' => $userDesktopOperatingSystems
        ]);

        $this->DesktopOperatingSystems->clear();

        foreach($values as $value){
            $this->DesktopOperatingSystems->add($value);
        }
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param array $userInterpretingSpecialisms
     */
    public function updateInterpretingSpecialisms($entityManager, $userInterpretingSpecialisms){

        $values = $entityManager->getRepository('\User\Entity\Specialism')->findBy([
            'id' => $userInterpretingSpecialisms
        ]);

        $this->InterpretingSpecialisms->clear();

        foreach($values as $value){
            $this->InterpretingSpecialisms->add($value);
        }
    }

    public function getData(){
        return array(
            'DesktopCatTools' => Func::getReferenceIds($this->DesktopCatTools),
            'DesktopOperatingSystems' => Func::getReferenceIds($this->DesktopOperatingSystems),
            'InterpretingSpecialisms' => Func::getReferenceIds($this->InterpretingSpecialisms),
            'Resources' => Func::getReferenceIds($this->Resources),
            'TranslationCatTools' => Func::getReferenceIds($this->TranslationCatTools),
            'TranslationSpecialisms' => Func::getReferenceIds($this->TranslationSpecialisms),
        );
    }

    /**
     * @param array $data
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function updateData($data, $entityManager){
        $keys = array(
            'DesktopCatTools',
            'DesktopOperatingSystems',
            'InterpretingSpecialisms',
            'Resources',
            'TranslationCatTools',
            'TranslationSpecialisms');
        foreach($keys as $key){
            $ids = $data[$key];
            $ids = array_unique($ids);
            /** @var \Doctrine\ORM\PersistentCollection $relation */
            $relation = $this->$key;
            $relationKeys = $relation->getKeys();
            foreach($relationKeys as $relationKey){
                $value = $relation->get($relationKey);
                $valueId = $value->getId();
                // if new item already exists
                if($index = array_search($valueId, $ids)){
                    array_splice($ids, $index, 1);  # remove it from adding
                } else {
                    $relation->remove($relationKey);
                }
            }
            if($ids){
                $relationTarget = $relation->getTypeClass()->getName();
                $newValues = $entityManager->getRepository($relationTarget)->findBy([
                    'id' => $ids
                ]);
                foreach($newValues as $newValue){
                    $relation->add($newValue);
                }
            }
        }
    }

} 