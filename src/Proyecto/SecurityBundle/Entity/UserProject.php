<?php

namespace Proyecto\SecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * UserProject
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Proyecto\SecurityBundle\Entity\UserProjectRepository")
 * @UniqueEntity("username")
 */
class UserProject implements AdvancedUserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=60, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=60)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="beginning_date", type="date")
     */
    private $beginningDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ending_date", type="date", nullable=true)
     */
    private $endingDate;

    /**
     * @var string
     * @Assert\Email()
     *
     * @ORM\Column(name="email", type="string", length=60)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="Proyecto\TaskBundle\Entity\Country", inversedBy="userProject")
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity="Proyecto\TaskBundle\Entity\Rol", inversedBy="userProject")
     */
    private $rol;

    /**
     * @ORM\ManyToOne(targetEntity="Proyecto\TaskBundle\Entity\State", inversedBy="userProject")
     */
    private $state;
    
    
    /*
     * @ORM\OneToMany(targetEntity="Proyecto\TaskBundle\Entity\UserTaskClient", mappedBy="user")
     */
    private $userTask;
    
    /*
     * @ORM\OneToMany(targetEntity="Proyecto\TaskBundle\Entity\Client", mappedBy="userProyect")
     */
    private $clients;
    
    /*
     * @ORM\OneToMany(targetEntity="Proyecto\TaskBundle\Entity\Task", mappedBy="users")
     */
    private $tasks;
    
    /**
     * @ORM\OneToMany(targetEntity="Proyecto\TaskBundle\Entity\History", mappedBy="userProject")
     */
    private $history;
    
    /**
     * @ORM\Column(type="string", length=32)
     */
    private $salt;
    
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->history = new \Doctrine\Common\Collections\ArrayCollection();
        
        //esto lo agregue para probar que se loguea
        //http://stackoverflow.com/questions/16638017/symfony2-cant-login-bad-credentials
        $this->isActive = true;
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16,36);
    }
    
    public function __toString() 
    {
        return $this->username;
    }
    
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }
    
    public function isEnabled()
    {
        return $this->isActive;
    }
    
    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        //return $this->rol;
         //return array('ROLE_USER');
         return explode(' ', $this->rol);
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return UserProject
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return UserProject
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return UserProject
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set beginningDate
     *
     * @param \DateTime $beginningDate
     * @return UserProject
     */
    public function setBeginningDate($beginningDate)
    {
        $this->beginningDate = $beginningDate;
    
        return $this;
    }

    /**
     * Get beginningDate
     *
     * @return \DateTime 
     */
    public function getBeginningDate()
    {
        return $this->beginningDate;
    }

    /**
     * Set endingDate
     *
     * @param \DateTime $endingDate
     * @return UserProject
     */
    public function setEndingDate($endingDate)
    {
        $this->endingDate = $endingDate;
    
        return $this;
    }

    /**
     * Get endingDate
     *
     * @return \DateTime 
     */
    public function getEndingDate()
    {
        return $this->endingDate;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return UserProject
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return UserProject
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set rol
     *
     * @param string $rol
     * @return UserProject
     */
    public function setRol($rol)
    {
        $this->rol = $rol;
    
        return $this;
    }

    /**
     * Get rol
     *
     * @return string 
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return UserProject
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }
    
    /**
     * Add history
     *
     * @param \Proyecto\TaskBundle\Entity\History $history
     * @return UserProject
     */
    public function addHistory(\Proyecto\TaskBundle\Entity\History $history, $action, $bdate, $edate, $user, $task)
    {
        $history->setTask($task);
        $history->setAction($action);
        $history->setBeginningDate($bdate);
        $history->setEndingDate($edate);
        $history->setUserProject($user);
        $this->history[] = $history;
    
        return $this;
    }

    /**
     * Remove history
     *
     * @param \Proyecto\TaskBundle\Entity\History $history
     */
    public function removeHistory(\Proyecto\TaskBundle\Entity\History $history)
    {
        $this->history->removeElement($history);
    }

    /**
     * Get history
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHistory()
    {
        return $this->history;
    }
    
    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    
    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;            
        return $this;
    }
    
    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return $this->salt;
    }
    
    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
    
     /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,));
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,) = unserialize($serialized);
    }
    
}