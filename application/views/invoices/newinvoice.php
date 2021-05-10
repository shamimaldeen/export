 <script type="text/javascript">
	    $(function() {
        <?php if (!isset($items)) { ?>
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
			<a href="javascript: void(0);" onclick="javascript: ajax_save_invoice();" class="btn btn-large btn-success pull-right" id="bttn_save_invoice"><i class="fa fa-check"></i> Save Invoice</a>
		</div>
	</div>
</div>

 <div id="page-wrapper">
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
          <div class="col-lg-12">
            <div class="panel panel-primary" style="margin-top:70px">
              <div class="panel-body">
                <div class="table-responsive">
					<div class="row">
						<div class="col-lg-6">
							<div class="panel panel-default col-lg-10">
							  <div class="panel-body">
							  <input type="hidden" id="invoice_status" name="invoice_status" value="unpaid"/>
							  <input type="hidden" name="save_type" value="new" id="save_type" />

							  <div class="form-group">
								<label>Invoice Number </label>
								 <input type="text" id="invoice_number" class="form-control" name="invoice_number" value="<?php echo $invoice_number; ?>"/>
							  </div>

								<div class="form-group">
								<label>Client </label>
								<select name="client_to_invoice" id="client_to_invoice" class="form-control"><?php echo $clients; ?></select>
								</div>
								
								<label>Invoice Date </label>
								<div class="form-group input-group date" style="margin-left:0;">
								   <input class="date form-control" size="16" type="text" name="invoice_date" readonly id="invoice_date"/>
									<span class="input-group-addon add-on"><i class="fa fa-calendar" style="display: inline"></i></span>
								</div>
								
								
								<label>Due Date </label>
								<div class="form-group input-group date" style="margin-left:0;">
								   <input class="date form-control" size="16" type="text" name="invoice_due_date" readonly id="invoice_due_date" />
									<span class="input-group-addon add-on"><i class="fa fa-calendar" style="display: inline"></i></span>
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
                  </tr>
                </thead>
                <tbody>
                  <tr id="new_item" style="display: none;">
					<input type="hidden" name="invoice_id" value="" id="invoice_id">
					<input type="hidden" name="item_id" value="">
                    <td style="width:20%"><input name="item_name" value="" class="form-control"/></td>
                    <td><textarea name="item_description" class="form-control"></textarea></td>
                    <td style="width:10%">
					<select name="tax_rate_id" id="tax_rate_id" onchange="javascript: calculateInvoiceAmounts();" class="form-control" ><?php echo $taxrates; ?></select>
					</td>
                    <td style="width:5%"><input class="form-control" onchange="javascript: calculateInvoiceAmounts();"  name="item_quantity" value=""/></td>
					<td class="text-right" style="width:10%"><input class="form-control text-right" onchange="javascript: calculateInvoiceAmounts();"  name="item_price" value=""/></td>
					<td class="text-right" style="width:10%"><input class="form-control text-right" onchange="javascript: calculateInvoiceAmounts();"  name="item_discount" value=""/></td>
					<td class="text-right" style="width:10%"><input class="form-control text-right" readonly name="item_sub_total" value=""/></td>
                  </tr>
				</table>
				
				  <table class="table table-bordered">
				 				  <tr class="text-right" id="invoice_total_row">
                    <td colspan="6" class="no-border">Sub Total:</td>
                    <td style="width:12%;" ><label><span id="items_total_cost"><?php echo format_amount(0); ?></span></label></td>
				 </tr>

				 <tr class="text-right">
                    <td colspan="6" class="no-border">Total Tax :</td>
                    <td ><label><span id="invoice_total_tax"><?php echo format_amount(0); ?></span></label></td>
                  </tr>

                  <tr class="text-right">
                    <td colspan="6" class="no-border"> New Sub-Total : </td>
                    <td class="invoice_amount_due"><label><span id="invoice_sub_total1"><?php echo format_amount(0); ?> </span></label></td>
                  </tr>
				 
					<tr class="text-right">
                    <td colspan="6" class="no-border" style="vertical-align: middle">Invoice Discount :</td>
                    <td  style="width:12%;" >
					<div class="form-group input-group invoice_grand_total" style="margin-bottom: 0px">
						<span class="input-group-addon"><?php echo get_siteconfig('currency'); ?></span>
						<input type="text" class="form-control text-right invoice_grand_total" name="invoice_discount_amount" onchange="javascript: calculateInvoiceAmounts();"  id="invoice_discount_amount" value="0.00"/>
					 </div>
					</td>
                  </tr>

				  <tr class="text-right">
                    <td colspan="6" class="no-border"> New Sub Total : </td>
                    <td class="invoice_amount_due"><label><span id="invoice_sub_total2"> <?php echo format_amount(0); ?> </span></label></td>
                  </tr>
				  
				  <tr class="text-right">
                    <td colspan="6" class="no-border">Amount Paid : </td>
                    <td class="invoice_grand_total"><label><span id="items_total_discount"><?php echo format_amount(0); ?></span></label></td>
                  </tr>
				  <tr class="text-right">
                    <td colspan="6" class="no-border "> Total Amount Due : </td>
                    <td class="invoice_amount_due"><label><span id="invoice_amount_due"><?php echo format_amount(0); ?></span></label></td>
                  </tr>
                </tbody>
              </table>
			  
			  <div class="form-group">
				<label> Invoice Terms </label>
				<textarea name="invoice_terms" class="form-control" id="invoice_terms"></textarea>
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