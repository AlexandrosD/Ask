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
	function display($tpl = null) {
		
		$app = JFactory::getApplication();

		$doc	= JFactory::getDocument();
		$params = $app->getParams();
		
		$this->questions = $this->get("Items");
		
		foreach ($this->questions as $question){
			
			// strip html from feed item title
			$title = $this->escape($question->title);
			$title = html_entity_decode($title, ENT_COMPAT, 'UTF-8');
			
			// url link to article
			// & used instead of &amp; as this is converted by feed creator
			$link = JRoute::_("index.php?option=com_ask&view=question&id=" . $question->id);
			
			$description	= $this->escape($question->text);
			$author			= JFactory::getUser($question->userid_creator)->name;
			@$date			= date('r', strtotime($question->submitted));
			
			$item = new JFeedItem();
			
			$item->title		= $title;
			$item->link			= $link;
			$item->description	= $description;
			$item->date			= $date;
			//$item->category		= $question->category;
			$item->author		= $author;
			
			$doc->addItem($item);
				
		}
		
	}
}
