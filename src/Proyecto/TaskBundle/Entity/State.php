<?php

namespace Proyecto\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * State
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Proyecto\TaskBundle\Entity\StateRepository")
 */
class State
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
     * @ORM\Column(name="state", type="string", length=60)
     */
    private $state;
    
    /**
     * @ORM\OneToMany(targetEntity="Proyecto\SecurityBundle\Entity\UserProject", mappedBy="state")
     */
    private $userProject;

    
    public function __toString() {
        return $this->state;
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
     * Set state
     *
     * @param string $state
     * @return State
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
     * Constructor
     */
    public function __construct()
    {
        $this->userProject = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add userProject
     *
     * @param \Proyecto\SecurityBundle\Entity\UserProject $userProject
     * @return State
     */
    public function addUserProject(\Proyecto\SecurityBundle\Entity\UserProject $userProject)
    {
        $this->userProject[] = $userProject;
    
        return $this;
    }

    /**
     * Remove userProject
     *
     * @param \Proyecto\SecurityBundle\Entity\UserProject $userProject
     */
    public function removeUserProject(\Proyecto\SecurityBundle\Entity\UserProject $userProject)
    {
        $this->userProject->removeElement($userProject);
    }

    /**
     * Get userProject
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserProject()
    {
        return $this->userProject;
    }
}