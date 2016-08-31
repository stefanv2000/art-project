<?php

namespace Frontend\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Entities;
use Zend\View\Model\JsonModel;

class MenuController extends AbstractRestfulController {
	public function get($id){
		/* @var $sectionMapper  Entities\Mapper\SectionMapper */
		$sectionMapper = $this->getServiceLocator()->get("Entities_SectionMapper");
		
		$mainsections = $sectionMapper->findSectionsWithParent(null);
		
		/* @var $section Entities\Entity\Section */
		foreach ($mainsections as $section){
			if ($section->getStatus() == 0) continue;
			if ($section->getName() == "portfolios"){
				/* @var $portfoliosection Entities\Entity\Section */
				foreach ($section->getSubsections() as $portfoliosection) {
					if ($portfoliosection->getStatus() == 0) continue;
					$temps = array();
					$temps['id'] = $portfoliosection->getId();
					$temps['slug'] = 'portfolio/'.$this->slugify($portfoliosection->getName()).'/'.$portfoliosection->getId();
					$temps['name'] = $portfoliosection->getName();
					if ($portfoliosection->getId() == $id) return new JsonModel($temps);
				}
				continue;
			}
			$temps = array();
			$temps['id'] = $section->getId();
			$temps['slug'] = $this->slugify($section->getName());
			$temps['name'] = $section->getName();
			if ($section->getId() == $id) return new JsonModel($temps);
		}
		
		return new JsonModel(array());		
	}
	public function getList(){
		/* @var $sectionMapper  Entities\Mapper\SectionMapper */
		$sectionMapper = $this->getServiceLocator()->get("Entities_SectionMapper");

		$mainsections = $sectionMapper->findSectionsWithParent(null);
		
		$menuAr = array();
		
		/* @var $section Entities\Entity\Section */ 
		foreach ($mainsections as $section){
			if ($section->getStatus() == 0) continue;			
			if ($section->getName() == "portfolios"){
				/* @var $portfoliosection Entities\Entity\Section */
				foreach ($section->getSubsections() as $portfoliosection) {
					if ($portfoliosection->getStatus() == 0) continue;
					$temps = array();
					$temps['id'] = $portfoliosection->getId();
					$temps['slug'] = 'portfolio/'.$this->slugify($portfoliosection->getName()).'/'.$portfoliosection->getId();
					$temps['name'] = $portfoliosection->getName();
					$menuAr[] = $temps;
				}
				continue;
			} 
			$temps = array();
			$temps['id'] = $section->getId();
			$temps['slug'] = $this->slugify($section->getName());
			$temps['name'] = $section->getName();
			$menuAr[] = $temps;
		}
		
		return new JsonModel($menuAr);
	}
	
	protected function slugify($string)
	{
		$slug = trim($string); // trim the string
		$slug = preg_replace('/[^a-zA-Z0-9 -]/', '', $slug); // only take alphanumerical characters, but keep the spaces and dashes too...
		$slug = str_replace(' ', '-', $slug); // replace spaces by dashes
		$slug = strtolower($slug);  // make it lowercase
		return $slug;
	}	
}

?>