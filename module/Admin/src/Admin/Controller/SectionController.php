<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Forms\AddNewSectionForm;
use Zend\View\Model\JsonModel;
use Entities;
use Admin\Forms\AddNewSectionFormValidator;
use Admin\Forms\AddNewTextBlockForm;

/**
 * SectionController
 *
 * @author
 *
 * @version
 *
 */
class SectionController extends AbstractActionController
{

    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        $result = array();
        $form = new AddNewSectionForm();
        $form->addParent($this->params()->fromRoute('sectionid'));
        $result['form'] =$form;
        
        /* @var $sectionMapper  Entities\Mapper\SectionMapper */
        $sectionMapper = $this->getServiceLocator()->get("Entities_SectionMapper");
        
        $sectionid = $this->params()->fromRoute('sectionid');
        /** @var Entities\Entity\Section $currentsection */
        $currentsection = $sectionMapper->findSectionById($sectionid);
        $result['sections'] = $sectionMapper->findSectionsWithParent($sectionid);
        $result['currentsection'] = $currentsection;
        $result['media'] = $sectionMapper->getSectionContent($sectionid);
        $result['textblocks'] = $sectionMapper->getSectionTextBlocks($sectionid);
        
        return $result;
    }
    
    /**
	 * add anew section, json response 
	 */
    public function addnewAction(){
        $form = new AddNewSectionForm();
        $request = $this->getRequest();
        $result = array();
        
        if ($request->isPost()){
            $formValidator = new AddNewSectionFormValidator();
            $form->setInputFilter($formValidator->getInputFilter());
            $form->setData($request->getPost());            
            
            if($form->isValid()){
                /* @var $sectionMapper  Entities\Mapper\SectionMapper */
                $sectionMapper = $this->getServiceLocator()->get("Entities_SectionMapper");
                $formValues = $request->getPost();
                $id = $sectionMapper->insert($formValues);
                if ($id){
                    $result = array('code'  => 'success','message'  => 'Section was successfully created','id' => $id);
                }
            } else {
                $messages = "";
                foreach ($form->getMessages() as $message) {
                    $messages.=$message.'<br />';
                }
                $result = array('code'  => 'failed','message'   => $messages);
            }        
        }
        return new JsonModel($result);
    }
    
    /**
     * action to sort the sections, json response 
     */
    public function sortsectionsAction(){
        /* @var $sectionMapper  Entities\Mapper\SectionMapper */
        $sectionMapper = $this->getServiceLocator()->get("Entities_SectionMapper");        
        $sectionMapper->sortSectionsFromArray($this->params()->fromQuery('sectioncontainer'));
        return new JsonModel();
    }
    
    /**
     * action change section status, json response 
     */
    public function changestatusAction(){
        /* @var $sectionMapper  Entities\Mapper\SectionMapper */
        $sectionMapper = $this->getServiceLocator()->get("Entities_SectionMapper");
        $result = $sectionMapper->changeStatusSection($this->params()->fromQuery('sectionid'), intval($this->params()->fromQuery('status')));
        if ($result) return new JsonModel(array('code'=>'success'));
            else return new JsonModel(array('code'=>'error'));
    }

    public function addformsectionAction(){
        $form = new AddNewSectionForm();
        $parentid = $this->params()->fromRoute('parentid');
        $form->addParent($parentid);


        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function editsectionAction(){
        $form = new AddNewSectionForm();
        $editid = $this->params()->fromRoute('editid');
        $form->addEditid($editid);

        /* @var $sectionMapper  Entities\Mapper\SectionMapper */
        $sectionMapper = $this->getServiceLocator()->get("Entities_SectionMapper");
        $section = $sectionMapper->findSectionById($editid);
        $form->setData(array(
            'name' => $section->getName(),
            'description'   => $section->getDescription(),
            'status'    => $section->getStatus(),
            'customfield1'    => $section->getCustomfield1(),
            'customfield2'    => $section->getCustomfield2(),
            'type'  => $section->getType()
        ));
        
        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setTerminal(true);
        return $viewModel;        
    }


    /**
     * add new section, json response
     */
    public function sendaddsectionAction(){
        $form = new AddNewSectionForm();
        $request = $this->getRequest();
        $result = array();

        if ($request->isPost()){
            $formValidator = new AddNewSectionFormValidator();
            $form->setInputFilter($formValidator->getInputFilter());
            $form->setData($request->getPost());

            if($form->isValid()){
                /* @var $sectionMapper  Entities\Mapper\SectionMapper */
                $sectionMapper = $this->getServiceLocator()->get("Entities_SectionMapper");
                $formValues = $request->getPost();
                $id = $sectionMapper->insert($formValues);
                if ($id){
                    $result = array('code'  => 'success','message'  => 'Section was successfully created','id' => $id);
                }
            } else {
                $messages = "";
                print_r($form->getMessages());
                foreach ($form->getMessages() as $message) {
                    $messages.=$message.'<br />';
                }
                $result = array('code'  => 'failed','message'   => $messages);
            }
        }
        return new JsonModel($result);
    }


    /**
     * edit section, json response
     */
    public function sendeditsectionAction(){
        $form = new AddNewSectionForm();
        $request = $this->getRequest();
        $result = array();
    
        if ($request->isPost()){
            $formValidator = new AddNewSectionFormValidator();
            $form->setInputFilter($formValidator->getInputFilter());
            $form->setData($request->getPost());
    
            if($form->isValid()){
                /* @var $sectionMapper  Entities\Mapper\SectionMapper */
                $sectionMapper = $this->getServiceLocator()->get("Entities_SectionMapper");
                $formValues = $request->getPost();
                $id = $sectionMapper->update($formValues);
                if ($id){
                    $result = array('code'  => 'success','message'  => 'Section was successfully edited');
                }
            } else {
                $messages = "";
                foreach ($form->getMessages() as $message) {
                    $messages.=$message.'<br />';
                }
                $result = array('code'  => 'failed','message'   => $messages);
            }
        }
        return new JsonModel($result);
    }    
    
    
    /**
     * move section, json response
     */
    public function sendmovesectionAction(){
    	$request = $this->getRequest();
    	$result = array('code' => 'error');
    
    	if ($request->isPost()){
    			/* @var $sectionMapper  Entities\Mapper\SectionMapper */
    			$sectionMapper = $this->getServiceLocator()->get("Entities_SectionMapper");

    			$sectionid = (int)$this->params()->fromPost('sectionid');
    			$parentid = (int)$this->params()->fromPost('newsectionid');
    			if ($sectionMapper->changeParentById($sectionid, $parentid)){
    				$result = array('code'  => 'success','message'  => 'Section was successfully moved');
    			} else {
    				$result = array('code'  => 'error','message'  => 'Moving the section has failed');
    			}
    	}
    	return new JsonModel($result);
    }    
    
    /**
     * action to delete section, json response
     */
    public function deletesectionAction(){
        /* @var $sectionMapper  Entities\Mapper\SectionMapper */
        $sectionMapper = $this->getServiceLocator()->get("Entities_SectionMapper");        
        $res = $sectionMapper->delete($this->params()->fromRoute('deleteid'));
        if ($res) return new JsonModel(array('code' => 'success'));
         else return new JsonModel(array('code' => 'error'));
    }

    public function sectionhtmlAction(){
        /* @var $sectionMapper  Entities\Mapper\SectionMapper */
        $sectionMapper = $this->getServiceLocator()->get("Entities_SectionMapper");
        $section = $sectionMapper->findSectionById($this->params()->fromRoute('sectionid'));
        $viewModel = new ViewModel();
        $viewModel->setVariable('section', $section);
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
    public function sectionslistAction(){
    	/* @var $sectionMapper  Entities\Mapper\SectionMapper */
    	$sectionMapper = $this->getServiceLocator()->get("Entities_SectionMapper");
		$rootSections = $sectionMapper->findSectionsWithParent(null);
    	
    	$collection = new \Doctrine\Common\Collections\ArrayCollection($rootSections);
    	$section_iterator = new \Entities\Iterator\RecursiveSectionIterator($collection);
    	$recursive_iterator = new \RecursiveIteratorIterator($section_iterator, \RecursiveIteratorIterator::SELF_FIRST);
    	
/*     	foreach ($recursive_iterator as $index => $child_section)
    	{
    		//echo '<option value="' . $child_category->getId() . '">' . str_repeat('&amp;nbsp;&amp;nbsp;', $recursive_iterator->getDepth()) . $child_category->getTitle() . '</option>';
    	
    	} */
    	$viewModel = new ViewModel();
    	$viewModel->setVariable('sectionsiterator', $recursive_iterator);
    	$viewModel->setTerminal(true);
    	return $viewModel;
    }
    
}