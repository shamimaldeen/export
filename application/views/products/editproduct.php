      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">Edit Product</h3>
			<a href="<?php echo site_url('products'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-chevron-left"> Back to Products List </i></a>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> Edit product </h3>
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
			<form role="form" method="POST" action="<?php echo site_url('products/editproduct'); ?>/<?php echo (isset($product->product_id)) ? $product->product_id : '' ;?>">
			<input type="hidden" name="product_id" value="<?php echo (isset($product->product_id)) ? $product->product_id : '' ;?>"/>
              <div class="form-group">
                <label>Product Name</label>
                <input class="form-control" name="product_name" value="<?php echo (isset($product->product_name)) ? $product->product_name : '' ;?>"/>
				<?php echo form_error('product_name'); ?>
              </div>

              <div class="form-group">
                <label>Product Description</label>
				<textarea class="form-control"  name="product_description" ><?php echo (isset($product->product_description)) ? $product->product_description : '' ;?></textarea>
				<?php echo form_error('product_description'); ?>
              </div>
			  
			  <div class="form-group">
                <label>Unit Price</label>
                <input class="form-control" name="product_unit_price" value="<?php echo (isset($product->product_unitprice)) ? $product->product_unitprice : '' ;?>"/>
				<?php echo form_error('product_unit_price'); ?>
              </div>

              <button type="submit" class="btn btn-large btn-success" name="editproductbtn" value="Edit products">Update Product Details</button>
             </form>
				  
				 </div>  
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->


      </div><!-- /#page-wrapper -->