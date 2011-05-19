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

jimport('joomla.application.component.view');

class AskViewForm extends JView
{
	protected $form;
	protected $item;

	public function display( $tpl = NULL ){
		
		global $logger;
		$logger->info("AskViewForm::display()");
		
		$this->form = $this->get("Form");
		$this->item = $this->get("Item");
		
		$app = JFactory::getApplication();
		$user = JFactory::getUser();
		
		//authorization
		if (!$user->authorize("core.create" , "com_ask")){
			JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			return false;
		}
		
		if ($user->id){
			$this->form->setFieldAttribute("name", "type", "hidden");
		}
		
		//params
		$params = $app->getParams();
		$this->assignRef("params", $params);
		
		//Page class suffix
		$this->assignRef("pageclass_sfx", htmlspecialchars($params->get('pageclass_sfx')));
		
		$this->assignRef("user", $user);

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseWarning(500, implode("\n", $errors));
			return false;
		}
		
		parent::display($tpl);
	}
	
}