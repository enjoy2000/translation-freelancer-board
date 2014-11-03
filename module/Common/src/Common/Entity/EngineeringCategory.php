<?php
/**
 * Created by PhpStorm.
 * User: hat.dao
 * Date: 10/22/2014
 * Time: 10:29 AM
 */

namespace Common\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class EngineeringCategory {
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $category;

    public function getData(){
        return [
            'id' => $this->id,
            'category' => $this->category
        ];
    }
} 