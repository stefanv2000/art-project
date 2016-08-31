<?php
namespace Entities\Mapper;

use Entities\Entity\TextBlock;
use Entities\Entity\Section;
use Doctrine\ORM\Query;

class TextBlockMapper extends AbstractMapper{
    
    /**
     * insert a new TextBlock with data from the array $data, belonging to the $section
     * @param array $data
     * @param Section $section
     * @return integer the id of the text block inserted
     */
    public function insert($data,$section){
        $textblock = new TextBlock();
        $textblock->setName($data['name']);
        $textblock->setContent($data['content']);
        if (isset($data['customfield1'])) $textblock->setCustomfield1($data['customfield1']);
        if (isset($data['customfield2'])) $textblock->setCustomfield2($data['customfield2']);
        $textblock->setSection($section);
        $maxorder = $this->findMaxOrder($section);
        $textblock->setSortorder($maxorder+1);
        /* @var $section Section */
        $section->addTextBlock($textblock);
        $this->em->persist($section);
        $this->em->persist($textblock);
        $this->em->flush();
        return $textblock->getId();
    }
    
    /**
     * finds the max sort order for all the text blocks of the $section
     * @param Section $section
     * @return integer maxorder
     */
    public function findMaxOrder($section){
        $query = $this->em->createQueryBuilder('t');
        $query->select('MAX(t.sortorder) as maxorder');
        $query->from('Entities\Entity\TextBlock','t');
        $query->where('t.section = ?1')->setParameter(1, $section);
        $result = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);
        return $result[0]['maxorder'];
    }    
    
    /**
     * find text block by id
     * @param integer $id
     * @return TextBlock|NULL return TextBlock if its found, null otherwise
     */
    public function findTextBlockById($id){
        $repository = $this->getRepository("textblock");
        return $repository->findOneBy(array("id" => $id));
    }    
    
    /**
     * sorts the text blocks based on the array
     * @param array $sortOrderArray - array with content ids sorted with the new order
     */
    public function sortTextBlocksFromArray($sortOrderArray){
        for ($i = 0; $i < count($sortOrderArray); $i++) {
            $textblock = $this->findTextBlockById($sortOrderArray[$i]);
            $textblock->setSortorder($i);
            $this->em->persist($textblock);
        }
        $this->em->flush();
    }    
    
    /**
     * delete text block with id $id
     * @param integer $id
     * @return boolean 
     */
    public function delete($id){
        $textblock = $this->findTextBlockById($id);
        if ($textblock==null) return false;
        $this->em->remove($textblock);
        $this->em->flush();
        return true;
    }
    
    /**
     * update text block from the $data
     * @param array $data should contain keys: edit_id,name optional: status,description
     */
    public function update($data){
        if (!isset($data['edit_id'])) return false;
        $textblock = $this->findTextBlockById($data['edit_id']);
        if ($textblock==null) return false;
    
        if (isset($data['name'])) $textblock->setName($data['name']); else return false;
        if (isset($data['content'])) $textblock->setContent($data['content']);
        if (isset($data['status'])) $textblock->setStatus($data['status']);
        if (isset($data['customfield1'])) $textblock->setCustomfield1($data['customfield1']);
        if (isset($data['customfield2'])) $textblock->setCustomfield2($data['customfield2']);
    
        $this->em->persist($textblock);
        $this->em->flush();
        return $textblock->getId();
    }
    
  
    /**
     * change the text block status
     * @param integer $id id of the text block to be changed
     * @param integer $status - 0 or 1 the new status of the text block
     * @return boolean true if succeded, false otherwise
     */
    public function changeStatus($id,$status){
        $textblock = $this->findTextBlockById($id);
        if ($textblock == null) return false;
        if (($status!==0)&&($status!==1)) return false;
        $textblock->setStatus($status);
        $this->em->persist($textblock);
        $this->em->flush();
        return true;
    }
        
    
}

?>