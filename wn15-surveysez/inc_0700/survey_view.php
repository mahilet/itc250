<?php
/**
* survey_view.php  works with survey_view.php to crate  alist/view app
* Based demo_list_pager.php along with demo_view_pager.php provides a sample web application
 *
 * The difference between demo_list.php and demo_list_pager.php is the reference to the 
 * Pager class which processes a mysqli SQL statement and spans records across multiple  
 * pages. 
 *
 * The associated view page, demo_view_pager.php is virtually identical to demo_view.php. 
 * The only difference is the pager version links to the list pager version to create a 
 * separate application from the original list/view. 
 * 
 * @package surveySez
 * @author Mahilet Hialemariam <mehalu15jan2013@gmail.com>
 * @version 1. 2015/02/03
 * @link http://www.mahitlet.dan/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see survey_view.php
  @see survey_listphp
 * @see Pager_inc.php 
  @see index.php
 * @todo Create survey_view.php
 */
# '../' works for a sub-folder.  use './' for the root  
# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
 
# check variable of item passed in - if invalid data, forcibly redirect back to demo_list_pager.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "surveys/index.php");
}
/*
we know that we want result or the survey,
not both...

we also know we many have no survey at all
if result , show result
else if survey, show survey
else show sorry, no survey
if (result){
	
}else if(survey){
		
		
}else {
			echo 'sorry no survey!';
}
if (result){
				
}else{
		if (survey){
						
	}else {
		echo 'sorry no survey!';
		}

*/



//dumpDie($mySurvey);

# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php

echo '
<h3 align="center">' . $config->titleTag . '</h3>
';

$myResult = new Result($myID);
if($myResult->isValid)
{
	$PageTitle = "'Result to " . $myResult->Title . " survey!"; #overwrite PageTitle with Muffin info!
}else{
	
	$mySurvey = new Survey($myID);
if($mySurvey->isValid){
	$config->titleTag = $mySurvey->Title . " survey!"; #overwrite PageTitle with Muffin info!
	
	}else{
			$config->titleTag = "No such survey!";
	}
	
}

if($myResult->isValid)
{# check to see if we have a valid SurveyID
	echo "Survey Title: <b>" . $myResult->Title . "</b><br />";  //show data on page
	echo "Survey Description: " . $myResult->Description . "<br />";
	$myResult->showGraph() . "<br />";	//showTallies method shows all questions, answers and tally totals!
	echo SurveyUtil:: responseList($myID);
	unset($myResult);  //destroy object & release resources
}else{
	if($mySurvey->isValid)
{ #check to see if we have a valid SurveyID
	echo "<b>" . $mySurvey->SurveyID . ") </b>";
	echo "<b>" . $mySurvey->Title . "</b>-->";
	echo "<b>" . $mySurvey->Description . "</b><br />";
	echo $mySurvey->showQuestions();
	echo SurveyUtil:: responseList($myID);
}else{
	echo "Sorry, no such survey!";	
	}
}




get_footer(); #defaults to theme footer or footer_inc.php



function responseList($myID)
	{
		
	$myReturn = '';
	 $sql = "select DateAdded,responseID from wn15_responses where SurveyID=$myID";
	 
	 
		#reference images for pager
		$prev = '<img src="' . VIRTUAL_PATH . 'images/arrow_prev.gif" border="0" />';
		$next = '<img src="' . VIRTUAL_PATH . 'images/arrow_next.gif" border="0" />';
		
		# Create instance of new 'pager' class
		$myPager = new Pager(10,'',$prev,$next,'');
		$sql = $myPager->loadSQL($sql);  #load SQL, add offset
		
		# connection comes first in mysqli (improved) function
		$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
		if(mysqli_num_rows($result) > 0)
		{#records exist - process
			if($myPager->showTotal()==1){$itemz = "responses";}
				else{$itemz = "responses";}  //deal with plural
		 $myReturn .= '<div align="center">We have ' . $myPager->showTotal() . ' ' . $itemz . '!</div>';
			while($row = mysqli_fetch_assoc($result))
			{# process each row
		          $myReturn .='<div align="center">
		         			<a href="' . VIRTUAL_PATH . 'surveys/responses_view.php?id=' . (int)$row['responseID'] . '">' . dbOut($row['DateAdded']) . '</a>';
		         
		       $myReturn .='</div>';
			}
			 $myPager->showNAV(); # show paging nav, only if enough records	 
		}else{#no records
		    "<div align=center>There are currently  No responses?  There must be a mistake!!</div>";	
		}
		@mysqli_free_result($result);
	
	return $myReturn ;
	
	
	}


?>

