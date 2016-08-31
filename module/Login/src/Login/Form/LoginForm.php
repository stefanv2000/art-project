<?php 
namespace Login\Form;

use Zend\Form\Form;
/**
 * Build form for the login page
 * @author Stefan Valea stefanvalea@gmail.com
 *
 */
class LoginForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('useraccount');

$this->setAttributes(array(
    'method' => 'post',
    'class'  => 'form-horizontal'
));

		$this->add(array(
				'name' => 'email',
				'type' => 'Zend\Form\Element\Text',
				'attributes' => array(
						'placeholder' => 'Enter email ...',
						'required' => 'required',
						'class' => 'form-control',						
				),
				'options' => array(
						'label' => 'Email',
				),
		));

		$this->add(array(
				'name' => 'password',
				'type' => 'Zend\Form\Element\Password',
				'attributes' => array(
						'placeholder' => 'Enter password ...',
						'required' => 'required',
						'class' => 'form-control',						
				),
				'options' => array(
						'label' => 'Password',
				),
		));

		$this->add(array(
				'name' => 'login',
				'attributes' => array(
						'type'  => 'submit',
						'value' => 'Login',
						'class' => 'btn btn-default',
				),
		));
		
	}
}