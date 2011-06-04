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

jimport('joomla.error.log');

class CustomLogger {
	
	//Variables
	private $_handle;
	private $_loglevel;
	private $_logfile;
	private $_options;
	
	//Constants
	const LOG_INFO 		= '9';
	const LOG_WARNING 	= '7';
	const LOG_ERROR		= '5';
	const LOG_SEVERE 	= '1';
	const LOG_NOLOG		= '0';
	
	function __construct( $filename = 'com_ask.log' , $loglevel = 0 , $format = '{DATE}_{TIME}_{USER_ID}_{CLASSNAME}: {COMMENT}' ){ 
		$this->_loglevel = $loglevel;
		$this->_logfile = $filename . ".php";	
		$this->_options = array(
	   		'format' => $format
		);
	}
	
	function setLoglevel( $level ){
		$this->_loglevel = $level;
	}
	
	function getLoglevel (){
		return $this->_loglevel;
	}
	
	function info($message){
	if ($this->_loglevel >= self::LOG_INFO){
			$this->_log($message , "INFO");
		}
	}
	
	function warning($message){
	if ($this->_loglevel >= self::LOG_WARNING){
			$this->_log($message , "WARNING");
		}
	}
	
	function error($message){
	if ($this->_loglevel >= self::LOG_ERROR){
			$this->_log($message , "ERROR");
		}
	}
	
	function severe($message){
	if ($this->_loglevel >= self::LOG_SEVERE){
			$this->_log($message , "SEVERITY");
		}
	}
	
	private function _log($message , $loglevel , $class = NULL){
		$userId = JFactory::getUser()->id;
		$log = &JLog::getInstance( $this->_logfile , $this->_options );
		$log->addEntry( array('comment' => $message , 'user_id' => $userId , 'classname' => $class ));
	}
	
}
