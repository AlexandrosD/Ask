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
		global $logger;
		$logger->info("Saving Answer..");
		
		$title = JRequest::getString("title");
		$title = htmlspecialchars($title);
		$title = mysql_real_escape_string($title);
		
		$text = JRequest::getString("text");
		$text = htmlspecialchars($text);
		$text = mysql_real_escape_string($text);
		
		$name = JRequest::getString("name");
		$name = htmlspecialchars($name);
		$name = mysql_real_escape_string($name);
		
		$parent = (int) JRequest::getInt("question_id");
		$parent = mysql_real_escape_string($parent);
		
		$submitted = date("Y-m-d H:i");
		$userid_creator = JFactory::getUser()->id;
		
		$ip = JRequest::getString("ip");
		$ip = mysql_real_escape_string($ip);
		
		$email = JRequest::getString("email");
		$email = mysql_real_escape_string($email);
		
		//TODO: Determine State
		$published = 1;
		
		//VALIDATE DATA
		$valid = TRUE;
		$msg = "";
		
		if ((!JFactory::getUser()->id) && (!$name)){
			$valid = FALSE;
			$msg.="<br />" . JText::_("ERR_ANSWER_NONAME");
		}
		
		if (!$text) {
			$valid = FALSE;
			$msg.="<br />" . JText::_("ERR_ANSWER_NOTEXT");
		}
		
		if (!$title){
			$valid = FALSE;
			$msg.="<br />" . JText::_("ERR_ANSWER_NOTITLE");
		}
		
		if(!$valid){
			$return = JRoute::_("index.php?option=com_ask&view=question&name=$name&title=$title&text=$text&id=" . $parent);		
			parent::setRedirect($return , JText::_("ERR_FILL_ALL_REQ_FIELDS") . $msg , "ERROR");
			return;
		}
		
		//Build the insert query
		$db = JFactory::getDBO();
		$q = "INSERT INTO #__ask";
		$q.= "(`id` ,`title` ,`text` ,`submitted` ,`modified` ,`userid_creator` ,`userid_modifier` ,`question` ,`votes_possitive` ,`votes_negative` ,`parent` ,`impressions` ,`published` ,`chosen` , `name`, `ip`, `email`)";
		$q.= "VALUES (NULL, '$title' , '$text' , '$submitted' , NULL , '$userid_creator' , NULL , '0' , '0' , '0' , '$parent' , '0' , '$published' , '0' , '$name' , '$ip', '$email')";
		
		$logger->info($q);
		
		$db->setQuery($q);
		
		if ($db->query()){
			$message = JText::_("MSG_ANSW_SAVED");
			$type = NULL;
		} else {
			$message = JText::_("MSG_ANSW_NOSAVE");
			$type="ERROR";
		}
		
		$return = JRoute::_("index.php?option=com_ask&view=question&id=" . $parent);		
		parent::setRedirect($return , $message , $type);
	}
	
}