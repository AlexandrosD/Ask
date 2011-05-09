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
 
// import Joomla view library
jimport('joomla.application.component.view');

class AskViewQuestion extends JView
{
        // Overwriting JView display method
        function display($tpl = null) 
        {
        	global $logger;
            
        	$this->question = $this->get("Item");

        	//Authorizations
        	$user = JFactory::getUser();
        	$this->assignRef("viewanswers", $user->authorize("question.viewanswers" , "com_ask"));
        	$this->assignRef("submitanswers", $user->authorize("question.answer" , "com_ask"));
        	
        	//params
        	$app = JFactory::getApplication();
        	$params = $app->getParams();
        	$this->assignRef("params", $params);
        	$this->assignRef("pageclass_sfx" , htmlspecialchars($params->get('pageclass_sfx')));
        	
        	if ( @$this->question ){ //check for questions, suppressing errors..
	        	//$logger->info ( json_encode($this->question) );
	        	parent::display($tpl);
        	}
        	else{
        		$logger->error("No Results..");
        		JError::raiseNotice(404, JText::_("ERROR_404"));
        	}
        }
}
