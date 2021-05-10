      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">Edit Client</h3>
			<a href="<?php echo site_url('clients'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-chevron-left"> Back to Clients List </i></a>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> Edit client </h3>
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
			<form role="form" method="POST" action="<?php echo site_url('clients/editclient'); ?>/<?php echo (isset($client->client_id)) ? $client->client_id : '' ;?>">
			<input type="hidden" name="client_id" value="<?php echo (isset($client->client_id)) ? $client->client_id : '' ;?>"/>
        <div class="form-group">
          <label>Client Name</label>
          <input class="form-control" name="client_name" value="<?php echo (isset($client->client_name)) ? $client->client_name : '' ;?>"/>
	        <?php echo form_error('client_name'); ?>
        </div>

        <div class="form-group">
          <label>Client Address</label>
          <input class="form-control" name="client_address" value="<?php echo (isset($client->client_address)) ? $client->client_address : '' ;?>"/>
	        <?php echo form_error('client_address'); ?>
        </div>
			  
         <div class="form-group">
          <label>Postal / Zip Code</label>
          <input class="form-control" name="client_postalcode" value="<?php echo (isset($client->postal_code)) ? $client->postal_code : '' ;?>"/>
          <?php echo form_error('client_postalcode'); ?>
        </div>

			  <div class="form-group">
                <label>Client City</label>
                <input class="form-control" name="client_city" value="<?php echo (isset($client->client_city)) ? $client->client_city : '' ;?>"/>
				        <?php echo form_error('client_city'); ?>
        </div>
			  
			  <div class="form-group">
                <label>Client Country</label>
				<?php echo country_dropdown('client_country', 'client_country', 'form-control', (isset($client->client_country)) ? $client->client_country : '' , array(), ''); ?>
				<?php echo form_error('client_country'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Client Telephone</label>
                <input class="form-control" name="client_telephone" value="<?php echo (isset($client->client_phone)) ? $client->client_phone : '' ;?>"/>
				<?php echo form_error('client_telephone'); ?>
              </div>
			  
			   <div class="form-group">
                <label>Client Fax</label>
                <input class="form-control" name="client_fax" value="<?php echo (isset($client->client_fax)) ? $client->client_fax : '' ;?>"/>
				<?php echo form_error('client_fax'); ?>
              </div>
			  
			   <div class="form-group">
                <label>Client Email</label>
                <input class="form-control" name="client_email" value="<?php echo (isset($client->client_email)) ? $client->client_email : '' ;?>"/>
				<?php echo form_error('client_email'); 
				if(isset($email_exists_error)) echo '<p class="has-error"><label class="control-label">'.$email_exists_error.'</label></p>';
				?>
              </div>

              <button type="submit" class="btn btn-large btn-success" name="editclientbtn" value="Edit Client">Update Client Details</button>
            </form>
				  
				 </div>  
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->


      </div><!-- /#page-wrapper -->