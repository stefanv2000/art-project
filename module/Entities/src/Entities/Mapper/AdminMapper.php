<?php

namespace Entities\Mapper;

use Entities\Entity\AdminUser as AdminUser;

class AdminMapper extends AbstractMapper{


	/**
	 * insert a new admin user from the $data
	 * @param array $data should contain keys: email,password. optional:parentid 
	 */
	public function insert($data){
		$adminuser = new AdminUser();
		$adminuser->setEmail($data['email']);
		$adminuser->setPassword($data['password']);
		$adminuser->setName('');
		if (array_key_exists("parentid", $data)){
			$parent = $this->findAdminById($data["parentid"]);
			$parent->addChild($adminuser);
			$adminuser->setParent($parent);
			$this->em->persist($parent);
		}
		
		$this->em->persist($adminuser);		
		$this->em->flush();
	}
	
	/**
	 * find admin user by id
	 * @param integer $admin_id
	 * @return AdminUser|NULL return AdminUser if its found, null otherwise
	 */
	public function findAdminById($admin_id){
		$repository = $this->getRepository("admin");
		return $repository->findOneBy(array("id" => $admin_id));
	}
	
	/**
	 * find admin user by email
	 * @param string $email
	 * @return AdminUser|NULL return AdminUser if its found, null otherwise
	 */
	public function findAdminByEmail($email){
		$repository = $this->getRepository("admin");
		return $repository->findOneBy(array("email" => $email));
		
	}
	
	
}

?>