<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Entities\Mapper\ContentMapper as ContentMapper;
use Zend\View\Model\ViewModel;
use Admin\Forms\EditMediaContentForm;
use Admin\Forms\AddNewSectionFormValidator;
use Admin\Forms\EditMediaContentFormValidator;

class ContentController extends AbstractActionController
{
    private function generateFilename($filename){
        //$ext = pathinfo($filename, PATHINFO_EXTENSION);
        return bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)).".".pathinfo($filename, PATHINFO_EXTENSION);
    }
    
    public function uploadfileAction(){
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            $fileUploadsService = $this->getServiceLocator()->get('Media_FileUploadsService');
            $details = $fileUploadsService->uploadFile($post['file']);
            if (array_key_exists('error', $details)){
                return new JsonModel(array('code' => 'error'));                
            }
            
            /* @var $contentMapper ContentMapper */
            $contentMapper = $this->getServiceLocator()->get('Entities_ContentMapper');
            $id = $contentMapper->insert($details,$post['sectionid']);
            return new JsonModel(array('code' => 'success','id' => $id));
        }        
        return new JsonModel(array('code' => 'error'));
    }
    
    /**
     * action to upload vimeo/youtube links
     * @return \Zend\View\Model\JsonModel
     */
    public function uploadvideolinkAction(){
    	//return new JsonModel(array('code' => 'success','id' => 1));
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$videolink = $request->getPost('videolink');
    		$sectionid = $request->getPost('sectionid');
    		$videodetails = array();
    		if (strpos($videolink,"vimeo.com")!==false){
    			
    			$videoid = substr($videolink, strpos($videolink,"vimeo.com")+9);
    			$videodetails['id'] = trim($videoid,"/");
    			
    			$vimeoresponse = file_get_contents('https://vimeo.com/api/v2/video/'.$videodetails['id'].'.json');
    			$arres = json_decode($vimeoresponse,true);
    			$videodetails['resp'] = $arres;
    			$arres = $arres[0];
    			//print_r($arres);return new JsonModel(array('code' => 'success','id' => 'none'));
    			/* @var $contentMapper ContentMapper */
    			$contentMapper = $this->getServiceLocator()->get('Entities_ContentMapper');

    			$datacontent = array(
    				'width' => $arres['width'],
    				'height' => $arres['height'],
    				'description'=> $arres['description'],
    				'type'	=> 4,
    				'hashcode' => 	$arres['id'],
    					'caption' => 	$arres['title'],
    					'extension' => 	'vimeo',
    					'mimetype' => 'vimeo',
    					'originalname' =>$arres['url'],
    					'name' =>'vimeo',
    					'path' => $arres['url'],
    			);    			
    			//print_r($datacontent);

    			    			
    			$idcontent = $contentMapper->insert($datacontent, $sectionid);
    			 $contentMapper->updateContentDetails($datacontent, $idcontent);
    			$image = file_get_contents($arres['thumbnail_large']);
    			$fileUploadsService = $this->getServiceLocator()->get('Media_FileUploadsService');
    			$details = $fileUploadsService->fileFromContents($image,array('name' => 'vimeo_'.$arres['id']));
    			$id = $contentMapper->insertCover($details,$idcontent);
    			return new JsonModel(array('code' => 'success','id' => $idcontent));
    			
    		} else 
    		
    		if (strpos($videolink,"youtube.com")!==false){
    			$youtubeparams = array();
    			 parse_str(parse_url($videolink,PHP_URL_QUERY),$youtubeparams);
    			 $youtubeid = $youtubeparams['v'];
    			 
    			 $youtubelink = 'https://www.googleapis.com/youtube/v3/videos?id='.$youtubeid.'&part=snippet&key=AIzaSyBEJlEI5KA4dHjwmnRLWoqesO51Uy92Q0c';
    			 
    			$youtuberesponse = file_get_contents($youtubelink);
    			$arres = json_decode($youtuberesponse,true);
    			if (count($arres['items'])>0){
    				$arres =$arres['items'][0];
    			}
    			/* @var $contentMapper ContentMapper */
    			$contentMapper = $this->getServiceLocator()->get('Entities_ContentMapper');
    		

   		
    			$urlthumb = '';
    			//get link cover
    			$imageThumbnailsSizes = array('maxres','standard','high','medium','low','default');
    			foreach ($imageThumbnailsSizes as $key){
    				if (array_key_exists($key, $arres['snippet']['thumbnails'])){
    					$urlthumb = $arres['snippet']['thumbnails'][$key]['url'];
    					break;
    				}
    			}
    			$image = file_get_contents($urlthumb);
    			$fileUploadsService = $this->getServiceLocator()->get('Media_FileUploadsService');
    			$details = $fileUploadsService->fileFromContents($image,array('name' => 'vimeo_'.$arres['id']));

    			
    			$datacontent = array(
    					'width' => $details['width'],
    					'height' => $details['height'],
    					'description'=> str_replace("\n", "<br />",$arres['snippet']['description']),
    					'type'	=> 4,
    					'hashcode' => 	$arres['id'],
    					'caption' => 	$arres['snippet']['title'],
    					'extension' => 	'youtube',
    					'mimetype' => 'youtube',
    					'originalname' =>$arres['id'],
    					'name' =>'youtube',
    					'path' => $arres['id'],
    			);    			
    			
    			$idcontent = $contentMapper->insert($datacontent, $sectionid);
    			$contentMapper->updateContentDetails($datacontent, $idcontent);    			

    			$id = $contentMapper->insertCover($details,$idcontent);
    			return new JsonModel(array('code' => 'success','id' => $idcontent));
    			 
    		}    		
    		
    		return new JsonModel(array('code' => 'error','id' => 'none'));
    	}
    	return new JsonModel(array('code' => 'error'));
    }    
    
    public function uploadcoverAction(){
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$post = array_merge_recursive(
    				$request->getPost()->toArray(),
    				$request->getFiles()->toArray()
    		);
    		$fileUploadsService = $this->getServiceLocator()->get('Media_FileUploadsService');
    		$details = $fileUploadsService->uploadFile($post['file']);
    		if (array_key_exists('error', $details)){
    			return new JsonModel(array('code' => 'error'));
    		}
    
    		/* @var $contentMapper ContentMapper */
    		$contentMapper = $this->getServiceLocator()->get('Entities_ContentMapper');
    		$content = $contentMapper->findContentById($post['contentid']);
    		if ($content==null) return new JsonModel(array('code' => 'error'));
    		if ($content->getCover()!==null) $fileUploadsService->deleteFile($content->getCover()->toArray());    		
    		$id = $contentMapper->insertCover($details,$post['contentid']);
    		$cover = $contentMapper->findContentById($id);
    		return new JsonModel(array('code' => 'success','id' => $id,'contentid' => $post['contentid'],'details' => array('hashcode' => $cover->getHashcode(),'extension' => $cover->getExtension())));
    	}
    	return new JsonModel(array('code' => 'error'));
    }    
    
    /**
     * action to sort the sections, json response
     */
    public function sortcontentAction(){
        /* @var $contentMapper ContentMapper */
        $contentMapper = $this->getServiceLocator()->get('Entities_ContentMapper');
        $contentMapper->sortContentFromArray($this->params()->fromQuery('mediaelementcontainer'));
        return new JsonModel($this->params()->fromQuery('mediaelementcontainer'));
    }    
    
    public function deletecontentAction(){
    	/* @var $contentMapper ContentMapper */
    	$contentMapper = $this->getServiceLocator()->get('Entities_ContentMapper');
    	//$content = $contentMapper->findContentById($this->params()->fromRoute('deleteid'));
    	//if ($content==null) return new JsonModel(array('code' => 'error'));    	    	
    	//$fileUploadsService = $this->getServiceLocator()->get('Media_FileUploadsService');
    	//if ($content->getCover()!==null) $fileUploadsService->deleteFile($content->getCover()->toArray());
    	//$fileUploadsService->deleteFile($content->toArray());
    	//$contentMapper->delete($this->params()->fromRoute('deleteid'));
    	$result = $this->deleteContent($this->params()->fromRoute('deleteid'));
    	if ($result)  	return new JsonModel(array('code' => 'success'));
    		else return new JsonModel(array('code' => 'error'));
    }
    
    public function bulkdeleteAction(){
    	$deleteArray = $this->params()->fromQuery('mediaelement');
    	$deletedArray = array();
    	$code = "success";
    	foreach ($deleteArray as $deleteid){
    		$result = $this->deleteContent($deleteid);
    		if ($result) $deletedArray[] = $deleteid; else $code = "error";
    	}
    	return new JsonModel(array('code' => $code,'result' => $deletedArray));    	
    }
    
    public function bulkchangestatusAction(){
    	$statusArray = $this->params()->fromQuery('mediaelement');
    	$status = 1;
    	if ($this->params()->fromQuery('status') === '0') $status = 0;
    	$rezArray = array();
    	$code = "success";
    	/* @var $contentMapper ContentMapper */
    	$contentMapper = $this->getServiceLocator()->get('Entities_ContentMapper');    	 
    	foreach ($statusArray as $contentid){
    		$result = $contentMapper->changeStatus($contentid, $status);
    		if ($result) $rezArray[] = $contentid; else $code = "error";
    	}
    	return new JsonModel(array('code' => $code,'result' => $rezArray));    	
    }
    
    public function contenthtmlAction(){
    	/* @var $contentMapper ContentMapper */
    	$contentMapper = $this->getServiceLocator()->get('Entities_ContentMapper');
    	$content = $contentMapper->findContentById($this->params()->fromRoute('contentid'));
    	$viewModel = new ViewModel();
    	$viewModel->setVariable('content', $content->toArray());
    	$viewModel->setTerminal(true);
    	return $viewModel;
    }   

    private function deleteContent($contentid){
    	/* @var $contentMapper ContentMapper */
    	$contentMapper = $this->getServiceLocator()->get('Entities_ContentMapper');
    	$content = $contentMapper->findContentById($contentid);
    	if ($content == null) return false;
    	$fileUploadsService = $this->getServiceLocator()->get('Media_FileUploadsService');
    	if ($content->getCover()!==null) $fileUploadsService->deleteFile($content->getCover()->toArray());
    	$fileUploadsService->deleteFile($content->toArray());
    	return $contentMapper->delete($contentid);    	
    }
    
    
    public function editcontentAction(){
    	$form = new EditMediaContentForm();
    	$editid = $this->params()->fromRoute('editid');
    	$form->addEditid($editid);
    
    	/* @var $contentMapper ContentMapper */
    	$contentMapper = $this->getServiceLocator()->get('Entities_ContentMapper');
    	$content = $contentMapper->findContentById($editid);
    	$form->setData(array(
    			'caption' => $content->getCaption(),
    			'description'   => $content->getDescription()
    	));
    
    	$viewModel = new ViewModel();
    	$viewModel->setVariable('form', $form);
    	$viewModel->setTerminal(true);
    	return $viewModel;
    }
    
    /**
     * edit content, json response
     */
    public function sendeditcontentAction(){
    	$form = new EditMediaContentForm();
    	$request = $this->getRequest();
    	$result = array();
    
    	if ($request->isPost()){
    		$formValidator = new EditMediaContentFormValidator();
    		$form->setInputFilter($formValidator->getInputFilter());
    		$form->setData($request->getPost());
    
    		if($form->isValid()){
    			/* @var $contentMapper ContentMapper */
    			$contentMapper = $this->getServiceLocator()->get('Entities_ContentMapper');
    			
    			$formValues = $request->getPost();
    			$id = $contentMapper->updateContentDetails($formValues, $formValues['edit_id']);
    			if ($id){
    				$result = array('code'  => 'success','message'  => 'Content was successfully edited');
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
    
    public function getcoverAction(){
    	$result = array();
    	/* @var $contentMapper ContentMapper */
    	$contentMapper = $this->getServiceLocator()->get('Entities_ContentMapper');
    	$content = $contentMapper->findContentById($this->params()->fromQuery('contentid'));
    	if ($content===null) $result=array('code' => 'failed');
    	$cover = $content->getCover();
    	if ($cover === null) $result=array('code' => 'empty');
    	else $result = array('code' => 'success','details' => array('hashcode' => $cover->getHashcode(),'extension' => $cover->getExtension()));    	
    	return new JsonModel($result);
    	 
    }
    
    public function removecoverAction(){
    	$result = array();
    	/* @var $contentMapper ContentMapper */
    	$contentMapper = $this->getServiceLocator()->get('Entities_ContentMapper');
    	$res = $contentMapper->removeCover($this->params()->fromQuery('contentid'));
    	if ($res) $result = array('code'  => 'success','message'  => 'Cover was successfully removed');
    	else $result = array('code'  => 'failed','message'   => 'An error occurred');
    	return new JsonModel($result);
    }    
    
    
    /**
     * action to move bulk content to a different section
     */
    public function bulkmoveAction(){
    	$moveArray = $this->params()->fromQuery('mediaelement');
    	$section_id = $this->params()->fromQuery('newsectionid');
    	$movedArray = array();
    	$code = "success";
    	foreach ($moveArray as $moveid){
    		$result = $this->moveContent($moveid,$section_id);
    		if ($result) $movedArray[] = $moveid; else $code = "error";
    	}
    	return new JsonModel(array('code' => $code,'result' => $movedArray));    	
    }
    
    /**
     * move content to a different section
     * @param integer $contentid
     * @param integer $sectionid
     */
    public function moveContent($contentid,$sectionid){
    	/* @var $contentMapper ContentMapper */
    	$contentMapper = $this->getServiceLocator()->get('Entities_ContentMapper');
    	return $contentMapper->moveContentToSectionId($contentid, $sectionid);
    }
}

?>
