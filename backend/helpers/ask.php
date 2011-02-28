<?php
// No direct access to this file
defined('_JEXEC') or die;

abstract class AskHelper {
	
	public static function addSubmenu($submenu){		
		JSubMenuHelper::addEntry(JText::_('QUESTIONS'), 'index.php?option=com_ask', $submenu == "Questions");
		JSubMenuHelper::addEntry(JText::_('ANSWERS'), 'index.php?option=com_ask&answers=1', $submenu == "Answers");
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
		if ( JRequest::getInt("answers" , 0) ){
			return "Answers";
		}
		else {
			return "Questions";		
		}
	}
	
	public static function canDo($action){
		$user = JFactory::getUser();
		return $user->authorize($action , "com_ask");
	}
	
}