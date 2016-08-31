<?php
namespace Entities\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Section entity
 * @author Stefan Valea stefanvalea@gmail.com
 *
 * @ORM\Entity
 * @ORM\Table(name="sections")
 * @ORM\HasLifecycleCallbacks
 */

class Section {

    const SECTION_TYPE_PORTFOLIO=0;
    const SECTION_TYPE_TEXT =1;
    const SECTION_TYPE_MOTION =2;
    const SECTION_TYPE_LINK = 3;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var integer
     */
    protected $id;
    
    /**
     * 1 for portfolio 2 for text 3 FOR MOTION 4 for link
     * @ORM\Column(type="integer", nullable=false)
     * @var integer
     */
    protected $type = 1;
    
    /**
     * @ORM\Column(type="integer", nullable=false)
     * @var integer
     */
    protected $status = 1;
        
    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $description;
    
    /**
     * @ORM\Column(type="integer", nullable=false)
     * @var integer
     */
    protected $sortorder=0;
    
    /**
     * @ORM\OneToMany(targetEntity="Section", mappedBy="parent",cascade={"remove"})
     * @var ArrayCollection
     */    
    protected $subsections;

    /**
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="subsections")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * @var Section
     */    
    private $parent;

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
     * 
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Content", mappedBy="section")
     * @ORM\JoinColumn(name="id", referencedColumnName="section_id")
     */    
    protected $contents;
    
    /**
     *
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="TextBlock", mappedBy="section")
     * @ORM\JoinColumn(name="id", referencedColumnName="section_id")
     */    
    protected $textblocks;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $created;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $updated;    
    
    public function __construct(){
        $this->subsections = new ArrayCollection();        
        $this->contents = new ArrayCollection();
        $this->textblocks = new ArrayCollection();
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return ArrayCollection
     */
    public function getSubsections()
    {
        return $this->subsections;
    }

    /**
     * @param ArrayCollection $subsections
     */
    public function setSubsections($subsections)
    {
        $this->subsections = $subsections;
    }

    /**
     * @return Section
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Section $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }
    



    /**
     * adds subsection to the current section
     * @param Section $section
     */
    public function addSubsection(Section $section){
        $this->subsections->add($section);
        $section->setParent($this);
    }
    
    /**
     * add content $content to the current section
     * @param Content $content
     */
    public function addContent(Content $content){
        $this->contents->add($content);
    }
    
    /**
     * add text block $textblock to the current section
     * @param TextBlock $textblock
     */
    public function addTextBlock(TextBlock $textblock){
        $this->textblocks->add($textblock);
    }    
	/**
     * @return ArrayCollection
     */
    public function getContents()
    {
        return $this->contents;
    }

	/**
     * @param \Doctrine\Common\Collections\ArrayCollection $contents
     */
    public function setContents($contents)
    {
        $this->contents = $contents;
    }
	/**
     * @return the $textblocks
     */
    public function getTextblocks()
    {
        return $this->textblocks;
    }

	/**
     * @param \Doctrine\Common\Collections\ArrayCollection $textblocks
     */
    public function setTextblocks($textblocks)
    {
        $this->textblocks = $textblocks;
    }

	/**
     * @return the $sortorder
     */
    public function getSortorder()
    {
        return $this->sortorder;
    }

	/**
     * @param number $sortorder
     */
    public function setSortorder($sortorder)
    {
        $this->sortorder = $sortorder;
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


    
    
    
}

?>