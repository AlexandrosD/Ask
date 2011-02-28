<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 

class AskControllerQuestion extends JControllerForm
{
	public function save (){
		//Method to save a question - just calls the parent && sets the redirect
		global $logger;
		$logger->info("AskControllerQuestion::save()");
		
		$data = JRequest::getVar('jform', array(), 'post', 'array');

		if ($data['question']){
			$displayAnswers = 0;
		}
		else {
			$displayAnswers = 1;
		}
		
		parent::save();
		
		$this->setRedirect("index.php?option=com_ask&view=questions&answers=" . $displayAnswers,JText::_("MSG_ITEM_SAVED"));
	}
	public function edit() {
		global $logger;
		
		if (!AskHelper::canDo("core.edit")){
			$this->setRedirect("index.php?option=com_ask&view=questions&answers=" . (int)(AskHelper::getActiveSubmenu()=="Answers") , JText::_("MSG_NOAUTH") ,  "error");
			return;
		}
		
		$question = JRequest::getInt("question",1);
		$parent = JRequest::getInt("parent",0);
		
		$app = JFactory::getApplication();
		$app->setUserState("isQuestion", $question);
		$app->setUserState("parentID", $parent);
		
		$logger->info ("Item type & parent id set!");
		
		parent::edit();
	}
}
