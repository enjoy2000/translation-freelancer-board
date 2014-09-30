<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/19/14
 * Time: 12:14 AM
 */
namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Session\Container;

use User\Model\Password;
use Common\Mail;
use Common\Func;

/** @ORM\Entity */
class User implements InputFilterAwareInterface{

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(type="string") */
    protected $firstName;

    /** @ORM\Column(type="string") */
    protected $lastName;

    /**
     * @var \User\Entity\UserGroup
     * @ORM\ManyToOne(targetEntity="UserGroup")
     */
    protected $group;

    /** @ORM\Column(type="string", unique=true) */
    protected $email;

    /** @ORM\Column(type="string") */
    protected $password;

    /** @ORM\Column(type="string") */
    protected $phone;

    /** @ORM\Column(type="datetime") */
    protected $lastLogin;

    /** @ORM\Column(type="datetime") */
    protected $createdTime;

    /** @ORM\Column(type="boolean") */
    protected $isActive = 0;

    /** @ORM\Column(type="boolean") */
    protected $profileUpdated = false;

    /** @ORM\Column(type="string", nullable=true) */
    protected $token = Null;

    /** @ORM\Column(type="string", nullable=true) */
    protected $country = null;

    /** @ORM\Column(type="string", nullable=true) */
    protected $city = null;

    /** @ORM\Column(type="boolean") */
    protected $gender = 0;

    /**
     * @var \Doctrine\ORM\PersistentCollection
     * @ORM\ManyToMany(targetEntity="Resource")
     */
    protected $resources = null;

    /** @ORM\Column(type="string") */
    protected $currency = 'cny';

    /**
     * @var \Doctrine\ORM\PersistentCollection
     * @ORM\ManyToMany(targetEntity="CatTool")
     * @ORM\JoinTable(name="UserDesktopCatTools")
     */
    protected $DesktopCatTools = null;

    /**
     * @var \Doctrine\ORM\PersistentCollection
     * @ORM\ManyToMany(targetEntity="OperatingSystem")
     * @ORM\JoinTable(name="UserOperatingSystem")
     */
    protected $DesktopOperatingSystems = null;

    /**
     * @var \Doctrine\ORM\PersistentCollection
     * @ORM\ManyToMany(targetEntity="Specialism")
     * @ORM\JoinTable(name="UserInterpretingSpecialisms")
     */
    protected $InterpretingSpecialisms = null;

    /**
     * @var \Doctrine\ORM\PersistentCollection
     * @ORM\ManyToMany(targetEntity="CatTool")
     * @ORM\JoinTable(name="UserTranslationCatTools")
     */
    protected $TranslationCatTools = null;

    /**
     * @var \Doctrine\ORM\PersistentCollection
     * @ORM\ManyToMany(targetEntity="Specialism")
     * @ORM\JoinTable(name="UserTranslationSpecialisms")
     */
    protected $TranslationSpecialisms = null;

    // class variables

    protected $inputFilter;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(){
        return $this->id;
    }

    /**
     *
     * Set group Id
     * @param UserGroup
     */
    public function setGroup(UserGroup $group){
        $this->group = $group;
    }

    /**
     * Set data
     * @param array $arr
     * @return $this
     */
    public function setData(array $arr){
        $keys = array(
            'city',
            'country',
            'currency',
            'createdTime',
            'email',
            'firstName',
            'gender',
            'lastLogin',
            'lastName',
            'password',
            'phone',
        );
        foreach($keys as $key){
            if(isset($arr[$key])){
                $this->$key = $arr[$key];
            }
        }
        return $this;
    }

    /**
     * update data
     * @param array $arr
     * @return $this
     */
    public function updateData(array $arr){
        $keys = array(
            'city',
            'country',
            'currency',
            'firstName',
            'gender',
            'lastName',
            'phone',
            'profileUpdated',
        );
        foreach($keys as $key){
            if(isset($arr[$key])){
                $this->$key = $arr[$key];
            }
        }

        return $this;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    function exchangeArray($data){
        return $this->setData($data);
    }

    // TODO: Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter(){

        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();
            $inputFilter->add($factory->createInput(array(
                'name' => 'lastName',
                'required' => true,
                'validators' => array(
                    array(
                        "name" => "NotEmpty",
                    )
                ),
            )));
            $inputFilter->add($factory->createInput(array(
                'name' => 'firstName',
                'required' => true,
                'validators' => array(
                    array(
                        "name" => "NotEmpty",
                    )
                ),
            )));
            $inputFilter->add($factory->createInput(array(
                'name' => 'email',
                'required' => true,
                'validators' => array(
                    array(
                        "name" => "NotEmpty",
                    ),
                    array(
                        'name' => 'EmailAddress',
                    )
                ),
            )));
            $inputFilter->add($factory->createInput(array(
                'name' => 'phone',
                'required' => true,
                'validators' => array(
                    array(
                        "name" => "NotEmpty",
                    )
                ),
            )));
            $inputFilter->add($factory->createInput(array(
                'name' => 'password',
                'required' => true,
                'validators' => array(
                    array(
                        "name" => "NotEmpty",
                    )
                ),
            )));
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    public function encodePassword($newPassword = null){
        if($newPassword){
            $this->password = $newPassword;
        }
        $passClass = new Password();
        $this->password = $passClass->create_hash($this->password);
        return $this;
    }

    /**
     * Get password hash
     * @return string
     */
    public function getPasswordHash(){
        return $this->password;
    }

    /**
     * Check user is active or not
     * @return boolean
     */
    public function isActivated(){
        return ($this->isActive == True);
    }

    /**
     * Check if user profile is updated
     * @return bool
     */
    public function isProfileUpdated(){
        return $this->profileUpdated;
    }

    /**
     * Get email of user
     * @return mixed
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * @param $token
     * @return bool
     */
    public function isTokenValid($token){
        return $this->token === $token && strlen($token) == 32;
    }

    /**
     * @param string $token
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @return bool
     */
    public function activate($token, $entityManager){
        if($this->isTokenValid($token)){
            $this->token = '';
            $this->isActive = true;
            $entityManager->persist($this);
            $entityManager->flush();
            return true;
        }
        return false;
    }

    /**
     * @param string $token
     * @param string $newPassword
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @return bool
     */
    public function reset($token, $newPassword, $entityManager){
        if($this->isTokenValid($token)){
            $this->token = '';
            $this->encodePassword($newPassword);
            $entityManager->persist($this);
            $entityManager->flush();
            return true;
        }
        return false;
    }

    public function generateToken(){
        $tokenLength = 16;
        $token = time();
        for($i = 0; $i < $tokenLength; $i++){
            $token .= chr(rand(1, 255));
        }
        $this->token = md5($token);
    }

    public function authenticate(){
        $sessionContainer = new Container('user');
        $sessionContainer->user_id = $this->id;
    }

    /**
     * Get current login user id
     * @return int
     */
    static public function currentLoginId(){
        $sessionContainer = new Container('user');
        return $sessionContainer->user_id;
    }

    public function checkPassword($password){
        $passClass = new Password();
        return $passClass->validate_password($password, $this->password);
    }

    /**
     * @param \Application\Controller\AbstractActionController $controller
     */
    public function sendConfirmationEmail($controller){
        $data = array();
        // TODO: initial data for email template
        Mail::sendMail($controller, "register-confirmation", $this->email, $data);
    }

    /**
     * @param \Application\Controller\AbstractActionController $controller
     */
    public function sendWelcomeEmail($controller){
        $data = array();
        // TODO: initial data for email template
        Mail::sendMail($controller, "register-welcome", $this->email, $data);
    }

    /**
     * @param \Application\Controller\AbstractActionController $controller
     */
    public function sendForgotPasswordEmail($controller){
        // initial data for email template
        $forgotLink = $controller->getBaseUrl() . '/user/forgotPassword/reset?token=' . $this->token;
        $data = array(
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'link' => $forgotLink,
        );
        Mail::sendMail($controller, "USER_RESET", $this->email, $data);
    }

    public function getData(){
        return array(
            "city" => $this->city,
            "country" => $this->country,
            'currency' => $this->currency,
            "createdTime" => $this->createdTime,
            "email" => $this->email,
            "firstName" => $this->firstName,
            'gender' => $this->gender,
            "group" => $this->group->getData(),
            "id" => $this->id,
            "isActive" => $this->isActive,
            "lastLogin" => $this->lastLogin,
            "lastName" => $this->lastName,
            "phone" => $this->phone,
            "profileUpdated" => $this->profileUpdated,
            'resources' => Func::getReferenceIds($this->resources),
            'DesktopCatTools' => Func::getReferenceIds($this->DesktopCatTools),
            'DesktopOperatingSystems' => Func::getReferenceIds($this->DesktopOperatingSystems),
            'InterpretingSpecialisms' => Func::getReferenceIds($this->InterpretingSpecialisms),
            'TranslationCatTools' => Func::getReferenceIds($this->TranslationCatTools),
            'TranslationSpecialisms' => Func::getReferenceIds($this->TranslationSpecialisms),
        );
    }

    public function getResources(){
        return $this->resources;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param array $userTranslationCatTools
     */
    public function updateTranslationCatTools($entityManager, $userTranslationCatTools){

        $values = $entityManager->getRepository('\User\Entity\CatTool')->findBy([
            'id' => $userTranslationCatTools
        ]);

        $this->TranslationCatTools->clear();

        foreach($values as $value){
            $this->TranslationCatTools->add($value);
        }
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param array $userTranslationSpecialisms
     */
    public function updateTranslationSpecialisms($entityManager, $userTranslationSpecialisms){

        $values = $entityManager->getRepository('\User\Entity\Specialism')->findBy([
            'id' => $userTranslationSpecialisms
        ]);

        $this->TranslationSpecialisms->clear();

        foreach($values as $value){
            $this->TranslationSpecialisms->add($value);
        }
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param array $userDesktopCatTools
     */
    public function updateDesktopCatTools($entityManager, $userDesktopCatTools){

        $values = $entityManager->getRepository('\User\Entity\CatTool')->findBy([
            'id' => $userDesktopCatTools
        ]);

        $this->DesktopCatTools->clear();

        foreach($values as $value){
            $this->DesktopCatTools->add($value);
        }
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param array $userDesktopOperatingSystems
     */
    public function updateDesktopOperatingSystems($entityManager, $userDesktopOperatingSystems){

        $values = $entityManager->getRepository('\User\Entity\OperatingSystem')->findBy([
            'id' => $userDesktopOperatingSystems
        ]);

        $this->DesktopOperatingSystems->clear();

        foreach($values as $value){
            $this->DesktopOperatingSystems->add($value);
        }
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param array $userInterpretingSpecialisms
     */
    public function updateInterpretingSpecialisms($entityManager, $userInterpretingSpecialisms){

        $values = $entityManager->getRepository('\User\Entity\Specialism')->findBy([
            'id' => $userInterpretingSpecialisms
        ]);

        $this->InterpretingSpecialisms->clear();

        foreach($values as $value){
            $this->InterpretingSpecialisms->add($value);
        }
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function save($entityManager){
        $entityManager->persist($this);
        $entityManager->flush();
    }
}

