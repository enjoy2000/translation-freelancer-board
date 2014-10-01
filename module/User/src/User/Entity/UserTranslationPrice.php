<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/28/14
 * Time: 11:51 AM
 */

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

use Common\Entity;

/** @ORM\Entity */
class UserTranslationPrice extends Entity{

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var \User\Entity\User
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $user;


    /**
     * @var \User\Entity\Language
     * @ORM\ManyToOne(targetEntity="Language")
     */
    protected $sourceLanguage;

    /**
     * @var \User\Entity\Language
     * @ORM\ManyToOne(targetEntity="Language")
     */
    protected $targetLanguage;

    /**
     * @var float
     * @ORM\Column(type="decimal", scale=2, precision=6)
     */
    protected $price = 0.00;

    public function getData(){
        return array(
            'id' => $this->id,
            'sourceLanguage' => $this->sourceLanguage->getData(),
            'targetLanguage' => $this->targetLanguage->getData(),
            'price' => $this->price,
        );
    }

    public function getId(){
        return $this->id;
    }
}