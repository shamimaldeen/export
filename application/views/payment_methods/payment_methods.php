      <div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">Payment Methods</h3>
			<a href="<?php echo site_url('payment_methods/create'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-plus"> Create Payment Method </i></a>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> List of Payment Methods</h3>
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
                        <th></th>
                        <th>Payment Method Name<i class="fa fa-sort"></i></th>
						<th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					if( isset($payment_methods) && $payment_methods->num_rows() > 0 )
					{
						foreach ($payment_methods->result_array() as $count => $payment_method)
						{
							$count++;
						?>
						<tr>
                        <td><?php echo $count; ?>.</td>
                        <td><?php echo $payment_method['payment_method_name']; ?></td>
						<td>
						<a href="<?php echo site_url('payment_methods/edit/'.$payment_method['payment_method_id']); ?>" class="btn btn-xs btn-success"><i class="fa fa-check"> Edit </i></a>
						<a href="<?php echo site_url('payment_methods/delete/'.$payment_method['payment_method_id']);?>" onclick="return confirm('Are you sure you want to permanently delete this payment method?');" class="btn btn-danger btn-xs"><i class="fa fa-times"> Delete </i></a>
						</td>
						</tr>
						<?php
						}
					}
					else
					{
					?>
					<tr class="no-cell-border">
					<td> There are no payment methods available at the moment.</td>
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