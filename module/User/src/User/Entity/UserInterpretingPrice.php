<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/28/14
 * Time: 11:51 AM
 */

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class UserInterpretingPrice{

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

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
     * @var \User\Entity\InterpretingService
     * @ORM\ManyToOne(targetEntity="InterpretingService")
     */
    protected $service;

    /**
     * @var float
     * @ORM\Column(type="decimal", scale=2, precision=6)
     */
    protected $priceDay = 0.00;

    /**
     * @var float
     * @ORM\Column(type="decimal", scale=2, precision=6)
     */
    protected $priceHalfDay = 0.00;

    public function getData(){
        return array(
            'id' => $this->id,
        );
    }

    public function getId(){
        return $this->id;
    }
}