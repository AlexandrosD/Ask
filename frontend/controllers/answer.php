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
jimport('joomla.application.component.controller');
 

class AskControllerAnswer extends JController
{
	public function __construct(){
		parent::__construct();
	}
	
	public function save(){
		//CSRF Anti-spoofing
		JRequest::checkToken() or die( 'Invalid Token' );
		
		global $logger;
		$logger->info("Saving Answer..");
		
		//Transparent Captcha
		$captcha = JRequest::getString("LastName");
		if ($captcha){
			JError::raiseError(404 , ""); 
		}
		
	 $title = JRequest::getString("title");
        //static method getString clean variable htmlspecialchars() not required (xss cleanup) see request.php line 248
        
        
        $text = JRequest::getString("text");

        $name = JRequest::getString("name");
        $parent = (int) JRequest::getInt("question_id");


        $submitted = date("Y-m-d H:i");
        $userid_creator = JFactory::getUser()->id;

        $ip = JRequest::getString("ip");
        $email = JRequest::getString("email");
        $catid = JRequest::getInt("catid");



        //TODO: Determine State
        $published = 1;

        //VALIDATE DATA
        $valid = TRUE;
        $msg = "";

        if ((!JFactory::getUser()->id) && (!$name)) {
            $valid = FALSE;
            $msg.="<br />" . JText::_("ERR_ANSWER_NONAME");
        }

        if (!$text) {
            $valid = FALSE;
            $msg.="<br />" . JText::_("ERR_ANSWER_NOTEXT");
        }

        if (!$title) {
            $valid = FALSE;
            $msg.="<br />" . JText::_("ERR_ANSWER_NOTITLE");
        }

        if (!$valid) {
            $return = JRoute::_("index.php?option=com_ask&view=question&name=$name&title=$title&text=$text&id=" . $parent);
            parent::setRedirect($return, JText::_("ERR_FILL_ALL_REQ_FIELDS") . $msg, "ERROR");
            return;
        }

        $db = JFactory::getDBO();



        $data = new stdClass;

        $data->id = NULL;
        $data->title = $title;
        $data->text = $text;
        $data->submitted = $submitted;
        $data->modified = NULL;
        $data->userid_creator = $userid_creator;
        $data->userid_modifier = NULL;
        $data->question = 0;
        $data->votes_possitive = 0;
        $data->votes_negative = 0;
        $data->parent = $parent;
        $data->impressions = 0;
        $data->published = $published;
        $data->chosen = 0;
        $data->name = $name;
        $data->ip = $ip;
        $data->email = $email;
        $data->catId = $catid;
        
        

        if ($db->insertObject('#__ask', $data)) {
            $message = JText::_("MSG_ANSW_SAVED");
            $type = NULL;
        } else {
            $message = JText::_("MSG_ANSW_NOSAVE");
            $type = "ERROR";
        }

        $return = JRequest::getString("returnTo");
        parent::setRedirect($return, $message, $type);
    }
	
	public function choose(){
		$ok = FALSE;
		
		//IDs..
		$qid = JRequest::getInt("questionid");
		$aid = JRequest::getInt("answerid");
		
		$q = "UPDATE #__ask SET chosen=0 WHERE parent=$qid";
		$db = JFactory::getDbo();
		$db->setQuery($q);
		
		if ($db->query())
			$ok = TRUE;
		else 
			$err = " - " . $db->getErrorMsg();
		
		if ($ok){
			$q="UPDATE #__ask SET chosen=1 WHERE id=$aid";
			
			$db->setQuery($q);
			
			if ($db->query())
				$ok = TRUE;
			else 
				$err = $db->getErrorMsg();
		}
			
		if ($ok)
			$msg = JText::_("ANSWER_CHOOSE_OK");
		else
			$msg = JText::_("ANSWER_CHOOSE_NOK") . $err;
		
		$this->setRedirect( JRoute::_("index.php?option=com_ask&view=question&id=$qid") , $msg);
	}
	
	public function chooseReset(){
		$ok = FALSE;
		
		//IDs..
		$qid = JRequest::getInt("questionid");
		$aid = JRequest::getInt("answerid");
		
		$q = "UPDATE #__ask SET chosen=0 WHERE parent=$qid";
		$db = JFactory::getDbo();
		$db->setQuery($q);
		
		if ($db->query())
			$ok = TRUE;
		else 
			$err = " - " . $db->getErrorMsg();
			
		if ($ok)
			$msg = JText::_("ANSWER_CHOOSERESET_OK");
		else
			$msg = JText::_("ANSWER_CHOOSERESET_NOK") . $err;
		
		$this->setRedirect( JRoute::_("index.php?option=com_ask&view=question&id=$qid") , $msg);
	}
	
}

       