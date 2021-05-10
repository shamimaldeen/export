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
		$(function() { $('#username').focus(); });
	</script>
</head>
	<body>
		<div class="well span5 center login-box">
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
			<form class="form-horizontal" action="<?php echo site_url('login/resetpassword');?>" method="post">
				<fieldset>
					<p class="form-group pull-left" style="margin-left:5px;width:100%;text-align:left">
					<label class="control-label"> Enter Username </label>
					</p>
					<?php echo form_error('username'); ?>

					
					<div style="clear:both"></div>
					<div class="form-group input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="text" class="form-control input-small" placeholder="Username" name="username"/>
					</div>
					
					<p class="pull-left">
						<a href="<?php echo site_url('login');?>" class="btn btn-large btn-success"><i class="fa fa-chevron-left"> Back to login page </i></a>
					</p>
					<p class="pull-right">
					<button type="submit" class="btn btn-primary" name="resetpasswordbttn" value="Reset Password">Reset Password</button>
					</p>
				</fieldset>
			</form>
		</div>
	</body>
</html>