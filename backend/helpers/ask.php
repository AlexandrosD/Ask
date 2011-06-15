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

abstract class AskHelper {
	
	public static function addSubmenu($submenu){		
		JSubMenuHelper::addEntry(JText::_('QUESTIONS'), 'index.php?option=com_ask', $submenu == "Questions");
		JSubMenuHelper::addEntry(JText::_('ANSWERS'), 'index.php?option=com_ask&answers=1', $submenu == "Answers");
		JSubMenuHelper::addEntry(JText::_('CATEGORIES'), 'index.php?option=com_categories&view=categories&extension=com_ask', $submenu == 'categories');
	}
	
	public static function getActiveSubmenu(){
		$option = JRequest::getVar("option");
		if ( JRequest::getInt("answers" , 0) ){
			return "Answers";
		}
		elseif ( $option == "com_categories" ){
			return "Categories";
		}
		else {
			return "Questions";		
		}
	}
	
	public static function canDo($action){
		$user = JFactory::getUser();
		return $user->authorize($action , "com_ask");
	}
	
	public static function getCurrentPageURL(){
		$pageURL = 'http';
 		if (isset($_SERVER["HTTPS"]) &&  $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 		$pageURL .= "://";
 		if ($_SERVER["SERVER_PORT"] != "80") {
  			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 		} else {
  			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 		}
 		return $pageURL;
	}

	/**
	 * Method to add a pathway to the current view
	 *
	 *	@param $viewObject: a reference to the current view object
	 *
	 */
	public function addPathway(){
		
		$app = JFactory::getApplication();
		$pathway = $app->getPathway();
				
		$viewOptions = AskHelper::getActiveViewOptions( TRUE );

		//00. Generic
		$pathway->addItem( JText::_("QUESTIONS") , JRoute::_("index.php?option=com_ask&view=questions") );
       	
		//01. Category
       	if ($viewOptions->catid) {
       		$pathway->addItem( JText::_("CATEGORIES") );
       		$pathway->addItem(AskHelper::getCategoryName($viewOptions->catid) , JRoute::_("index.php?option=com_ask&view=questions&catid=" . $viewOptions->catid) );
       	}
		
       	//02. Tag
       	if ($viewOptions->tag){
       		$pathway->addItem( JText::_("TAGS") );
       		$pathway->addItem( $viewOptions->tag , JRoute::_("index.php?option=com_ask&view=questions&tag=" . $viewOptions->tag ) );  
       	}
       	
        //03. Filter
        if ($viewOptions->filter){
        	$pathway->addItem( JText::_("FILTER_" .$viewOptions->filter ) );
        }
       	
	}
	
	/**
	 * Method to get the active vie options
	 *
	 *	@param bool $viewObject: 	if true, an object will be returned
	 *								if false, query string vars will be returned
	 *
	 */
	public static function getActiveViewOptions( $returnObject = FALSE ){
		$viewOptions = new stdClass();
		$viewOptions->filter = JRequest::getWord("filter");
		$viewOptions->tag = JRequest::getWord("tag");
		$viewOptions->catid = JRequest::getInt("catid");
		
		if ($returnObject){
			return $viewOptions;
		}
		else {
			return 	"&catid=" 	. $viewOptions->catid	. 
				 	"&tag="		. $viewOptions->tag		.
					"&filter="	. $viewOptions->filter	;
		}
	}
	
	public static function getCategoryName ( $catid ){
		if ($catid==0)
			return;
		
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(TRUE);
		$query->select("cats.title");
		$query->from("#__categories AS cats");
		$query->where("cats.id=$catid");
		
		$db->setQuery($query);
		$catname = $db->loadObject();
		
		return $catname->title;
		
		/*
		$category = JCategories::getInstance('Ask')->get($catid);
		
		return $category->title;
		*/
	}
	
	/**
	 * 
	 * Method to return the title of an entry / row (question or answer)
	 * 
	 * @param $id int The row ID
	 * 
	 */
	public static function getTitle ( $id ) {
		 if ($id == 0)
		 	return; 
		 
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(TRUE);
		$query->select("title");
		$query->from("#__ask");
		$query->where("id=$id");
		
		$db->setQuery($query);
		$row = $db->loadObject();
		
		return $row->title;	
		 	
	}
}