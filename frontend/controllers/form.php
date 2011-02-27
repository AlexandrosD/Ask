<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
 jimport('joomla.application.component.controllerform');

class AskControllerForm extends JControllerForm {
	
	public function save(){ //Just For Logging Reference
		global $logger;
		$logger->info("AskControllerForm::save()");
		
		parent::save();
		
		$this->setRedirect(JRoute::_("index.php?option=com_ask&view=questions"));
	}
	
	public function cancel(){
		$this->setRedirect(JRoute::_("index.php?option=com_ask&view=questions"));
	}
	
}