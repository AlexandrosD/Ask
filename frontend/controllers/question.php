<?php
class AskControllerQuestion extends JController {

	public function votepossitive(){ 
		$this->vote(true);
	}
	
	public function votenegative(){
		$this->vote(false);
	}
	
	private function vote( $possitive = TRUE ){
		$user = JFactory::getUser();
		
		//get id
		$id = (int) JRequest::getInt("id");
		
		//get db instance
		$db = JFactory::getDBO();
		
		//build select query
		$query = "SELECT * FROM #__ask WHERE id='$id'";
			
		//fetch data
		$db->setQuery($query);
		$question = $db->loadObject();
		
		if ($question->parent){
			$questionid = $question->parent;
		}
		else {
			$questionid = $id;
		}	
		
		if (!$question) {
			JError::raiseError(404, JText::_("ERROR_404"));
		}
		
		if( ! $user->authorize("question.vote" , "com_ask")){
			$msg = JText::_("ERROR_UNAUTHORIZED");
			$this->setRedirect(JRoute::_("index.php?option=com_ask&view=question&id=" . $questionid) , $msg );
		}
		else {			
			//check whether the user has already voted
			$hasUserVoted = FALSE;
			$users_voted = json_decode($question->users_voted);
			if ($user->id){
				$hasUserVoted = in_array((string) $user->id, $users_voted);
				$msg = JText::_("VOTE_VOTED");
			}
			
			if (!$hasUserVoted){ //The user has not voted.. proceed updating entry
				$votes_possitive = $question->votes_possitive;
				$votes_negative  = $question->votes_negative;
				if ($possitive){
					$votes_possitive++;
				}
				else {
					$votes_negative++;
				}
				$users_voted = json_decode($question->users_voted);
				if ($user->id){ //save the user's vote
					$users_voted[] = (string)$user->id;	
				}
				$users_voted = json_encode($users_voted);
				
				//update row
				$query = "UPDATE #__ask SET votes_possitive='$votes_possitive', votes_negative='$votes_negative', users_voted='$users_voted' WHERE id='$id'";
				
				$db->setQuery($query);
				if (!$db->query()){
					JError::raiseError(404, JText::_("ERROR"));
				}
				$msg = JText::_("VOTE_SAVED");
			}
			
			//Redirect the user accordingly	
			$this->setRedirect(JRoute::_("index.php?option=com_ask&view=question&id=" . $questionid) , $msg );
		}
		
	}
	
}