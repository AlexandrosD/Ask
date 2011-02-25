<?php
// No direct access to this file
defined('_JEXEC') or die;

abstract class AskHelper {
	
	public static function addSubmenu($submenu){
		/*
		 *  JSubMenuHelper::addEntry(JText::_('COM_HELLOWORLD_SUBMENU_MESSAGES'), 'index.php?option=com_helloworld', $submenu == 'messages');
                JSubMenuHelper::addEntry(JText::_('COM_HELLOWORLD_SUBMENU_CATEGORIES'), 'index.php?option=com_categories&view=categories&extension=com_helloworld', $submenu == 'categories');
                // set some global property
                $document = JFactory::getDocument();
                $document->addStyleDeclaration('.icon-48-helloworld {background-image: url(../media/com_helloworld/images/tux-48x48.png);}');
                if ($submenu == 'categories') 
                {
                        $document->setTitle(JText::_('COM_HELLOWORLD_ADMINISTRATION_CATEGORIES'));
                }
		 */
		
		JSubMenuHelper::addEntry(JText::_('Questions'), 'index.php?option=com_ask', $submenu == "Questions");
		JSubMenuHelper::addEntry(JText::_('Answers'), 'index.php?option=com_ask&answers=1', $submenu == "Answers");
	}
	
	public static function getActions(){
		/*
		 *  $user  = JFactory::getUser();
                $result        = new JObject;
 
                if (empty($messageId)) {
                        $assetName = 'com_helloworld';
                }
                else {
                        $assetName = 'com_helloworld.message.'.(int) $messageId;
                }
 
                $actions = array(
                        'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.delete'
                );
 
                foreach ($actions as $action) {
                        $result->set($action,        $user->authorise($action, $assetName));
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