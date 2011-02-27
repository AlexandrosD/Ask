<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
 
// import Joomla table library
jimport('joomla.database.table');
 
/**
 * Hello Table class
 */
class AskTableAsk extends JTable
{
	protected $params;
	
        /**
         * Constructor
         *
         * @param object Database connector object
         */
        function __construct(&$db) 
        {
        		global $logger;
        		$logger->info("AskTableAsk::__construct()");
                parent::__construct('#__ask', 'id', $db);
        }
        /**
         * Overloaded bind function
         *
         * @param       array           named array
         * @return      null|string     null is operation was satisfactory, otherwise returns an error
         * @see JTable:bind
         * @since 1.5
         */
        public function bind($array, $ignore = '') 
        {
        	global $logger;
            $logger->info("AskTableAsk::bind()");
                if (isset($array['params']) && is_array($array['params'])) 
                {
                        // Convert the params field to a string.
                        $parameter = new JRegistry;
                        $parameter->loadArray($array['params']);
                        $array['params'] = (string)$parameter;
                }
                return parent::bind($array, $ignore);
        }
 
        /**
         * Overloaded load function
         *
         * @param       int $pk primary key
         * @param       boolean $reset reset data
         * @return      boolean
         * @see JTable:load
         */
        public function load($pk = null, $reset = true) 
        {
        	 global $logger;
             $logger->info("AskTableAsk::load()");
             
                if (parent::load($pk, $reset)) 
                {
                        // Convert the params field to a registry.
                        $params = new JRegistry;
                        $params->loadJSON($this->params);
                        $this->params = $params;
                        return true;
                }
                else
                {
                        return false;
                }
        }
        /**
         * Method to compute the default name of the asset.
         * The default name is in the form `table_name.id`
         * where id is the value of the primary key of the table.
         *
         * @return      string
         * @since       1.6
         */
        protected function _getAssetName()
        {
                //$k = $this->_tbl_key;
                //return 'com_helloworld.message.'.(int) $this->$k;
                global $logger;
                $logger->severe("_getAssetName()");
                return "com_ask";
        }
 
        /**
         * Method to return the title to use for the asset table.
         *
         * @return      string
         * @since       1.6
         */
        protected function _getAssetTitle()
        {
                //return $this->greeting;
                global $logger;
                $logger->severe("_getAssetTitle()");
                return "getAssetTitle";
        }
 
        /**
         * Get the parent asset id for the record
         *
         * @return      int
         * @since       1.6
         */
        protected function _getAssetParentId()
        {
        		global $logger;
              	$logger->severe("_getAssetParentId()");
                $asset = JTable::getInstance('Asset');
                $asset->loadByName('com_ask');
                return $asset->id;
        }
}
