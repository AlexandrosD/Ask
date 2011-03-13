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
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 

class AskControllerQuestions extends JControllerAdmin
{   
	function __construct(){	
		parent::__construct();
	} 
	
    public function getModel($name = 'Question', $prefix = 'AskModel') 
    {
    	//In case no parameters are injected to this function, a reference to single question model
    	//will be returned 
    	//This is needed for publishing/unpublishing items
     	global $logger;
       	$logger->info("AskControllerQuestions::getModel()");
    	$model = parent::getModel($name, $prefix, array('ignore_request' => true));
        return $model;
    }	
    
    //Overide core finctions in order to set the redirect correctly
    public function publish(){
    	global $logger;
    	$logger->info("AskControllerQuestions::publish()");
    	
    	parent::publish();
    	
    	$this->setRedirect("index.php?option=com_ask&view=questions&answers=" . JRequest::getInt("answers" , 0) ,JText::_("MSG_STATE_CHANGED"));
    }
    
    public function delete(){
    	global $logger;
    	$logger->info("AskControllerQuestions::delete()");
    	
    	parent::delete();
    	
    	$this->setRedirect("index.php?option=com_ask&view=questions&answers=" . JRequest::getInt("answers" , 0) ,JText::_("MSG_ITEM_DELETED"));
    }
    
}
