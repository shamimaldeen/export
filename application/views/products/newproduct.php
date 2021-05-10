      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">Create Product</h3>
			<a href="<?php echo site_url('products'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-chevron-left"> Back to Products List </i></a>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> Create a new product </h3>
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
			<form role="form" method="POST" action="<?php echo site_url('products/createproduct'); ?>">
              <div class="form-group">
                <label>Product Name</label>
                <input class="form-control" name="product_name" value="<?php echo set_value('product_name');?>"/>
				<?php echo form_error('product_name'); ?>
              </div>

              <div class="form-group">
                <label>Product Description</label>
				<textarea class="form-control"  name="product_description" ><?php echo set_value('product_description');?></textarea>
				<?php echo form_error('product_description'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Unit Price</label>
                <input class="form-control" name="product_unit_price" value="<?php echo set_value('product_unit_price');?>"/>
				<?php echo form_error('product_unit_price'); ?>
              </div>

              <button type="submit" class="btn btn-large btn-success" name="createproductbtn" value="New products">Create Product</button>
              <button type="reset" class="btn btn-large btn-danger">Reset Form</button>  

            </form>
				  
				 </div>  
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->


      </div><!-- /#page-wrapper -->