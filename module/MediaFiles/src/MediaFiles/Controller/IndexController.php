<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/MediaFiles for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace MediaFiles\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Entities\Mapper\ContentMapper;
use MediaFiles\Provider\FileContents;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        if ($this->params()->fromRoute('filename')==null){            
            //todo something if the filename not exists, redirect to default file?
        }
        
        $config = $this->serviceLocator->get('Config');
        /* @var $contentMapper ContentMapper */
        $contentMapper = $this->getServiceLocator()->get('Entities_ContentMapper');
        $content = $contentMapper->findContentByHashcode($this->params()->fromRoute('filename'));
        if ($content == null) {
        	//if the file doesn't exists show a default image
        	$fc = new FileContents(
        			array('parameters' => $this->params()->fromRoute(),
        					'details' => array('type' => 1,'width' => 512,'height' => 512,'path' => '/','hashcode' => $this->params()->fromRoute('filename'),'extension' =>$this->params()->fromRoute('extension')),
        					'uploadfolder' => '/img'));
        	$mimetype='image/png';
        } else {
        	$mimetype=$content->getMimetype();
        	$fc = new FileContents(array('parameters' => $this->params()->fromRoute(),'details' => $content->toArray(),'uploadfolder' => $config['uploadmf']['folder']['path']));
        }
        
        
        
        //$fc->getContents();
        //*
        $r = $this->getResponse();
        $r->setContent($fc->getContents()); 
        $r->getHeaders()->addHeaders(
        array('Content-Type'=>$mimetype .'; charset=utf-8'));

        return $r;
        //*/
        return array();
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /index/index/foo
        return array();
    }
}
