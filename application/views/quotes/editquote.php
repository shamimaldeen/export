  <script type="text/javascript">
	    $(function() {
        <?php if (!isset($quote_items)) { ?>
            $('#new_item').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
        <?php } ?>
		});
 </script>
 <div class="loading"></div>
<div class="row">
	<div class="col-lg-12">
		<div class="well invoice_menu navbar navbar-fixed-top">
			<a href="javascript: void(0);" class="btn btn-large btn-primary" id="bttn_add_item"><i class="fa fa-plus"></i> Add Item</a>
			<a href="javascript: void(0);" class="btn btn-large btn-info" id="bttn_quote_add_product"><i class="fa fa-plus"></i> Add Item From Products</a>
			<a href="javascript: void(0);" onclick="delete_quote('<?php echo $quote_details->quote_id; ?>');" class="btn btn-large btn-danger pull-right" id="bttn_delete_invoice" ><i class="fa fa-times"></i> Delete Quote</a>
			<a href="javascript: void(0);" onclick="javascript: ajax_save_quote();" class="btn btn-large btn-success pull-right"   style="margin-right:10px"  id="bttn_save_quote"><i class="fa fa-check"></i> Save Quote</a>
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
		if($this->session->flashdata('success'))
		{
		?>
		<div class="alert alert-dismissable alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Success ! </strong> <?php echo $this->session->flashdata('success');?>
		</div>
		<?php
		}
		?>
					<div class="row">
						<div class="col-lg-6">
						<h4> Quote Number : # <?php echo $quote_details->quote_id; ?> </h4>
							<div class="panel panel-default col-lg-10">
							  <div class="panel-body">
							  <input type="hidden" id="quote_number" name="quote_number" value="<?php echo $quote_details->quote_id;?>"/>
								<div class="form-group">
								<label>Client </label>
								<select name="quote_client" id="quote_client" class="form-control"><?php echo $clients; ?></select>
								</div>
								
								<label>Quote Date </label>
								<div class="form-group input-group date" style="margin-left:0;">
								   <input class="date form-control" size="16" type="text" name="quote_date" value="<?php echo (isset($quote_details->date_created)) ? date('d-m-Y', strtotime($quote_details->date_created)) : ''; ?>" readonly id="quote_date"/>
									<span class="input-group-addon add-on"><i class="fa fa-calendar" style="display: inline"></i></span>
								</div>
								
								<label>Valid Until </label>
								<div class="form-group input-group date" style="margin-left:0;">
								   <input class="date form-control" size="16" type="text" name="valid_until_date" value="<?php echo (isset($quote_details->valid_until)) ? date('d-m-Y', strtotime($quote_details->valid_until)) : ''; ?>" readonly id="valid_until_date" />
									<span class="input-group-addon add-on"><i class="fa fa-calendar" style="display: inline"></i></span>
								</div>
								
								<div class="form-group">
								<a href="javascript: void(0);" onclick="emailclientquote('<?php echo $quote_details->quote_id; ?>')" class="btn btn-large btn-success pull-right"  style="margin-right:10px"><i class="fa fa-envelope"></i> Email Quote to Client </a>
								</div>
								
							  </div>
							</div>
						</div>
						
						<div class="col-lg-6">
							<label>Quote Subject </label>
							<div class="form-group input-group" style="margin-left:0;">
							<textarea name="quote_subject" id="quote_subject" class="form-control" cols="80" rows="4"><?php echo $quote_details->quote_subject; ?></textarea>
							</div>
							<label>Status </label>
							<div class="form-group input-group" style="margin-left:0;">
							<select name="quote_status" id="quote_status" class="form-control" >
							<?php
							foreach($statuses as $key=>$status){
							?>
							<option value="<?=$key;?>" <?=($key == $quote_details->quote_status) ? 'selected' : '' ;?>> <?=$status['label'];?></option>
							<?php
							}
							
							?>
							</select>
							</div>
						  <div class="invoice_actions ">
						  <div class="form-group">
						  <a href="<?php echo site_url('quotes/viewpdf');?>/<?php echo $quote_details->quote_id; ?>" class="btn btn-large btn-primary" ><i class="fa fa-file"></i> Download PDF</a>
						  <a href="javascript: void(0);" class="btn btn-large btn-info" onclick="viewQuote('<?php echo $quote_details->quote_id; ?>')"><i class="fa fa-search"></i> Preview Quote </a>
						  <a href="javascript: void(0);" class="btn btn-large btn-warning" onclick="convertQuote('<?php echo $quote_details->quote_id; ?>')"><i class="fa fa-usd"></i> Convert to an invoice </a>
						  </div>
						  </div>
						</div>
						
					</div>
		<div class="row">
			<div class="col-lg-12">
			<h4>Quote Items</h4>
						
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
					<input type="hidden" name="quote_id" value="">
					<input type="hidden" name="item_id" value="">
                    <td style="width:20%"><input name="item_name" value="" class="form-control"/></td>
                    <td><textarea name="item_description" class="form-control"></textarea></td>
                    <td style="width:10%">
					<select name="tax_rate_id" id="tax_rate_id" onchange="javascript: calculatequoteAmounts();" class="form-control" ><?php echo $taxrates; ?></select>
					</td>
                    <td style="width:5%"><input class="form-control" onchange="javascript: calculatequoteAmounts();"  name="item_quantity" value=""/></td>
					<td class="text-right" style="width:10%"><input class="form-control text-right" onchange="javascript: calculatequoteAmounts();"  name="item_price" value=""/></td>
					<td class="text-right" style="width:10%"><input class="form-control text-right" onchange="javascript: calculatequoteAmounts();"  name="item_discount" value=""/></td>
					<td class="text-right" style="width:10%"><input class="form-control text-right" readonly name="item_sub_total" value=""/></td>
					<td style="width:2%"></td>
                  </tr>
				  <?php 
					if(isset($quote_items))
					{
						foreach($quote_items as $item)
						{
					?>
						<tr id="item" class="item">
						<td style="width:20%">
						<input type="hidden" name="quote_id" value="<?php echo $quote_details->quote_id; ?>">
						<input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
						<input name="item_name" value="<?php echo $item['item_name']; ?>" class="form-control"/>
						</td>
						<td style="width:25%"><textarea name="item_description" class="form-control"><?php echo $item['item_description']; ?></textarea></td>
						<td style="width:12%">
						<select name="tax_rate_id" id="tax_rate_id" onchange="javascript: calculatequoteAmounts();" class="form-control" ><?php echo get_tax_select($item['Item_tax_rate_id']); ?></select>
						</td>
						<td style="width:10%"><input class="form-control" onchange="javascript: calculatequoteAmounts();"  name="item_quantity" value="<?php echo $item['item_quantity']; ?>"/></td>
						<td class="text-right" style="width:10%"><input class="form-control text-right" onchange="javascript: calculatequoteAmounts();"  name="item_price" value="<?php echo $item['item_price']; ?>"/></td>
						
						<td class="text-right" style="width:8%"><input class="form-control text-right" onchange="javascript: calculatequoteAmounts();"  name="item_discount" value="<?php echo $item['item_discount']; ?>"/></td>
						<td class="text-right" style="width:10%"><input class="form-control text-right" onchange="javascript: calculatequoteAmounts();"  name="item_sub_total" readonly value="<?php echo $item['item_price'] * $item['item_quantity'] - $item['item_discount']; ?>"/></td>
						
						<td style="width:2%">
						<a class="" href="<?php echo site_url('quotes/delete_item/'.$item['quote_id'].'/'.$item['item_id']);?>" title="delete"><i class="fa fa-times"></i></a>
						</td>
						</tr>
					<?php
						
						}
					}
				  ?>
				  </table>
				  <table class="table table-bordered">
				  <tr class="text-right" id="quote_total_row">
                    <td colspan="4" class="no-border">Items Sub-Total :</td>
                    <td style="width:12%;"><label><span id="items_total_cost"><?php echo format_amount($quote_details->totals['item_total']); ?></span></label></td>
					<td style="width:2%;"></td>
                  </tr>
				  <tr class="text-right">
                    <td colspan="4" class="no-border" style="vertical-align: middle">Quote Discount :</td>
                    <td>
					<div class="form-group input-group" style="margin-bottom: 0px">
						<span class="input-group-addon"><?php echo get_siteconfig('currency'); ?></span>
						<input type="text" class="form-control text-right" name="quote_discount_amount" onchange="javascript: calculatequoteAmounts();"  id="quote_discount_amount" value="<?php echo $quote_details->quote_discount; ?>"/>
					 </div>
					</td>
					<td style="width:2%;"></td>
                  </tr>
				   <tr class="text-right">
                    <td colspan="4" class="no-border"> New Sub-Total : </td>
                    <td class="invoice_grand_total"><label><span id="quote_sub_total"><?php echo format_amount($quote_details->totals['sub_total']); ?></span></label></td>
					<td style="width:2%;"></td>
                  </tr>
				  <tr class="text-right">
                    <td colspan="4" class="no-border">Total Tax :</td>
                    <td><label><span id="quote_total_tax"><?php echo format_amount($quote_details->totals['tax_total']); ?></span></label></td>
					<td style="width:2%;"></td>
                  </tr>
				  
				  <tr class="text-right">
                    <td colspan="4" class="no-border"> Total Amount Due : </td>
                    <td class="invoice_amount_due">
                    	<label><span id="quote_amount_due"><?php echo format_amount($quote_details->totals['amount_due']); ?></span></label>
                    </td>
					<td style="width:2%;"></td>
                  </tr>
                </tbody>
              </table>
			  
			  <div class="form-group">
				<label> Quote Terms </label>
				<textarea name="quote_terms" class="form-control" id="quote_terms"><?php echo $quote_details->customer_notes;?></textarea>
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