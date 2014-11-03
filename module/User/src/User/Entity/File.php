<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 10/6/14
 * Time: 9:46 AM
 */

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

use Common\Entity;

/** @ORM\Entity */
class File extends Entity{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $path;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $size;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $time;

    /**
     * @var \User\Entity\Project
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id", nullable=true)
     */
    protected $project;

    public function getData(){
        return [
            'id' => $this->id,
        ];
    }

    public function getId(){
        return $this->id;
    }

    public function getProject(){
        return $this->project;
    }

    public function setProject($project){
        $this->project = $project;
    }
}