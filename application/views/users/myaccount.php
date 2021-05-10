      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">My Profile</h3>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-6">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> Update your profile </h3>
              </div>
              <div class="panel-body">
                <div class="table-responsive">
           <div class="col-lg-12"> 
			<?php
			if($this->session->flashdata('profile_update_success')){
			?>
			<div class="alert alert-dismissable alert-success">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Success !</strong> <?php echo $this->session->flashdata('profile_update_success');?>
			</div>
			<?php
			}
			?>
			<form role="form" method="POST" action="<?php echo site_url('account/myprofile'); ?>">
			  <div class="form-group">
                <label>Username</label>
                <input class="form-control" name="username" readonly value="<?php echo (isset($userdata->username)) ? $userdata->username : '' ;?>"/>
              </div>
			  
              <div class="form-group">
                <label>First Name</label>
                <input class="form-control" name="firstname" value="<?php echo (isset($userdata->first_name)) ? $userdata->first_name : '' ;?>"/>
				<?php echo form_error('firstname'); ?>
              </div>

              <div class="form-group">
                <label>Last Name</label>
                <input class="form-control" name="lastname" value="<?php echo (isset($userdata->last_name)) ? $userdata->last_name : '' ;?>"/>
				<?php echo form_error('lastname'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Email</label>
                <input class="form-control" name="email" value="<?php echo (isset($userdata->user_email)) ? $userdata->user_email : '' ;?>"/>
				<?php echo form_error('email'); 
				if(isset($email_exists_error)) echo '<p class="has-error"><label class="control-label">'.$email_exists_error.'</label></p>';
				?>
              </div>
			  
			  <div class="form-group">
                <label>Phone Number</label>
                <input class="form-control" name="phone" value="<?php echo (isset($userdata->user_phone)) ? $userdata->user_phone : '' ;?>"/>
				<?php echo form_error('phone'); ?>
              </div>
              <button type="submit" class="btn btn-large btn-success" name="updateprofilebtn" value="New User">Update Profile</button>
            </form>
				  
				 </div>  
                </div>
              </div>
            </div>
          </div>
		  
		   <div class="col-lg-6">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> Change your password </h3>
              </div>
              <div class="panel-body">
                <div class="table-responsive">
           <div class="col-lg-12"> 
				<?php
				if($this->session->flashdata('change_password_success')){
				?>
				<div class="alert alert-dismissable alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Success !</strong> <?php echo $this->session->flashdata('change_password_success');?>
				</div>
				<?php
				}
				?>
			<form role="form" method="POST" action="<?php echo site_url('account/changepassword'); ?>">
              <div class="form-group">
                <label>Current Password</label>
                <input class="form-control" name="currentpassword" type="password" value="<?php echo set_value('currentpassword');?>"/>
				<?php echo form_error('currentpassword'); ?>
              </div>

              <div class="form-group">
                <label>New Password</label>
                <input class="form-control" name="new_password" type="password" value="<?php echo set_value('new_password');?>"/>
				<?php echo form_error('new_password'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Confirm New Password</label>
                <input class="form-control" name="confirm_password" type="password" value="<?php echo set_value('confirm_password');?>"/>
				<?php echo form_error('confirm_password'); ?>
              </div>
              <button type="submit" class="btn btn-large btn-success" name="changepasswordbtn" value="New User"> Change Password </button>
            </form>
				  
				 </div>  
                </div>
              </div>
            </div>
          </div>
		  
        </div><!-- /.row -->


      </div><!-- /#page-wrapper -->