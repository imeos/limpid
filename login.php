<?php
/*
  --------------------------------------------------
  limpid CMS Made Simple Theme
  --------------------------------------------------
  Login Theme-File
  --------------------------------------------------
*/
?><!doctype html>
<head>
  <title><?php echo lang('logintitle')?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=<?php echo get_encoding() ?>" />
  <meta name="robots" content="noindex, nofollow" />

  <link rel="shortcut icon" href="themes/limpid/images/icons/system/favicon.ico" />
  <link rel="Bookmark" href="themes/limpid/images/icons/system/favicon.ico" />

  <link rel="stylesheet" type="text/css" media="screen, projection" href="loginstyle.php" />
  <!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" href="themes/limpid/css/ie8.css" />
  <![endif]-->
  
  <base href="<?php global $gCms; $config =& $gCms->GetConfig(); echo $config['root_url'] . '/' . $config['admin_dir'] . '/'; ?>" />
</head>

<body class="login">
  
  <?php
		debug_buffer('Debug in the page is: ' . $error);
		if (isset($error) && $error != '') {
			echo '<div class="pagemcontainer"><p class="pageerror">'.$error.'</p></div>';
		}
		else if (isset($warningLogin) && $warningLogin != '')	{
			echo '<div class="pagemcontainer"><p class="pageerror">'.$warningLogin.'</p></div>';
		}
		else if (isset($acceptLogin) && $acceptLogin != '')	{
			echo '<div class="pagemcontainer"><p class="pagemessage">'.$acceptLogin.'</p></div>';
		}
	?>
  
  <div class="box">
    <h1><?php echo lang('logintitle')?></h1>

    <?php
      # change PW
      if ($changepwhash != '') {
				echo '<div class="pagemcontainer"><p class="pageerror">'.lang('passwordchange').'</p></div>';
		?>
        <p class="password">
          <label for="password"><?php echo lang('password')?>:</label>
        </p>
        <p class="password">
          <label for="passwordagain"><?php echo lang('passwordagain')?>:</label>
        </p>
  			<div class="login-fields">
  				<form method="post" action="login.php">
  					<input id="lbpassword"  name="password" type="password" size="15" /><br />
  					<input id="lbpasswordagain"  name="passwordagain" type="password" size="15" /><br />
  					<input type="hidden" name="changepwhash" value="<?php echo $changepwhash ?>" />
  					<input type="hidden" name="forgotpwchangeform" value="1" />
  					<input class="loginsubmit" name="loginsubmit" type="submit" value="<?php echo lang('submit')?>" /> 
  					<input class="loginsubmit" name="logincancel" type="submit" value="<?php echo lang('cancel')?>" />
  				</form>
  			</div>
    <?php
  		} 
      # forgot PW
  		else if (isset($_REQUEST['forgotpw']) && $_REQUEST['forgotpw']) {
  	?>
				<p class="info"><?php echo lang('forgotpwprompt')?></p>
        <div class="login-fields">
        	<form method="post" action="login.php">
        	  <p class="username">
              <label for="username" title="<?php echo lang('username')?>">
                <?php echo lang('username')?>:
              </label>
              <input id="lbusername" name="forgottenusername" placeholder="<?php echo lang('username')?>" type="text" size="15" value="" />
            </p>
        		<input type="hidden" name="forgotpwform" value="1" />
        		<p class="buttons">
              <input class="loginsubmit" name="loginsubmit" type="submit" value="<?php echo lang('submit')?>" /> 
  						<input class="loginsubmit" name="logincancel" type="submit" value="<?php echo lang('cancel')?>" />
  					</p>
        	</form>
        </div>
    <?php
      } 
      # normal Login
      else { 
    ?>    
				<form method="post" action="login.php">
          <p class="username">
            <label for="username" title="<?php echo lang('username')?>">
              <?php echo lang('username')?>:
            </label>
            <input id="lbusername" name="username" placeholder="<?php echo lang('username')?>" type="text" size="15" value="<?php echo htmlentities(isset($_POST['username'])?$_POST['username']:'')?>" autofocus /><br />
          </p>
          <p class="password">
            <label for="password" title="<?php echo lang('password')?>">
              <?php echo lang('password')?>:
            </label>
            <?php if(isset($error) && $error!='') {
						  echo '<input id="lbpassword" class="defaultfocus" name="password" type="password" placeholder="'.lang('password').'" size="15"><br />';
						} else {
						  echo '<input id="lbpassword" name="password" type="password" placeholder="'.lang('password').'" size="15"><br />';
						} ?>
          </p>
          <p class="buttons">
            <input class="loginsubmit" name="loginsubmit" type="submit" value="<?php echo lang('submit')?>" /> 
						<input class="loginsubmit" name="logincancel" type="submit" value="<?php echo lang('cancel')?>" />
					</p>
				</form>
				<p class="forgot-pw">
					<a href="login.php?forgotpw=1"><?php echo lang('lostpw')?></a>
				</p>
    <?php
      } 
    ?> 
  </div>
  
  <div id="copy">
    <p>
      &copy; <a rel="external" href="http://www.cmsmadesimple.org">CMS Made Simple</a><br /> 
      Is free software released under the General Public Licence.
    </p>
  </div>
  
</body>
</html>