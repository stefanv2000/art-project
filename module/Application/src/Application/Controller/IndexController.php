<?php
/**
 * Author Stefan Valea stefanvalea@gmail.com
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Entities\Mapper\ContentMapper;


class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	
        /* @var $adminMapper Entities\Mapper\AdminMapper  */                
        //$adminMapper = $this->getServiceLocator ()->get ( "Entities_AdminMapper" );
        //$adminMapper->insert(array('email' => 'a@a.ro','password' => 'a'));
        /* @var $contentMapper Entities\Mapper\ContentMapper  */
        $contentMapper = $this->getServiceLocator ()->get ( "Entities_ContentMapper" );
		//$contentMapper->generateRandomCaption();
        $config = $this->getServiceLocator()->get('Config');
        //echo $config['uploadmf']['folder']['path'];
        return new ViewModel();
    }
}
