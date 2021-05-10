  <div id="page-wrapper">

	<div class="row">
	  <div class="col-lg-12">
		<h3 class="pull-left">Products</h3>
		<a href="<?php echo site_url('products/createproduct'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-plus"> Create Product </i></a>
	  </div>
	</div><!-- /.row -->

	<div class="row">
	  <div class="col-lg-12">
		<div class="panel panel-primary">
		  <div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-user"></i> List of Products</h3>
		  </div>
		  <div class="panel-body">
			<div class="table-responsive">
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
			  <table class="table table-bordered table-hover table-striped tablesorter">
				<thead>
				  <tr class="table_header">
					<th>Product Name <i class="fa fa-sort"></i></th>
					<th>Product Description <i class="fa fa-sort"></i></th>
					<th>Unit Price <i class="fa fa-sort"></i></th>
					<th>Actions</th>
				  </tr>
				</thead>
				<tbody>
				<?php
				if( isset($products) && $products->num_rows() > 0 )
				{
					foreach ($products->result_array() as $count => $product)
					{
					?>
					<tr>
					<td><?php echo ucfirst($product['product_name']); ?></td>
					<td><?php echo limit_text($product['product_description'], 50); ?></td>
					<td><?php echo $product['product_unitprice']; ?></td>
					<td>
					<a href="<?php echo site_url('products/editproduct/'.$product['product_id']); ?>" class="btn btn-xs btn-success"><i class="fa fa-check"> Edit </i></a>
					<a href="<?php echo site_url('products/delete/'.$product['product_id']);?>" onclick="return confirm('Are you sure you want to permanently delete this product?');" class="btn btn-danger btn-xs"><i class="fa fa-times"> Delete </i></a>
					</td>
					</tr>
					<?php
					}
				}
				else
				{
				?>
				<tr class="no-cell-border"><td> There are no products available at the moment.</td>
				<td></td>
				<td></td>
				<td></td>
				</tr>
				<?php
				}
				?>
				</tbody>
			  </table>
			</div>
		  </div>
		</div>
	  </div>
	</div><!-- /.row -->


  </div><!-- /#page-wrapper -->