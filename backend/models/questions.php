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
jimport('joomla.application.component.modellist');

class AskModelQuestions extends JModelList
{
		public function __construct($config = array())
			{
				if (empty($config['filter_fields'])) {
					$config['filter_fields'] = array(
					);
				}
		
				parent::__construct($config);
			}
			
			
		protected function populateState( $ordering = "submitted" , $direction = "DESC" ){
			global $logger;
			$logger->info("AskModelQuestions::populateState($ordering , $direction)");
			
			$app = JFactory::getApplication();
			
			//Ordering
			$this->setState( "list.ordering" , $ordering );
			$this->setState( "list.direction" , $direction );
	
			//Pagination
			$value = JRequest::getInt('limit', $app->getCfg('list_limit', 0));
			$this->setState('list.limit', $value);
			
			//Pagination
			$value = JRequest::getInt('limitstart', 0);
			$this->setState('list.start', $value);
			
			$logger->info("Admin State Populated!");
		}
		
        protected function getListQuery()
        {
                // Create a new query object.         
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                $query->select('*');
                $query->from('#__ask');
                $query->order($this->getState("list.ordering") . " " . $this->getState("list.direction"));
                
                $answers = JRequest::getInt("answers");
                if ($answers){
                	$query->where("question=0");
                }
                else
                {
                	$query->where("question=1");
                }
                
                return $query;
        }
        
        function delete(){
        	global $logger;
        	$logger->info("AskModelQuestions::delete()");
        	
        	$cids = implode(",", JRequest::getVar("cid"));
        	
        	$logger->info ("CID=" . $cids );
        }
}
