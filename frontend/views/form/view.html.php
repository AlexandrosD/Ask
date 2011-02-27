<?php
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class AskViewForm extends JView
{
	protected $form;
	protected $item;

	public function display( $tpl = NULL ){
		
		global $logger;
		$logger->info("AskViewForm::display()");
		
		$this->item = $this->get("Item");
		$this->form = $this->get("Form");
		
		$app = JFactory::getApplication();
		$user = JFactory::getUser();
		
		//authorization
		//TODO: update for edit own questions
		if (!$user->authorize("core.create" , "com_ask")){
			JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			return false;
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