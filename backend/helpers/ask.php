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
	
	public static function getActions(){
		/*
		 *  $user  = JFactory::getUser();
                $result = new JObject;
 
                if (empty($messageId)) {
                        $assetName = 'com_ask';
                }
                else {
                        $assetName = 'com_ask.message.'.(int) $messageId;
                }
 
                $actions = array(
                        'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.delete'
                );
 
                foreach ($actions as $action) {
                        $result->set($action, $user->authorize($action, $assetName));
                }
 
                return $result;

		 */
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
	
	public function getCurrentPageURL(){
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
}