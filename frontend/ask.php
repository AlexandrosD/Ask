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
 
// import joomla controller library
jimport('joomla.application.component.controller');
 
//Initialize the custom logger
require_once ("custom_logger.php");
global $logger;
$logger = new CustomLogger("/home/alexd3499/asklog.log");

//Set the loglevel
$logger->setLoglevel(CustomLogger::LOG_INFO);

//Add stylesheet
$doc = JFactory::getDocument();
$doc->addStyleSheet("components/com_ask/media/stylesheet.css");

// Get an instance of the controller prefixed by HelloWorld
$controller = JController::getInstance('ask');
 
// Perform the Request task
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
