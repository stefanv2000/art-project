<?php

namespace Frontend\View\Helper;
use Entities\Entity\Section;
use Zend\View\Helper\AbstractHelper;

class InitializeModelsHelper extends AbstractHelper{
	
	/* @var $sectionMapper  \Entities\Mapper\SectionMapper */
	private $sectionMapper;
	
	public function __construct($sectionMapper){
		$this->sectionMapper = $sectionMapper;
	}
	
	public function __invoke(){
		 
		$mainsections = $this->sectionMapper->findSectionsWithParent(null);
		 
		$menuAr = array();
		 
		/* @var $section \Entities\Entity\Section */
		foreach ($mainsections as $section){
			if ($section->getStatus() == 0) continue;
			if ($section->getName() === 'blankmenu'){//adds separator to the menu array
				$temps = array();
				$temps['type'] = "blank";
				$menuAr[] = $temps;
			} else
			if (($section->getType() === Section::SECTION_TYPE_PORTFOLIO)||($section->getType() === Section::SECTION_TYPE_MOTION)){
				//handle portfolio sections
				$temps = array();
				$temps['id'] = $section->getId();
				$temps['type'] = "album";
				$temps['name'] = $section->getName();
				$sectioncategory = 'still';
				if ($section->getType() == Section::SECTION_TYPE_MOTION) $sectioncategory='motion';
				$temps['slug']='/'.$sectioncategory.'/'.$this->slugify($section->getName()).'/'.$section->getId();
				$menuAr[] = $temps;
				continue;
			}else
				if ($section->getType() === Section::SECTION_TYPE_LINK){
					$temps = array();
					$temps['id'] = $section->getId();
					$temps['type'] = "link";
					$temps['slug'] = $section->getDescription();
					$temps['name'] = $section->getName();
					$menuAr[] = $temps;
				} else {
				$temps = array();
				$temps['id'] = $section->getId();
				$temps['type'] = "page";
				$temps['slug'] = '/'.$this->slugify($section->getName());
				$temps['name'] = $section->getName();
				$menuAr[] = $temps;
			}
		}		
		return $this->getView()->render("helpers/initializemodels.phtml",array('menu' => $menuAr));
		
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