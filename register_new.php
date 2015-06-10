<?php 
    require_once('cart_fns.php');

    //create short variable names
    $email=$_POST['email'];
    $username=$_POST['username'];
    $passwd=$_POST['passwd'];
    $passwd2=$_POST['passwd2'];
    // start session which may be needed later
    // start it now because it must go before headers
    session_start();
    try   {
        // check forms filled in
        if (!filled_out($_POST)) {
            throw new Exception('You have not filled the form out correctly - please go back and try again.');
        }

        // email address not valid
        if (!valid_email($email)) {
            throw new Exception('That is not a valid email address.  Please go back and try again.');
        }

        // passwords not the same
        if ($passwd != $passwd2) {
            throw new Exception('The passwords you entered do not match - please go back and try again.');
        }

        // check password length is ok
        // ok if username truncates, but passwords will get
        // munged if they are too long.
        if ((strlen($passwd) < 6) || (strlen($passwd) > 16)) {
            throw new Exception('Your password must be between 6 and 16 characters Please go back and try again.');
        }

        // attempt to register
        // this function can also throw an exception
        register($username, $email, $passwd);
        // register session variable
        $_SESSION['user'] = $username;
        setcookie('user',$username,time()+3600);

        // provide link to members page
        display_html_header('Registration successful','regbg');
        echo 'Your registration was successful.';
        //echo '<script>setTimeout(function(){location.href="index.php";},1000);</script>';

        // end page
        displayer_html_footer();
    }
    catch (Exception $e) {
        display_html_header('Problem:','regbg');
        echo $e->getMessage();
        display_html_footer();
        exit();
    }
 ?>