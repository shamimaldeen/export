      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">Tax Rates</h3>
			<a href="<?php echo site_url('tax/newtax'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-plus"> Create Tax Rate </i></a>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> List of Tax Rates</h3>
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
                        <th>Tax Name <i class="fa fa-sort"></i></th>
                        <th>Percentage Value <i class="fa fa-sort"></i></th>
						<th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					if( isset($tax_rates) && $tax_rates->num_rows() > 0 )
					{
						foreach ($tax_rates->result_array() as $count => $tax_rate)
						{
						?>
						<tr>
                        <td><?php echo ucwords($tax_rate['tax_rate_name']); ?></td>
                        <td><?php echo $tax_rate['tax_rate_percent']; ?></td>
						<td>
						<a href="<?php echo $this->config->item('nav_base_url'); ?>tax/edittax/<?php echo $tax_rate['tax_rate_id'];?>" class="btn btn-xs btn-success"><i class="fa fa-check"> Edit </i></a>
						<a href="<?php echo site_url('tax');?>/delete/<?php echo $tax_rate['tax_rate_id'];?>" onclick="return confirm('Are you sure you want to permanently delete this tax rate?');" class="btn btn-danger btn-xs"><i class="fa fa-times"> Delete </i></a>
						</td>
						</tr>
						<?php
						}
					}
					else
					{
					?>
					<tr class="no-cell-border"><td> There are no tax rates available at the moment.</td>
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