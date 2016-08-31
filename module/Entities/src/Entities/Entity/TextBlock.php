<?php
namespace Entities\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 * TextContent entity. Holds text content for the sections
 * @author Stefan Valea stefanvalea@gmail.com
 *
 * @ORM\Entity @ORM\Table(name="textblocks")
 * @ORM\HasLifecycleCallbacks
 */

class TextBlock {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var integer
     */
    protected $id;
    
    /**
     * name of the media file
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */    
    protected $name;
    /**
     * name of the media file
     * @ORM\Column(type="text", nullable=false)
     * @var string
     */    
    protected $content;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var String
     */
    protected $customfield1;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var String
     */
    protected $customfield2;
    
    /**
     * @ORM\Column(type="integer", nullable=false)
     * @var integer
     */    
    protected $status=1;
    
    /**
     * the section that this content belongs to
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="textblocks")
     * @ORM\JoinColumn(name="section_id", referencedColumnName="id",onDelete="CASCADE")
     * @var Section
     */
    protected $section;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $created;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $updated;
    
    /**
     * @ORM\Column(type="integer", nullable=false)
     * @var integer
     */
    protected $sortorder=0;
    

    
    public function __construct(){
        $this->created = $this->updated = new \DateTime("now");
    }

    /**
     * @ORM\PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
    }
        
	/**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

	/**
     * @return the $content
     */
    public function getContent()
    {
        return $this->content;
    }

	/**
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
    }

	/**
     * @return the $section
     */
    public function getSection()
    {
        return $this->section;
    }

	/**
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

	/**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

	/**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

	/**
     * @param number $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

	/**
     * @param \Entities\Entity\Section $section
     */
    public function setSection($section)
    {
        $this->section = $section;
    }
	/**
     * @return the $created
     */
    public function getCreated()
    {
        return $this->created;
    }

	/**
     * @return the $updated
     */
    public function getUpdated()
    {
        return $this->updated;
    }

	/**
     * @return the $sortorder
     */
    public function getSortorder()
    {
        return $this->sortorder;
    }

	/**
     * @param \Entities\Entity\DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

	/**
     * @param \Entities\Entity\DateTime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

	/**
     * @param number $sortorder
     */
    public function setSortorder($sortorder)
    {
        $this->sortorder = $sortorder;
    }

    /**
     * @return String
     */
    public function getCustomfield1()
    {
        return $this->customfield1;
    }

    /**
     * @param String $customfield1
     */
    public function setCustomfield1($customfield1)
    {
        $this->customfield1 = $customfield1;
    }

    /**
     * @return String
     */
    public function getCustomfield2()
    {
        return $this->customfield2;
    }

    /**
     * @param String $customfield2
     */
    public function setCustomfield2($customfield2)
    {
        $this->customfield2 = $customfield2;
    }



    public function toArray(){
        $result = array();
        $result['id'] = $this->getId();
        $result['status'] = $this->getStatus();
        $result['name'] = $this->getName();
        $result['customfield1'] = $this->getCustomfield1();
        $result['customfield'] = $this->getCustomfield2();
        return $result;
    }
        
    
}

?>