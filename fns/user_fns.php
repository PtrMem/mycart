<?php 
	 require_once('db_fns.php');

    function register($username, $email, $password) {
        // register new person with db
        // return true or error message

        // connect to db
        $conn = db_connect();

        // check if username is unique
        $result = $conn->query("select * from user where username='".$username."' or email='".$email."'");
        if (!$result) {
            $conn->close();
            throw new Exception('Could not execute query');
        }

        if ($result->num_rows>0) {
            $conn->close();
            throw new Exception('That username is taken - go back and choose another one.');
        }

        // if ok, put in db
        $result = $conn->query("insert into user (username,password,email) values('".$username."', sha1('".$password."'), '".$email."')");

        if (!$result) {
            $conn->close();
            throw new Exception('Could not register you in database - please try again later.');
        }
        $conn->close();
        return true;
    }
 ?>