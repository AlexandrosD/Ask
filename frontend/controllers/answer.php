<?php
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
		
		//TODO: Determine State
		$published = 1;
		
		//VALIDATE DATA
		$valid = TRUE;
		$msg = "";
		
		if ((!JFactory::getUser()->id) && (!$name)){
			$valid = FALSE;
			$msg.="<br />Please enter your name";
		}
		
		if (!$text) {
			$valid = FALSE;
			$msg.="<br />Text cannot be empty";
		}
		
		if (!$title){
			$valid = FALSE;
			$msg.= "<br />Title cannot be empty";
		}
		
		if(!$valid){
			$return = JRoute::_("index.php?option=com_ask&view=question&name=$name&title=$title&text=$text&id=" . $parent);		
			parent::setRedirect($return , "Please fill all the required fiels" . $msg , "ERROR");
			return;
		}
		
		//Build the insert query
		$db = JFactory::getDBO();
		$q = "INSERT INTO #__ask";
		$q.= "(`id` ,`title` ,`text` ,`submitted` ,`modified` ,`userid_creator` ,`userid_modifier` ,`question` ,`votes_possitive` ,`votes_negative` ,`parent` ,`impressions` ,`published` ,`chosen` , `name`)";
		$q.= "VALUES (NULL, '$title' , '$text' , '$submitted' , NULL , '$userid_creator' , NULL , '0' , '0' , '0' , '$parent' , '0' , '$published' , '0' , '$name' )";
		
		$logger->info($q);
		
		$db->setQuery($q);
		
		if ($db->query()){
			$message = "Answer Saved!";
			$type = NULL;
		} else {
			$message = "Cannot Save Answer";
			$type="ERROR";
		}
		
		$return = JRoute::_("index.php?option=com_ask&view=question&id=" . $parent);		
		parent::setRedirect($return , $message , $type);
	}
	
}