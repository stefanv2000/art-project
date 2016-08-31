<?php

namespace Login\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Zend\Authentication\AuthenticationService;
use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;
use Facebook\GraphObject;
use Login\Form\LoginForm;
use Login\Form\LoginFormValidator;
use Login\Authentication\CTAuthAdapter;
use Login\Authentication\FacebookAuthAdapter;
use Zend\Authentication\Result;
use Zend\View\Model\JsonModel;



class IndexController extends AbstractActionController
{
    /**
     * login action
     */
    
    public function loginAction() {

		$form = new LoginForm ();
		$request = $this->getRequest ();
		$config = $this->getServiceLocator()->get('Config');		
		
		if ($request->isPost ()) {

			$formValidator = new LoginFormValidator ();
			$form->setInputFilter ( $formValidator->getInputFilter () );
			$form->setData ( $request->getPost () );
			
			if ($form->isValid ()) {
				$authadapter = new CTAuthAdapter ( $this->params()->fromPost ( 'email' ), $this->params()->fromPost ( 'password' ), $this );
				$auth = new AuthenticationService ();
				/* @var $result \Zend\Authentication\Result */
				//try to authenticate through custom adapter
				$result = $auth->authenticate ( $authadapter );

				if (!$result->isValid()){
					//authentication returned a Result with failed code
					$form->get("email")->setMessages(array("Login failed"));
				} else {
					$iden = $result->getIdentity();
					//authentication valid,
					//if there is a link saved in the session storage redirect to it
					/** @var $sessionManager \Zend\Session\SessionManager  */
					$sessionManager = $this->serviceLocator->get('Zend\Session\SessionManager');
					$detailsarray = $sessionManager->getStorage()->toArray();
					
					if (isset($detailsarray['backlink'])) {						
						$backlink = $detailsarray['backlink'];
						unset($detailsarray['backlink']);
						
						$sessionManager->getStorage()->fromArray($detailsarray);
						return $this->redirect()->toUrl($backlink);
						
						
					} 
					//redirect based on identity type user,admin
					switch ($iden['type']) {
						case 'admin': return $this->redirect()->toRoute("admin-index");
					}					
					
					
				}
			}
		}
		
		return array (
				'form' => $form ,
		);
	}
	
	/**
	 * logout action
	 */
	public function logoutAction(){
		//remove identity from the AuthenticationService
		$auth = new AuthenticationService();
		$auth->clearIdentity();
		
		//if there is a redirect link saved in the session storage remove it 
		/** @var $sessionManager Zend\Session\SessionManager  */
		$sessionManager = $this->serviceLocator->get('Zend\Session\SessionManager');
		$detailsarray = $sessionManager->getStorage()->toArray();
			
		if (isset($detailsarray['backlink'])) {
			$backlink = $detailsarray['backlink'];
			unset($detailsarray['backlink']);
		
			$sessionManager->getStorage()->fromArray($detailsarray);
		}
		
		//send a message to redirected page
		$this->flashMessenger()->setNamespace("logout");
		$this->flashMessenger()->addMessage("You've been logged out");
		return $this->redirect()->toRoute("home");
	}
	
}
