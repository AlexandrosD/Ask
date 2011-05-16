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
        function display($tpl = null) 
        {        	
        	$this->items = $this->get('Items');
			$this->pagination = $this->get('Pagination');
			$this->state = $this->get("State");
			
			$this->addToolBar();
			
			//Calculate parents..
			foreach ($this->items as $item){
				$parent = NULL;
				if ($item->parent){
					$q = "SELECT * FROM #__ask WHERE id=" . (int)$item->parent;
					$db = JFactory::getDBO();
					$db->setQuery($q);
					$parent = $db->loadObject();
				}
				$item->parentData = $parent;
				
				//tags
				$item->tags = json_decode($item->tags);
				
			}
			
            // Display the template
            parent::display($tpl);
        }
        
		protected function addToolBar() 
        {
        	$user= JFactory::getUser();
        	
            JToolBarHelper::title(JText::_('QUESTIONS'));
            
            AskHelper::canDo("core.create") ? JToolBarHelper::addNewX('question.add') : NULL ;
            AskHelper::canDo("core.edit") ? JToolBarHelper::editListX('question.edit') : NULL;
            AskHelper::canDo("question.publish") ? JToolBarHelper::publishList("questions.publish") : NULL;
            AskHelper::canDo("question.publish") ? JToolBarHelper::unpublishList("questions.unpublish") : NULL;
            AskHelper::canDo("question.delete") ? JToolBarHelper::deleteListX(JText::_("ITEM_DEL_Q"), 'questions.delete') : NULL;
            AskHelper::canDo("core.admin") ? JToolBarHelper::preferences("com_ask") : NULL;
        }
}
