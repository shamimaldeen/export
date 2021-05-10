 <?php
	if( isset($invoices) && !empty($invoices))
	{
		foreach ($invoices as $count => $invoice)
		{
		
		?>
		<tr>
		<td>
		<?php echo status_label($invoice['invoice_status']);?>
		</td>
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
	<td colspan="7"> There are no <?php echo $status; ?> invoices at the moment.</td>
	</tr>
	<?php
	}
	?>