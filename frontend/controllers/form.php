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
		
		//authorization
		$user = JFactory::getUser();
		if (!$user->authorize("core.create" , "com_ask")){
			JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			return false;
		}
		
		//Transparent Captcha
		$captcha = JRequest::getString("LastName");
		if ($captcha){
			JError::raiseError(404 , ""); 
		}
			
		//load request data
		$data = JRequest::getVar('jform', array(), 'post', 'array');

		//parse config options
		$params = json_decode(JFactory::getApplication()->getParams());
		
		//Determine default state 
		// TODO: 	Check if the user is allowed to alter the state
		//			- If so, then do not use the default state, but leave the state as is
		if (TRUE){
			$data['published'] = (int) $params->defaultQuestionState;
		}
		
		//Encode the tags to json..
		$tags = $data["tags"];
		$tagsPlainText = $tags; 	// preserve original tag data as inserted by the user
									// in order the form to contain the exact tag info, 
									// i.e. data in plain text format and NOT json
		if ($tags){
			$tags = explode("," , $tags);
			$tags = json_encode ( $tags );
			$tags = str_replace(' ', '', $tags);
			$tags = str_replace(',""', '', $tags);
			$tags = json_decode($tags);
			//remove duplicates
			$tags = array_values(array_unique($tags));
			$tags = json_encode ( $tags );
			$data['tags'] = $tags;
			//replace the original request
			JRequest::setVar("jform" , $data);
		}		
		
		if (parent::save()) {
			if ($data['id']) { //do we have an id?
				$lastid = $data['id'];	//if so, use it
			}
			else { //if no, use the last inserted id
				$db = &JFactory::getDbo();
				$lastid = $db->insertid();
			}
			//redirect & display the inserted data
			$this->setRedirect(JRoute::_("index.php?option=com_ask&view=questions"));
			//clear state
			JFactory::getApplication()->setUserState("com_ask.edit.question.data", array());
		}
		else {
			//store temp data
			$data['tags'] = $tagsPlainText;
			JFactory::getApplication()->setUserState("com_ask.edit.question.data", $data);
		}
	}
	
	public function cancel(){
		echo "<script type='text/javascript'>javascript:history.go(-2);</script>";
		//clear state
		JFactory::getApplication()->setUserState("com_ask.edit.question.data", array());
	}
	
}