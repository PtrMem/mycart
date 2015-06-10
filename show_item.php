<?php 
    include_once('cart_fns.php');
	session_start();
	setcookie('user',$_SESSION['user'],time()+3600);
	$itemid=$_GET['id'];
	$item=get_item_details($itemid);
	display_html_header('Item Information','item');
	display_html_top_bar();
	display_html_nav();
	display_item($item);
	display_html_footer();
 ?>