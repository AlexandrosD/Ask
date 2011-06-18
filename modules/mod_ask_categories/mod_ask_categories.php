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

@require_once 'administrator/components/com_ask/helpers/ask.php';

//retrieve categories
$query = "SELECT A.catid, COUNT(A.catid) as questions, C.* "
		."FROM #__ask AS A INNER JOIN #__categories AS C "
		."ON A.catid = C.id "
		."WHERE C.extension='com_ask' " //only com_ask categories
		."AND C.published=1 "			//only published categories
		."AND A.question=1 "			//only question categories
		."AND A.published=1 "			//only ppublished questions
		."AND A.catid<>0 "				//only questions that have categoru
		."GROUP BY A.catid";

$db = JFactory::getDbo();
$db->setQuery($query);

$categories = $db->loadObjectList();

//load and compute configuration / view options -> load the into the options variable
$options = 	 "&test1=1"
			."&test2=2"
			."&display_filters=1";

if ( count($categories) > 0 ) { //verify that categories exist

	//display categories
	echo "<ul class='ask-categories'>";
	foreach ( $categories as $category ) {
		
		@$category->link = JRoute::_( "index.php?option=com_ask&view=questions&catid=" . $id . $options );
				
		echo "<li>";
		echo "<a href='" . $category->link . "'>" . $category->title . "</a> (" . $category->questions . ") ";
		echo "</li>";
		
	} //end foreach ($categories)
	echo "</ul>";

}