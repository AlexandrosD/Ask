<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HelloWorlds View
 */
class AskViewQuestions extends JView
{
        function display($tpl = null) 
        {
        	/*
            // Get data from the model
            ;
            $pagination = $this->get('Pagination');
            // Check for errors.
 			if (count($errors = $this->get('Errors'))) 
            {
            	JError::raiseError(500, implode('<br />', $errors));
                return false;
            }
            // Assign data to the view
            $this->items = $items;
            
            */
        	
        	$this->items = $this->get('Items');
			$this->pagination = $this->get('Pagination');
        	
			$this->addToolBar();
			
            // Display the template
            parent::display($tpl);
        }
        
		protected function addToolBar() 
        {
                JToolBarHelper::title(JText::_('Ask Questions'));
                JToolBarHelper::deleteListX('', 'question.delete');
                JToolBarHelper::editListX('question.edit');
                JToolBarHelper::addNewX('question.add');
                JToolBarHelper::preferences("com_ask");
        }
}
