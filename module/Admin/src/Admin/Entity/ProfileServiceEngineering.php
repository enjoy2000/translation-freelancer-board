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
class ProfileServiceEngineering {
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Common\Entity\EngineeringCategory")
     */
    protected $engineeringCategory;

    /**
     * @ORM\ManyToOne(targetEntity="\Common\Entity\Unit")
     */
    protected $unit;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=2)
     */
    protected $price;
} 