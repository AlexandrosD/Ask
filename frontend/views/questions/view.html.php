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

class AskViewQuestions extends JView
{
        // Overwriting JView display method
        function display($tpl = null) 
        {
        	global $logger;
            
        	$this->questions = $this->get("Items");
        	$this->pagination = $this->get("Pagination");
        	
        	$this->document = JFactory::getDocument();
        	
        	$this->filteringOptions = $this->get("filteringOptions");
        	$this->sortingOptions = $this->get("sortingOptions");
        	
        	//Category View
        	$this->categoryView = FALSE; //Initialization
        	if (JRequest::getInt( "catid" , 0 ))
        		$this->categoryView = TRUE;
        		
        	//Tag View
        	$this->tag = JRequest::getString("tag" , NULL);
        	
        	//Authorizations
        	$user = JFactory::getUser();
        	$this->assignRef("viewanswers", $user->authorize("question.viewanswers" , "com_ask"));
        	$this->assignRef("submitanswers", $user->authorize("question.answer" , "com_ask"));
        	
        	//params
        	$app = JFactory::getApplication();
        	$params = $app->getParams();
        	$this->assignRef("params", $params);
        	$this->assignRef("pageclass_sfx" , htmlspecialchars($params->get('pageclass_sfx')));
        	
        	//view options
        	$this->viewStats = JRequest::getInt("display_stats");
        	$this->viewFilteringOptions = JRequest::getInt("display_filters");
        	$this->viewGravatars = JRequest::getInt("display_gravatars");
        	       
        	if ( @$this->questions ){ //check for questions, suppressing errors..
	        	
	        	// Add feed links
				$link = '&format=feed&limitstart=';
				$attribs = array('type' => 'application/rss+xml', 'title' => 'RSS 2.0');
				$this->document->addHeadLink(JRoute::_($link . '&type=rss'), 'alternate', 'rel', $attribs);
				$attribs = array('type' => 'application/atom+xml', 'title' => 'Atom 1.0');
				$this->document->addHeadLink(JRoute::_($link . '&type=atom'), 'alternate', 'rel', $attribs);
        		
	        	parent::display($tpl);
        	}
        	else{
        		$logger->error("No Results..");
        		JError::raiseNotice(404, JText::_("ERROR_404"));
        	}
        	
        }
}
