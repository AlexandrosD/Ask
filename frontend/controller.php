<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');

class AskController extends JController
{
	public function display( $tpl = NULL )
	{
		//TODO: Specify a default view...later...
		//JRequest::setVar('view','questions');
		
		global $logger;
		
		//Call the display function
		$logger->info("Controller - Calling parent::display..");		
		return parent::display();
	}
}
