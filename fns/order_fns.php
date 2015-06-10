<?php 
	function process_card($card_details) {
        // connect to payment gateway or
        // use gpg to encrypt and mail or
        // store in DB if you really want to

        return true;
    }

    function insert_order($order_details) {
        // extract order_details out as variables
        extract($order_details);

        // set shipping address same as address
        if((!isset($ship_name)) && (!isset($ship_address)) && (!isset($ship_city)) && (!isset($ship_state)) && (!isset($ship_phone))) {
            $ship_name = mysql_real_escape_string($name);
            $ship_address =  mysql_real_escape_string($address);
            $ship_city =  mysql_real_escape_string($city);
            $ship_state =  mysql_real_escape_string($state);
            $ship_phone =  mysql_real_escape_string($phone);
        }
        $conn = db_connect();

        // we want to insert the order as a transaction
        // start one by turning off autocommit
        $conn->autocommit(FALSE);

        // insert customer address
        $query = "select user_id from customers where
        name = '".$name."' and address = '".$address."'
        and city = '".$city."' and state = '".$state."'
        and phone = '".$phone."'";

        $result = $conn->query($query);
        $user_id=-1;

        if(@$result->num_rows>0) {
            $customer = $result->fetch_object();
            $user_id=$customer->user_id;            
        } else {
            $ret=$conn->query("select user_id from user where username='".$_SESSION['user']."'");

            if(!$ret){
                return false;
            }

            if($ret->num_rows>0) {
                $customer = $ret->fetch_object();
                $user_id=$customer->user_id;
                $query = "insert into customers values ('".$user_id."','".$name."','".$address."','".$city."','".$state."','".$phone."')";
                $result = $conn->query($query);
                if (!$result) {

                    return false;
                }
            }
        }



        $date = date("Y-m-d");


        //order is exists,return orderid
        $query="select * from orders where 
        user_id='".$user_id."' and amount = ".$_SESSION['total_price']." and
        date=".$date." and ship_name = '".$ship_name."' and
        ship_address = '".$ship_address."' and ship_city='".$ship_city."' 
        and ship_phone='".$ship_phone."' and ship_state='".$ship_state."'";
        $result=$conn->query($query);
        if(!$result){

            return false;
        }

        if($result->num_rows>0) {

            $order = $result->fetch_object();
            return $orderid = $order->orderid;
        }


        //insert order
        $query = "insert into orders values
        ('', '".$user_id."', '".$_SESSION['total_price']."', '".$date."', 'PARTIAL',
         '".$ship_name."', '".$ship_address."', '".$ship_city."', '".$ship_state."',
         '".$ship_phone."')";

        $result = $conn->query($query);

        if (!$result) {

            return false;
        }

        //get order id
        $query = "select orderid from orders where
        user_id = '".$user_id."' and
        amount > (".$_SESSION['total_price']."-.001) and
        amount < (".$_SESSION['total_price']."+.001) and
        date = '".$date."' and
        order_status = 'PARTIAL' and
        ship_name = '".$ship_name."' and
        ship_address = '".$ship_address."' and
        ship_city = '".$ship_city."' and
        ship_state = '".$ship_state."' and
        ship_phone = '".$ship_phone."'";

        $result = $conn->query($query);
        if($result->num_rows>0) {

            $order = $result->fetch_object();
            $orderid = $order->orderid;
        } else {

            return false;
        }

        // insert each book
        foreach($_SESSION['cart'] as $isbn => $quantity) {
            $detail = get_item_details($isbn);
            $query = "delete from order_items where
            orderid = '".$orderid."' and isbn = '".$isbn."'";
            $result = $conn->query($query);
            $query = "insert into order_items values
            ('".$orderid."', '".$isbn."', ".$detail['price'].", $quantity)";
            $result = $conn->query($query);
            if(!$result) {

                return false;
            }
        }

        // end transaction
        $conn->commit();
        $conn->autocommit(TRUE);

        $conn->close();
        return $orderid;
    }
 ?>