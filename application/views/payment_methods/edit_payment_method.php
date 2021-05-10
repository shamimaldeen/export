 <div id="page-wrapper">
<div class="row">
  <div class="col-lg-12">
	<h3 class="pull-left">Edit Payment Method</h3>
	<a href="<?php echo site_url('payment_methods'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-chevron-left"> Back to Payment Methods </i></a>
  </div>
</div><!-- /.row -->

<div class="row">
  <div class="col-lg-12">
	<div class="panel panel-primary">
	  <div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-user"></i> Edit Payment Method</h3>
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
	<form role="form" method="POST" action="<?php echo site_url('payment_methods/edit'); ?>/<?php echo (isset($payment_method->payment_method_id)) ? $payment_method->payment_method_id : ''?>">
	<input type="hidden" name="payment_method_id" value="<?php echo (isset($payment_method->payment_method_id)) ? $payment_method->payment_method_id : '';?>" />
	  <div class="form-group">
		<label>Payment Method Name</label>
		<input class="form-control" name="payment_method_name" value="<?php echo (isset($payment_method->payment_method_name)) ? $payment_method->payment_method_name : '';?>"/>
		<?php echo form_error('payment_method_name'); ?>
	  </div>

	  <button type="submit" class="btn btn-large btn-success" name="editpayment_methodbtn" value="Edit payment method">Update Payment Method</button>
	  <button type="reset" class="btn btn-large btn-danger">Reset Form</button>  

	</form>
		  
		 </div>  
		</div>
	  </div>
	</div>
  </div>
</div><!-- /.row -->
</div><!-- /#page-wrapper -->