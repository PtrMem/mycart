<?php 
  include_once('cart_fns.php');
  session_start();
  if(!$_SESSION['user'])
    	header("Location: index.php");
	display_html_header('Checkout','checkout');
	display_html_top_bar();
	display_html_nav();

	if(($_SESSION['cart']) && (array_count_values($_SESSION['cart']))) {
    	display_cart($_SESSION['cart'],false,0);
      echo "<div class=\"error\">".($_SESSION['error']?$_SESSION['error']:'')."</div>";
      $_SESSION['error']='';
    	display_checkout_form();
  	} else {
    	echo "<p>There are no items in your cart</p><hr/>";
  	}


  	echo "<div class=\"continue_shop\"><a href=\"index.php\"><img src=\"images/continue-shopping.gif\" /></a>";

 ?>