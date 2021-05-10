<div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">Overdue Invoices</h3>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> List of overdue Invoices</h3>
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
                  <table class="table table-bordered table-striped tablesorter">
                    <thead>
                      <tr class="table_header">
						<th>Status</th>
                        <th>Invoice No.</i></th>
                        <th>Date Issued</th>
						<th>Client Name</th>
                        <th class="text-right">Amount </th>
                        <th class="text-right">Paid </th>
						<th>Actions</th>
                      </tr>
                    </thead>
                    <tbody id="invoice_table_body">
					<?php
					if( isset($overdue_invoices) && !empty($overdue_invoices))
					{
						foreach ($overdue_invoices as $count => $invoice)
						{
						?>
						<tr>
						<td style="width:15%">
						<?php echo status_label($invoice['invoice_status']);?>
						<span class="label label-danger">Overdue</span>
						</td>
                        <td><a href="<?php echo site_url('invoices/edit/'.$invoice['invoice_id']);?>"><?php echo $invoice['invoice_number']; ?></a></td>
                        <td><?php echo format_date($invoice['invoice_date_created']); ?></td>
                        <td><a href="<?php echo site_url('clients/editclient/'.$invoice['client_id']); ?>"><?php echo ucwords($invoice['client_name']); ?></a></td>
                        <td class="text-right invoice_amt"><?php echo format_amount($invoice['invoice_amount']); ?></td>
                        <td class="text-right amt_paid"><?php echo format_amount($invoice['total_paid']); ?></td>
						<td style="width:32%">
						<a href="<?php echo site_url('invoices/edit/'.$invoice['invoice_id']);?>" class="btn btn-xs btn-primary"><i class="fa fa-check"> Edit </i></a>
						<a href="javascript:;" onclick="enterPayment('<?php echo $invoice['invoice_id']; ?>')" class="btn btn-success btn-xs"><i class="fa fa-usd"> Enter Payment </i></a>
						<a href="javascript:;" onclick="viewInvoice('<?php echo $invoice['invoice_id']; ?>')" class="btn btn-info btn-xs"><i class="fa fa-search"> Preview </i></a>
						<a href="<?php echo site_url('invoices/viewpdf/'.$invoice['invoice_id']);?>" class="btn btn-warning btn-xs">Download pdf </a>
						</td>
						</tr>
						<?php
						}
					}
					else
					{
					?>
					<tr class="no-cell-border">
					<td> There are no invoices available at the moment.</td>
					<td></td>
					<td></td>
					<td></td>
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