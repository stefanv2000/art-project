<?php
/**
 */

namespace Frontend\Controller;

use Entities\Entity\Section;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Helper\ViewModel;
use Zend\View\Model\JsonModel;
use Frontend\Forms\ContactFormValidator;


class IndexController extends AbstractActionController
{
    public function indexAction()
    {

    	return new ViewModel();	
    }
    


    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /index/index/foo
        return array();
	}

	/**
	 * action to retrieve the project details
	 * @return JsonModel
	 */
	public function apiprojectAction()
	{
		/* @var $sectionMapper  \Entities\Mapper\SectionMapper */
		$sectionMapper = $this->getServiceLocator()->get('Entities_SectionMapper');
		$project = array();
		$projectSection = $sectionMapper->findSectionById($this->params()->fromRoute('id'));
		if ($projectSection != null) {
			$projectcategory = "albums";
			//if ($projectsection->getParent()!=null) $projectcategory = $projectsection->getParent()->getName();
			$project = array_merge($project, array('name' => $projectSection->getName(),
				'id' => $projectSection->getId(),
				'slug' => '/portfolio/' . $projectSection->getName() . '/' . $projectSection->getId(),
				'backslug' => '/portfolio/' . $projectSection->getName() . '/' . $projectSection->getId(),

				'category' => $projectSection->getParent()->getName(),
				'categoryslug' => '/still/' . $projectSection->getParent()->getParent()->getName() . '/' . $projectSection->getParent()->getParent()->getId(),
				'color' => $projectSection->getParent()->getCustomfield1(),
			));
		}

		$images = $sectionMapper->getSectionEnabledContent($projectSection->getId());

		return new JsonModel(array(
				'portfolio' => $project,
				'content' => $images,
			)
		);
	}

	/**
	 * action to retrieve the motion project details
	 * @return JsonModel
	 */
	public function apiprojectmotionAction(){
		/* @var $sectionMapper  \Entities\Mapper\SectionMapper */
		$sectionMapper = $this->getServiceLocator()->get('Entities_SectionMapper');
		$project = array();
		$projectSection = $sectionMapper->findSectionById($this->params()->fromRoute('id'));
		if ($projectSection!=null){
			$projectcategory = "motion";
			//if ($projectsection->getParent()!=null) $projectcategory = $projectsection->getParent()->getName();
			$project = array_merge($project,array('name' => $projectSection->getName(),
				'id' => $projectSection->getId(),
				'slug' => '/motion/'.$projectSection->getName().'/'.$projectSection->getId(),
				'category' => $projectSection->getParent()->getName(),
				'categoryslug' => '/motion/'.$projectSection->getParent()->getName().'/'.$projectSection->getParent()->getId(),
				'backslug' => '/motion/'.$projectSection->getParent()->getName().'/'.$projectSection->getParent()->getId(),
				'color' => $projectSection->getCustomfield1(),
			));
		}

		$images = $sectionMapper->getSectionEnabledContent($projectSection->getId());

		return new JsonModel(array(
				'portfolio' => $project,
				'content' =>$images,
			)
		);
	}

	/**
	 * action to retrieve the details about still page
	 */
	public function apimainstillAction(){
		/* @var $sectionMapper  \Entities\Mapper\SectionMapper */
		$sectionMapper = $this->getServiceLocator()->get('Entities_SectionMapper');
		$stillSection = $sectionMapper->findSectionById($this->params()->fromRoute('id'));
		$arrayStill = array();
		if (($stillSection === null)||($stillSection->getType()!==Section::SECTION_TYPE_PORTFOLIO)) return new JsonModel($arrayStill);

		$arrayStill['name'] = $stillSection->getName();
		$arrayStill['categories'] = array();

		$mainsubsection = $sectionMapper->findSectionsWithParent($this->params()->fromRoute('id'));
		/* @var $subsection \Entities\Entity\Section */
		foreach ($mainsubsection as $subsection){
			$tempArray = array();
			$tempArray['name'] = $subsection->getName();
			$tempArray['color'] = $subsection->getCustomfield1();
			$tempArray['projects'] = array();
			$portfolios = $subsection->getSubsections();
			/* @var $project \Entities\Entity\Section */
			foreach ($portfolios as $project) {
				$projectTemp = array();
				$projectTemp['name'] = $project->getName();
				$projectTemp['id'] = $project->getId();
				$projectTemp['slug'] = '/portfolio/'.$project->getName().'/'.$project->getId();
				$contentIterator = $project->getContents()->getIterator();
				if ($contentIterator->offsetExists(0)){
					/* $coverContent  \Entities\Entity\Content */
					$coverContent = $contentIterator->offsetGet(0);
					$projectTemp['cover'] = $coverContent->toArray();
				}
				$tempArray['projects'][] = $projectTemp;
			}

			$arrayStill['categories'][]=$tempArray;
		}
		return new JsonModel($arrayStill);
	}


	/**
	 * action to retrieve the details about motion page
	 */
	public function apimainmotionAction(){
		/* @var $sectionMapper  \Entities\Mapper\SectionMapper */
		$sectionMapper = $this->getServiceLocator()->get('Entities_SectionMapper');
		$motionSection = $sectionMapper->findSectionById($this->params()->fromRoute('id'));
		$arrayMotion = array();
		if (($motionSection === null)||($motionSection->getType()!==Section::SECTION_TYPE_MOTION)) return new JsonModel($arrayMotion);

		$arrayMotion['name'] = $motionSection->getName();
		$arrayMotion['projects'] = array();

		$mainsubsection = $sectionMapper->findSectionsWithParent($this->params()->fromRoute('id'));
		/* @var $project \Entities\Entity\Section */
		foreach ($mainsubsection as $project){
			$tempArray = array();
			$tempArray['name'] = $project->getName();
			$tempArray['color'] = $project->getCustomfield1();
			$tempArray['id'] = $project->getId();
			$tempArray['slug'] = '/motion/'.$project->getName().'/'.$project->getId();
			$tempArray['content'] = $sectionMapper->getSectionEnabledContent($project->getId());

			$arrayMotion['projects'][]=$tempArray;
		}
		return new JsonModel($arrayMotion);
	}
    
    public function apipageAction(){
    	/* @var $sectionMapper  \Entities\Mapper\SectionMapper */
    	$sectionMapper = $this->getServiceLocator()->get('Entities_SectionMapper');    	
    	
    	$pagesection = $sectionMapper->findSectionByNameFromParent($this->params()->fromRoute('id'), null);
    	$page = array();
    	if ($pagesection!= null){
    		$page = array_merge($page,array(
    				'id' => $pagesection->getId(),
    				'name' => $pagesection->getName(),
    				'slug' => $pagesection->getName(),
					'color' => $pagesection->getCustomfield1(),
    		));
    	}
    	
    	$textblocks = $sectionMapper->getSectionTextBlocks($pagesection->getId());
    	$textblocks = array_map(function($element){ $element['content'] = $this->emailize($element['content']);return $element;}, $textblocks);
    	
    	$coverarray = array();
    	$coversection = $sectionMapper->findSectionByNameFromParent("cover", $pagesection->getId());
    	if ($coversection!=null){
    		$coverarray = $sectionMapper->getSectionEnabledContent($coversection->getId());
    	}    	
    	
    	$images = $sectionMapper->getSectionEnabledContent($pagesection->getId());
    	
    	return new JsonModel(array(
    			'page' => $page,
    			'textblocks' =>$textblocks,
    			'content' => $images,
    			'cover' => $coverarray)
    	);    	
    }
    
    public function apiintroAction(){
    	/* @var $sectionMapper  \Entities\Mapper\SectionMapper */
    	$sectionMapper = $this->getServiceLocator()->get('Entities_SectionMapper');

		$arrayResult = array();
		$sectionsIntro = $sectionMapper->findSectionsWithParent(0);
		/* @var $sectionIntro \Entities\Entity\Section */
		foreach ($sectionsIntro as $sectionIntro){
			if ($sectionIntro->getStatus() === 0) continue;
			if (($sectionIntro->getType()!==Section::SECTION_TYPE_PORTFOLIO)&&($sectionIntro->getType()!==Section::SECTION_TYPE_MOTION)) continue;
			$arrTemp = array();
			$arrTemp['name'] = $sectionIntro->getName();
			$arrTemp['color'] = $sectionIntro->getCustomfield1();
			$sectioncategory = 'still';
			if ($sectionIntro->getType() == Section::SECTION_TYPE_MOTION) $sectioncategory='motion';
			$arrTemp['slug'] = '/'.$sectioncategory.'/'.$sectionIntro->getName().'/'.$sectionIntro->getId();
			$contentIterator = $sectionIntro->getContents()->getIterator();
			if ($contentIterator->offsetExists(0)){
				/* $coverContent  \Entities\Entity\Content */
				$coverContent = $contentIterator->offsetGet(0);
				$arrTemp['cover'] = $coverContent->toArray();
			}
			$arrayResult[]=$arrTemp;
			//$arrTemp['cover']
		}
    	 

    	 
    	return new JsonModel($arrayResult);
    }    
    
    public function apisendcontactAction(){
    	$contactvalidator = new ContactFormValidator();
    	$contactvalidator->getInputFilter()->setData($this->params()->fromQuery());
    	if ($contactvalidator->getInputFilter()->isValid())
    	//$valuestobesent = $contactvalidator->getInputFilter()->getValues();
    	return new JsonModel(array('code' => '1')); else {
    		print_r($contactvalidator->getInputFilter()->getMessages());
    		return new JsonModel(array('code' => '2')); 
    	}
    }
    
    function emailize($text)
    {
/*     	$regex = '/(\S+@\S+\.\S+)/';
    	$replace = '<a href="mailto:$1">$1</a>';
    echo preg_replace($regex, $replace, $text);
 */    $mail_pattern = "/([A-z0-9_-]+\@[A-z0-9_-]+\.)([A-z0-9\_\-\.]{1,}[A-z])/";
    
    $str = preg_replace($mail_pattern, '<a href="mailto:$1$2">$1$2</a>', $text);
    
    return $str;
    	//return preg_replace($regex, $replace, $text);
    }
    
}
