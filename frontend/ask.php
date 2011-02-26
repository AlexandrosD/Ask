<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import joomla controller library
jimport('joomla.application.component.controller');
 
//Initialize the custom logger
require_once ("custom_logger.php");
global $logger;
$logger = new CustomLogger("/home/alexd3499/asklog.log");
		
//Set the loglevel
$logger->setLoglevel(CustomLogger::LOG_INFO);

// Get an instance of the controller prefixed by HelloWorld
$controller = JController::getInstance('ask');
 
// Perform the Request task
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
