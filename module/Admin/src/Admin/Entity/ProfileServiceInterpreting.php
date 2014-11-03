<?php
/**
 * Created by PhpStorm.
 * User: hat.dao
 * Date: 10/21/2014
 * Time: 3:58 PM
 */

namespace Admin\Entity;

use Common\Entity;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class ProfileServiceInterpreting extends Entity {
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
     * @ORM\Column(type="decimal", precision=19, scale=2)
     */
    protected $pricePerDay;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=2)
     */
    protected $pricePerHalfDay;


    /**
     * Set data
     * @param array $arr
     * @return $this
     */
    public function setData(array $arr){
        $keys = array(
            'sourceLanguage',
            'targetLanguage',
            'interpretingService',
            'pricePerDay',
            'pricePerHalfDay',
        );
        foreach($keys as $key){
            if(isset($arr[$key])){
                $this->$key = $arr[$key];
            }
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getData(){
        return array(
            'id' => $this->id,
            'sourceLanguage' => $this->sourceLanguage->getData(),
            'targetLanguage' => $this->targetLanguage->getData(),
            'interpretingService' => $this->interpretingService->getData(),
            'pricePerDay' => $this->pricePerDay,
            'pricePerHalfDay' => $this->pricePerHalfDay,
        );
    }
} 