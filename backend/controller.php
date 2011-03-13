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
