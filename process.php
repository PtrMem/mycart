<?php 
	include_once('cart_fns.php');
    // The shopping cart needs sessions, so start one
    session_start();
    setcookie('user',$_SESSION['user'],time()+3600);

    display_html_header('Checkout','process');
    display_html_top_bar();
	display_html_nav();
    print_r($_POST);
    $card_number = $_POST['card_number'];
    $card_name = $_POST['card_name'];
    $name=$_POST['name'];

    if($_SESSION['cart']  && $card_number && $name) {
        //display cart, not allowing changes and without pictures
        display_cart($_SESSION['cart'], false, 0);

        if(process_card($_POST)) {
            //empty shopping cart
            unset($_SESSION['cart']);
            echo "<div class=\"pro_ret\"><p>Thank you for shopping with us. Your order has been placed.</p>";
            display_button("index.php", "continue-shopping", "Continue Shopping");
        } else {
            echo "<div class=\"pro_ret\"><p>Could not process your card. Please contact the card issuer or try again.</p>";
            display_button("purchase.php", "back", "Back");
        }
    } else {
        echo "<div class=\"pro_ret\"><p>You did not fill in all the fields, please try again.</p><hr />";
        display_button("purchase.php", "back", "Back");
    }
    echo "</div>";
    display_html_footer();
 ?>