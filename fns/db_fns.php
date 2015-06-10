<?php 
	function db_connect() {
		$server="localhost";
		$username="root";
		$password='';
		$db_name='book_sc';
        $result = new mysqli($server,$username,$password,$db_name);
        if (!$result) {
            return false;
        }
        $result->autocommit(TRUE);
        return $result;
    }

    function db_result_to_array($result) {
        $res_array = array();

        for ($count=0; $row = $result->fetch_assoc(); $count++) {
            $res_array[$count] = $row;
        }

        return $res_array;
    }
 ?>