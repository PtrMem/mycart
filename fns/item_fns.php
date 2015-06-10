<?php 
	function calculate_shipping_cost($total_price)
	{
		$free=60;
		$cost=40.0;
		return $total_price>$free?0.0:$cost;
	}

	function get_categories() {
        // query database for a list of categories
        $conn = db_connect();
        $query = "select catid, catname from categories";
        $result = @$conn->query($query);
        if (!$result) {
            return false;
        }
        $num_cats = @$result->num_rows;
        if ($num_cats == 0) {
            return false;
        }
        $result = db_result_to_array($result);
        $conn->close();
        return $result;
    }


	function get_category_name($catid) {
        // query database for the name for a category id
        $conn = db_connect();
        $query = "select catname from categories
        where catid = '".$catid."'";
        $result = @$conn->query($query);
        if (!$result) {
            return false;
        }
        $num_cats = @$result->num_rows;
        if ($num_cats == 0) {
            return false;
        }
        $row = $result->fetch_object();
        $conn->close();
        return $row->catname;
    }

    function get_items($catid) {
        // query database for the books in a category
        if ((!$catid) || ($catid == '')) {
            return false;
        }

        $conn = db_connect();
        $query = "select * from books where catid = '".$catid."'";
        $result = @$conn->query($query);
        if (!$result) {
            $conn->close();
            return false;
        }
        $num_books = @$result->num_rows;
        if ($num_books == 0) {
            $conn->close();
            return false;
        }
        $result = db_result_to_array($result);
        $conn->close();
        return $result;
    }


	function get_item_details($id) {
        // query database for all details for a particular book
        if ((!$id) || ($id=='')) {
            return false;
        }
        $conn = db_connect();
        $query = "select * from books where isbn='".$id."'";
        $result = @$conn->query($query);
        if (!$result) {
            $conn->close();
            return false;
        }
        $result = @$result->fetch_assoc();
        $conn->close();
        return $result;
    }

	function calculate_price($cart) {
        // sum total price for all items in shopping cart
        $price = 0.0;
        if(is_array($cart)) {
            $conn = db_connect();
            foreach($cart as $isbn => $qty) {
                $query = "select price from books where isbn='".$isbn."'";
                $result = $conn->query($query);
                if ($result) {
                    $item = $result->fetch_object();
                    $item_price = $item->price;
                    $price +=$item_price*$qty;
                }
            }
        }
        return $price;
    }


	function calculate_items($cart) {
        // sum total items in shopping cart
        $items = 0;
        if(is_array($cart))   {
            foreach($cart as $isbn => $qty) {
                $items += $qty;
            }
        }
        return $items;
    }


 ?>