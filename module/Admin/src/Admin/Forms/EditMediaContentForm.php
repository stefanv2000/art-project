<?php
namespace Admin\Forms;

use Zend\Form\Form;

class EditMediaContentForm extends Form
{
	public function __construct($name = null) {
		parent::__construct ( 'forms' );
		
		$this->setAttributes ( array (
				'method' => 'post',
				'class' => 'form-horizontal',
				'id' => 'formeditmediacontent' 
		) );
		
		$this->add ( array (
				'name' => 'caption',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array (
						'class' => 'form-control',
						'placeholder' => 'Caption',
						'required' => 'required' 
				),
				'options' => array (
						'label' => 'Caption' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'description',
				'type' => 'Zend\Form\Element\Textarea',
				'attributes' => array (
						'class' => 'form-control',
						'required' => 'required' 
				),
				'options' => array (
						'label' => 'Description' 
				) 
		) );

		$this->add(array(
			'name' => 'customfield1',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'form-control',
				'id' => 'customfield1',
				'placeholder' => '',
			),
			'options' => array(
				'label' => 'Custom field',
			),
		));

		$this->add(array(
			'name' => 'customfield2',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'form-control',
				'id' => 'customfield2',
				'placeholder' => '',
			),
			'options' => array(
				'label' => 'Custom field',
			),
		));
		
		$this->add ( array (
				'name' => 'submit',
				'attributes' => array (
						'type' => 'submit',
						'value' => 'Submit',
						'class' => 'btn btn-default',
						'id' => 'submiteditmediacontent' 
				) 
		) );
	}
	
	public function addEditid($editid){
		$this->add(array(
				'name' => 'edit_id',
				'type' => 'Zend\Form\Element\Hidden',
				'attributes' => array(
						'value' => $editid,
				),
		));
	
	}
}