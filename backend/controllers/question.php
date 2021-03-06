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
 

class AskControllerQuestion extends JControllerForm
{
	public function save (){
		//TODO: Validate & Sanitize
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
		
		//tags -- retrieve the and store them as json
		$tags = $data['tags'];
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
			//replace the request object
			JRequest::setVar("jform" , $data);
		}
		
		if (parent::save()) {
			$msg = JText::_("MSG_ITEM_SAVED");
			$url = "index.php?option=com_ask&view=questions&answers=" . $displayAnswers;
			$this->setRedirect($url , $msg);
		}		
		
	}
	public function edit() {
		global $logger;
		
		if (!AskHelper::canDo("core.edit")){
			$this->setRedirect("index.php?option=com_ask&view=questions&answers=" . (int)(AskHelper::getActiveSubmenu()=="Answers") , JText::_("MSG_NOAUTH") ,  "error");
			return;
		}
		
		$question = JRequest::getInt("question",1);
		$parent = JRequest::getInt("parent",0);
		$catid = JRequest::getInt("catid", 0);
		
		$app = JFactory::getApplication();
		$app->setUserState("isQuestion", $question);
		$app->setUserState("parentID", $parent);
		$app->setUserState("catid", $catid);
		
		$logger->info ("Item type & parent id, catid set!");
		
		parent::edit();
	}
}
