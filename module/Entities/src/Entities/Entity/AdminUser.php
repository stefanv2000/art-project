<?php

namespace Entities\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/**
 * Admin user entity
 * @author Stefan Valea stefanvalea@gmail.com
 * 
 * @ORM\Entity @ORM\Table(name="adminusers")
 */
class AdminUser {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 * @var integer
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", nullable=false, unique=true)
	 * @var string
	 */
	protected $email;
	
	/**
	 * @ORM\Column(type="string", nullable=false, unique=true)
	 * @var string
	 */
	protected $password;
	
	/**
	 * @ORM\Column(type="string", nullable=false)
	 * @var string
	 */
	protected $name;
	
	/**
	 * @ORM\OneToMany(targetEntity="AdminUser", mappedBy="parent")
	 * @var ArrayCollection
	 */
	protected $children;
	
	
	/**
	 * @ORM\ManyToOne(targetEntity="AdminUser", inversedBy="children")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
	 * @var AdminUser;
	 */	
	protected $parent;
	
	public function __construct(){
		$this->children = new ArrayCollection();
	}
	
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @return the $password
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @param number $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param string $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @param string $password
	 */
	public function setPassword($password) {
		$this->password = password_hash($password, PASSWORD_BCRYPT);
	}
	/**
	 * @return the $children
	 */
	public function getChildren() {
		return $this->children;
	}

	/**
	 * @return the $parent
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * @param \Doctrine\Common\Collections\ArrayCollection $children
	 */
	public function setChildren($children) {
		$this->children = $children;
	}

	/**
	 * set the parent admin user for this admin user
	 * @param \Entities\Entity\AdminUser; $parent
	 */
	public function setParent($parent) {
		$this->parent = $parent;
	}

	/**
	 * adds a child admin user to this admin user
	 * @param AdminUser $child
	 */
	public function addChild(AdminUser $child){
		$this->children->add($child);
	}
	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}


	
	
}

?>