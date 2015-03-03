<?php
//SurveyUtil_inc.php

class SurveyUtil
{

	public static function responseList($myID)
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
		
	
	}#end responselist


}#SurveyUtil_inc.php class 