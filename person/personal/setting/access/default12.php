<?php
include("../library/portal/menu.php");
$menu=new menu;
$rr=mysql_query("SELECT DISTINCT `center`, `semat` FROM `p_semat` Limit 60,10");
while($rrr=mysql_fetch_object($rr))
{
	$menu->reset_menu($rrr->semat,$rrr->center);
}
			
?>

