<?php

namespace Proyecto\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Proyecto\TaskBundle\Entity\ClientRepository")
 */
class Client
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
     * @ORM\Column(name="name", type="string", length=60)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255)
     */
    private $color;
    
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="Proyecto\SecurityBundle\Entity\UserProject")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $userProject;
    
    /*
     * @ORM\OneToMany(targetEntity="Proyecto\TaskBundle\Entity\Task", mappedBy="client")
     */
    private $tasks;
    
    /**
     * @ORM\OneToMany(targetEntity="Proyecto\TaskBundle\Entity\UserTaskClient", mappedBy="client")
     */
    private $userTaskClient;


    public function __toString() {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return Client
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
     * Set color
     *
     * @param string $color
     * @return Client
     */
    public function setColor($color)
    {
        $this->color = $color;
    
        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set userProject
     *
     * @param string $userProject
     * @return Client
     */
    public function setUserProject($userProject)
    {
        $this->userProject = $userProject;
    
        return $this;
    }

    /**
     * Get userProject
     *
     * @return string 
     */
    public function getUserProject()
    {
        return $this->userProject;
    }
    
    /**
     * Set userProject
     *
     * @param string $userTask
     * @return Task
     */
    public function setUserTask($userTask, $user) {
        foreach ($userTask as $userT) {
            $this->addUserTask($userT, $user);
        }
        $this->userTaskClient = $userTask;

        return $this;
    }

    /**
     * Get userTask
     *
     * @return string 
     */
    public function getUserTask() {
        return $this->userTaskClient;
    }
    
    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Client
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
}