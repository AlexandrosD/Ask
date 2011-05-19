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

// import the Joomla modellist library
jimport('joomla.application.component.modeladmin');

class AskModelQuestion extends JModelAdmin {
	
	protected $item;	//The question
	
	/*
	 * Method to return a JTable instance of the question table
	 */
	public function getTable( $type = "Ask" , $prefix = "AskTable" , $config = array() ){
		global $logger;
		$logger->info("AskModelQuestion::getTable( $type , $prefix , " . implode( " , " , $config ) ." )");
		
		return JTable::getInstance($type, $prefix , $config);
	}
	
	/*
	 * Method to return a form object
	 */
	public function getForm ( $data = array(), $loadData = TRUE ){
		global $logger;
		$logger->info("AskModelQuestion::getForm(" . implode (" , " , $data ) . " , $loadData )");

		$form = $this->loadForm("com_ask.question" , "question" , array("control"=>"jform" , "loadData"=> $loadData) );
		
		if ( empty($form)){
			$logger->warning("Form Object is NULL");
			return FALSE;
		}
				
		//Fill the form with data
		if ( $data = $this->loadFormData() ){
			$logger->info("Filling the form with data..");
			$logger->info("JSON DATA:" . json_encode($data));
			
			$user = JFactory::getUser();
			
			if (! $data instanceof JObject)
				$data = JArrayHelper::toObject($data);
			
			if ( $data->userid_creator ){
				//Existing Item..
				//Fill in the apropriate information concerning the modifications
				$logger->info("Existing Item");
				$logger->info("Filling modification information..");
				
				$data->userid_modifier = $user->id;
				$data->modified = date("Y-m-d H:i:s");
				
				//tags
				if ($data->tags){
					$data->tags = implode(", " , json_decode($data->tags));
				}
			}
			
			if ( $data->id==0 ) { 
				//New Item.. Fill the form with some defaults values..
				$logger->info("New Item. Filling default values..");
				
				$data->userid_creator = $user->id;
				$data->submitted = date("Y-m-d H:i:s");
				
				//get email from user object
				$data->email = $user->email;
				
				$app = JFactory::getApplication();
				$parent = $app->getUserState("parentID");
				$question = $app->getUserState("isQuestion");
				$catid = $app->getUserState("catid");
				
				if (!$parent){
					$parent=0;
				}
				
				//Set data
				$data->parent = $parent;
				$data->question = $question;
				$data->catid = $catid;
				
				//Clear User State
				$app->setUserState("isQuestion", 1);
				$app->setUserState("parentID", 0);
				$app->setUserState("catid", 0);
				
				$logger->info("Question: $question");
				$logger->info("Parent: $parent");
				
			}
			
			$logger->info("\n\n" . json_encode($data) . "\n\n");
			$this->preprocessForm($form, $data);
			$form->bind($data);
		}
		else {
			$logger->warning("Cannot add data into form");
		}
		
		$logger->info("About to return form object..");		
		return $form;		
	}
	
	/*
	 * Method to load the data of the form
	 */
	protected function loadFormData() {
		global $logger;
		$logger->info("AskModelQuestion::loadFormData()");
		
		$data = JFactory::getApplication()->getUserState("com_ask.edit.question.data" , array() );
		
		if (empty($data)){
			$logger->info("Data is empty.. Shall get the item instead..");
			$data = $this->getItem();			
		}
		
		return $data;	
	}
	
	/*
	 * Method to return a QUESTION item
	 * 
	 * Here is used only for reference / logging
	 * It just invokes the parent method
	 * 
	 */
	public function getItem(){
		global $logger;
		$logger->info ("AskModelQuestion::getItem()");
		return parent::getItem();
	}
	
}