<?php
/*------------------------------------------------------------------------
# com_ask - Ask (Questions)
# ------------------------------------------------------------------------
# @author    Alexandros D
# @copyright Copyright (C) 2011 Alexandros D. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# @Website: http://alexd.mplofa.com
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
 jimport('joomla.application.component.controllerform');

class AskControllerForm extends JControllerForm {
	
	public function save(){ //Just For Logging Reference
		global $logger;
		$logger->info("AskControllerForm::save()");
		
		//Transparent Captcha
		$captcha = JRequest::getString("LastName");
		if ($captcha){
			JError::raiseError(404 , ""); 
		}
		
		parent::save();
		
		$this->setRedirect(JRoute::_("index.php?option=com_ask&view=questions"));
	}
	
	public function cancel(){
		$this->setRedirect(JRoute::_("index.php?option=com_ask&view=questions"));
	}
	
}