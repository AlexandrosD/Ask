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
			//quit if no rows exist..
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
			
			//votes	        
	        $question->votes2 = $question->votes;
			$question->score2 = $question->score;
	        
	        //calculate..
		 	if ($question->votes > 1000){
	        	$v = $question->votes / 1000;
	        	$question->votes2 = round($v,1) . "K";
	        }
	        
		 	if ($question->score > 1000){
	        	$s = $question->score / 1000;
	        	$question->score2 = round($s,1) . "K";
	        }
	        	
	        //tags
	        $question->tags = json_decode($question->tags);
	        
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
		$query->select("a.*, a.votes_possitive-a.votes_negative as score, a.votes_possitive+a.votes_negative as votes, (SELECT COUNT(*) FROM #__ask AS b WHERE b.parent=a.id) as answerscount, c.title AS CategoryName");
		$query->from("#__ask AS a");
		$query->leftJoin("#__categories AS c ON c.id=a.catid");

		$show_answers = $this->getState("filter.answers" , 0);
		$show_unpublished = $this->getState("filter.unpublished" , 0);

		if ($show_answers && !$show_unpublished) { $where = "a.published=1"; }
		if (!$show_answers && $show_unpublished) { $where = "a.question=1"; }
		if (!$show_answers && !$show_unpublished) { $where = "a.published=1 AND a.question=1"; }
		if ($show_answers && $show_unpublished) { $where = NULL; }		
		
		
		//************* FILTERING - BEGIN ***************
		
		//categories - filter.catid
		$catid = $this->getState("filter.catid" , 0);
		if ($catid){
			if ($where)
				$where .= " AND a.catid='$catid'";
			else
				$where = "a.catid='$catid'";
		}
		
		//tags - filter.tag
		$tag = $this->getState("filter.tag" , 0 );
		if ($tag)
			if ($where)
				$where .= " AND a.tags LIKE '%\"$tag\"%'";
			else $where = "a.tags LIKE '$like'";
			
		//answered questions - filter.answered
		$answered = $this->getState("filter.answered" , 0);
		if ($answered){
			
			$q = "a.id IN (SELECT parent FROM #__ask WHERE question=0)";
			
			if ($where)
				$where .= " AND " . $q;
			else 
				$where = $q;
		}
		
		//not answered questions - filter.notanswered
		$notanswered = $this->getState("filter.notanswered" , 0);
		if ($notanswered){
			
			$q = "a.id NOT IN (SELECT parent FROM #__ask WHERE question=0) AND a.question=1";
			
			if ($where)
				$where .= " AND " . $q;
			else 
				$where = $q;
		}
		
		//resolved question - filter.resolved
		$resolved = $this->getState("filter.resolved" , 0);
		if ($resolved){
			
			$q = "a.id in (SELECT parent from #__ask where question=0 and chosen=1)";
			
			if ($where)
				$where .= " AND " . $q;
			else 
				$where = $q;
		}
		
		//unresolved questions - filter.unresolved
		$unresolved = $this->getState("filter.unresolved" , 0);
		if ($unresolved){
			
			$q = "a.id in (select parent from #__ask where question=0 and chosen=0) and a.id not in (SELECT parent from #__ask where question=0 and chosen=1)";
			
			if ($where)
				$where .= " AND " . $q;
			else 
				$where = $q;
		}
			
		//************* FILTERING - END ***************
		
		//apply filters
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
		
		
		
		//************ Categories & Tags - BEGIN ********** 
				
		//category
		$catid = JRequest::getInt('catid' , 0);
		$this->setState("filter.catid", $catid);
		
		//tag
		$tag = JRequest::getString("tag" , 0);
		$this->setState("filter.tag" , $tag);
		
		//************ Categories & Tags - END **********
		
		
		
		//************* FILTERING - BEGIN ***************
		
		$filter = JRequest::getString("filter");
		
		//answered
		$this->setState("filter.answered" , (int)($filter=="answered"));
		
		//not answered
		$this->setState("filter.notanswered" , (int)($filter=="notanswered"));
		
		//resolved
		$this->setState("filter.resolved" , (int)($filter=="resolved"));
		
		//unresolved
		$this->setState("filter.unresolved" , (int)($filter=="unresolved"));
		
		//************* FILTERING - END ***************
		
		
		
		//************* ORDERING - START ***************
		
		$ordering = JRequest::getString("list_ordering" , "submitted");
		$direction = JRequest::getString("list_direction" , "DESC");
		
		$this->setState("list.ordering" , $ordering);
		$this->setState("list.direction" , $direction);
		
		//************* ORDERING - END ***************
		
		

		$logger->info("filter.unpublished: " . $view_unpublished );
		$logger->info("filter.answers: " . $viewanswers );

		$logger->info("State Populated!");
	}
	
 	public function getFilteringOptions(){
        	
        $currentOptions = 
        	"&tag=" . JRequest::getString("tag") . 
        	"&catid=" . JRequest::getInt("catid");
        
        $answered = 
        	"<li><a " . (JRequest::getString("filter" , 0)=="answered"?'class=active':'') . " href='" . JRoute::_("index.php?option=com_ask&view=questions&filter=answered" . $currentOptions)  . "'>" . JText::_("FILTER_ANSWERED") . "</a></li>";
        
        $notanswered = 
        	"<li><a " . (JRequest::getString("filter" , 0)=="notanswered"?'class=active':'') . " href='" . JRoute::_("index.php?option=com_ask&view=questions&filter=notanswered" . $currentOptions)  . "'>" . JText::_("FILTER_NOTANSWERED") . "</a></li>";
        
        $resolved = 
        	"<li><a " . (JRequest::getString("filter" , 0)=="resolved"?'class=active':'') . " href='" . JRoute::_("index.php?option=com_ask&view=questions&filter=resolved" . $currentOptions)  . "'>" . JText::_("FILTER_RESOLVED") . "</a></li>";
        
        $unresolved = 
        	"<li><a " . (JRequest::getString("filter", 0)=="unresolved"?'class=active':'') . " href='" . JRoute::_("index.php?option=com_ask&view=questions&filter=unresolved" . $currentOptions)  . "'>" . JText::_("FILTER_UNRESOLVED") . "</a></li>";
        
        $options = "<div class='questions_filters'><ul>" . $answered . $notanswered . $resolved . $unresolved . "</ul></div>";
        
        return $options;
 	}

}
