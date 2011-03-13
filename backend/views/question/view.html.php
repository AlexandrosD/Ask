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
	public function display( $tpl = null ){
		global $logger;
		$logger->info("AskViewQuestion::display()");
		
		$form = $this->get("Form");
		$item = $this->get("Item");
		
		if (count($errors = $this->get("Errors"))){
			JError::raiseError(500, implode("<br />" , $errors));
			$logger->error("ERROR!");
			$logger->error( implode("\n" , $errors ));
			return false;
		}
		
		$this->form = $form;
		$this->item = $item;
		
		$this->addToolBar();
		
		$logger->info ("AskViewQuestion, calling parent::display()");
		parent::display($tpl);
	}
	
	public function addToolBar(){
		global $logger;
		$logger->info("AskViewQuestion::addToolBar");
		$isNew = ($this->item->id == 0);
		JToolBarHelper::title($isNew ? JText::_("NEW_QUESTION") : JText::_("EDIT_QUESTION"));
		JToolBarHelper::save("question.save");
		JToolBarHelper::cancel( "question.cancel" , $isNew ? "JTOOLBAR_CANCEL" : "JTOOLBAR_CLOSE" );
	}
	
}