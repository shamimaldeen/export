 <script type="text/javascript">
	    $(function() {
        <?php if (!isset($invoice_items) || empty($invoice_items)) { ?>
            $('#new_item').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
        <?php } ?>
		});
 </script>
 <div class="loading"></div>
<div class="row">
	<div class="col-lg-12">
		<div class="well invoice_menu navbar navbar-fixed-top">
			<a href="javascript: void(0);" class="btn btn-large btn-primary" id="bttn_add_item"><i class="fa fa-plus"></i> Add Item</a>
			<a href="javascript: void(0);" class="btn btn-large btn-info" id="bttn_add_product"><i class="fa fa-plus"></i> Add Item From Products</a>
			<a href="javascript: void(0);" onclick="delete_invoice('<?php echo $invoice_details->invoice_id; ?>');" class="btn btn-large btn-danger pull-right" id="bttn_delete_invoice" ><i class="fa fa-times"></i> Delete Invoice</a> 
			<a href="javascript: void(0);" onclick="javascript: ajax_save_invoice();" class="btn btn-large btn-success pull-right"  style="margin-right:10px" id="bttn_save_invoice"><i class="fa fa-check"></i> Save Changes</a>
			
		</div>
	</div>
</div>
 <div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary" style="margin-top:70px">
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
					<div class="row">
						<div class="col-lg-6">
						<h3> Invoice Number : # <?php echo $invoice_details->invoice_number; ?> </h3>
							<div class="panel panel-default col-lg-10">
							  <div class="panel-body">
							  	<input type="hidden" name="save_type" value="edit" id="save_type" />
							  	<div class="form-group">
								<label>Invoice Number </label>
								 <input type="text" id="invoice_number" class="form-control" name="invoice_number" value="<?php echo $invoice_details->invoice_number; ?>"/>
								</div>

								<div class="form-group">
								<label>Client </label>
								<select name="client_to_invoice" id="client_to_invoice" class="form-control"><?php echo $clients; ?></select>
								</div>
								
								<label>Invoice Date </label>
								<div class="form-group input-group date" style="margin-left:0;">
								   <input class="form-control" size="16" type="text" value="<?php echo (isset($invoice_details->invoice_date_created)) ?  date('d-m-Y', strtotime($invoice_details->invoice_date_created)) : ''; ?>" name="invoice_date" readonly id="invoice_date"/>
									<span class="input-group-addon add-on"><i class="fa fa-calendar" style="display: inline"></i></span>
								</div>
								
								<label>Invoice Due Date </label>
								<div class="form-group input-group date" style="margin-left:0;">
								   <input class="form-control" size="16" type="text" name="invoice_due_date" value="<?php echo (isset($invoice_details->invoice_due_date)) ? date('d-m-Y', strtotime($invoice_details->invoice_due_date)) : ''; ?>" readonly id="invoice_due_date" />
									<span class="input-group-addon add-on"><i class="fa fa-calendar" style="display: inline"></i></span>
								</div>
								<div class="form-group">
								<a href="javascript: void(0);" onclick="emailclient('<?php echo $invoice_details->invoice_id; ?>')" class="btn btn-large btn-success pull-right"  style="margin-right:10px"><i class="fa fa-envelope"></i> Email Invoice to Client </a>
								</div>
							  </div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="panel-default col-lg-12">
							 <div class="panel-body">
							  <?php echo invoice_status($invoice_details->invoice_status); ?>
							<div style="clear: both"></div>
							<div class="form-group invoice_change_status pull-right">
							<label>Change Status : </label>
								<select class="form-control" name="invoice_status" id="invoice_status">
								<option value="paid" <?php echo ($invoice_details->invoice_status == 'PAID') ? 'selected' : ''; ?>> PAID </option>
								<option value="unpaid" <?php echo ($invoice_details->invoice_status == 'UNPAID') ? 'selected' : ''; ?>> UNPAID </option>
								<option value="cancelled" <?php echo ($invoice_details->invoice_status == 'CANCELLED') ? 'selected' : ''; ?>> CANCELLED </option>
								</select>
							</div>	
								
							  </div>
							  <div class="invoice_actions pull-right">
							  <div class="form-group">
							  <a href="javascript: void(0);" onclick="enterPayment('<?php echo $invoice_details->invoice_id; ?>')" class="btn btn-large btn-primary" id="bttn_enter_payment"><i class="fa fa-usd"></i> Enter Payment</a>
							  <a href="javascript: void(0);" class="btn btn-large btn-info" id="bttn_view_pdf" onclick="viewInvoice('<?php echo $invoice_details->invoice_id; ?>')"><i class="fa fa-search"></i> Preview Invoice </a>
							  </div>
							
							  </div>
							</div>
						</div>
						
					</div>
		<div class="row">
			<div class="col-lg-12">
				<h4>Invoice Items</h4>	
			<div class="table-responsive">			
              <table id="item_table" class="table table-bordered">
                <thead>
                  <tr class="table_header">
                    <th>Item</th>
                    <th>Description</th>
					<th>Tax Rate</th>
                    <th>Quantity</i></th>
                    <th class="text-right">Unit Price</th>
					<th class="text-right">Discount</th>
					<th class="text-right">Sub-total <br/> (Tax Excl.)</th>
					<th></th>
                  </tr>
                </thead>
                <tbody>
					<tr id="new_item" style="display: none;">
					<td style="width:20%">
					<input type="hidden" name="invoice_id" value="<?php echo $invoice_details->invoice_id; ?>" id="invoice_id">
					<input type="hidden" name="item_id" value="">
					<input name="item_name" value="" class="form-control"/></td>
					<td style="width:25%"><textarea name="item_description" class="form-control"></textarea></td>
					<td style="width:12%">
					<select name="tax_rate_id" id="tax_rate_id" onchange="javascript: calculateInvoiceAmounts();" class="form-control" ><?php echo $taxrates; ?></select>
					</td>
					<td style="width:5%"><input class="form-control" onchange="javascript: calculateInvoiceAmounts();"  name="item_quantity" value=""/></td>
					<td class="text-right" style="width:10%"><input class="form-control text-right" onchange="javascript: calculateInvoiceAmounts();"  name="item_price" value=""/></td>
					<td class="text-right" style="width:8%"><input class="form-control text-right" onchange="javascript: calculateInvoiceAmounts();"  name="item_discount" value=""/></td>
					<td class="text-right" style="width:10%"><input class="form-control text-right" readonly name="item_sub_total" value=""/></td>
					<td style="width:2%"></td>
					</tr>
				  <?php 
					if(isset($invoice_items))
					{
						foreach($invoice_items as $item)
						{
					?>
						<tr id="item" class="item">
						<td style="width:20%">
						<input type="hidden" name="invoice_id" value="<?php echo $invoice_details->invoice_id; ?>">
						<input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
						<input name="item_name" value="<?php echo $item['item_name']; ?>" class="form-control"/>
						</td>
						<td style="width:25%"><textarea name="item_description" class="form-control"><?php echo $item['item_description']; ?></textarea></td>
						<td style="width:12%">
						<select name="tax_rate_id" id="tax_rate_id" onchange="javascript: calculateInvoiceAmounts();" class="form-control" ><?php echo get_tax_select($item['item_taxrate_id']); ?></select>
						</td>
						<td style="width:10%"><input class="form-control" onchange="javascript: calculateInvoiceAmounts();"  name="item_quantity" value="<?php echo $item['item_quantity']; ?>"/></td>
						<td class="text-right" style="width:10%"><input class="form-control text-right" onchange="javascript: calculateInvoiceAmounts();"  name="item_price" value="<?php echo $item['item_price']; ?>"/></td>
						
						<td class="text-right" style="width:8%"><input class="form-control text-right" onchange="javascript: calculateInvoiceAmounts();"  name="item_discount" value="<?php echo $item['item_discount']; ?>"/></td>
						<td class="text-right" style="width:10%"><input class="form-control text-right" onchange="javascript: calculateInvoiceAmounts();"  name="item_sub_total" readonly value="<?php echo $item['item_total']; ?>"/></td>
						
						<td style="width:2%">
						<a class="" href="<?php echo site_url('invoices/delete_item/'.$item['invoice_id'].'/'.$item['item_id']);?>" title="delete"><i class="fa fa-times"></i></a>
						</td>
						</tr>
					<?php
						}
					}
				  ?>

				  </tbody>
				  </table>
			
				<table class="table table-bordered">
					<tr class="text-right" id="invoice_total_row">
                    <td colspan="6" class="no-border">Sub Total:</td>
                    <td style="width:12%;" ><label><span id="items_total_cost"><?php echo format_amount($invoice_details->invoice_totals['item_total']); ?></span></label></td>
					<td style="width:2%"></td>
				 </tr>

				  <tr class="text-right">
                    <td colspan="6" class="no-border">Total Tax :</td>
                    <td ><label><span id="invoice_total_tax"><?php echo format_amount($invoice_details->invoice_totals['tax_total']); ?></span></label></td>
					<td style="width:2%"></td>
                  </tr>
				 
				   <tr class="text-right">
                    <td colspan="6" class="no-border"> New Sub-Total : </td>
                    <td class="invoice_amount_due"><label><span id="invoice_sub_total1"><?php echo format_amount($invoice_details->invoice_totals['sub_total']); ?></span></label></td>
					<td style="width:2%"></td>
                  </tr>


					<tr class="text-right">
                    <td colspan="6" class="no-border" style="vertical-align: middle">Invoice Discount :</td>
                    <td  style="width:12%;" >
					<div class="form-group input-group invoice_grand_total" style="margin-bottom: 0px">
						<span class="input-group-addon"><?php echo get_siteconfig('currency'); ?></span>
						<input type="text" class="form-control text-right invoice_grand_total" name="invoice_discount_amount" onchange="javascript: calculateInvoiceAmounts();"  id="invoice_discount_amount" value="<?php echo number_format($invoice_details->invoice_discount, 2); ?>"/>
					 </div>
					</td>
					<td style="width:2%"></td>
                  </tr>

				  <tr class="text-right">
                    <td colspan="6" class="no-border"> New Sub Total : </td>
                    <td class="invoice_amount_due"><label><span id="invoice_sub_total2"><?php echo format_amount($invoice_details->invoice_totals['sub_total'] - $invoice_details->invoice_discount); ?></span></label></td>
					<td style="width:2%"></td>
                  </tr>
				  
				  <tr class="text-right">
                    <td colspan="6" class="no-border">Amount Paid : </td>
                    <td class="invoice_grand_total"><label><span id="items_total_discount"><?php echo format_amount($invoice_details->invoice_totals['amount_paid']); ?></span></label></td>
					<td style="width:2%"></td>
                  </tr>
				  <tr class="text-right">
                    <td colspan="6" class="no-border"> Amount Due : </td>
					<?php
					$class = ($invoice_details->invoice_balance > 0) ? 'invoice_amount_due' : 'invoice_grand_total';
					?>
                    <td class="<?php echo $class; ?>"><label><span id="invoice_amount_due"><?php echo format_amount($invoice_details->invoice_totals['amount_due']); ?></span></label></td>
					<td style="width:2%"></td>
                  </tr>
			
			</table>
			  
			<h4> Payment History </h4> <hr/>
			  <table class="table table-striped table-bordered">
				<thead>
					<tr class="table_header">
						<th>Date</th>
						<th>Payment Method</th>
						<th>Amount Paid</th>
						<th>Payment Remarks</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if(isset($invoice_payments) && $invoice_payments->num_rows() > 0)
					{
						foreach($invoice_payments->result_array() as $count=>$payment){
					?>
					<tr>
					<td><?php echo format_date($payment['payment_date']); ?> </td>
					<td><?php echo $payment['payment_method_name']; ?></td>
					<td><?php echo format_amount($payment['payment_amount']); ?></td>
					<td><?php echo $payment['payment_note']; ?></td>
					</tr>
					<?php
					}
					} else {
					?>
					<tr>
					<td colspan="4">No payment has been made for this invoice.</td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
				<hr/>		  
			  <div class="form-group">
			  <h4> Invoice Terms </h4> 
				<textarea name="invoice_terms" class="form-control" id="invoice_terms"><?php echo $invoice_details->invoice_terms; ?></textarea>
			  </div>
            </div>
						</div>
					</div>
					
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->
</div><!-- /#page-wrapper -->