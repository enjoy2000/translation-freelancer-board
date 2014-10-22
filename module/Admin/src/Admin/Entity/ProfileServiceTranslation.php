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
class ProfileServiceTranslation extends Entity {
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
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    protected $professionalPrice;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    protected $businessPrice;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    protected $premiumPrice;

    /**
     * Set data
     * @param array $arr
     * @return $this
     */
    public function setData(array $arr){
        $keys = array(
            'sourceLanguage',
            'targetLanguage',
            'professionalPrice',
            'businessPrice',
            'premiumPrice',
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
            'sourceLanguage' => $this->sourceLanguage,
            'targetLanguage' => $this->targetLanguage,
            'professionalPrice' => $this->professionalPrice,
            'businessPrice' => $this->businessPrice,
            'premiumPrice' => $this->premiumPrice,
        );
    }
} 