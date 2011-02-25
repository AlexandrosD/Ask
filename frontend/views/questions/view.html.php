<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
/**
 * HTML View class for the HelloWorld Component
 */
class AskViewQuestions extends JView
{
        // Overwriting JView display method
        function display($tpl = null) 
        {
        	global $logger;
            
        	$this->questions = $this->get("Items");
        	$this->pagination = $this->get("Pagination");
       
        	if ( @$this->questions ){ //check for questions, suppressing errors..
	        	//$logger->info ( json_encode($this->questions) );
	        	parent::display($tpl);
        	}
        	else{
        		$logger->error("No Results..");
        		JError::raiseNotice(404, "Nothing found");
        	}
        }
}
