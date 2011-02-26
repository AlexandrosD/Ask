<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
 jimport('joomla.application.component.controllerform');

class AskControllerQuestion extends JControllerForm {
	
	public function save(){
		echo "save - TODO";
		//parent::save();
		//TODO Add new model and table
	}
	
	public function cancel(){
		echo "cancel";
	}
	
}