<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of HelloWorld component
 */
class AskController extends JController
{
        function display($cachable = false) 
        {
                // set default view if not set
                JRequest::setVar('view', JRequest::getCmd('view', 'questions'));
 
                // call parent behavior
                parent::display($cachable);
                
                AskHelper::addSubmenu(AskHelper::getActiveSubmenu());
        }
}
