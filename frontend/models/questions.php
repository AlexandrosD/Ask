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

// import Joomla modelitem library
jimport('joomla.application.component.modellist');

class AskModelQuestions extends JModelList {

	public function getItems(){
		global $logger;
		$logger->info("AskModelQuestions::getItems()");

		$logger->info("Will retrieve " . $this->getState("list.limit") . " records, starting from " . $this->getState("list.start") );

		$rows	= parent::getItems();

		$questions = array();
		$answers = array();
		
		//If there are answers, associate them with their questions
		if ( $this->getState("filter.answers" , 0) ) {
			//seperate questions from answers
			foreach ($rows as $row){
				if ($row->question){
					$questions[] = $row;
				}
				else {
					$answers[] = $row;
				}
			}
			
			//add each answer to its relevant question
			foreach ($questions as $question){
				$question->answers = array();
				foreach ($answers as $answer){
					if ($answer->parent == $question->id ){
						$question->answers[] = $answer;
					}
				}
			}
			
			$items = $questions;
		}
		else { //Only questions...
			$questions = $rows;
		}
		
		foreach ($questions as $question){
			$question->link = JRoute::_( "index.php?option=com_ask&view=question&id=" . $question->id ); 
		}

		$items = $questions;
		
		$logger->info ("Total rows are " . parent::getTotal() . ". (Retrieved " . count($questions) . " Questions and " . count($answers) . " Answers)" );
		
		return $items;
	}

	function getListQuery(){
		global $logger;
		$logger->info("AskModelQuestions::getListQuery()");

		$db = JFactory::getDbo();

		$query = $db->getQuery(TRUE);
		$query->select("a.*, c.title AS CategoryName");
		$query->from("#__ask AS a");
		$query->leftJoin("#__categories AS c ON c.id=a.catid");

		$show_answers = $this->getState("filter.answers" , 0);
		$show_unpublished = $this->getState("filter.unpublished" , 0);

		if ($show_answers && !$show_unpublished) { $where = "a.published=1"; }
		if (!$show_answers && $show_unpublished) { $where = "a.question=1"; }
		if (!$show_answers && !$show_unpublished) { $where = "a.published=1 AND a.question=1"; }
		if ($show_answers && $show_unpublished) { $where = NULL; }
		
		$catid = $this->getState("filter.catid" , 0);
		
		if ($catid){
			if ($where)
				$where .= " AND a.catid='$catid'";
			else
				$where = "a.catid='$catid'";
		}
		
		if ($where) { $query->where( $where ); }
		
		$ordering = $this->getState( "list.ordering" , "submitted" );
		$direction = $this->getState( "list.direction" , "DESC" );
		
		$query->order("$ordering $direction");

		$logger->info( "SQL Query: " . $query);

		return $query;
	}

	public function populateState( $ordering = "submitted" , $direction = "DESC" ){
		global $logger;
		$logger->info("AskModelQuestions::populateState($ordering , $direction)");
		
		$app = JFactory::getApplication();
		
		$this->setState( "list.ordering" , $ordering );
		$this->setState( "list.direction" , $direction );

		$value = JRequest::getInt('limit', $app->getCfg('list_limit', 0));
		$this->setState('list.limit', $value);

		$value = JRequest::getInt('limitstart', 0);
		$this->setState('list.start', $value);

		$user = JFactory::getUser();

		$logger->info("User ID: " . $user->id . " - Username: " . $user->name);

		$view_unpublished = 0;
		$viewanswers = 0;

		//Which questions can the user display?
		if ( $user->authorise("question.unpublished","com_ask") ){
			$view_unpublished = 1;
		}

		//view answers??
		if ($user->authorize("question.viewanswers" , "com_ask")){
			$viewanswers = 1;
		}

		$this->setState("filter.unpublished" , $view_unpublished );
		$this->setState("filter.answers" , $viewanswers);
		
		//category view
		$catid = JRequest::getInt('catid' , 0);
		$this->setState("filter.catid", $catid);

		$logger->info("filter.unpublished: " . $view_unpublished );
		$logger->info("filter.answers: " . $viewanswers );

		$logger->info("State Populated!");
	}

}
