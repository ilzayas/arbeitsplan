<?php

namespace Proyecto\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;


/**
 * Task
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Proyecto\TaskBundle\Entity\TaskRepository")
 */
class Task {

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
     * @var \DateTime
     *
     * @ORM\Column(name="beginning_date", type="date", nullable=true)
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
     *
     * @ORM\Column(name="notas", type="string", length=255, nullable=true)
     */
    private $notas;
    
    /**
     * @var string
     *
     * @ORM\Column(name="teil", type="string", length=255, nullable=true)
     */
    private $teil;

    /**
     * @ORM\OneToMany(targetEntity="History", mappedBy="task")
     */
    private $history;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     */
    private $client;
    
    /**
     * @ORM\ManyToOne(targetEntity="Proyecto\SecurityBundle\Entity\UserProject")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var ArrayCollection users
     */
    private $users;

    /*
     * @ORM\OneToMany(targetEntity="Proyecto\TaskBundle\Entity\TaskTag", mappedBy="task")
     */
    protected $tags;

    /**
     * @ORM\OneToMany(targetEntity="Proyecto\TaskBundle\Entity\UserTaskClient", mappedBy="task")
     */
    private $userTask;

    /**
     * @var boolean
     *
     * @ORM\Column(name="erledig", type="boolean", length=1, nullable=true)
     */
    private $erledig;
    
    /**
     * @ORM\OneToMany(targetEntity="Proyecto\TaskBundle\Entity\Document", mappedBy="task")
     */
    private $file;
    
    /**
     * @var string
     *
     * @ORM\Column(name="kontaktPerson", type="string", length=255, nullable=true)
     */
    private $kontaktPerson;
    
    /**
     * @var string
     *
     * @ORM\Column(name="hpNummer", type="string", length=255, nullable=true)
     */
    private $hpNummer;
    
    /**
     * @var string
     *
     * @ORM\Column(name="lieferant", type="string", length=255, nullable=true)
     */
    private $lieferant;
    
    /**
     * @var string
     *
     * @ORM\Column(name="beiLieferantAngefragt", type="string", length=255, nullable=true)
     */
    private $beiLieferantAngefragt;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ekPreis", type="string", length=255, nullable=true)
     */
    private $ekPreis;
    
    /**
     * @var string
     *
     * @ORM\Column(name="angebotErstellt", type="string", length=255, nullable=true)
     */
    private $angebotErstellt;
    
    /**
     * @var string
     *
     * @ORM\Column(name="angebotzuKunden", type="string", length=255, nullable=true)
     */
    private $angebotZuKunden;
    
    /**
     * @var string
     *
     * @ORM\Column(name="kundeBestellt", type="string", length=255, nullable=true)
     */
    private $kundeBestellt;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nichtMoglich", type="string", length=255, nullable=true)
     */
    private $nichtMoglich;

    /**
     * @var UploadedFile
     * @Assert\File(maxSize="6000000")
     * @ORM\Column(name="attachment", nullable=true)
     */
//    private $attachment;

    /**
     * @var string
     *
     * @ORM\Column(name="attachment_path", type="string", length=255, nullable=true)
     */
//    private $attachment_path;

    /**
     * Sets attachment.
     *
     * @param  $file
     */
//    public function setAttachment($file) {
//        $this->attachment = $file;
//    }

    /**
     * Get attachment.
     *
     * @return UploadedFile
     */
//    public function getAttachment() {
//        return $this->attachment;
//    }

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
     * @return Task
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
     * Set beginningDate
     *
     * @param \DateTime $beginningDate
     * @return Task
     */
    public function setBeginningDate($beginningDate) {
        $this->beginningDate = $beginningDate;

        return $this;
    }

    /**
     * Get beginningDate
     *
     * @return \DateTime 
     */
    public function getBeginningDate() {
        return $this->beginningDate;
    }

    /**
     * Set endingDate
     *
     * @param \DateTime $endingDate
     * @return Task
     */
    public function setEndingDate($endingDate) {
        $this->endingDate = $endingDate;

        return $this;
    }

    /**
     * Get endingDate
     *
     * @return \DateTime 
     */
    public function getEndingDate() {
        return $this->endingDate;
    }

    /**
     * Set notas
     *
     * @param string $notas
     * @return Task
     */
    public function setNotas($notas) {
        $this->notas = $notas;

        return $this;
    }

    /**
     * Get notas
     *
     * @return string 
     */
    public function getNotas() {
        return $this->notas;
    }

    /**
     * Set tags
     *
     * @param string $tag
     * @return Task
     */
    public function setTags($tag) {
        $this->tags = $tag;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string 
     */
    public function getTags() {
        return $this->tags;
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
        $this->userTask = $userTask;

        return $this;
    }

    /**
     * Get userTask
     *
     * @return string 
     */
    public function getUserTask() {
        return $this->userTask;
    }

    /**
     * Add userProject
     *
     * @param \Proyecto\TaskBundle\Entity\User_Task $userTask
     * @return Task
     */
    public function addUserTaskClient(\Proyecto\TaskBundle\Entity\UserTaskClient $userTask) {
        $userTask->setTask($this);
        //$userTask->setClient($client);
        
        $this->userTask[] = $userTask;
    }

    /**
     * Remove userProject
     *
     * @param \Proyecto\TaskBundle\Entity\User_Task $userTask
     */
    public function removeUserTask(\Proyecto\TaskBundle\Entity\UserTaskClient $userTask) {
        $this->userTask->removeElement($userTask);
    }

    /**
     * Set history
     *
     * @param string $history
     * @return Task
     */
    public function setHistory($history) {
        $this->history = $history;

        return $this;
    }

    /**
     * Get history
     *
     * @return string 
     */
    public function getHistory() {
        return $this->history;
    }

    /**
     * Set priority
     *
     * @param string $priority
     * @return Task
     */
//    public function setPriority($priority) {
//        $this->priority = $priority;
//
//        return $this;
//    }

    /**
     * Get priority
     *
     * @return string 
     */
//    public function getPriority() {
//        return $this->priority;
//    }

    /**
     * Set client
     *
     * @param string $client
     * @return Task
     */
    public function setClient($client) {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return string 
     */
    public function getClient() {
        return $this->client;
    }
    
    /**
     * Set users
     *
     * @param string $user
     * @return Task
     */
    public function setUsers($user) {
        $this->users = $user;

        return $this;
    }

    /**
     * Get users
     *
     * @return Doctrine\Common\Collections\ArrayCollection 
     */
    public function getUsers() { //probando para el editar tarea que da bateo con el array de usuarios
        return $this->users;
    }
    
    /**
     * Set usersfile
     * @param string $file
     * @return Task
     */
    public function setFile($file) {
        $this->file = $file;

        return $this;
    }
    
    public function addFile(\Proyecto\TaskBundle\Entity\Document $doc) {
        
        $this->file[] = $doc;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * Set erledig
     *
     * @param boolean $erledig
     * @return Task
     */
    public function setErledig($erledig) {
        $this->erledig = $erledig;

        return $this;
    }

    /**
     * Get erledig
     *
     * @return boolean 
     */
    public function getErledig() {
        return $this->erledig;
    }
    
    /**
     * Set notas
     *
     * @param string $teil
     * @return Task
     */
    public function setTeil($teil) {
        $this->teil = $teil;

        return $this;
    }

    /**
     * Get teil
     *
     * @return string 
     */
    public function getTeil() {
        return $this->teil;
    }
    
    /**
     * Set kontaktPerson
     *
     * @param string $kontak
     * @return Task
     */
    public function setKontaktPerson($kontak) {
        $this->kontaktPerson = $kontak;

        return $this;
    }

    /**
     * Get kontaktPerson
     *
     * @return string 
     */
    public function getKontaktPerson() {
        return $this->kontaktPerson;
    }
    
     /**
     * Set hpNummer
     *
     * @param string $nummer
     * @return Task
     */
    public function setHpNummer($nummer) {
        $this->hpNummer = $nummer;

        return $this;
    }

    /**
     * Get teil
     *
     * @return string 
     */
    public function getHpNummer() {
        return $this->hpNummer;
    }
    
     /**
     * Set nlieferant
     *
     * @param string $lieferant
     * @return Task
     */
    public function setLieferant($lieferant) {
        $this->lieferant = $lieferant;

        return $this;
    }

    /**
     * Get lieferant
     *
     * @return string 
     */
    public function getLieferant() {
        return $this->lieferant;
    }
    
     /**
     * Set beiLieferantAngefragt
     *
     * @param string $beiLieferantAngefragt
     * @return Task
     */
    public function setBeiLieferantAngefragt($beiLieferantAngefragt) {
        $this->beiLieferantAngefragt = $beiLieferantAngefragt;

        return $this;
    }

    /**
     * Get beiLieferantAngefragt
     *
     * @return string 
     */
    public function getBeiLieferantAngefragt() {
        return $this->beiLieferantAngefragt;
    }
    
    /**
     * Set ekPreis
     *
     * @param string $ekPreis
     * @return Task
     */
    public function setEkPreis($ekPreis) {
        $this->ekPreis = $ekPreis;

        return $this;
    }

    /**
     * Get beiLieferantAngefragt
     *
     * @return string 
     */
    public function getEkPreis() {
        return $this->ekPreis;
    }
    
    /**
     * Set angebotErstellt
     *
     * @param string $angebotErstellt
     * @return Task
     */
    public function setAngebotErstellt($angebotErstellt) {
        $this->angebotErstellt = $angebotErstellt;

        return $this;
    }

    /**
     * Get angebotErstellt
     *
     * @return string 
     */
    public function getAngebotErstellt() {
        return $this->angebotErstellt;
    }
    
    /**
     * Set angebotZuKunden
     *
     * @param string $angebotZuKunden
     * @return Task
     */
    public function setAngebotZuKunden($angebotZuKunden) {
        $this->angebotZuKunden = $angebotZuKunden;

        return $this;
    }

    /**
     * Get angebotZuKunden
     *
     * @return string 
     */
    public function getAngebotZuKunden() {
        return $this->angebotZuKunden;
    }
    
    /**
     * Set kundeBestellt
     *
     * @param string $kundeBestellt
     * @return Task
     */
    public function setKundeBestellt($kundeBestellt) {
        $this->kundeBestellt = $kundeBestellt;

        return $this;
    }

    /**
     * Get kundeBestellt
     *
     * @return string 
     */
    public function getKundeBestellt() {
        return $this->kundeBestellt;
    }
    
    /**
     * Set nichtMoglich
     *
     * @param string $nichtMoglich
     * @return Task
     */
    public function setNichtMoglich($nichtMoglich) {
        $this->nichtMoglich = $nichtMoglich;

        return $this;
    }

    /**
     * Get nichtMoglich
     *
     * @return string 
     */
    public function getNichtMoglich() {
        return $this->nichtMoglich;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->history = new ArrayCollection();
        $this->userTask = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->file = new ArrayCollection();
       // $this->users = new ArrayCollection();
    }

    /**
     * Add history
     *
     * @param \Proyecto\TaskBundle\Entity\History $history
     * @return Task
     */
    public function addHistory(\Proyecto\TaskBundle\Entity\History $history, $action, $bdate, $edate, $user) {
        $history->setTask($this);
        $history->setAction($action);
        $history->setBeginningDate($bdate);
        $history->setEndingDate($edate);
        $history->setUserProject($user);
        $this->history[] = $history;
    }

    /**
     * Remove history
     *
     * @param \Proyecto\TaskBundle\Entity\History $history
     */
    public function removeHistory(\Proyecto\TaskBundle\Entity\History $history) {
        $this->history->removeElement($history);
    }

    /**
     * Add tags
     *
     * @param \Proyecto\TaskBundle\Entity\TaskTag $tags
     * @return Task
     */
    public function addTag(\Proyecto\TaskBundle\Entity\TaskTag $tags) {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Proyecto\TaskBundle\Entity\TaskTag $tags
     */
    public function removeTag(\Proyecto\TaskBundle\Entity\TaskTag $tags) {
        $this->tags->removeElement($tags);
    }
    
    

    /*
     * **************************************para archivos******************************************************************************
     */

    /**
     * Get path for attachment
     *
     * @param string $type Can return web path, or absolute path, web is default
     * @return null|string
     */
//    public function getAttachmentPath($type = 'web') {
//        if ($type == 'absolute') {
//            return null === $this->attachment_path ? null : $this->getUploadRootDir() . '/' . $this->attachment_path;
//        } else {
//            return null === $this->attachment_path ? null : $this->getUploadDir() . '/' . $this->attachment_path;
//        }
//    }
//
//    protected function getUploadRootDir() {
//        // the absolute directory path where uploaded
//        // documents should be saved
//        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
//    }
//
//    protected function getUploadDir() {
//        // get rid of the __DIR__ so it doesn't screw up
//        // when displaying uploaded doc/image in the view.
//        return 'uploads/invoice/attachments';
//    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
//    public function preUpload() {
//        if (null !== $this->attachment) {
//            // do whatever you want to generate a unique name
//            //$filename = sha1(uniqid(mt_rand(), true));
//            $filename = $this->attachment->getFilename();
//            //$this->attachment = $filename.'.'.$this->attachment->guessExtension();
//            $this->attachment_path = $filename . '.' . $this->attachment->guessExtension();
//        }
//    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
//    public function upload() {
//        if ($this->attachment === null) {
//            return;
//        }
//
//        // if there is an error when moving the file, an exception will
//        // be automatically thrown by move(). This will properly prevent
//        // the entity from being persisted to the database on error
//        $this->attachment->move($this->getUploadRootDir(), $this->attachment_path);
//
//        unset($this->attachment);
//    }

    /**
     * @ORM\PostRemove()
     */
//    public function removeUpload() {
//        if ($file = $this->getAttachmentPath('absolute')) {
//            unlink($file);
//        }
//    }

    /*
     * ********************************************************************************************************************************
     */
    
    public function __toString() {
        return $this->name;
    }
}
