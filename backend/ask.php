<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
require_once("../components/com_ask/custom_logger.php");
global $logger;
$logger = new CustomLogger("/home/alexd3499/asklog.log");
$logger->setLoglevel(CustomLogger::LOG_INFO);
$logger->info("ADMIN Action started");

// Access check.
//if (!JFactory::getUser()->authorise('core.manage', 'com_content')) {
	//return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
//}

// import joomla controller library
jimport('joomla.application.component.controller');
JLoader::register('AskHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'ask.php');
 
$controller = JController::getInstance('ask');
 
// Perform the Request task
$logger->info("TASK: " . JRequest::getVar('task') . " - VIEW: " . JRequest::getVar('view') );
$controller->execute(JRequest::getCmd('task'));

$logger->info("ADMIN Action completed");
// Redirect if set by the controller
$controller->redirect();