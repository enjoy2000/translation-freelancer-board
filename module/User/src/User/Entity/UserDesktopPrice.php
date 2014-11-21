<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/28/14
 * Time: 11:51 AM
 */

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

use Common\Entity;

/** @ORM\Entity */
class UserDesktopPrice extends Entity{

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
     * @var \User\Entity\Language
     * @ORM\ManyToOne(targetEntity="Language")
     */
    protected $language;

    /**
     * @var \User\Entity\DesktopSoftware
     * @ORM\ManyToOne(targetEntity="DesktopSoftware")
     */
    protected $software;

    /**
     * @var float
     * @ORM\Column(type="decimal", scale=2, precision=6)
     */
    protected $priceMac = 0.00;

    /**
     * @var float
     * @ORM\Column(type="decimal", scale=2, precision=6)
     */
    protected $pricePc = 0.00;

    /**
     * @var float
     * @ORM\Column(type="decimal", scale=2, precision=6)
     */
    protected $priceHourMac = 0.00;

    /**
     * @var float
     * @ORM\Column(type="decimal", scale=2, precision=6)
     */
    protected $priceHourPc = 0.00;

    public function getData(){
        return array(
            'id' => $this->id,
            'language' => $this->language->getData(),
            'priceHourMac' => $this->formatPrice($this->priceHourMac),
            'priceHourPc' => $this->formatPrice($this->priceHourPc),
            'priceMac' => $this->formatPrice($this->priceMac),
            'pricePc' => $this->formatPrice($this->pricePc),
            'software' => $this->software->getData(),
        );
    }

    public function getId(){
        return $this->id;
    }
    
    /**
     * Set data
     * @param array $arr
     * @return $this
     */
    public function setData(array $arr){
    	$keys = array(
    			'user',
    			'language',
    			'software',
    			'priceMac',
    			'pricePc',
    			'priceHourMac',
    			'priceHourPc'
    	);
    	foreach($keys as $key){
    		if(isset($arr[$key])){
    			$this->$key = $arr[$key];
    		}
    	}
    	return $this;
    }
}