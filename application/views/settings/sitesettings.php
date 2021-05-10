<?php
	if(isset($settings) && $settings->num_rows() > 0)
	{
		$config 	= $settings->row();
		$name 		= $config->name;
		$address 	= $config->address;
		$fax 		= $config->fax;
		$postal_code= $config->postal_code;
		$email 		= $config->email;
		$phone 		= $config->phone;
		$website 	= $config->website;
		$logo 		= $config->logo;
		$currency 	= $config->currency;
		$date_format = $config->date_format;
	}
?>
<div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">System Configuration </h3>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-gear"></i> System Settings </h3>
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
			<form role="form" method="POST" action="<?php echo site_url('settings'); ?>">
              <div class="form-group">
                <label>Name</label>
                <input class="form-control" name="companyname" value="<?php echo (isset($name)) ? $name : ''; ?>"/>
				<?php echo form_error('companyname'); ?>
              </div>

              <div class="form-group">
                <label>Address</label>
                <input class="form-control" name="companyaddress" value="<?php echo (isset($address)) ? $address : ''; ?>"/>
				<?php echo form_error('companyaddress'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Fax</label>
                <input class="form-control" name="companyfax" value="<?php echo (isset($fax)) ? $fax : ''; ?>"/>
				<?php echo form_error('companyfax'); ?>
              </div>

              <div class="form-group">
                <label>Postal / Zip Code  </label>
                <input class="form-control" name="postal_code" value="<?php echo (isset($postal_code)) ? $postal_code : ''; ?>"/>
				<?php echo form_error('postal_code'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Email</label>
                <input class="form-control" name="companyemail" value="<?php echo (isset($email)) ? $email : ''; ?>"/>
				<?php echo form_error('companyemail'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Phone Number</label>
                <input class="form-control" name="companyphone" value="<?php echo (isset($phone)) ? $phone : ''; ?>"/>
				<?php echo form_error('companyphone'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Website</label>
                <input class="form-control" name="companywebsite" value="<?php echo (isset($website)) ? $website : ''; ?>"/>
				<?php echo form_error('companywebsite'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Currency Symbol</label>
                <input class="form-control" name="currency" value="<?php echo (isset($currency)) ? $currency : ''; ?>"/>
				<?php echo form_error('currency'); ?>
              </div>
              <div class="form-group">
	              <label class="control-label">Date Format</label>
	               <?php  echo date_format_select((isset($date_format)) ? $date_format : ''); ?>
	               <?php echo form_error('date_format'); ?>
              </div>
			  
              <button type="submit" class="btn btn-large btn-success" name="updatesettingsbtn" value="save settings">Save Configurations</button>
            </form>
		</div>
			<!-- company logo area -->
				<div class="col-lg-6"> 
					<div class="panel panel-primary center" style="width:auto">
						<div class="panel-body">
							<div class="table-responsive">
								<?php
								if(isset($logoerror)){
								?>
									<div class="alert alert-dismissable alert-danger">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									<strong>Error !</strong> <?php echo $logoerror;?>
									</div>
								<?php
								}
								?>
								<?php
								if($this->session->flashdata('logosuccess')){
								?>
									<div class="alert alert-dismissable alert-success">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									<strong>Success !</strong> <?php echo $this->session->flashdata('logosuccess');?>
									</div>
								<?php
								}
								?>
								<div class="form-group">
									<label>Company Logo</label><br/>
									<?php 
										$logo = (isset($logo) && $logo != '') ? UPLOADSDIR.$logo : IMAGESFOLDER.'no-logo.jpg'; 
									?>
									<img src="<?php echo base_url().$logo;?>" width="200px" />
								 </div>
								 <form method="POST" action="" enctype="multipart/form-data" >
								 <div class="form-group">
									<label for="logo">Browse Logo : </label>
										 <input type="file" class="filestyle" data-classButton="btn btn-primary" name="logo"/>
										 <br/><?php echo form_error('logo'); ?>
								</div> <!-- /field -->
								<button type="submit" class="btn btn-large btn-success" name="updatelogobtn" value="New Logo">Update Logo</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			  
            </div>
          </div>
		 </div>
        </div><!-- /.row -->
 </div><!-- /#page-wrapper -->