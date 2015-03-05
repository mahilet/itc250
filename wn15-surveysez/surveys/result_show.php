<?
/**
* result_show.php shows the results of a Survey, indicating tallied answers
 * 
 * Will attempt to create a Result 'object' to create an array of Result objects, 
 * and show total tallies of answer
 *
 * This is a test page to prove the concept of returning Result data, with  
 * internal Result object data
 * 
 * @package SurveySez
 * @author Bill Newman <williamnewman@gmail.com>
 * @version 2.0 2009/11/10
 * @link http:# www.billnsara.com/advdb/  
 * @license http:// opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see Result_inc.php
 * @see Result_inc.php 
 * @see Survey_inc.php     
 * @todo none
 */
 
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials

/*
$config->metaDescription = ''; #Fills <meta> tags.
$config->metaKeywords = '';
$config->metaRobots = '';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/

# currently 'hard wired' to one Result - will need to pass in #id of a Result on the qstring  
$myResult = new Result(1);
if($myResult->isValid)
{
	$PageTitle = "'Result to " . $myResult->Title . "' Survey!";
}else{
	$PageTitle = THIS_PAGE; #use constant 
}
$config->titleTag = $PageTitle;
 
#END CONFIG AREA ---------------------------------------------------------- 

get_header(); # defaults to header_inc.php
?>
<h2><?php print THIS_PAGE; ?></h2>

<p>This is a proof of concept for the initial SurveySez objects.</p>
<p>It features the new Result & Tally Objects</p>
<p>This is test page for the Result object.  (SurveySez version 3)</p>
<p>It is a model intended to be changed to result_view.php, with the ID of a survey to be passed in via the QueryString</p>
<?php

if($myResult->isValid)
{# check to see if we have a valid SurveyID
	echo "Survey Title: <b>" . $myResult->Title . "</b><br />";  //show data on page
	echo "Survey Description: " . $myResult->Description . "<br />";
	$myResult->showGraph() . "<br />";	//showTallies method shows all questions, answers and tally totals!
	unset($myResult);  //destroy object & release resources
}else{
	echo "Sorry, no results!";	
}

get_footer(); #defaults to footer_inc.php

?>