<?php
namespace Frontend\Forms; 

use Zend\InputFilter\Factory as InputFactory; 
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ContactFormValidator implements InputFilterAwareInterface {
	protected $inputFilter;
	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception ( "Not used" );
	}
	public function getInputFilter() {
		if (! $this->inputFilter) {
			$inputFilter = new InputFilter ();
			$factory = new InputFactory ();
			
			$inputFilter->add ( $factory->createInput ( [ 
					'name' => 'contactname',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					),
					'validators' => array (
							array (
									'name' => 'not_empty' 
							) 
					) 
			] ) );
			
			
			$inputFilter->add ( $factory->createInput ( [
					'name' => 'contactemail',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),
					'validators' => array (
							array (
									'name' => 'not_empty'
							),
							array (
									'name' => 'EmailAddress',
									'options' =>array(
											'domain'   => 'false',
											'mx'       => 'false',
											'deep'     => 'false',
											'message'  => 'Invalid email address',
									),
							)							
					)
			] ) );	

			$inputFilter->add ( $factory->createInput ( [
					'name' => 'contactmessage',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),
					'validators' => array (
							array (
									'name' => 'not_empty'
							),
					)
			] ) );			
			

 
            $this->inputFilter = $inputFilter; 
        } 
        
        return $this->inputFilter; 
    } 
} 

namespace Frontend\Forms;

