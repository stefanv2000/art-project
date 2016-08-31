<?php

namespace Entities\Mapper;

use Entities\Entity\Content;
use Entities\Entity\Section as Section;
use Doctrine\ORM\Query;

class ContentMapper extends AbstractMapper{


    /**
     * insert a new Content with data from the array $data, belonging to the $section
     * @param array $data
     * @param integer $sectionid - id of the section the media content belongs
     * @return integer the id of the content inserted 
     */
	public function insert($data,$sectionid){
		$content = $this->createContent($data);
		$sm = new SectionMapper($this->em);
		$section = $sm->findSectionById($sectionid); 
		if ($section == null) return;
		$content->setSection($section);
		$maxorder = $this->findMaxOrder($section);
		$content->setSortorder($maxorder+1);
		$section->addContent($content);
				
		$this->em->persist($section);
		$this->em->persist($content);		
		$this->em->flush();
		return $content->getId();
	}
	
	
	private function createContent($data){
		$content = new Content();
		$content->setName($data['name']);
		$content->setHashcode($data['hashcode']);
		$content->setWidth($data['width']);
		$content->setHeight($data['height']);
		$content->setExtension($data['extension']);
		$content->setMimetype($data['mimetype']);
		$content->setType($data['type']);
		$content->setOriginalname($data['originalname']);
		$content->setPath($data['path']);
		return $content;		
	}
	
	/**
	 * insert a new content from $data as cover for content with id $contentid
	 * @param array $data
	 * @param integer $contentid
	 * @return integer|null the id of the inserted content cover
	 */
	public function insertCover($data,$contentid){
		$cover = $this->createContent($data);
		$content = $this->findContentById($contentid);
		if ($content == null) return;
		$content->setCover($cover);
	
		$this->em->persist($content);
		$this->em->persist($cover);
		$this->em->flush();
		return $cover->getId();
	}	
	/**
	 * delete content with id $contentid
	 * @param integer $contentid
	 * @return boolean - true if succeded, false otherwise 
	 */
	public function delete($contentid){
	    $content = $this->findContentById($contentid);
	    if ($content==null) return false;
	    $content->setCover(null);
	    $this->em->flush();
	    $this->em->remove($content);
	    $this->em->flush();
	    return true;
    }

	/**
	 * update content caption,description
	 * @param array $data
	 * @param integer $contentid
	 * @return boolean
	 */
	public function updateContentDetails($data,$contentid){
	    $content = $this->findContentById($contentid);
	    if ($content == null)
	        return false;
	    $content->setCaption($data['caption']);
	    $content->setDescription($data['description']);
		if (isset($data['customfield1'])) $content->setCustomfield1($data['customfield1']);
		if (isset($data['customfield2'])) $content->setCustomfield2($data['customfield2']);
	    $this->em->persist($content);
	    $this->em->flush();
	    return true;
	     
	}
	
	/**
	 * @param integer $contentid
	 * @return boolean
	 */
	public function removeCover($contentid){
		$content = $this->findContentById($contentid);
		if ($content == null)
			return false;
		$cover = $content->getCover();
		$content->setCover(null);
		$this->em->persist($content);
		$this->em->remove($cover);		
		$this->em->flush();
		return true;
	}
	
	/**
	 * find content by id
	 * @param integer $admin_id
	 * @return Content|NULL return Content if its found, null otherwise
	 */
	public function findContentById($id){
		$repository = $this->getRepository("content");
		return $repository->findOneBy(array("id" => $id));
	}
	
	/**
	 * find content by hashcode
	 * @param string $hashcode
	 * @return Content|NULL return Content if its found, null otherwise* 
	 */
	public function findContentByHashcode($hashcode){
	    $repository = $this->getRepository("content");
	    return $repository->findOneBy(array("hashcode" => $hashcode));	     
	}
	
	/**
	 * finds the max sort order for all the content of the $section
	 * @param Section $section
	 * @return integer maxorder
	 */
	public function findMaxOrder($section){
	    $query = $this->em->createQueryBuilder('c');
	    $query->select('MAX(c.sortorder) as maxorder');
	    $query->from('Entities\Entity\Content','c');
        $query->where('c.section = ?1')->setParameter(1, $section);
	    $result = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);
	    return $result[0]['maxorder'];
	}	
	
	/**
	 * sorts the content based on the array
	 * @param array $sortOrderArray - array with content ids sorted with the new order
	 */
	public function sortContentFromArray($sortOrderArray){
	    for ($i = 0; $i < count($sortOrderArray); $i++) {
	        $content = $this->findContentById($sortOrderArray[$i]);
	        $content->setSortorder($i);
	        $this->em->persist($content);
	    }
	    $this->em->flush();
	}	
	
	/**
	 * changes the status of the media content
	 * @param integer $contentid
	 * @param integer $status
	 * @return boolean true if succeded
	 */
	public function changeStatus($contentid,$status){
		$content = $this->findContentById($contentid);
		if ($content == null) return false;
		if (($status!==0) && ($status !==1)) return false;
		$content->setStatus($status);
		$this->em->persist($content);
		$this->em->flush();
		return true;
	}
	
	private function generateContent($minwords, $maxwords){
		$words = array('molestie','vel','metus','neque','dui','volutpat','sollicitudin','sociis','ac','imperdiet','tristique','et','nascetur','ad','rhoncus','viverra','ornare','consectetur','ultrices','orci','parturient','lorem','massa','quis','platea','aenean','fermentum','augue','placerat','auctor','natoque','habitasse','pharetra','ridiculus','leo','sit','cras','est','venenatis','aptent','nibh','magnis','sodales','malesuada','praesent','potenti','lobortis','justo','quam','cubilia','pellentesque','porttitor','pretium','adipiscing','phasellus','lectus','vivamus','id','mi','bibendum','feugiat','odio','rutrum','vestibulum','posuere','elementum','suscipit','purus','accumsan','egestas','mus','varius','a','arcu','commodo','dis','lacinia','tellus','cursus','aliquet','interdum','turpis','maecenas','dapibus','cum','fames','montes','iaculis','erat','euismod','hac','faucibus','mauris','tempus','primis','velit','sem','duis','luctus','penatibus','sapien','blandit','eros','suspendisse','urna','ipsum','congue','nulla','taciti','mollis','facilisis','at','amet','laoreet','dignissim','fringilla','in','nostra','quisque','donec','enim','eleifend','nisl','morbi','felis','torquent','eget','convallis','etiam','tincidunt','facilisi','pulvinar','vulputate','integre','himenaeos','netus','senectus','non','litora','per','curae','ultricies','nec','nam','eu','ante','mattis','vehicula','sociosqu','nunc','semper','lacus','proin','risus','condimentum','scelerisque','conubia','consequat','dolor','libero','diam','ut','inceptos','porta','nullam','dictumst','magna','tempor','fusce','vitae','aliquam','curabitur','ligula','habitant','class','hendrerit','sagittis','gravida','nisi','tortor','ullamcorper','dictum','elit','sed');
		$randomlength = rand($minwords, $maxwords);
		$generatedcontent="";
		for ($i=1;$i<=$randomlength;$i++){
			$randomword = rand(0,count($words)-1);
			$generatedcontent.=' '.$words[$randomword];
		}			
		
		return ucfirst(trim($generatedcontent));	
	}
	
	public function generateRandomCaption(){
		$repository = $this->getRepository("content");
		$contents = $repository->findAll();
		
		/* @var $content Content */
		foreach ($contents as $content){
			$content->setCaption($this->generateContent(2, 6));
			$content->setDescription($this->generateContent(8, 25));
			$this->em->persist($content);
		}
		$this->em->flush();
	}
	
	
	/**
	 * moves the content contentid to section sectionid
	 * @param integer $contentid
	 * @param integer $sectionid
	 * @return boolean false if contentid or sectionid don't exist or operation cannot be completed
	 */
	public function moveContentToSectionId($contentid,$sectionid){
		
		$sectionrepository = $this->getRepository('section');
		$section = $sectionrepository->find($sectionid);
		if ($section == null) return false;
		$content = $this->findContentById($contentid);
		if ($content == null) return false;
		$content->setSection($section);
		$this->em->persist($content);
		$this->em->flush($content);		
		return true;
	}
	
}

?>