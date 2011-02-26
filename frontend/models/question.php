<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');

class AskModelQuestion extends JModelItem {
	
	private $id;
	private $item;
	
	public function getItem($id = null){
		global $logger;
		$logger->info("AskModelQuestion::getItem($id)");
		
		if ($this->item){
			return $this->item;
		}
		
		if ( ! $id ) {
			$logger->info("Retrieving id from state..");
			$id = $this->getState("question.id");
			$logger->info("Question id is $id");
		} 
		
		$this->id = $id;
		
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(TRUE);
		$query->select("*");
		$query->from("#__ask");
		
		$where = "";
		if (!$this->getState("filter.unpublished")){
			$where = "id=$id";
		}
		else {
			$where = "id=$id AND published=1";
		}
		$query->where($where);
		
		$logger->info("SQL Query: " . $query );
		
		$db->setQuery($query);
		$question = $db->loadObject();
		
		if (! $question ){
			$logger->severe("Question not found!");
			return;
		}
	
		$question->answers = $this->getAnswers();
		$question->link = JRoute::_( "index.php?option=com_ask&view=question&id=" . $question->id );
		
		foreach ($question->answers as $a){
			if (!$a->name){
				$a->name = JFactory::getUser($a->userid_creator)->name;
			}
		}
		
		$this->item = $question;
		
		//hit!
		$this->hit();
		
		return $this->item;	
	}
	
	public function getAnswers(){
		global $logger;
		
		if ( ! $this->getState("filter.answers") ){
			$logger->info("User is not authorized to view answers..");
			//return array();
		}
		
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(TRUE);
		$query->select("*");
		$query->from("#__ask");
		$query->where("parent=" . $this->id );
		$query->order("submitted DESC");
		
		$logger->info("SQL Query for answers: " . $query);
		
		$db->setQuery($query);
		$answers = $db->loadObjectList();
		
		if ($answers){
			$logger->info("Loaded " . count($answers) . " answers for question with id=" . $this->id );
			return $answers;
		}
		else {
			$logger->info("No answers found!");
			return array();
		}
	}
	
	protected function populateState(){
		global $logger;
		
		$app = JFactory::getApplication('site');
		
		// Load state from the request.
		$id = JRequest::getInt('id');
		$this->setState('question.id', $id);
		
		$user = JFactory::getUser();
		
		$this->setState( "filter.unpublished" , $user->authorize("question.unpublished" , "com_ask") );
		$this->setState( "filter.answers" , $user->authorize("question.answers" , "com_ask") );
		
		$logger->info("AskModelQuestion::populateState() completed!");
		
	}	
	
	public function hit( $id=NULL ){
		global $logger;
		if ($id){
			$this->id = $id;
		}
		
		if ( $this->id ){
			$logger->info("Hitting question with id=" . $this->id );
				
			$db = JFactory::getDbo();
			
			$q = "UPDATE #__ask SET impressions = impressions+1 WHERE id=" . (int)$this->id;				
			$db->setQuery($q);
			
			if (!$db->query()){
				$logger->error("Cannot update impressions!");
				return FALSE;
			}
			
			return TRUE;
		}
		else {
			$logger->warning("Cannot hit an empty question!");
			return FALSE;
		}
	}
	
	public function publish(){
		global $logger;
		if ($id){
			$this->id = $id;
		}
			
		if ( $this->id ){
			$logger->info("Change publish state for question with id=" . $this->id );
			
			$db = JFactory::getDbo();
			
			if ($this->item){
				$state = $item->published;
			}
			else {
				$q = $db->getQuery ( TRUE );
				$q->select("state");
				$q->from("#__ask");
				$q->where("id=" . $this->id );
				$logger->info("SQL: " . $q );
				
				$db->setQuery($q);
				$row = $db->loadObject();
				
				$state = $row->published;
			}
			
			$state = ($state-1) ^ 2; //Quarter will allways make it positive or 0;
			
			$q = "UPDATE #__ask SET published = " . $state . " WHERE id=" . (int)$this->id;				
			$db->setQuery($q);
			
			if (!$db->query()){
				$logger->error("Cannot update state!");
				return FALSE;
			}
			
			return TRUE;
		}
		else {
			$logger->warning("Cannot change state of an empty question!");
			return FALSE;
		}
	}			
	
	public function vote( $id = null , $negative = FALSE ){
		global $logger;
		if ($id){
			$this->id = $id;
		}
			
		if ( $this->id ){
			$logger->info("Vote for question with id=" . $this->id );
			$db = JFactory::getDbo();
			
			if ($negative){
				$q = "UPDATE #__ask SET votes_negative = votes_negative+1 WHERE id=" . (int)$this->id;
			}
			else {
				$q = "UPDATE #__ask SET votes_possitive = votes_possitive+1 WHERE id=" . (int)$this->id;	
			}
			
			$logger->info("SQL: " . $q );
			$db->setQuery($q);
			
			if (!$db->query()){
				$logger->error("Cannot update votes!");
				return FALSE;
			}
			
			return TRUE;
		}
		else {
			$logger->warning("Cannot vote for an empty question!");
			return FALSE;
		}
	}
	
	private function store(){
		global $logger;
		
	}
	
	/*
	 * 
	 
	 public function getTable( $type = "Question" , $prefix = "AskTable" , $config = array() ){
		global $logger;
		$logger->info("AskModelQuestion::getTable( $type , $prefix , " . implode( " , " , $config ) ." )");
		
		return JTable::getInstance($type, $prefix , $config);
	}
	
	protected function populateState(){
		global $logger;
		$logger->info("AskModelQuestion::populateState()");
		
		$app = JFactory::getApplication();
		$id = JRequest::getInt("id");
		$this->setState("question.id" , $id );
		
		$logger->info("setState('question.id' , $id )");
		
		$params = $app->getParams();
		$this->setState("params" , $params);
		
		$logger->info("setState('params' , $params )");
		
		$logger->info("Calling parent::populateState()");
		parent::populateState();
	}
	
	public function getItem(){
		global $logger;
		$logger->info("AskModelQuestion::getItem()");
		
		if (!isset($this->item)){
			$logger->info ("Item is not set.. Setting item now..");
			$id = $this->getState("question.id");
			$this->_db->setQuery( $this->db->getQuery(true) 
				->select("*")
				->from ("#__ask")
				->where("id=" . (int)$id )
				);
			
			if ( !$this->item = $this->_db->loadObject() ){
				$logger->error("Database Error: " . $this->_db->getError);
				$this->setError($this->_db->getError());
			}
			else {
				$params = new JRegistry();
				$params->loadJSON($this->item->params);
				$this->item->params = $params;
				
				$params = clone $this->getState("params");
				$params->merge($this->item->params);
				$this->item->params = $params;
			}
		}
		
		return $this->item;
		
	}
	 
	 
	 * 
	 */
	
}
