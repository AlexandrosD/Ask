<?php
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
    	
    	$this->setRedirect("index.php?option=com_ask&view=questions&answers=" . JRequest::getInt("answers" , 0) ,"State Changed!");
    }
    
    public function delete(){
    	global $logger;
    	$logger->info("AskControllerQuestions::delete()");
    	
    	parent::delete();
    	
    	$this->setRedirect("index.php?option=com_ask&view=questions&answers=" . JRequest::getInt("answers" , 0) ,"Item Deleted!");
    }
    
}
