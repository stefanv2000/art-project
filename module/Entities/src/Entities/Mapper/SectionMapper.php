<?php
namespace Entities\Mapper;

use Entities\Entity\Section;
use Doctrine\ORM\Query;
class SectionMapper extends AbstractMapper {
    /**
     * insert a new section from the $data
     * @param array $data should contain keys: name optional: type,status,description,parent_id
     */    
    public function insert($data){
        $section = new Section();
        
        if (isset($data['name'])) $section->setName($data['name']); else return false;
        if (isset($data['type'])) $section->setType($data['type']);
        if (isset($data['status'])) $section->setStatus($data['status']);
        if (isset($data['customfield1'])) $section->setCustomfield1($data['customfield1']);
        if (isset($data['customfield2'])) $section->setCustomfield2($data['customfield2']);
        if (isset($data['description'])) $section->setDescription($data['description']);
        if (isset($data['parent_id'])) {
            $parent = $this->findSectionById($data['parent_id']);
            if ($parent!=null) {
                $section->setParent($parent);
                $parent->addSubsection($section);
                $this->em->persist($parent);
            }
        } else $section->setParent(null);
        $maxorder = $this->findMaxOrder($section->getParent());
        $section->setSortorder($maxorder+1);
        $this->em->persist($section);
        $this->em->flush();
        return $section->getId();
    }
    
    /**
     * update section from the $data
     * @param array $data should contain keys: edit_id,name optional: type,status,description,parent_id
     */    
    public function update($data){
        if (!isset($data['edit_id'])) return false;
        $section = $this->findSectionById($data['edit_id']);
        if ($section==null) return false;
    
        if (isset($data['name'])) $section->setName($data['name']); else return false;
        if (isset($data['type'])) $section->setType($data['type']);
        if (isset($data['customfield1'])) $section->setCustomfield1($data['customfield1']);
        if (isset($data['customfield2'])) $section->setCustomfield2($data['customfield2']);
        if (isset($data['status'])) $section->setStatus($data['status']);
        if (isset($data['description'])) $section->setDescription($data['description']);

        $this->em->persist($section);
        $this->em->flush();
        return $section->getId();
    }
    
    /**
     * delete a section by id
     * @param integer $sectionid id of the section to be deleted
     * @return boolean
     */
    public function delete($sectionid){
        $section = $this->findSectionById($sectionid);
        if ($section == null) return false;
        $this->em->remove($section);
        $this->em->flush();
        return true;
    }
        
    
    /**
     * finds the max sort order for all the subsections of the $parent section
     * @param Section $parent
     * @return integer maxorder
     */
    public function findMaxOrder($parent){        
        //$query = $this->em->createQuery('SELECT max(s.sortorder) as maxorder from Entities\Entity\Section s where s.parent=0');
        $query = $this->em->createQueryBuilder('s');
        $query->select('MAX(s.sortorder) as maxorder');
        $query->from('Entities\Entity\Section','s');
        if ($parent == null) {
            $query->where('s.parent is NULL');
        } else $query->where('s.parent = ?1')->setParameter(1, $parent);
        $result = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);
        return $result[0]['maxorder'];
    }
    
    /**
     * find section by id
     * @param integer $section_id
     * @return Section|NULL return Section if its found, null otherwise
     */
    public function findSectionById($section_id){
        $repository = $this->getRepository("section");
        return $repository->findOneBy(array("id" => $section_id));
    }  

    /**
     * find section by name
     * @param string $sectionname
     * @return Section|NULL return Section if its found, null otherwise
     */
    public function findSectionByName($sectionname){
    	$repository = $this->getRepository("section");
    	return $repository->findOneBy(array("name" => $sectionname));
    }

    /**
     * find section by name from parent id
     * @param string $sectionname
     * @param string $parent_id
     * @return Section|NULL return Section if its found, null otherwise
     */
    public function findSectionByNameFromParent($sectionname,$parent_id){
    	$repository = $this->getRepository("section");
    	return $repository->findOneBy(array("name" => $sectionname,"parent" => $parent_id));
    }    
    
    /**
     * change the status of the section
     * @return true if the status was changed, false if the section was not found or an error was raised
     * @param integer $sectionid - id of the section
     * @param integer $status - the new status of the section
     */
    public function setSectionStatus($sectionid,$status){
        $section = $this->findSectionById($sectionid);
        if ($section == null) return false;
        if (($status!==0) && ($status !==1)) return false; 
        $section->setStatus($status);
        $this->em->persist($section);
        $this->em->flush();
        return true;
    }
    
    /**
     * get all the sections with parent id $parentid
     * @return array
     * @param integer $parentid
     */
    public function findSectionsWithParent($parentid){
        $repo = $this->getRepository("section");
        $parent=null;
        if ($parentid !== '0'){
            $parent = $this->findSectionById($parentid);
        }
        return $repo->findBy(array('parent'    => $parent),array('sortorder' => 'ASC'));
    }
    
    /**
     * sorts the sections based on the array
     * @param array $sortOrderArray - array with section ids sorted with the new order
     */
    public function sortSectionsFromArray($sortOrderArray){
        for ($i = 0; $i < count($sortOrderArray); $i++) {
            $section = $this->findSectionById($sortOrderArray[$i]);
            $section->setSortorder($i);
            $this->em->persist($section);
        }
        $this->em->flush();
    }
    
    /**
     * change the section status
     * @param integer $section_id id of the section to be changed
     * @param integer $status - 0 or 1 the new status of the section
     * @return boolean true if succeded, false otherwise
     */
    public function changeStatusSection($section_id,$status){
        $section = $this->findSectionById($section_id);
        if ($section == null) return false;
        if (($status!==0)&&($status!==1)) return false;
        $section->setStatus($status);
        $this->em->persist($section);
        $this->em->flush();
        return true;
    }
    
    /**
     * get all the media content from the section with the id $section_id ordered by sortorder
     * @param integer $section_id id of the section
     * @return boolean|array the content as array
     */
    public function getSectionContent($section_id){
        $section = $this->findSectionById($section_id);
        if ($section == null) return false;
        $query = $this->em->createQueryBuilder('c');
        $query->select('c,co');
        $query->from('Entities\Entity\Content','c');
        $query->leftJoin('c.cover', 'co');
        $query->where('c.section = :section') ->setParameter('section', $section);
        $query->orderBy('c.sortorder','ASC');

        $result = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);
        return $result;        
    }
    
    
    /**
     * get the media content with status enabled from the section with the id $section_id ordered by sortorder
     * @param integer $section_id id of the section
     * @return boolean|array the content as array
     */
    public function getSectionEnabledContent($section_id){
    	$section = $this->findSectionById($section_id);
    	if ($section == null) return false;
    	$query = $this->em->createQueryBuilder('c');
    	$query->select('c,co');
    	$query->from('Entities\Entity\Content','c');
    	$query->leftJoin('c.cover', 'co');
    	$query->where('c.section = :section and c.status=1') ->setParameter('section', $section);
    	$query->orderBy('c.sortorder','ASC');
    
    	$result = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);
    	return $result;
    }
    
    
    /**
     * get all the text blocks from the section with the id $section_id ordered by sortorder
     * @param integer $section_id id of the section
     * @return boolean|array the content as array
     */
    public function getSectionTextBlocks($section_id){
        $section = $this->findSectionById($section_id);
        if ($section == null) return false;
        $query = $this->em->createQueryBuilder('t');
        $query->select('t');
        $query->from('Entities\Entity\TextBlock','t');
        $query->where('t.section = :section') ->setParameter('section', $section);
        $query->orderBy('t.sortorder','ASC');
    
        $result = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);
        return $result;
    }    
    
    /**
     * change the parent section of the section with id section_id
     * @param integer $section_id - id of the section 
     * @param \Entity\Section $parent - the new parent section
     * @return boolean false if parent id or section id not found or the operation cannot be completed, true if operation completes 
     */
    public function changeParent($section_id,$parent){
    	$section = $this->findSectionById($section_id);
    	if ($section == null) return false;
    	$section->setParent($parent);
    	$this->em->flush($section);
    	return true;
    }
    
    /**
     * change the parent section of the section with id section_id
     * @param integer $section_id - id of the section 
     * @param integer $parent_id - id of the parent section, 0 for root
     * @return boolean false if parent id or section id not found or the operation cannot be completed, true if operation completes
     */
    public function changeParentById($section_id,$parent_id){
        $parent=null; //if parent_id==0 than parent section will be null
        if ($parent_id!=0) {
            $parent = $this->findSectionById($parent_id);
            if ($parent == null) return false;
        }
    	return $this->changeParent($section_id, $parent);
    }
}

?>