<?php
/**
 * Created by PhpStorm.
 * User: hat.dao
 * Date: 10/21/2014
 * Time: 3:58 PM
 */

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class ProfileServiceInterpreting {
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\User\Entity\Language")
     */
    protected $sourceLanguage;

    /**
     * @ORM\ManyToOne(targetEntity="\User\Entity\Language")
     */
    protected $targetLanguage;

    /**
     * @ORM\ManyToOne(targetEntity="\User\Entity\InterpretingService")
     */
    protected $interpretingService;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    protected $pricePerDay;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    protected $pricePerHalfDay;
} 