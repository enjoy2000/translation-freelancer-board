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
     * @ORM\Id
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

    public function getData(){
        return array(
            'id' => $this->id,
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
        return $this->updateManyToOne($data, $keys, $entityManager);
    }

} 