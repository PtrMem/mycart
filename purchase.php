<?php 
	  include_once('cart_fns.php');
    // The shopping cart needs sessions, so start one
    session_start();
    setcookie('user',$_SESSION['user'],time()+3600);



    // create short variable names
    $name = $_POST['name'];
    $address = $_POST['address'];
    $state=$_POST['state'];
    $city = $_POST['city'];
    $phone = $_POST['phone'];

    if(!is_numeric($phone)){
        $_SESSION['error']='请填入正确的手机号码';
        header("location: checkout.php");
    }
    display_html_header("Checkout",'card');
    display_html_top_bar();
    display_html_nav();

    // if filled out
    if (($_SESSION['cart']) && ($name) && ($address) && ($city) && ($phone) && ($state)) {
        // able to insert into database
        $order_id=insert_order($_POST);
        if($order_id != false ) {
            echo "<div class=\"order_id\"><span>你的订单号：$order_id</span></div>";
            //display cart, not allowing changes and without pictures
            display_cart($_SESSION['cart'], false, 0);

            //get credit card details
            display_card_form();

            display_button("index.php", "continue-shopping", "Continue Shopping");
        } else {
            echo "<p>Could not store data, please try again.</p>";
            display_button('checkout.php', 'back', 'Back');
        }
    } else {
        echo "<p>You did not fill in all the fields, please try again.</p><hr />";
        display_button('checkout.php', 'back', 'Back');
    }

    display_html_footer();
 ?>