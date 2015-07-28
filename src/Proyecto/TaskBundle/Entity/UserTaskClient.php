<?php

namespace Proyecto\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User_Task
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Proyecto\TaskBundle\Entity\UserTaskClientRepository")
 */
class UserTaskClient
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
     * @ORM\ManyToOne(targetEntity="Proyecto\SecurityBundle\Entity\UserProject")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Proyecto\TaskBundle\Entity\Task", inversedBy="userTask")
     */
    private $task;
    
    /**
     * @ORM\ManyToOne(targetEntity="Proyecto\TaskBundle\Entity\Client", inversedBy="userTaskClient")
     */
    private $client;


    public function toArray(){
        return $this;
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
     * Set user
     *
     * @param string $user
     * @return User_Task
     */
    public function setUser($user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set task
     *
     * @param string $task
     * @return User_Task
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
    
    /**
     * Set user
     *
     * @param string $client
     * @return User_Task_Client
     */
    public function setClient($client)
    {
        $this->client = $client;
    
        return $this;
    }

    /**
     * Get client
     *
     * @return string 
     */
    public function getClient()
    {
        return $this->client;
    }
}