<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Classic Invoicing System</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<link href="<?php echo base_url().CSSFOLDER; ?>bootstrap.css" rel="stylesheet">
	<link href="<?php echo base_url().CSSFOLDER; ?>login.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url().FONTSFOLDER;?>css/font-awesome.min.css">
	<script src="<?php echo base_url().JAVASCRIPTFOLDER; ?>jquery.min.js"></script>
	<script src="<?php echo base_url().JAVASCRIPTFOLDER; ?>bootstrap.js"></script>
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<script type="text/javascript">
		$(function() { $('#email').focus(); });
	</script>
</head>
	<body>
		<div class="well span5 center login-box">
		<div class="login-header">
			<?php
			$logo = (isset($logo) && $logo != '') ? base_url().UPLOADSDIR.$logo : base_url().IMAGESFOLDER.'ci_logo.jpg'; 
			echo '<img src="'.$logo.'" width="50%" />';
			?>
			<div class="clearfix"></div>
		</div>
		<?php
				if($this->session->flashdata('error')){
				?>
				<div class="alert alert-dismissable alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Error !</strong> <?php echo $this->session->flashdata('error');?>
				</div>
				<?php
				}
				?>
			<form class="form-horizontal" action="<?php echo site_url('login');?>" method="post">
				<fieldset>
					<div class="form-group input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="text" class="form-control input-small" placeholder="Username" name="username"/>
						
					</div>
					
					<div class="form-group input-group">
						<span class="input-group-addon"><i class="fa fa-key"></i></span>
						<input type="password" class="form-control input-small" placeholder="Password" name="password" id="password"/>
					</div>
				
					<p class="pull-left">
					<a href="<?php echo site_url('login/resetpassword');?>" class="btn btn-large btn-primary"><i class="fa fa-key"> Forgot Password </i></a>
					</p>
					<p class="pull-right">
					<button type="submit" class="btn btn-success" name="loginbttn" value="Login">Login</button>
					</p>
				</fieldset>
			</form>
		</div>
	</body>
</html>