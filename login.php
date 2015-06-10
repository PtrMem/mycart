<?php 
	include_once('cart_fns.php');
	session_start();
	$result='';
	if(isset($_POST['username'])&&isset($_POST['passwd'])){
		if(empty($_POST['username'])||empty($_POST['passwd'])){
			$result="请填写用户名或密码";
			goto display;
		}
		$conn = db_connect();
		if(!$conn){
			$result="网络故障，请稍候再试。";
			goto display;
		}
		$sql="select * from user where username='".$_POST['username']."' and password=sha1('".$_POST['passwd']."')";
		$ret=$conn->query($sql);
		if(!$ret){
			$result="用户名或密码错误，请重试.";
			goto display;
		}
		if(@$ret->num_rows>0){
			$_SESSION['user']=$_POST['username'];
			setcookie('user',$_POST['username'],time()+3600);
			header("Location:index.php");
		}else{

		}
	}

	display:
	display_html_header('Login','login');
	//display_html_top_bar();
	if($result){
		echo "<div class=\"ret\"><p>".$result."</p></div>";
	}
 ?>
	<div class="login">
        <form method="post" action="login.php">
            <ul>
            	<li><a href="register.php">立即注册</a></li>
            	<li></li>
	            <li>Username: <input type="text" name="username"/></li>
            	<li></li>
                <li>Password: <input type="password" name="passwd"/></li>
                <li></li>
                <li></li>
                <li align="center"> <input style="height: 31px;" type="submit" value="登 录"/></li>
                <li></li>

            </ul>
        </form>
    </div>


<?php 
	display_html_footer();
 ?>