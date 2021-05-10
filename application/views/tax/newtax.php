      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">Create Tax Rate</h3>
			<a href="<?php echo site_url('tax'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-chevron-left"> Back to Tax List </i></a>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> Create a new Tax rate </h3>
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
			<form role="form" method="POST" action="<?php echo site_url('tax/newtax'); ?>">
              <div class="form-group">
                <label>Tax Rate Name</label>
                <input class="form-control" name="tax_rate_name" value="<?php echo set_value('tax_rate_name');?>"/>
				<?php echo form_error('tax_rate_name'); ?>
              </div>

              <div class="form-group">
                <label>Tax Rate Percentage</label>
                <input class="form-control" name="tax_rate_percentage" style="width:95%;display: inline;" value="<?php echo set_value('tax_rate_percentage');?>"/> %
				<?php echo form_error('tax_rate_percentage'); ?>
              </div>

              <button type="submit" class="btn btn-large btn-success" name="createtaxbtn" value="New Tax Rate">Create Tax Rate</button>
              <button type="reset" class="btn btn-large btn-danger">Reset Form</button>  

            </form>
				  
				 </div>  
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->
      </div><!-- /#page-wrapper -->