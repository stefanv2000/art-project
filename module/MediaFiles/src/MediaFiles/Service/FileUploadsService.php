<?php
namespace MediaFiles\Service;
class FileUploadsService {
    protected $serviceLocator;
    
    public function __construct(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator){
        $this->serviceLocator = $serviceLocator;
    }  
    
    
    /**
     * 
     * @param array $fileDetails
     */
    public function uploadFile($fileDetails){
        $getid3 = new \getID3();
        $filex = $getid3->analyze($fileDetails['tmp_name']);
        //print_r($filex);
        if (isset($filex['error'])) return array('error' => 'File type not supported');
        
        $details = $this->detailsByMimeType($filex);
        if ($details == null) return array('error' => 'Mime type not supported');

        $details['originalname'] = $fileDetails['name'];
        
        $config = $this->serviceLocator->get('Config');                
        //echo ROOT_PATH.'/'.$config['uploadmf']['folder']['path'].$details['path'].$details['hashcode'].'.'.$details['extension'];
        move_uploaded_file($fileDetails['tmp_name'], ROOT_PATH.'/'.$config['uploadmf']['folder']['path'].$details['path'].$details['hashcode'].'.'.$details['extension']);

        return $details;
    }
    
    /**
     * 
     * @param string $contents - media file content
     * @param array $fileDetails
     */
    public function fileFromContents($contents,$fileDetails){
    	$config = $this->serviceLocator->get('Config');
    	$filename = ROOT_PATH.'/'.$config['uploadmf']['folder']['temppath'].'/'.$fileDetails['name'].'.jpg';
    	file_put_contents($filename, $contents);
    	$getid3 = new \getID3();
    	$filex = $getid3->analyze($filename);    	
    	if (isset($filex['error'])) return array('error' => 'File type not supported');
    	
    	$details = $this->detailsByMimeType($filex);
    	if ($details == null) return array('error' => 'Mime type not supported');
    	
    	$details['originalname'] = $fileDetails['name'];    
    	file_put_contents(ROOT_PATH.'/'.$config['uploadmf']['folder']['path'].$details['path'].$details['hashcode'].'.'.$details['extension'], $contents);	
    	return $details;
    }
    
    private function detailsByMimeType($filex){
        $details = array();
        switch ($filex['mime_type']){
            case 'image/jpeg':
            case 'image/pjpeg':
            case 'image/png':
            case 'image/gif':
            case 'image/tiff':
            case 'image/svg+xml':
            case 'image/vnd.djvu':
                $details['type'] = 1;
                $details['path'] = '/images/';
            case 'video/avi':
            case 'video/mpeg':
            case 'video/mp4':
            case 'video/ogg':
            case 'video/quicktime':
            case 'video/webm':
            case 'video/x-matroska':
            case 'video/x-ms-wmv':
            case 'video/x-flv':
                if (! array_key_exists('type', $details))
                    $details['type'] = 2;
                if (! array_key_exists('path', $details))
                        $details['path'] = '/video/';                    
                $details['extension'] = $filex['fileformat'];
                $details['width'] = $filex['video']['resolution_x'];
                $details['height'] = $filex['video']['resolution_y'];
                $details['hashcode'] = $this->generateHash();
                $details['mimetype'] = $filex['mime_type'];
                $details['name'] = $details['hashcode'].'.'.$details['extension'];
                
                break;
            default:
                return null;
                break;
        }       
        return $details; 
    }
    
    private function generateHash(){
        return bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
    }    
    
    
    private function allowedExtensions(){
    	$config = $this->serviceLocator->get('Config');
    	return explode(',',$config['uploadmf']['allowedextensions']);
    }

    /**
     * removes a file     * 
     * @param array $fileDetails - expectes key : path,hashcode,extension
     */
    public function deleteFile($fileDetails){
    	$config = $this->serviceLocator->get('Config');
    	$filepath = ROOT_PATH.'/'.$config['uploadmf']['folder']['path'].$fileDetails['path'].$fileDetails['hashcode'].'.'.$fileDetails['extension'];
    	if (file_exists($filepath)) unlink($filepath);
    	return true;
    }
}

?>