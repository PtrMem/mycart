<?php 
	 // include function files for this application
    require_once('cart_fns.php');
    session_start();
    @$old_user = $_SESSION['user'];
    @setcookie('user',$_SESSION['user'],time()-3600);

    // store  to test if they *were* logged in
    unset($_SESSION['user']);
    $result_dest = session_destroy();

    // start output html
    display_html_header('Logging Out','logout');
    echo "<div class=\"logout\">";
    if (!empty($old_user)) {
        if ($result_dest)  {
            // if they were logged in and are now logged out
            echo 'Logged out.<br />';
            echo '<script>setTimeout(function(){location.href="index.php";},2000);</script>';
        } else {
            // they were logged in and could not be logged out
            echo 'Could not log you out.<br />';
        }
    } else {
        // if they weren't logged in but came to this page somehow
        echo 'You were not logged in, and so have not been logged out.<br />';
        echo '<script>setTimeout(function(){location.href="login.php";},2000);</script>';
    }
    echo "</div>";
    display_html_footer();
 ?>