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

jimport('joomla.application.categories');

//helpers
require_once 'administrator/components/com_ask/helpers/ask.php';

function AskBuildRoute( &$query ) {	
	$segments = array();
	
	//CATEGORY
	if ( isset( $query["catid"] ) ) {
		if ( $query["catid"] != 0 ) {
			$segments[] = "category";
			$segments[] = $query["catid"] . "-" . AskHelper::getCategoryName( $query["catid"] );
		}
		unset( $query["catid"] );
	}
	
	//TAG
	if ( isset($query["tag"]) ) {
		if ( $query["tag"] ) {
			$segments[] = "tag";
			$segments[] = $query["tag"];
		}		
		unset($query["tag"]);
	}
	
	//FILTER
	if ( isset($query["filter"]) ) {
		if ($query["filter"]){
			$segments[] = "filter";
			$segments[] = $query["filter"];
		}
		unset($query["filter"]);
	}
	
	//VIEW
	if ( isset($query["view"]) ) {
		if ($query["view"]) {
			//$segments[] = "view";
			$segments[] = $query["view"];
		}
		unset($query["view"]);
	}
	
	//ID
	if ( isset($query["id"]) ) {
		if ($query["id"]){
			//$segments[] = "id";
			$segments[] = $query["id"] . "-" . AskHelper::getTitle($query["id"]); 
		}
		unset($query["id"]);
	}

	return $segments;
	
}

function AskParseRoute( $segments ){
	$vars = array();
	
	$count = count($segments);
	
	if ($count) {
		for ( $i = 0; $i < $count ; $i++ ) {
			
			//filter
			if ( $segments[$i] == "filter" ) {
				$i++;
				$vars["filter"] = $segments[$i];	
			}
			
			//category
			if ( $segments[$i] == "category" ) {
				$i++;
				$category = $segments[$i];
				$category = explode(":" , $category);
				$vars["catid"] = $category[0];
			}
			
			//tag
			if ( $segments[$i] == "tag" ) {
				$i++;
				$vars["tag"] = $segments[$i];
			}
			
			//single question - view=question
			if ( $segments[$i] == "question" ) { 
				$i++;
				$id = $segments[$i];
				$id = explode("-", $id);
				$vars["view"] = "question";
				$vars["id"] = $id[0];
			}
			
			//questions listing - view=questions
			if ( $segments[$i] == "questions" ) { 
				$vars["view"] = "questions";
			}
			
			//edit mode - view=form
			if ( $segments[$i] == "form" ) {
				$vars["view"] = "form";
			}
			
		}
		
		
	}
	
	return $vars;
}
