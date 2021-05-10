<?php $countries = config_item('country_list');  ?>
<link href="<?php echo base_url().CSSFOLDER; ?>style.css" rel="stylesheet"/>
<style>
table {
	border-collapse: collapse;
	border-spacing: 0;
	width:100%;
}
.table-bordered td, .table-bordered th{
	border: 1px solid #ddd;
	padding: 8px;
	border-collapse: collapse;
	
}
.table-bordered th{
	color: #bce8f1;
}
body {
	font-size: 75%;
}
</style>
<div class="row">
	<div class="col-lg-12">
	<table width="100%">
	<tr><td>
			<?php $logo = get_siteconfig('logo');
			if($logo != ''){
			?>
			<img src="<?php echo base_url().UPLOADSDIR.$logo;?>" width="30%"/>
			<?php
			}
			?>
			</td>
			<td>
			<?php
			 $class = ($invoice_details['invoice_details']->invoice_status == 'UNPAID') ? 'invoice_status_cancelled' : 'invoice_status_paid';
			  ?>
			<div class="<?php echo $class; ?>"> <?php echo $invoice_details['invoice_details']->invoice_status; ?></div>
			</td>
			</tr>
	</table>
	</div>
	
</div>
<hr/>
<div class="row">
	<div class="col-lg-12">
	<table width="100%">
	<tr><td>From : </td><td><p>Billed To : </p></td></tr>
	<tr><td>
		<h4><?php echo get_siteconfig('name'); ?></h4>
		<p><?php echo get_siteconfig('address'); ?></p>
		<p><?php echo get_siteconfig('postal_code'); ?></p>
		<p><?php echo get_siteconfig('phone'); ?></p>
		<p><?php echo get_siteconfig('email'); ?></p>
		<p><?php echo get_siteconfig('website'); ?></p>
	</td><td>
		<h4><?php echo $invoice_details['invoice_details']->client_name; ?></h4>
		<p><?php echo $invoice_details['invoice_details']->client_address; ?></p>
		<p><?php echo $invoice_details['invoice_details']->postal_code; ?></p>
		<p><?php echo $invoice_details['invoice_details']->client_phone; ?></p>					
		<p><?php echo $invoice_details['invoice_details']->client_email; ?></p>	
		<p><?php echo $countries [$invoice_details['invoice_details']->client_country]; ?>.</p>	
	</td></tr><tr>
	<td><h4> Invoice No. <?php echo $invoice_details['invoice_details']->invoice_number; ?></h4></td>
	<td><h4> Invoice Date : <?php echo format_date($invoice_details['invoice_details']->invoice_date_created); ?></h4></td>
	</tr>
	</table>
	</div>
</div>
<div class="row">
<div class="col-lg-12">
<table class="table table-bordered">
	<thead>
	  <tr class="table_header">
		<th style="color: #bce8f1">ITEM</th>
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
	foreach ($invoice_details['invoice_items'] as $count=>$item)
	{?>
	<tr class="transaction-row">
	<td><?php echo $item['item_name'];?></td>
	<td><?php echo $item['item_description'];?></td>
	<td><?php echo ($item['item_taxrate_id'] !=0 ) ? $item['tax_rate_name'].' - '.$item['tax_rate_percent'].'%' : '0.00%';?></td>
	<td style="text-align:center"><?php echo $item['item_quantity'];?></td>
	<td class="text-right" style="width: 13%"><?php echo number_format($item['item_price'], 2); ?></td>
	<td class="text-right" style="width: 10%"><?php echo number_format($item['item_discount'], 2); ?></td>
	<td class="text-right" style="width: 14%"><?php echo number_format($item['item_price']*$item['item_quantity']-$item['item_discount'], 2); ?></td>
	</tr>
	<?php
	}
	?>
	
	<tr><td colspan="6" class="text-right">ITEMS TOTAL COST : </td><td class="text-right"><label><?php echo format_amount($invoice_details['invoice_totals']['item_total']);?></label></td></tr>
	<tr><td colspan="6" class="text-right no-border">TOTAL TAX : </td><td class="text-right no-border"><label><?php echo format_amount($invoice_details['invoice_totals']['tax_total']);?></label></td></tr>
	<tr><td colspan="6" class="text-right no-border">SUB TOTAL : </td><td class="text-right invoice_amount_due"><label><?php echo format_amount($invoice_details['invoice_totals']['sub_total']);?></label></td></tr>
	<tr><td colspan="6" class="text-right no-border">INVOICE DISCOUNT : </td><td class="text-right no-border"><label><?php echo format_amount($invoice_details['invoice_details']->invoice_discount);?></label></td></tr>

	<tr><td colspan="6" class="text-right no-border">AMOUNT PAID : </td><td class="text-right no-border invoice_amount_paid"><label><?php echo format_amount($invoice_details['invoice_totals']['amount_paid']);?></label></td></tr>
	<tr><td colspan="6" class="text-right no-border">AMOUNT DUE : </td><td class="text-right invoice_amount_due"><label><?php echo format_amount($invoice_details['invoice_totals']['amount_due']);?></label></td>
	</tr>
	
	
	<tr class="table_header"><td colspan="7"></td></tr>
	</table>
	<h4>Invoice Terms </h4>
	<i><?php echo $invoice_details['invoice_details']->invoice_terms; ?></i>
	<br/><br/>
	<label class="control-label">Client : <?php echo $invoice_details['invoice_details']->client_name; ?></label>
	<br/><br/><br/>
	................................................<br/>
	<i>Signature &amp; Stamp</i>
</div>
</div>

