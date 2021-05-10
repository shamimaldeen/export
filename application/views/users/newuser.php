      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">Create User</h3>
			<a href="<?php echo site_url('users'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-chevron-left"> Back to Users List </i></a>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> Create a new user account </h3>
              </div>
              <div class="panel-body">
                <div class="table-responsive">
           <div class="col-lg-6"> 
				<?php
				if($this->session->flashdata('success')){
				?>
				<div class="alert alert-dismissable alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Success !</strong> <?php echo $this->session->flashdata('success');?>
				</div>
				<?php
				}
				?>
			<form role="form" method="POST" action="<?php echo site_url('users/createuser'); ?>">
              <div class="form-group">
                <label>First Name</label>
                <input class="form-control" name="firstname" value="<?php echo set_value('firstname');?>"/>
				<?php echo form_error('firstname'); ?>
              </div>

              <div class="form-group">
                <label>Last Name</label>
                <input class="form-control" name="lastname" value="<?php echo set_value('lastname');?>"/>
				<?php echo form_error('lastname'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Email</label>
                <input class="form-control" name="email" value="<?php echo set_value('email');?>"/>
				<?php echo form_error('email'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Phone Number</label>
                <input class="form-control" name="phone" value="<?php echo set_value('phone');?>"/>
				<?php echo form_error('phone'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Username</label>
                <input class="form-control" name="username" value="<?php echo set_value('username');?>"/>
				<?php echo form_error('username'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Password</label>
                <input class="form-control" name="password" type="password" value="<?php echo set_value('password');?>"/>
				<?php echo form_error('password'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Confirm Password</label>
                <input class="form-control" name="confirmpassword" type="password" value="<?php echo set_value('confirmpassword');?>"/>
				<?php echo form_error('confirmpassword'); ?>
              </div>

              <button type="submit" class="btn btn-large btn-success" name="createuserbtn" value="New User">Create user</button>
              <button type="reset" class="btn btn-large btn-danger">Reset Form</button>  

            </form>
				  
				 </div>  
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->


      </div><!-- /#page-wrapper -->