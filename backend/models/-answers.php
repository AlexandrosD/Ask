<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');

class AskModelAnswers extends JModelList
{

        protected function getListQuery()
        {
                // Create a new query object.         
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                $query->select('*');
                $query->from('#__ask');
                $query->where("question=0");
                return $query;
        }
}