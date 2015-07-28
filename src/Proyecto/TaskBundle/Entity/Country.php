<?php

namespace Proyecto\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Proyecto\TaskBundle\Entity\CountryRepository")
 */
class Country {

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
     * @ORM\Column(name="code", type="string", length=60)
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity="Proyecto\SecurityBundle\Entity\UserProject", mappedBy="country")
     */
    private $userProject;

    public function __toString() {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Country
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Country
     */
    public function setCode($code) {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->userProject = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add userProject
     *
     * @param \Proyecto\SecurityBundle\Entity\UserProject $userProject
     * @return Country
     */
    public function addUserProject(\Proyecto\SecurityBundle\Entity\UserProject $userProject) {
        $this->userProject[] = $userProject;

        return $this;
    }

    /**
     * Remove userProject
     *
     * @param \Proyecto\SecurityBundle\Entity\UserProject $userProject
     */
    public function removeUserProject(\Proyecto\SecurityBundle\Entity\UserProject $userProject) {
        $this->userProject->removeElement($userProject);
    }

    /**
     * Get userProject
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserProject() {
        return $this->userProject;
    }

}