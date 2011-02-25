<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
require_once ("custom_logger.php");

class AskController extends JController
{
	public function display( $tpl = NULL )
	{
		//TODO: Specify a default view...later...
		//JRequest::setVar('view','questions');
		
		//Initialize the custom logger
		global $logger;
		$logger = new CustomLogger("/home/alexd3499/asklog.log");
		
		//Set the loglevel
		$logger->setLoglevel(CustomLogger::LOG_INFO);
		
		//Call the display function
		$logger->info("Controller - Calling parent::display..");		
		return parent::display();
	}
}
