<?php

namespace Proyecto\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Priority
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Proyecto\TaskBundle\Entity\PriorityRepository")
 */
class Priority
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
     * @return Priority
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
     * Constructor
     */
    public function __construct()
    {
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add tasks
     *
     * @param \Proyecto\TaskBundle\Entity\Task $tasks
     * @return Priority
     */
    public function addTask(\Proyecto\TaskBundle\Entity\Task $tasks)
    {
        $this->tasks[] = $tasks;
    
        return $this;
    }

    /**
     * Remove tasks
     *
     * @param \Proyecto\TaskBundle\Entity\Task $tasks
     */
    public function removeTask(\Proyecto\TaskBundle\Entity\Task $tasks)
    {
        $this->tasks->removeElement($tasks);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}