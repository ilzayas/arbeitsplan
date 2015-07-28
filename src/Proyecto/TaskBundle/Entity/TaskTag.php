<?php

namespace Proyecto\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task_Tag
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Proyecto\TaskBundle\Entity\TaskTagRepository")
 */
class TaskTag
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
     * @ORM\ManyToOne(targetEntity="Tag")
     */
    private $tag;

    /**
     * @ORM\ManyToOne(targetEntity="Task")
     */
    private $task;


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
     * Set tag
     *
     * @param string $tag
     * @return Task_Tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    
        return $this;
    }

    /**
     * Get tag
     *
     * @return string 
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set task
     *
     * @param string $task
     * @return Task_Tag
     */
    public function setTask($task)
    {
        $this->task = $task;
    
        return $this;
    }

    /**
     * Get task
     *
     * @return string 
     */
    public function getTask()
    {
        return $this->task;
    }
}