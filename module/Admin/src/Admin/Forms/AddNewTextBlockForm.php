<?php
namespace Admin\Forms;


use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;

class AddNewTextBlockForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('forms');

        $this->setAttributes(array(
            'method' => 'post',
            'class'  => 'form-horizontal',
            'id'     => 'formaddnewtextblock', 
        ));

        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Name',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));

        $this->add(array(
            'name' => 'content',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Content ...',
            ),
            'options' => array(
                'label' => 'Content',
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
                'id'    => 'submitaddnewtextblock',
            ),
        ));        

    }
    
    /**
     * add a hidden field section_id for the form
     * @param string $section the value of the field
     */
    public function addParentSection($section){
        $this->add(array(
            'name' => 'section_id',
            'type' => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'value' => $section,
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
    
        $this->setAttribute('id', 'formedittextblock');
    }    
}