<?php
/**
 * Created by PhpStorm.
 * User: hat.dao
 * Date: 10/21/2014
 * Time: 3:58 PM
 */

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Common\Entity;

/** @ORM\Entity */
class ProfileServiceEngineering extends Entity {
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

    /**
     * @return array
     */
    public function getData(){
        return [
            'id' => $this->id,
            'engineeringCategory' => $this->engineeringCategory->getData(),
            'unit' => $this->unit->getData(),
            'price' => $this->price
        ];
    }

    /**
     * Set data
     * @param array $arr
     * @return $this
     */
    public function setData(array $arr){
        $keys = array(
            'engineeringCategory',
            'unit',
            'price',
        );
        foreach($keys as $key){
            if(isset($arr[$key])){
                $this->$key = $arr[$key];
            }
        }
        return $this;
    }
} 