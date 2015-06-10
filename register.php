<?php 
	require_once('cart_fns.php');
	display_html_header('register','reg');
 ?>

<div class="reg">
	<form method="post" action="register_new.php">
     <li>&nbsp;&nbsp;<span class="behov">*</span>用户名:&nbsp;<input type="text" name="username"/>&nbsp;最大16个字符</li>
     <li><span class="behov">*</span>请设置密码:&nbsp;<input type="password" name="passwd"/>&nbsp;6至16个字符</li>
     <li><span class="behov">*</span>请确认密码:&nbsp;<input type="password" name="passwd2"/></li>
     <li>&nbsp;<span class="behov">*</span>邮箱地址:&nbsp;<input type="text" name="email" /></li>
     <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="注册"></li>
    </form>
</div>

<?php 
	display_html_footer();
 ?>
