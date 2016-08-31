<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\JsonModel;
use Ifsnop\Mysqldump as IMysqldump;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	/* @var $adminMapper AdminMapper */
    	$adminMapper = $this->getServiceLocator()->get("Entities_AdminMapper");

    	return array('identity' => $this->getIdentityFromAuth());
    }
    
    public function dbbackupAction(){
    	$config = $this->serviceLocator->get('Config');
    	$dbdetails = $config['doctrine']['connection']['orm_default']['params'];
    	//$this->backup_tables($dbdetails['host'], $dbdetails['user'], $dbdetails['password'], $dbdetails['dbname']);
    	
    	
    	try {
    		$dump = new IMysqldump\Mysqldump($dbdetails['dbname'], $dbdetails['user'], $dbdetails['password'],$dbdetails['host']);
    		$dump->start('dbbackup/db-backup-'.time().'.sql');
    	} catch (\Exception $e) {
    		echo 'mysqldump-php error: ' . $e->getMessage();
    	}    	
    	return new JsonModel(array());
    }

    /**
     * Get the current authenticated identity
     * @return mixed|NULL the identity object if it exists, null othewise
     */
    private function getIdentityFromAuth(){
        $auth = new AuthenticationService();
        return $auth->getIdentity();
    }    
}
