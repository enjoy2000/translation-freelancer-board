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
class Employer extends Entity{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var \User\Entity\Company
     * @ORM\ManyToOne(targetEntity="Company")
     */
    protected $company;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $position = '';

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $defaultServiceLevel = 1;


    public function getData(){
        return [
            'id' => $this->id,
            'position' => $this->position,
            'defaultServiceLevel' => $this->defaultServiceLevel,
            'company' => $this->company ? $this->company->getData() : null,
        ];
    }

    public function updateData($data){
        $this->setData($data);
    }
} 