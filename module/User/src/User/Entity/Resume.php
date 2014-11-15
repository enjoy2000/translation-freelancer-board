<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 11/12/14
 * Time: 11:59 PM
 */

namespace User\Entity;

use Common\Entity;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Resume extends Entity {

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var \User\Entity\Freelancer
     * @ORM\OneToOne(targetEntity="Freelancer")
     * @ORM\JoinColumn(name="freelancer_id", referencedColumnName="id", nullable=true)
     */
    protected $freelancer;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    protected $workingExperiences;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    protected $education;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    protected $recommended;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    protected $papertaskComments;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cvUploaded;

    public function getData(){
        return [
            'id' => $this->id,
            'freelancer' => $this->freelancer,
            'workingExperiences' => $this->workingExperiences,
            'education' => $this->education,
            'recommended' => $this->recommended,
            'papertaskComments' => $this->papertaskComments,
            'cvUploaded' => $this->cvUploaded
        ];
    }
} 