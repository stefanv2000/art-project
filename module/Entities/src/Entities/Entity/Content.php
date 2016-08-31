<?php

namespace Entities\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 * Content entity.
 * Holds content like images and videos
 * 
 * @author Stefan Valea stefanvalea@gmail.com
 *        
 *         @ORM\Entity @ORM\Table(name="contents")
 *         @ORM\HasLifecycleCallbacks
 */
class Content {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 * 
	 * @var integer
	 */
	protected $id;
	
	/**
	 * type of the media content.
	 * 1 for image, 2 for video, 3 audio,4 vimeo,5 youtube. default image
	 * @ORM\Column(type="integer", nullable=false)
	 * 
	 * @var integer
	 */
	protected $type = 1;
	
	/**
	 * @ORM\Column(type="integer", nullable=false)
	 * 
	 * @var integer
	 */
	protected $status = 1;
	
	/**
	 * mimetype of the media file
	 * @ORM\Column(type="string", nullable=true)
	 * 
	 * @var string
	 */
	protected $mimetype;
	
	/**
	 * caption of the media file
	 * @ORM\Column(type="string", nullable=true)
	 * 
	 * @var string
	 */
	protected $caption;

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
	 * description of the media file
	 * @ORM\Column(type="text", nullable=true)
	 * 
	 * @var string
	 */
	protected $description;
	
	/**
	 * hashcode of the media file
	 * @ORM\Column(type="string", nullable=false)
	 * 
	 * @var string
	 */
	protected $hashcode;
	
	/**
	 * file format extension
	 * @ORM\Column(type="string", nullable=false)
	 * 
	 * @var string
	 */
	protected $extension;
	
	/**
	 * name of the media file
	 * @ORM\Column(type="string", nullable=false)
	 * 
	 * @var string
	 */
	protected $name;
	
	/**
	 * original name of the media file
	 * @ORM\Column(type="string", nullable=true)
	 * 
	 * @var string
	 */
	protected $originalname;
	
	/**
	 * path where the media file is stored
	 * @ORM\Column(type="string", nullable=false)
	 * 
	 * @var string
	 */
	protected $path = '/';
	
	/**
	 * width of the media content
	 * @ORM\Column(type="integer", nullable=false)
	 * 
	 * @var integer
	 */
	protected $width = 0;
	
	/**
	 * height of the media content
	 * @ORM\Column(type="integer", nullable=false)
	 * 
	 * @var integer
	 */
	protected $height = 0;
	
	/**
	 * cover image
	 * @ORM\OneToOne(targetEntity="Content",cascade={"remove"},orphanRemoval=true)
	 */
	protected $cover;
	
	/**
	 * the section that this content belongs to
	 * @ORM\ManyToOne(targetEntity="Section", inversedBy="contents")
	 * @ORM\JoinColumn(name="section_id", referencedColumnName="id",onDelete="CASCADE")
	 * 
	 * @var Section
	 */
	protected $section;
	
	/**
	 * @ORM\Column(type="integer", nullable=false)
	 * 
	 * @var integer
	 */
	protected $sortorder = 0;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	private $created;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	private $updated;
	public function __construct() {
		$this->created = $this->updated = new \DateTime ( "now" );
	}
	
	/**
	 * @ORM\PreUpdate
	 */
	public function updated() {
		$this->updated = new \DateTime ( "now" );
	}
	/**
	 *
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 *
	 * @return the $type
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 *
	 * @return the $status
	 */
	public function getStatus() {
		return $this->status;
	}
	
	/**
	 *
	 * @return the $mimetype
	 */
	public function getMimetype() {
		return $this->mimetype;
	}
	
	/**
	 *
	 * @return the $caption
	 */
	public function getCaption() {
		return $this->caption;
	}
	
	/**
	 *
	 * @return the $description
	 */
	public function getDescription() {
		return $this->description;
	}
	
	/**
	 *
	 * @return the $hashcode
	 */
	public function getHashcode() {
		return $this->hashcode;
	}
	
	/**
	 *
	 * @return the $extension
	 */
	public function getExtension() {
		return $this->extension;
	}
	
	/**
	 *
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 *
	 * @return the $originalname
	 */
	public function getOriginalname() {
		return $this->originalname;
	}
	
	/**
	 *
	 * @return the $path
	 */
	public function getPath() {
		return $this->path;
	}
	
	/**
	 *
	 * @return the $width
	 */
	public function getWidth() {
		return $this->width;
	}
	
	/**
	 *
	 * @return the $height
	 */
	public function getHeight() {
		return $this->height;
	}
	
	/**
	 *
	 * @return Content the $cover
	 */
	public function getCover() {
		return $this->cover;
	}
	
	/**
	 *
	 * @return the $section
	 */
	public function getSection() {
		return $this->section;
	}
	
	/**
	 *
	 * @return the $sortorder
	 */
	public function getSortorder() {
		return $this->sortorder;
	}
	
	/**
	 *
	 * @return the $created
	 */
	public function getCreated() {
		return $this->created;
	}
	
	/**
	 *
	 * @return the $updated
	 */
	public function getUpdated() {
		return $this->updated;
	}
	
	/**
	 *
	 * @param number $id        	
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 *
	 * @param number $type        	
	 */
	public function setType($type) {
		$this->type = $type;
	}
	
	/**
	 *
	 * @param number $status        	
	 */
	public function setStatus($status) {
		$this->status = $status;
	}
	
	/**
	 *
	 * @param string $mimetype        	
	 */
	public function setMimetype($mimetype) {
		$this->mimetype = $mimetype;
	}
	
	/**
	 *
	 * @param string $caption        	
	 */
	public function setCaption($caption) {
		$this->caption = $caption;
	}
	
	/**
	 *
	 * @param string $description        	
	 */
	public function setDescription($description) {
		$this->description = $description;
	}
	
	/**
	 *
	 * @param string $hashcode        	
	 */
	public function setHashcode($hashcode) {
		$this->hashcode = $hashcode;
	}
	
	/**
	 *
	 * @param string $extension        	
	 */
	public function setExtension($extension) {
		$this->extension = $extension;
	}
	
	/**
	 *
	 * @param string $name        	
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 *
	 * @param string $originalname        	
	 */
	public function setOriginalname($originalname) {
		$this->originalname = $originalname;
	}
	
	/**
	 *
	 * @param string $path        	
	 */
	public function setPath($path) {
		$this->path = $path;
	}
	
	/**
	 *
	 * @param number $width        	
	 */
	public function setWidth($width) {
		$this->width = $width;
	}
	
	/**
	 *
	 * @param number $height        	
	 */
	public function setHeight($height) {
		$this->height = $height;
	}
	
	/**
	 *
	 * @param field_type $cover        	
	 */
	public function setCover($cover) {
		$this->cover = $cover;
	}
	
	/**
	 *
	 * @param \Entities\Entity\Section $section        	
	 */
	public function setSection($section) {
		$this->section = $section;
	}
	
	/**
	 *
	 * @param number $sortorder        	
	 */
	public function setSortorder($sortorder) {
		$this->sortorder = $sortorder;
	}
	
	/**
	 *
	 * @param \DateTime $created        	
	 */
	public function setCreated($created) {
		$this->created = $created;
	}
	
	/**
	 *
	 * @param \DateTime $updated        	
	 */
	public function setUpdated($updated) {
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


	public function toArray() {
		$content = array (
				'id' => $this->getId(),
				'name' => $this->getName (),
				'original' => $this->getOriginalname (),
				'hashcode' => $this->getHashcode (),
				'mimetype' => $this->getMimetype (),
				'extension' => $this->getExtension (),
				'width' => $this->getWidth (),
				'path' => $this->getPath (),
				'height' => $this->getHeight (),
				'type' => $this->getType (),
				'caption' => $this->getCaption (),
				'description' => $this->getDescription (),
				'customfield1' => $this->getCustomfield1(),
				'customfield2' => $this->getCustomfield2(),
		    'status' => $this->getStatus()
		);
		if ($this->cover !== null) $content['cover'] = $this->getCover()->toArray();
		return $content;
	}
}

?>