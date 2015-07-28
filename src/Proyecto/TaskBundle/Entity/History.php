<?php

namespace Proyecto\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * History
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Proyecto\TaskBundle\Entity\HistoryRepository")
 */
class History
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
     * @ORM\Column(name="action", type="string", length=255)
     */
    private $action;

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
     * @ORM\ManyToOne(targetEntity="Proyecto\SecurityBundle\Entity\UserProject", inversedBy="history")
     * @ORM\JoinColumn(name="userProject_id", referencedColumnName="id")
     */
    private $userProject;

    /**
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="history")
     * @ORM\JoinColumn(name="task_id", referencedColumnName="id")
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
     * Set action
     *
     * @param string $action
     * @return History
     */
    public function setAction($action)
    {
        $this->action = $action;
    
        return $this;
    }

    /**
     * Get action
     *
     * @return string 
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set beginningDate
     *
     * @param \DateTime $beginningDate
     * @return History
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
     * @return History
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
     * Set userProject
     *
     * @param string $userProject
     * @return History
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
     * Set task
     *
     * @param string $task
     * @return History
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