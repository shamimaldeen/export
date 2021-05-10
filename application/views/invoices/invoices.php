 <script type="text/javascript">
	    $(function() {
			$('input:radio[name="invoice_status"]').change(function(){
			$('.loading').fadeIn('slow');
			var status = $(this).val();
			$.post("<?php echo site_url('invoices/ajax_filter_invoices'); ?>", {
                status: status,
            },
            function(data) {
               $('#invoice_table_body').html(data);
			   $('.loading').fadeOut('slow');
            });
				
			});
			
		});
</script>
<div class="loading"></div>
<div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">Invoices</h3>
			<a href="<?php echo $this->config->item('nav_base_url'); ?>invoices/newinvoice" class="btn btn-large btn-success pull-right"><i class="fa fa-plus"> New Invoice </i></a>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> List of Invoices</h3>
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
				<div class="well" style="background-color: #d9edf7;border-color: #bce8f1;color: #31708f;">
					<div class="form-group" style="margin-bottom:0px">
					<label> Filter : </label> &nbsp;&nbsp;
					<label class="radio-inline"><input type="radio" name="invoice_status" <?php echo ($status == 'all') ? 'checked' : ''; ?> id="allinvoices" value="all"> All Invoices</label>
					<label class="radio-inline"><input type="radio" name="invoice_status" <?php echo ($status == 'paid') ? 'checked' : ''; ?> id="paidinvoices" value="paid"> Paid</label>
					<label class="radio-inline"><input type="radio" name="invoice_status" <?php echo ($status == 'unpaid') ? 'checked' : ''; ?> id="unpaidinvoices" value="unpaid"> Unpaid</label>
					<label class="radio-inline"><input type="radio" name="invoice_status" <?php echo ($status == 'cancelled') ? 'checked' : ''; ?> id="cancelledinvoices" value="cancelled"> Cancelled</label>
					</div>
				</div>
                  <table class="table table-bordered table-striped tablesorter">
                    <thead>
                      <tr class="table_header">
						<th>Status</th>
                        <th>Invoice No.</i></th>
                        <th>Date Issued</th>
						<th>Client Name</th>
                        <th class="text-right">Amount </th>
                        <th class="text-right">Paid</th>
						<th>Actions</th>
                      </tr>
                    </thead>
                    <tbody id="invoice_table_body">
					<?php
					if( isset($invoices) && !empty($invoices))
					{
						foreach ($invoices as $count => $invoice)
						{
						?>
						<tr>
						<td><?php echo status_label($invoice['invoice_status']);?></td>
                        <td><a href="<?php echo site_url('invoices/edit/'.$invoice['invoice_id']);?>"><?php echo $invoice['invoice_number']; ?></a></td>
                        <td><?php echo format_date($invoice['invoice_date_created']); ?></td>
                        <td><a href="<?php echo site_url('clients/editclient/'.$invoice['client_id']); ?>"><?php echo ucwords($invoice['client_name']); ?></a></td>
                        <td class="text-right invoice_amt"><?php echo format_amount($invoice['invoice_amount']); ?></td>
                        <td class="text-right amt_paid"><?php echo format_amount($invoice['total_paid']); ?></td>
						<td style="width:32%">
						<a href="<?php echo site_url('invoices/edit/'.$invoice['invoice_id']);?>" class="btn btn-xs btn-primary"><i class="fa fa-check"> Edit </i></a>
						<a href="javascript:;" onclick="enterPayment('<?php echo $invoice['invoice_id']; ?>')" class="btn btn-success btn-xs"><i class="fa fa-usd"> Enter Payment </i></a>
						<a href="javascript:;" class="btn btn-info btn-xs" onclick="viewInvoice('<?php echo $invoice['invoice_id']; ?>')"><i class="fa fa-search"> Preview </i></a>
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