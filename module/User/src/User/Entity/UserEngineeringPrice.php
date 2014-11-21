<?php
/**
 * Created by Gao.
 * User: meas
 * Date: 11/18/14
 * Time: 11:50 AM
 */

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

use Common\Entity;

/** @ORM\Entity */
class UserEngineeringPrice extends Entity {

   /**
     * @ORM\Id
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
     * @ORM\ManyToOne(targetEntity="\Common\Entity\EngineeringCategory")
     */
    protected $engineeringcategory;

    /**
     * @ORM\ManyToOne(targetEntity="\Common\Entity\Unit")
     */
    protected $unit;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $price;

    public function getData(){
        return array(
            'id' => $this->id,
            'engineeringcategory' => $this->engineeringcategory->getData(),
       		'unit'=>$this->unit->getData(),
        	'price'=>$this->price
        );
    }

    public function getId(){
        return $this->id;
    }
}