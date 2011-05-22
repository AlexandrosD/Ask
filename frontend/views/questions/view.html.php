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
        
        function getFilteringOptions(){
        	
        	$currentOptions = "&tag=" . JRequest::getString("tag") . "&catid=" . JRequest::getInt("catid");
        	
        	$answered = 
        		"<li><a " . (JRequest::getInt("answered" , 0)?'class=active':'') . " href='" . JRoute::_("index.php?option=com_ask&view=questions&answered=1" . $currentOptions)  . "'>" . JText::_("FILTER_ANSWERED") . "</a></li>";
        	
        	$notanswered = 
        		"<li><a " . (JRequest::getInt("notanswered" , 0)?'class=active':'') . " href='" . JRoute::_("index.php?option=com_ask&view=questions&notanswered=1" . $currentOptions)  . "'>" . JText::_("FILTER_NOTANSWERED") . "</a></li>";
        	
        	$resolved = 
        		"<li><a " . (JRequest::getInt("resolved" , 0)?'class=active':'') . " href='" . JRoute::_("index.php?option=com_ask&view=questions&resolved=1" . $currentOptions)  . "'>" . JText::_("FILTER_RESOLVED") . "</a></li>";
        	
        	$unresolved = 
        		"<li><a " . (JRequest::getInt("unresolved", 0)?'class=active':'') . " href='" . JRoute::_("index.php?option=com_ask&view=questions&unresolved=1" . $currentOptions)  . "'>" . JText::_("FILTER_UNRESOLVED") . "</a></li>";
        	
        	$options = "<div class='questions_filters'><ul>" . $answered . $notanswered . $resolved . $unresolved . "</ul></div>";
        	
        	return $options;
        }
        
        function getSortingOptions(){
        	
        }
}
