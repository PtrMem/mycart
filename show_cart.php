<?php 
  include_once('cart_fns.php');
  include_once('fns/item_fns.php');
  session_start();
  setcookie('user',$_SESSION['user'],time()+3600);
  //add item
  @$new = $_GET['new'];
  if($new){

  	  if(!isset($_SESSION['user']))
  	    $_SESSION['user']='';
  	  if(!isset($_SESSION['items']))
  	    $_SESSION['items']=0;
      if(!isset($_SESSION['total_price']))
  	    $_SESSION['total_price']=0.0;
      if(!isset($_SESSION['cart']))
  	    $_SESSION['cart']=array();

  	  //add item
  	  if(isset($_SESSION['cart'][$new])){
  	  	$_SESSION['cart'][$new]++;
  	  }else
  	  	$_SESSION['cart'][$new]=1;

  	  $_SESSION['items']=calculate_items($_SESSION['cart']);
  	  $_SESSION['total_price']=calculate_price($_SESSION['cart']);
  	}

  	//change item
  	if(isset($_POST['save'])){
  		foreach ($_SESSION['cart'] as $key => $value) {
  			if($_SESSION['cart'][$key] == 0){
  				unset($_SESSION['cart'][$key]);
  			}else
  			 	$_SESSION['cart'][$key] = $_POST[$key];
  		}

  	  $_SESSION['items']=calculate_items($_SESSION['cart']);
  	  $_SESSION['total_price']=calculate_price($_SESSION['cart']);
  	}


  	//show cart
  	display_html_header('Shopping Cart','cart');
  	display_html_top_bar();
	  display_html_nav();
  	if(($_SESSION['cart']) && (array_count_values($_SESSION['cart']))) {
    	display_cart($_SESSION['cart']);
  	} else {
    	echo "<p>There are no items in your cart</p><hr/>";
  	}

  	//add an item to cart,continue shopping in that category
  	$target='index.php';
  	if($new){
  		$item_details=get_item_details($new);
  		if($item_details){
  			$target='index.php?catid='.$item_details['catid'];
  		}
  	}
  	echo "<div class=\"continue_shopping\"><a href=\"".$target."\"><img src=\"images/continue-shopping.gif\" /></a>";

  	display_html_footer();
 ?>