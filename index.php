<?php 
  include_once('cart_fns.php');
  session_start();
  if(!isset($_SESSION['user']))
  	$_SESSION['user']='';
  if(!isset($_SESSION['items']))
  	$_SESSION['items']=0;
  if(!isset($_SESSION['total_price']))
  	$_SESSION['total_price']=0.0;
  if(!isset($_SESSION['cart']))
  	$_SESSION['cart']=array();

  //show category
  $title='Welcome to BookShop';
  $css='index';
  if(isset($_GET['catid'])){
  	$catid=$_GET['catid'];
  	$title=get_category_name($catid);
  }else{
  	$catid=1;
  }
  display_html_header($title,$css);
  //show user 
  display_html_top_bar();
  display_html_nav();
  display_items($catid);
  display_html_footer();

 ?>