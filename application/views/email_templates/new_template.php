<div id="page-wrapper">

<div class="row">
  <div class="col-lg-12">
	<h3 class="pull-left">Create Template</h3>
	<a href="<?php echo site_url('email_templates'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-chevron-left"> Back to email templates </i></a>
  </div>
</div><!-- /.row -->

<div class="row">
  <div class="col-lg-12">
	<div class="panel panel-primary">
	  <div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-user"></i> Create a new template </h3>
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
	<form role="form" method="POST" action="<?php echo site_url('email_templates/create'); ?>">
	  <div class="form-group">
		<label>Template Title</label>
		<input class="form-control" name="template_title" value="<?php echo set_value('template_title');?>"/>
		<?php echo form_error('template_title'); ?>
	  </div>

	  <div class="form-group">
		<label>Template Body</label>
		<textarea class="form-control"  name="template_body" id="template_body" rows="10"><?php echo set_value('template_body');?></textarea>
		<?php echo form_error('template_body'); ?>
	  </div>

	  <button type="submit" class="btn btn-large btn-success" name="createtemplatebtn" value="New template">Create Template</button>
	  <button type="reset" class="btn btn-large btn-danger">Reset Form</button>  

	</form>
		 </div>
		<div class="col-lg-3"> 
		<p><label>Invoice Tags</label></p>
		 <a href="#" class="text-tag" data-tag="[invoice_id]">Invoice ID</a><br>
		 <a href="#" class="text-tag" data-tag="[invoice_number]">Invoice Number</a><br>
		 <a href="#" class="text-tag" data-tag="[invoice_total]">Invoice Total</a><br>
		 <a href="#" class="text-tag" data-tag="[invoice_date_created]">Invoice Created Date</a><br>
		 <a href="#" class="text-tag" data-tag="[invoice_due_date]">Invoice Due Date</a><br>
		 <a href="#" class="text-tag" data-tag="[invoice_total_paid]">Invoice Total Paid</a><br>
		 <a href="#" class="text-tag" data-tag="[invoice_balance]">Invoice Balance</a><br>
		 <a href="#" class="text-tag" data-tag="[invoice_terms]">Invoice Terms</a><br>
		 <a href="#" class="text-tag" data-tag="[invoice_status]">Invoice status</a><br>
		 <a href="#" class="text-tag" data-tag="[invoice_payment_method]">Invoice Payment Method</a><br>
		 </div>
		 
		<div class="col-lg-3"> 
		<p><label>Client Tags</label></p>
		 <a href="#" class="text-tag" data-tag="[client_name]">Client Name</a><br>
		 <a href="#" class="text-tag" data-tag="[client_address]">Client Address</a><br>
		 <a href="#" class="text-tag" data-tag="[client_city]">Client City</a><br>
		 <a href="#" class="text-tag" data-tag="[client_state]">Client State</a><br>
		 <a href="#" class="text-tag" data-tag="[client_country]">Client Country</a><br>
		</div>
		</div>
	  </div>
	</div>
  </div>
</div><!-- /.row -->


</div><!-- /#page-wrapper -->