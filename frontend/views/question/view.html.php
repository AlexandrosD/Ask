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
            
        	$user = JFactory::getUser();
        	$app = JFactory::getApplication();
        	
        	$this->question = $this->get("Item");

        	//Authorizations
        	$user = JFactory::getUser();
        	$this->assignRef("viewanswers", $user->authorize("question.viewanswers" , "com_ask"));
        	$this->assignRef("submitanswers", $user->authorize("question.answer" , "com_ask"));
        	
        	//params
        	$params = $app->getParams();
        	$this->assignRef("params", $params);
        	$this->assignRef("pageclass_sfx" , htmlspecialchars($params->get('pageclass_sfx')));
        	
        	//check ownership
        	$isOwner = (bool)($user->id == $this->question->userid_creator && $user->id != 0 );
        	$this->assignRef("isOwner", $isOwner);  

        	//Add Pathway
        	AskHelper::addPathway(); 
        	$pathway=$app->getPathway();
        	$pathway->addItem ( $this->question->title );
        	
        	if ( @$this->question && $this->question->viewable ){ //check for questions, suppressing errors..
	        		parent::display($tpl);

        	}
        	else{
        		$logger->error("No Results..");
        		JError::raiseNotice(404, JText::_("ERROR_404"));
        	}
        }
}
