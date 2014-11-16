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
class BankInfo extends Entity {

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var \User\Entity\User
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    protected $user;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $paypal;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $alipay;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $account;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $address;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $city;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $country;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $swift;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $accountNo;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    protected $routingNumber;

    public function getData(){
        return [
            'id' => $this->id,
            'user' => $this->user,
            'paypal' => $this->paypal,
            'alipay' => $this->alipay,
            'account' => $this->account,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'name' => $this->name,
            'accountNo' => $this->accountNo,
            'swift' => $this->swift,
            'routingNumber' => $this->routingNumber,
        ];
    }

    /**
     * Set data
     * @param array $arr
     * @return $this
     */
    public function setData(array $arr){
        $keys = array(
            'id',
            'user',
            'paypal',
            'alipay',
            'account',
            'address',
            'city',
            'name',
            'accountNo',
            'swift',
            'routingNumber',
        );
        foreach($keys as $key){
            if(isset($arr[$key])){
                $this->$key = $arr[$key];
            }
        }
        return $this;
    }
} 