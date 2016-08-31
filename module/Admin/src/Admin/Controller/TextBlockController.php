<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Forms\AddNewTextBlockForm;
use Admin\Forms\AddNewTextBlockFormValidator;
use Entities\Mapper\SectionMapper as SectionMapper;
use Zend\View\Model\JsonModel;
use Entities\Mapper\TextBlockMapper;
use Zend\View\Model\ViewModel;

class TextBlockController extends AbstractActionController{
    
    /**
     * add new text block action, json response
     * @return \Admin\Controller\JsonModel
     */
    public function addnewAction(){
        $form = new AddNewTextBlockForm();
        $request = $this->getRequest();
        $result = array();
        
        if ($request->isPost()){
            $formValidator = new AddNewTextBlockFormValidator();
            $form->setInputFilter($formValidator->getInputFilter());
            $form->setData($request->getPost());
        
            if($form->isValid()){
                /* @var $textblockMapper  TextBlockMapper */
                $textblockMapper = $this->getServiceLocator()->get("Entities_TextBlockMapper");
                $formValues = $request->getPost();
                /* @var $sectionMapper  SectionMapper */
                $sectionMapper = $this->getServiceLocator()->get("Entities_SectionMapper");
                $section = $sectionMapper->findSectionById($formValues['section_id']);
                $id = $textblockMapper->insert($formValues,$section);
                if ($id){
                    $result = array('code'  => 'success','message'  => 'Text block was successfully created','id' => $id);
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
    
    public function sorttextblockAction(){
        /* @var $textblockMapper  \Entities\Mapper\TextBlockMapper */
        $textblockMapper = $this->getServiceLocator()->get("Entities_TextBlockMapper");
        $textblockMapper->sortTextBlocksFromArray($this->params()->fromQuery('textblockcontainer'));
        return new JsonModel();
    }
    
    public function textblockhtmlAction(){
        /* @var $textblockMapper  \Entities\Mapper\TextBlockMapper */
        $textblockMapper = $this->getServiceLocator()->get("Entities_TextBlockMapper");
        $textblock = $textblockMapper->findTextBlockById($this->params()->fromRoute('textblockid'));
        $viewModel = new ViewModel();
        $viewModel->setVariable('textblock', $textblock);
        $viewModel->setTerminal(true);
        return $viewModel;        
    }
    
    /**
     * action delete text block , json response
     */    
    public function deletetextblockAction(){
        /* @var $textblockMapper  TextBlockMapper */
        $textblockMapper = $this->getServiceLocator()->get("Entities_TextBlockMapper");
        $res = $textblockMapper->delete($this->params()->fromRoute('deleteid'));
        if ($res) return new JsonModel(array('code' => 'success'));
         else return new JsonModel(array('code' => 'error'));
    }
    
    /**
     * action change text block status, json response 
     */
    public function changestatusAction(){
        /* @var $textblockMapper  TextBlockMapper */
        $textblockMapper = $this->getServiceLocator()->get("Entities_TextBlockMapper");
        $result = $textblockMapper->changeStatus($this->params()->fromQuery('textblockid'), intval($this->params()->fromQuery('status')));
        if ($result) return new JsonModel(array('code'=>'success'));
            else return new JsonModel(array('code'=>'error'));
    }


    /**
     * action returns the html for add form
     * @return ViewModel
     */
    public function addformtextblockAction(){
        $form = new AddNewTextBlockForm();
        $form->addParentSection($this->params()->fromRoute('sectionid'));


        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    /**
     * add the new textblock action. Ajax request
     */
    public function sendaddtextblockAction(){
        $form = new AddNewTextBlockForm();
        $request = $this->getRequest();
        $result = array();

        if ($request->isPost()){
            $formValidator = new AddNewTextBlockFormValidator();
            $form->setInputFilter($formValidator->getInputFilter());
            $form->setData($request->getPost());

            if($form->isValid()){
                /* @var $textblockMapper  TextBlockMapper */
                $textblockMapper = $this->getServiceLocator()->get("Entities_TextBlockMapper");
                $formValues = $request->getPost();
                /* @var $sectionMapper  SectionMapper */
                $sectionMapper = $this->getServiceLocator()->get("Entities_SectionMapper");

                $section = $sectionMapper->findSectionById($formValues['section_id']);
                $id = $textblockMapper->insert($formValues,$section);
                if ($id){
                    $result = array('code'  => 'success','message'  => 'Text block was successfully created','id' => $id);
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

    public function edittextblockAction(){
        $form = new AddNewTextBlockForm();
        $editid = $this->params()->fromRoute('editid');
        $form->addEditid($editid);
    
        /* @var $textblockMapper  TextBlockMapper */
        $textblockMapper = $this->getServiceLocator()->get("Entities_TextBlockMapper");
        $textblock = $textblockMapper->findTextBlockById($editid);
        $form->setData(array(
            'name' => $textblock->getName(),
            'content'   => $textblock->getContent(),
            'customfield1'   => $textblock->getCustomfield1(),
            'customfield2'   => $textblock->getCustomfield2(),
        ));
    
        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
    /**
     * edit section, json response
     */
    public function sendedittextblockAction(){
        $form = new AddNewTextBlockForm();
        $request = $this->getRequest();
        $result = array();
    
        if ($request->isPost()){
            $formValidator = new AddNewTextBlockFormValidator();
            $form->setInputFilter($formValidator->getInputFilter());
            $form->setData($request->getPost());
    
            if($form->isValid()){
                /* @var $textblockMapper  TextBlockMapper */
                $textblockMapper = $this->getServiceLocator()->get("Entities_TextBlockMapper");
                $formValues = $request->getPost();
                $id = $textblockMapper->update($formValues);
                if ($id){
                    $result = array('code'  => 'success','message'  => 'Text block was successfully edited');
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
}

?>