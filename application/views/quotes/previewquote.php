<?php $countries = config_item('country_list'); ?>
<script type="text/javascript">
$(function()
{
$('#modal-view-quote').modal('show');
$('html').click(function() {
    $('#modal-view-quote').modal('hide');
});
});
</script>
<div class="modal" id="modal-view-quote" style="width:1000px;left:40%;font-size:11px">
<div class="modal-header">
	<a data-dismiss="modal" class="close">&times;</a>
	<label class="control-ccclabel">Quote Preview : #<?php echo $quote_details['quote_details']->quote_id; ?> </label>
</div>
<div class="modal-body">
<div class="row">
<div class="col-lg-12">
	<div class="col-lg-6">
		<?php $logo = get_siteconfig('logo');
		if($logo != ''){
		?>
		<img src="<?php echo base_url().UPLOADSDIR.$logo;?>" width="50%"/>
		<?php
		}
		?>
	</div>
	<div class="col-lg-6">
		<h2> Quote # <?php echo $quote_details['quote_details']->quote_id; ?></h2><hr/>
		<p><?php echo get_siteconfig('name'); ?></p>
		<p><?php echo get_siteconfig('address'); ?></p>
		<p><?php echo get_siteconfig('postal_code'); ?></p>
		<p><?php echo get_siteconfig('phone'); ?></p>
		<p><?php echo get_siteconfig('email'); ?></p>
		<p><?php echo get_siteconfig('website'); ?></p>
	</div>
</div>
</div>
<hr/>
<div class="row">
	<div class="col-lg-12">
	<div class="client-details">
		<div class="row">
			<div class="col-lg-12">
			<h4>Client : <?php echo $quote_details['quote_details']->client_name; ?></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">	
				<h5>Address&nbsp;&nbsp; : <?php echo $quote_details['quote_details']->client_address; ?></h5>
				<h5>Postal Code&nbsp;&nbsp; : <?php echo $quote_details['quote_details']->postal_code; ?></h5>
				<h5>Phone &nbsp;&nbsp;&nbsp;&nbsp; : <?php echo $quote_details['quote_details']->client_phone; ?></h5>					
				<h5>Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <?php echo $quote_details['quote_details']->client_email; ?></h5>	
				<h5>Country &nbsp;&nbsp; : <?php echo $countries [$quote_details['quote_details']->client_country]; ?></h5>	
			</div>
			<div class="col-lg-6 text-right">
			<h4><label> Total Amount Due </label></h4>
			<h4 class="invoice_amount_due"><label>
			<?php 
			
			echo format_amount($quote_details['quote_totals']['amount_due']);
			
			?>
			</label></h4>
			</div>
		</div>
		</div>
	</div>
</div>
<hr/>
<div class="row">
<div class="col-lg-12">
<table class="table">
	<thead>
	  <tr class="table_header">
		<th>ITEM</th>
		<th>DESCRIPTION</th>
		<th>TAX </th>
		<th>QUANTITY</th>
		<th class="text-right">UNIT PRICE</th>
		<th class="text-right">DISCOUNT</th>
		<th class="text-right">SUB TOTAL</th>
	  </tr>
	</thead>
	<tbody>
	<?php
	foreach ($quote_details['quote_items'] as $count=>$item)
	{?>
	<tr class="transaction-row">
	<td><?php echo $item['item_name'];?></td>
	<td style="width: 30%"><?php echo $item['item_description'];?></td>
	<td><?php echo ($item['Item_tax_rate_id'] !=0 ) ? $item['tax_rate_name'].' - '.$item['tax_rate_percent'].'%' : '0.00%';?></td>
	<td><?php echo $item['item_quantity'];?></td>
	<td class="text-right" style="width: 10%"><?php echo format_amount($item['item_price']) ; ?></td>
	<td class="text-right" style="width: 10%"><?php echo format_amount($item['item_discount']); ?></td>
	<td class="text-right" style="width: 10%"><?php echo format_amount($item['item_price']*$item['item_quantity']-$item['item_discount']); ?></td>
	</tr>
	<?php
	}
	?>
	<tr><td colspan="6" class="text-right">ITEMS SUB TOTAL : </td><td class="text-right"><label><?php echo format_amount($quote_details['quote_totals']['item_total']);?></label></td></tr>
	<tr><td colspan="6" class="text-right no-border">QUOTE DISCOUNT : </td><td class="text-right no-border"><label><?php echo format_amount($quote_details['quote_details']->quote_discount);?></label></td></tr>
	<tr><td colspan="6" class="text-right no-border">NEW SUB TOTAL : </td><td class="text-right invoice_amount_due"><label><?php echo format_amount($quote_details['quote_totals']['sub_total']);?></label></td></tr>
	<tr><td colspan="6" class="text-right no-border">TOTAL TAX : </td><td class="text-right no-border"><label><?php echo format_amount($quote_details['quote_totals']['tax_total']);?></label></td></tr>
		

	<tr><td colspan="6" class="text-right no-border">AMOUNT DUE : </td><td class="text-right invoice_amount_due"><label><?php echo format_amount($quote_details['quote_totals']['amount_due']);?></label></td>
	</tr>
<tr class="table_header"><td colspan="7"></td></tr>
<tr><td colspan="5">
<h4>Quote Terms </h4>
<?php echo $quote_details['quote_details']->customer_notes; ?>
<hr/>
</td></tr>
</div>
</div>
</div>
</div>

<style>
.client-details {
border: 1px dotted #CCC;
font-size: 12px;
background-color: #d9edf7;
padding: 10px 15px;
}
</style>
