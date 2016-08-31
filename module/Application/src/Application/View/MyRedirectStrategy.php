<?php

namespace Application\View;

use BjyAuthorize\View\RedirectionStrategy;
use Zend\Mvc\MvcEvent;
use BjyAuthorize\Guard\Controller;
use BjyAuthorize\Guard\Route;
use Zend\Mvc\Application;
use BjyAuthorize\Exception\UnAuthorizedException;
use Zend\Http\Response;


/**
 * Strategy for the unauthorized routes in byjauthorize module in RedirectStrategy
 * @author Stefan Valea stefanvalea@gmail.com
 *
 */
class MyRedirectStrategy extends RedirectionStrategy{
	//overwrite the redirect route
	protected $redirectRoute = 'user-login';
	
	/**
	 * Handles redirects in case of dispatch errors caused by unauthorized access
	 *
	 * @param \Zend\Mvc\MvcEvent $event
	 */
	public function onDispatchError(MvcEvent $event)
	{
		// Do nothing if the result is a response object
		$result     = $event->getResult();
		$routeMatch = $event->getRouteMatch();
		$response   = $event->getResponse();
		$router     = $event->getRouter();
		$error      = $event->getError();
		$url        = $this->redirectUri;
		//echo $routeMatch->getMatchedRouteName();
		//exit;		
	
		if ($result instanceof Response
		|| ! $routeMatch
		|| ($response && ! $response instanceof Response)
		|| ! (
				Route::ERROR === $error
				|| Controller::ERROR === $error
				|| (
						Application::ERROR_EXCEPTION === $error
						&& ($event->getParam('exception') instanceof UnAuthorizedException)
				)
		)
		) {
			return;
		}

		//save in the session storage the url that was requested to redirect to that url after login
		$sessionManager = $event->getApplication()->getServiceManager()->get('Zend\Session\SessionManager');
		$detailsarray = $sessionManager->getStorage()->toArray();		
		$detailsarray['backlink'] = $event->getRequest()->getUriString();
		$sessionManager->getStorage()->fromArray($detailsarray);
		
	
		if (null === $url) {
			$url = $router->assemble(array(), array('name' => $this->redirectRoute));
		}
	
		$response = $response ?: new Response();
	
		$response->getHeaders()->addHeaderLine('Location', $url);
		$response->setStatusCode(302);
	
		$event->setResponse($response);
	}	
}

?>