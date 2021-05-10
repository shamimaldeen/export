<div class="row">
<div class="col-lg-12">
  <h1 class="page-header">Dashboard</h1>
</div>
</div>
		
<div class="row">
<!-- Total unpaid amount section -->
<div class="col-lg-6">
  <div class="panel panel-yellow">
      <div class="panel-heading">
          <h3 class="panel-title">Total unpaid amount</h3>
      </div>
      <div class="panel-body  text-center">
          <span class="pending_bal huge"><?php echo format_amount($invoice_stats['unpaid_amount'], true, 'before'); ?></span>
      </div>
  </div>
</div>
<!-- Total unpaid amount section -->
<div class="col-lg-6">
      <div class="panel panel-red">
      <div class="panel-heading"> 
          <h3 class="panel-title">Total overdue amount</h3>
      </div>
      <div class="panel-body text-center">
          <span class="pending_bal huge"><?php echo format_amount($invoice_stats['overdue_amount'], true, 'before'); ?></span>
      </div>
    </div>
</div>
</div>
<hr/>



        <div class="row">
          <div class="col-lg-3">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-usd fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <p class="announcement-heading"><?php echo $invoice_stats['all_invoices']; ?></p>
                    <p class="announcement-text">Invoices Created</p>
                  </div>
                </div>
              </div>
			  <?php if($invoice_stats['all_invoices'] > 0){ ?>
              <a href="<?php echo site_url('invoices');?>">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-7">
                      View all Invoices
                    </div>
                    <div class="col-xs-5 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
			  <?php } ?>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="panel panel-yellow">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-money fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <p class="announcement-heading"><?php echo $invoice_stats['unpaid_invoices']; ?></p>
                    <p class="announcement-text">Unpaid Invoices</p>
                  </div>
                </div>
              </div>
			  <?php if($invoice_stats['unpaid_invoices'] > 0){ ?>
              <a href="<?php echo site_url('invoices/index/unpaid');?>">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-9">
                      View Unpaid Invoices
                    </div>
                    <div class="col-xs-3 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
			  <?php } ?>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="panel panel-red">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-times fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <p class="announcement-heading"><?php echo $invoice_stats['cancelled_invoices']; ?></p>
                    <p class="announcement-text">Invoices Cancelled </p>
                  </div>
                </div>
              </div>
			  <?php if($invoice_stats['cancelled_invoices'] > 0){ ?>
              <a href="<?php echo site_url('invoices/index/cancelled');?>">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-10">
                      View Cancelled Invoices
                    </div>
                    <div class="col-xs-2 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
			  <?php } ?>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="panel panel-green">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-check fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <p class="announcement-heading"><?php echo $invoice_stats['paid_invoices']; ?></p>
                    <p class="announcement-text">Invoices Paid</p>
                  </div>
                </div>
              </div>
			  <?php if($invoice_stats['paid_invoices'] > 0){?>
              <a href="<?php echo site_url('invoices/index/paid');?>">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-8">
                      View Paid Invoices
                    </div>
                    <div class="col-xs-4 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
			  <?php } ?>
            </div>
          </div>
		  
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-money"></i> Recent Invoices</h3>
              </div>
              <div class="panel-body">
                <div class="table-responsive">
                   <table class="table table-bordered table-striped">
                    <thead>
                      <tr class="table_header">
						            <th>Status</th>
                        <th>Invoice No.</i></th>
                        <th>Date Issued</th>
						            <th>Due Date</th>
						            <th>Client Name</th>
                        <th class="text-right">Amount </th>
						            <th class="text-right">Amount Paid </th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					if( isset($recent_invoices))
					{
						foreach ($recent_invoices as $count => $invoice)
						{
						?>
						<tr>
						<td>
						
						<?php 
						if($invoice['invoice_status'] == 'PAID'){ $class='success'; } 
						if($invoice['invoice_status'] == 'UNPAID'){ $class='warning'; } 
						if($invoice['invoice_status'] == 'CANCELLED'){ $class='danger'; } 
						?>
						<span class="label label-<?php echo $class;?>"><?php echo $invoice['invoice_status'];?></span>
						</td>
            <td><a href="<?php echo site_url('invoices/edit/'.$invoice['invoice_id']);?>"><?php echo $invoice['invoice_number']; ?></a></td>
            <td><?php echo format_date($invoice['invoice_date_created']); ?></td>
						<td><?php echo format_date($invoice['invoice_due_date']); ?></td>
            <td><a href="<?php echo site_url('clients/editclient/'.$invoice['client_id']); ?>"><?php echo ucwords($invoice['client_name']); ?></a></td>
            <td class="text-right"><?php echo format_amount($invoice['invoice_amount']); ?></td>
						<td class="text-right"><?php echo format_amount($invoice['total_paid']);?>
						</td>
						</tr>
						<?php
						}
					}
					?>
                    </tbody>
                  </table>
                </div>
                <div class="text-right">
                  <a href="<?php echo site_url('invoices');?>">View All Invoices <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->