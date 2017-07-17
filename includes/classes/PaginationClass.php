<?php
class PaginationClass{

var $pag_sql;
var $url;
var $next_nav;
var $total_count;
var $recperpage;
var $page;

function Pagination($sql,$url,$recperpage){
global $db;
$url=str_replace("&acc=del","",$url);
$_SESSION['red_url_u']=$url;
$this->url=$_SESSION['red_url_u'];

if(!empty($_GET['page_no']))
$this->page=$_GET['page_no'];
else
{
if(!empty($_GET['page']))
$this->page=$_GET['page'];
else
$this->page=1;
}

$page=$this->page;
$res=$db->query($sql);
$this->total_count=$db->db_nrow($res);
$this->recperpage=$recperpage;
$this->pag_sql=$sql." limit ".(($page-1)*$recperpage).", $recperpage";

	if($page>1)
	{
		$url_prev=stristr($url,"&page_no=".$page)==FALSE?$url."&page=".($page-1):str_replace("&page_no=".$page,"&page_no=".($page-1),$url);
		$prev="<a href='$url_prev' class='small_link'>Prev</a>";
	}
	else
		$prev="Prev";
		
	if((($page)*$recperpage)<$this->total_count)
	{
		$url_next=stristr($url,"&page_no=".$page)==FALSE?$url."&page_no=".($page+1):str_replace("&page_no=".$page,"&page_no=".($page+1),$url);
		$next="<a href='$url_next' class='small_link'>Next</a>";
	}
	else
		$next="Next";
		
	$page_temp=(($page)*$recperpage);
	$page_temp=$page_temp<$this->total_count?$page_temp:$this->total_count;
	$this->next_nav=" Showing ".(($page-1)*$recperpage+1)." - ".$page_temp." of ".$this->total_count." | ".$prev." ".$next." &nbsp;";
	$this->next_nav_only=$prev." ".$next." &nbsp;";
    return $this->pag_sql;
}

function Pagination_Dropdown(){
if ($this->total_count>0) {
 $str_dd="<select name=\"page_no\" style=\"width:45px;\" onChange=\"javascript:location.href='".str_replace("&page_no=".$this->page,"",$this->url)."&page_no='+this.value;\">";
 for($m=1; $m<=ceil($this->total_count/$this->recperpage); $m++) {
   $aa=$this->page==$m?'selected':'';
   $str_dd.="<option value='".$m."'".$aa.">".$m."</option>";
 }
 $str_dd.="</select>";
}
echo $str_dd;
}

function Pagination_custom(){
if ($this->total_count>0) {
 $str_dd.=" Showing ".($this->page)." - ".ceil($this->total_count/$this->recperpage)." | $this->next_nav_only &nbsp;";
}
echo $str_dd;
}



function Pagination_flat(){

$adjacents = 3;
$page=$this->page;
$total_pages=$this->total_count;
$limit=$this->recperpage;
$url1=$this->url;
		
		/* Setup page vars for display. */
		if ($page == 0) $page = 1;					//if no page var is given, default to 1.
		$prev = $page - 1;							//previous page is page - 1
		$next = $page + 1;							//next page is page + 1
		$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
		$lpm1 = $lastpage - 1;						//last page minus 1
		
		/* 
			Now we apply our rules and draw the pagination object. 
			We're actually saving the code to a variable in case we want to draw it more than once.
		*/
		$pagination = "";
		if($lastpage > 1)
		{	
			
			$pagination .= "<ul>";
			//previous button
			//$pagination .="<span></span>";
			if ($page > 1) 
				$pagination.= "<li><a href=\"$url1&page=$prev\">Prev</a></li>";
			else
				$pagination.= "<li><a href=\"$url1&page=$prev\">Prev</a></li>";	
			
			//pages	
			if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
			{	
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"active\"><a href=\"$url1&page=$counter\">$counter</a></li>";
					else
						$pagination.= "<li><a href=\"$url1&page=$counter\"><span>$counter</span></a></li>";					
				}
			}
			elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
			{
				//close to beginning; only hide later pages
				if($page < 1 + ($adjacents * 2))		
				{
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					{
						if ($counter == $page)
							$pagination.= "<li class=\"active\"><a href=\"$url1&page=$counter\">$counter</a></li>";
						else
							$pagination.= "<li><a href=\"$url1&page=$counter\"><span>$counter</span></a></li>";					
					}
					$pagination.= "<li><a href='#forwaed' class='dot'>...</a></li>";
					$pagination.= "<li><a href=\"$url1&page=$lpm1\"><span>$lpm1</span></a></li>";
					$pagination.= "<li><a href=\"$url1&page=$lastpage\"><span>$lastpage</span></a></li>";		
				}
				//in middle; hide some front and some back
				elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
				{
					$pagination.= "<li><a href=\"$url1&page=1\"><span>1</span></a></li>";
					$pagination.= "<li><a href=\"$url1&page=2\"><span>2</span></a></li>";
					$pagination.= "<li><a href='#forwaed' class='dot'>...</a></li>";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<li class=\"active\"><a href=\"$url1&page=$counter\">$counter</a></li>";
						else
							$pagination.= "<li><a href=\"$url1&page=$counter\"><span>$counter</span></a></li>";					
					}
					$pagination.= "<li><a href='#forwaed' class='dot'>...</a></li>";
					$pagination.= "<li><a href=\"$url1&page=$lpm1\"><span>$lpm1</span></a></li>";
					$pagination.= "<li><a href=\"$url1&page=$lastpage\"><span>$lastpage</span></a></li>";		
				}
				//close to end; only hide early pages
				else
				{
					$pagination.= "<li><a href=\"$url1&page=1\"><span>1</span></a></li>";
					$pagination.= "<li><a href=\"$url1&page=2\"><span>2</span></a></li>";
					$pagination.= "<li><a href='#forwaed' class='dot'>...</a></li>";
					for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<li class=\"active\"><a href=\"$url1&page=$counter\">$counter</a></li>";
						else
							$pagination.= "<li><a href=\"$url1&page=$counter\"><span>$counter</span></a></li>";					
					}
				}
			}
			
			//next button
			if ($page < $counter - 1) 
				$pagination.= "<li><a href=\"$url1&page=$next\">Next</a></li>";
			else
				$pagination.= "<li><a href=\"$url1&page=$next\">Next</a></li>";
			$pagination.= "</div>";		
		}
 return  $pagination;		
}
}
?>