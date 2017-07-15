
<div id="cklogin" style="z-index:40;position:absolute;text-align:center;width:600px;display:none;height:400px;left:50%;top:0%; background-color:#FFF;margin-top: -400px;margin-left: -300px;">
<div>登陆后才能继续播放</div>
	<!-- if not logged -->
	<form action="<?php echo wp_login_url( get_permalink() ); ?>" method="post" id="loginform">
		<div class="loginblock">

			<p class="login"><input type="text" name="log" id="log" size="" tabindex="11" /></p>
			<p class="password"><input type="password" name="pwd" id="pwd"  size="" tabindex="12" /></p>
			<p class="lefted"><button value="Submit" id="submit_t" type="submit" tabindex="13">登&nbsp;录</button></p>
			
		</div>
		<input type="hidden" name="redirect_to" value="<?php echo $_SERVER[ 'REQUEST_URI' ]; ?>" />
		<input type="checkbox" name="rememberme" id="modlogn_remember" value="yes"  checked="checked" alt="Remember Me" />下次自动登录
	</form>
</div>
