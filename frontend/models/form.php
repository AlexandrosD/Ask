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


jimport('joomla.application.component.modeladmin');

class AskModelForm extends JModelAdmin
{

	protected $item;	//The question
	
	/*
	 * Method to return a JTable instance of the question table
	 */
	public function getTable( $type = "Question" , $prefix = "AskTable" , $config = array() ){
		global $logger;
		$logger->info("AskModelForm::getTable( $type , $prefix , " . implode( " , " , $config ) ." )");
		
		return JTable::getInstance($type, $prefix , $config);
	}
	
	/*
	 * Method to return a form object
	 */
	public function getForm ( $data = array(), $loadData = TRUE ){
		global $logger;
		$logger->info("AskModelForm::getForm(" . implode (" , " , $data ) . " , $loadData )");

		$form = $this->loadForm("com_ask.question" , "question" , array("control"=>"jform" , "loadData"=> $loadData) );
		$logger->info("FORM OBJECT: " . json_encode($form));
		if ( empty($form)){
			$logger->warning("Form Object is NULL");
			return FALSE;
		}
		
		//Fill the form with data
		if ( $data = $this->loadFormData() ){
			$logger->info("Filling the form with data..");
			
			$user = JFactory::getUser();
			
			if (! $data instanceof JObject)
				$data = JArrayHelper::toObject($data);
			
			//Fix issue #10 - https://github.com/alexd3499/Ask/issues/10
			if ( $data->title ){
				//Existing Item..
				//Fill in the apropriate information concerning the modifications
				$logger->info("Existing Item");
				$logger->info("Filling modification information..");
				
				$data->userid_modifier = $user->id;
				$data->modified = date("Y-m-d H:i:s");
				
				//proccess json tags..
				$tags = json_decode( $data->tags );
				//Fix issue #13 - https://github.com/alexd3499/Ask/issues/13
				$data->tags = NULL;
				if ($tags) {
					$data->tags = implode( ", " , $tags );
				}
				
			}
			
			if ( $data->id==0 ) { 
				//New Item.. Fill the form with some defaults values..
				$logger->info("New Item. Filling default values..");
				
				if ($user->id){
					$data->userid_creator = $user->id;
				} else {
					$data->userid_creator = 0;
				}
				$data->submitted = date("Y-m-d H:i:s");
				
				$data->parent = 0;
				$data->question = 1;
				$data->impressions = 0;
				$data->votes_possitive = 0;
				$data->votes_negative = 0;
				$data->chosen = 0;
				
				//get email from user object
				if ($user->id)
					$data->email = $user->email;
				
				//get user's name
				if ($user->id)
					$data->name = $user->name;
				
			}
			
			$logger->info("\n\n" . json_encode($data) . "\n\n");
			$this->preprocessForm($form, $data);
			$form->bind($data);
		}
		else {
			$logger->warning("Cannot add data into form");
		}
		
		$logger->info("About to return form object..");		
		$logger->info("FORM OBJECT: " . json_encode($form));
		return $form;		
	}
	
	/*
	 * Method to load the data of the form
	 */
	protected function loadFormData() {
		global $logger;
		$logger->info("AskModelForm::loadFormData()");

		$data = JFactory::getApplication()->getUserState("com_ask.edit.question.data" , array() );
		
		//we got the data, clear state
		JFactory::getApplication()->setUserState("com_ask.edit.question.data" , array() );
		
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
		$logger->info ("AskModelForm::getItem()");
		return parent::getItem();
	}

}