<?php

namespace MediaFiles\Provider;

class FileContents {
    protected $parameters;
    protected $originalDetails;
    protected $filecontents;
    protected $imageContents;
    /* @var $im \Imagick */ 
    protected $im = null;
	public function __construct($fileDetails) {
		$this->parameters = $fileDetails ['parameters'];
		$this->originalDetails = $fileDetails ['details'];
		$this->filecontents = file_get_contents ( ROOT_PATH . '/' . $fileDetails ['uploadfolder'] . $this->originalDetails ['path'] . $this->originalDetails ['hashcode'] . '.' . $this->originalDetails ['extension'] );
		//if (($this->originalDetails ['type'] !== 1) || ($this->originalDetails ['extension'] == 'gif')) {
		if (($this->originalDetails ['type'] !== 1)) {	
		} else {
			$this->im = new \Imagick ( ROOT_PATH . '/' . $fileDetails ['uploadfolder'] . $this->originalDetails ['path'] . $this->originalDetails ['hashcode'] . '.' . $this->originalDetails ['extension'] );
			$this->processImage();
		}
	}
    
	/**
	 * resize the image if needed
	 * if only width is 
	 */
    public function processImage(){
        if ($this->im == null) return;
        $haswidth = array_key_exists('width', $this->parameters);
        $hasheight = array_key_exists('height', $this->parameters);
        $width = $haswidth? $this->parameters['width']:0;
        $height = $hasheight? $this->parameters['height']:0;
        if ($hasheight && $haswidth) {       	
        	$this->im = $this->im->coalesceimages();
        	foreach ($this->im as $image){
        		$image->cropthumbnailimage($width, $height);
        		$image->setimagepage(0,0,0,0);
        	}
        	$this->im = $this->im->deconstructimages(); 
        	//$this->im->cropthumbnailimage($width, $height);
        }
        else  if ($hasheight || $haswidth) {
        	$this->im = $this->im->coalesceimages();
        	foreach ($this->im as $image){
        		$image->resizeimage($width, $height, \Imagick::FILTER_LANCZOS, 1);
        		$image->setimagepage(0,0,0,0);
        	}
        	$this->im = $this->im->deconstructimages();
        	 
        	//$this->im->resizeimage($width, $height, \Imagick::FILTER_LANCZOS, 1);
        }
        //$this->im->resizeimage($width, $height, \Imagick::FILTER_LANCZOS, 1);
    }
    
    /**
     * saves the image content from $imageContents to disk in the folder media
     * filename :filename[_w:width][_h:height].:extension
     */
    public function save(){
        //other file types are delivered as original without resize
        if (($this->originalDetails['type'] !== 1)){
        	$this->imageContents = $this->filecontents;
        } else $this->imageContents = $this->im->getimagesblob();    
        $filename = $this->originalDetails['hashcode'];
        if (array_key_exists('width', $this->parameters)) $filename.="_w".$this->parameters['width'];
        if (array_key_exists('height', $this->parameters)) $filename.="_h".$this->parameters['height'];
        $filename.='.'.$this->originalDetails['extension'];
        $foldername = ROOT_PATH.'/media/'.$this->parameters['routepath'].'/';
        $this->mkdirs($foldername);
        file_put_contents($foldername.$filename, $this->imageContents);    
    }   
    
    /**
     * save to disk and returns the binary content of the image
     * @return string - the binary content of the image
     */
    public function getContents(){
        $this->save();
        return $this->imageContents;
    }
    
    /**
     * create a folder if it doesn't exist
     * @param unknown $foldername
     */
    private function mkdirs($foldername){
        if (!is_dir($foldername)) mkdir($foldername,0777,true); 
    }
    
}

?>