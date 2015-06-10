<?php 
	function display_html_header($title,$css)
	{
		if (!isset($_SESSION['items'])) {
            $_SESSION['items'] = '0';
        }
        if (!isset($_SESSION['total_price'])) {
            $_SESSION['total_price'] = '0.00';
        }
?>

		<html>
		<head>
			<title><?php echo $title;?></title>
      <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
			<?php 
                $ret=array();
                switch($css){
                    case 'index':
                      $ret[]='index.css';
                        break;
                    case 'cart':
                        $ret[]='cart.css';
                        break;
                    case 'process':
                        $ret[]='cart.css';
                        $ret[]='process.css';
                        break;
                    case 'item':
                        $ret[]='item.css';
                        break;
                    case 'card':
                        $ret[]='cart.css';
                        $ret[]='card.css';
                        break;
                    case 'reg':
                        $ret[]='reg.css';
                        break;
                    case 'login':
                        $ret[]='login.css';
                        break;
                    case 'checkout':
                        $ret[]='cart.css';
                        $ret[]='checkout.css';
                        break;
                    default:
                        break;
                }
                if($ret)
                  foreach ($ret as $value) {
                     echo "<link href=\"css/".$value."\" rel=\"stylesheet\" type=\"text/css\" /> ";
                  }
                 
            ?>
        <style type="text/css">
          *{
              margin: 0;
              padding:0;
          }

          ul,li{
            list-style-type: none;
            line-height: 30px;
          }

          a{
            text-decoration: none;
          }
          .error{
            margin-top: 10px;
            text-align: center;
            color: red;
            font-size: 20px;
          }
          #wrap{
            width:980px;
            margin:0px auto;
          }

          #top_bar{
            width:100%;
          }
          #top_bar ul{
            float: right;
            margin-right: 20px;
          }
          #top_bar li{
            line-height: 30px;
            display: inline;
            margin-right: 10px;
          }
          .clearfix{
            display: block;
            clear: both;
          }

          #nav{
            background-color: rgb(206,206,206);
            position: relative;
            width: 100%;
          }
          #nav div{
            display: inline-block;
          }
          #cate {
            position: absolute;
            top:10px;
            left: 400px;
          }
          #cate li{
            display: inline;
            margin-right: 10px;
          }
          #mycart{
            position: absolute;
            top: 10px;
            right: 50px;
          }
        </style>
		</head>
		<body>
      <div id="wrap">
<?php
	}

	function display_html_footer()
	{	
		echo "</div></body></html>";
	}


	function display_html_top_bar()
	{
		if(!empty($_SESSION['user']))

?>
		<div id="top_bar">
			<ul>
				<?php  empty($_SESSION['user'])?printf('<li><a href="login.php">登录</a></li><li><a href="register.php">注册</a></li>'):printf('<li>'.$_SESSION['user'].'</li><li><a href="logout.php">退出</a></li>');?>
			</ul>
		</div>
    <i class="clearfix"></i> 
<?php
	}


  	function display_html_nav()
  	{
 ?>
 		<div id="nav">
 			<div id="logo"><a href="index.php"><img src="images/Book-O-Rama.gif" alt="logo" /></a></div>
 			<div id="cate">
 				<ul>
 					<?php 
 						$cats=get_categories();
 						display_categories($cats);
 					 ?>
 				</ul>	
 			</div>

 			<div id="mycart"><a href="show_cart.php"><img src="images/cart.gif"/></a></div>
 		</div> 
    <i class="clearfix"></i>

 <?php		
  	}


  	function display_categories($cat_array)
  	{
  		if(!is_array($cat_array)){
  			echo "<p>No categories currently available</p>";
  			return;
  		}
  		foreach ($cat_array as $key) {
  			$url="index.php?catid=".$key['catid'];
  			$title=$key['catname'];
  			echo "<li><a href=\"".$url."\">".$key['catname']."</a></li>";
  		}
  	}

  	//show items of a category 
  	function display_items($catid)
  	{
  		$ret=get_items($catid);
  		if(!is_array($ret)){
  			echo "<p>No books currently available in this category</p>";
  			return;
  		}

  		echo "<div class=\"items\"><ul>";

  		foreach ($ret as $row) {
  			$url = 'show_item.php?id='.$row['isbn'];
  			echo "<li><a href=\"".$url."\"><img class=\"item_img\" src=\"images/".$row['isbn'].".jpg\" alt=\"".$row['title']."\" /><span class=\"price\">&yen; {$row['price']}</span><span class=\"book_name\">".$row['title']."</span></a>";
        echo "<a href=\"show_cart.php?new=".$row['isbn']."\"><img class=\"items_add\" src=\"images/add-to-cart.gif\" /></a></li>";
  		}

  		echo "</ul><i class=\"clearfix\"></i></div>";
  	}

  	//show a item information
  	function display_item($item)
  	{
  		if(is_array($item)){
  			echo "<div class=\"item\">";
  			echo "<div class=\"item_img\"><img src=\"images/".$item['isbn'].".jpg\" alt=\"".$item['title']."\"/></div>";
  ?>
  			<div class="item_info">
  				<ul>
  					<li><strong>Author:&nbsp;</strong><?php echo $item['author'];?></li>
  					<li><strong>ISBN:&nbsp;</strong><?php echo $item['isbn'];?></li>
  					<li><strong>Our Price:&nbsp;</strong><?php echo number_format($item['price'], 2);;?></li>
  					<li><strong>Description:&nbsp;</strong><?php echo $item['description'];?></li>
  					<li class="addcart"><a href=<?php echo "show_cart.php?new=".$item['isbn'];?>><img src="images/add-to-cart.gif" /></a></li>
  				</ul>
  			</div>
        <i class="clearfix"></i>
 <?php
  		}
  	}



  	 function display_cart($cart, $change = true, $images = 1) {
        // display items in shopping cart
        // optionally allow changes (true or false)
        // optionally include images (1 - yes, 0 - no)

        echo "<div class=\"cart_th\"><span class=\"t_item\">商品</span><span class=\"space\"></span><span class=\"t_price\">单价</span><span class=\"t_qty\">数量</span><span class=\"t_total\">小计</span></div>";
        echo "<div class=\"cart\"><form action=\"show_cart.php\" method=\"post\"><ul>";

        //display each item as a table row
        foreach ($cart as $isbn => $qty)  {
          if($qty==0)
            continue;
            $item=get_item_details($isbn);
            echo "<li>";
            if($images == true) {
                echo "<img src=\"images/".$isbn.".jpg\"/ alt=\"".$item['title']."\">";
            }
            echo "<a href=\"show_item.php?id=".$isbn."\">".$item['title']."</a><span class=\"space\" ></span><span class=\"item_price\">".number_format($item['price'], 2)."</span>";

            // if we allow changes, quantities are in text boxes
            if ($change == true) {
                echo "<input class=\"qty\" type=\"text\" name=\"".$isbn."\" value=\"".$qty."\" />";
            } else {
                echo $qty;
            }
            echo "<span class=\"items_price\">".number_format($item['price']*$qty,2)."</span><i class=\"clearfix\"></i></li>";
        }
        echo "<li class=\"post_cost\" style=\"background-color: #ffffff\"><span>运费：".calculate_shipping_cost($_SESSION['total_price'])."</span><i class=\"clearfix\"></i></li>";
        // display total row
        echo "<li class=\"sum_price\" style=\"background-color: #ffffff\"><span>合计： ".number_format($_SESSION['total_price']+calculate_shipping_cost($_SESSION['total_price']), 2)."</span><i class=\"clearfix\"></i></li>";

        // display save change button
        if($change == true) {
        	echo "<li class=\"option\" style=\"background-color: #ffffff\"><input type=\"hidden\" name=\"save\" value=\"true\"/><input type=\"image\" src=\"images/save-changes.gif\" alt=\"Save Changes\"/>";
            echo "<a href=\"checkout.php\"><img src=\"images/go-to-checkout.gif\" /></a><i class=\"clearfix\"></i></li>";
        }

        echo "</ul></form></div>";
    }

    function display_checkout_form()
    {
 ?>
 		<div class = "checkout">
 			<form action="purchase.php" method="post">
 				<ul>
 					<li><span>&nbsp;&nbsp;姓名: </span><input type="text" name="name" value=""/><i class="clearfix"></i></li>
 					<li><span>手机号码: </span><input type="text" name="phone" value=""/><i class="clearfix"></i></li>
 					<li><span>&nbsp;&nbsp;省份: </span><input type="text" name="state" value=""/><i class="clearfix"></i></li>
 					<li><span>&nbsp;&nbsp;城市: </span><input type="text" name="city" value=""/><i class="clearfix"></i></li>
 					<li><span>详细地址: </span><input type="text" name="address" value=""/><i class="clearfix"></i></li> 	
 					<li><input type="image" src="images/purchase.gif" alt="purchase"/><i class="clearfix"></i></li> 				
 				</ul>
 			</form>
 		</div>
<?php
    }


    function display_button($target, $image, $alt)
    {
        echo "<div align=\"center\"><a href=\"".$target."\">
        <img src=\"images/".$image.".gif\"
        alt=\"".$alt."\" /></a></div>";
    }



    function display_card_form()
    {
?>
      <div class="pay">
        <div class="card">
          <form method="post" action="process.php">
            <ul>
              <li>银行卡号&nbsp;<input class="card_info" type="text" name="card_number" value=""></li>
              <li>&nbsp;&nbsp;姓名&nbsp;<input class="card_info" type="text" name="name" value=""></li>
              <li  class="bank"><input type="image" name="card_name" value="gs" src="images/gs.jpg" /></li>
              <li  class="bank"><input type="image" name="card_name" value="js" src="images/js.jpg" /></li>
              <li  class="bank"><input type="image" name="card_name" value="jt" src="images/jt.jpg" /></li>
              <li  class="bank"><input type="image" name="card_name" value="ny" src="images/ny.jpg" /></li>
              <li  class="bank"><input type="image" name="card_name" value="ms" src="images/ms.jpg" /></li>
              <li  class="bank"><input type="image" name="card_name" value="gf" src="images/gf.jpg" /></li>
              <li  class="bank"><input type="image" name="card_name" value="zg" src="images/zg.jpg" /></li>
              <li  class="bank"><input type="image" name="card_name" value="zs" src="images/zs.jpg" /></li>
            </ul>
          </form>
        </div>
        <i class="clearfix"></i>
      </div>
<?php 
    }
?>

