<?php

namespace Proyecto\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rol
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Proyecto\TaskBundle\Entity\RolRepository")
 */
class Rol
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
     * @ORM\Column(name="rol", type="string", length=60)
     */
    private $rol;
    
    /**
     * @ORM\OneToMany(targetEntity="Proyecto\SecurityBundle\Entity\UserProject", mappedBy="rol")
     */
    private $userProject;
    
    public function __toString() {
        return $this->rol;
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
     * Set rol
     *
     * @param string $rol
     * @return Rol
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
     * @return Rol
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