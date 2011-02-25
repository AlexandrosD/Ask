<?php

//If _NOLOG is defined, no logging will be performed
//In order the logger to work correctly, either the access rights should correctly set
//(or just the file to exist??)

class CustomLogger {
	
	//Variables
	private $_filename;
	private $_handle;
	private $_loglevel;

	//Constants
	const LOG_INFO 		= '9';
	const LOG_WARNING 	= '7';
	const LOG_ERROR		= '5';
	const LOG_SEVERE 	= '1';
	const LOG_NOLOG		= '0';
	
	function __construct( $filename , $loglevel = 0 ){
		if ( ! defined ("_NOLOG") ){ 
			$this->_loglevel = $loglevel;

			if ($filename){
				$this->_filename = $filename;
			}
			else {
				throw new Exception("Invalid filename specified");
			}
			
			//open the file
			$this->_handle = @fopen($this->_filename, "a");
			
			if (! $this->_handle ){
				throw new Exception("Cannot create file handle");
			}
		}		
	}
	
	function __destruct(){
		if ( ! defined ("_NOLOG") ){ 
			@fclose ( $this->_handle );
		}
	}
	
	function getFilename(){
		return $this->_filename;
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
	
	private function _log($message , $loglevel){
		//check if there is a global variable that ovverides the loglevel
		if ( ! defined ("_NOLOG") ){ 
			if ($message){
				$timestamp = date("c"); //ISO 8601 Date Format (PHP 5+ ONLY)
				$msg = "$timestamp [$loglevel]: " . $message . "\n";
				if ( ! @fwrite( $this->_handle, $msg ) ) {
					throw new Exception("Cannot write to file " . $this->_filename );
				}
			}
		}
	}
	
}