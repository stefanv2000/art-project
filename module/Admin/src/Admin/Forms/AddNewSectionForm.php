<?php
namespace Admin\Forms;

use Zend\Form\Form; 

class AddNewSectionForm extends Form 
{ 
    public function __construct($name = null) 
    { 
        parent::__construct(''); 
        
        $this->setAttributes(array(
            'method' => 'post',
            'class'  => 'form-horizontal',
            'id'     => 'formaddnewsection', 
        ));
        
        $this->add(array( 
            'name' => 'name', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'class' => 'form-control',	
                'id' => 'sectionname', 
                'placeholder' => 'Name', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Name', 
            ), 
        )); 
    
        $this->add(array( 
            'name' => 'status', 
            'type' => 'Zend\Form\Element\Checkbox', 
            'attributes' => array( 
                'id' => 'sectionstatus',
                'value' => '1' 
            ), 
            'options' => array( 
                'label' => 'Status', 
                'checked_value' => '1',
                'unchecked_value' => '0',
                'label_attributes' => array('class' => 'formlabelmain',)
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'type', 
            'type' => 'Zend\Form\Element\Radio', 
            'attributes' => array( 
                'id' => 'typesectionradio', 
                'required' => 'required', 
                'value' => '0', 
            ), 
            'options' => array( 
                'label' => 'Type',
                'label_attributes' => array('class' => 'formlabelmain',),
                'value_options' => array(
                    array(
                        'value' => '0',
                        'label' => 'portfolio',
                        'label_attributes' => array('class' => 'radiolabel',),
                    ),
                    array(
                        'value' => '1',
                        'label' => 'text',
                        'label_attributes' => array('class' => 'radiolabel',),
                    ),
                    array(
                        'value' => '2',
                        'label' => 'motion',
                        'label_attributes' => array('class' => 'radiolabel',),
                    ),
                    array(
                        'value' => '3',
                        'label' => 'link',
                        'label_attributes' => array('class' => 'radiolabel',),
                    ),
                ),
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'description', 
            'type' => 'Zend\Form\Element\Textarea', 
            'attributes' => array( 
                'class' => 'form-control',	
                'id' => 'descriptionsection', 
                'placeholder' => 'Description', 
            ), 
            'options' => array( 
                'label' => 'Description', 
            ), 
        ));

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



        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Submit',
                'class' => 'btn btn-default',
                'id'    => 'submitaddnewsection',
            ),
        ));        
    }

    /**
     * add a hidden field parent for the form
     * @param string $parent the value of the field
     */
    public function addParent($parent){
        $this->add(array(
            'name' => 'parent_id',
            'type' => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'value' => $parent,
            ),
        ));
    }
    
    /**
     * add a hidden field edit_id for the form,when the form is used to edit the section details
     * @param string $editid the value of the field
     */    
    public function addEditid($editid){
        $this->add(array(
            'name' => 'edit_id',
            'type' => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'value' => $editid,
            ),
        ));
        
        $this->setAttribute('id', 'formeditsection');
    }    
} 