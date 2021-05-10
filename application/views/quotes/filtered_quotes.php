<?php
if( isset($quotes) && count($quotes) > 0)
{
	foreach ($quotes as $count => $quote)
	{
	?>
	<tr>
	<td>
	<span class="label <?php echo $statuses[$quote['quote_status']]['class'];?>"><?php echo $statuses[$quote['quote_status']]['label'];?></span>
	</td>
	<td><a href="<?php echo site_url('quotes/edit/'.$quote['quote_id']);?>"><?php echo $quote['quote_id']; ?></a></td>
	<td><?php echo date('d/m/Y', strtotime($quote['date_created'])); ?></td>
	<td><?php echo date('d/m/Y', strtotime($quote['valid_until'])); ?></td>
	<td><a href="<?php echo site_url('clients/editclient/'.$quote['client_id']); ?>"><?php echo ucwords($quote['client_name']); ?></a></td>
	<td class="text-right"><?php echo format_amount($quote['quote_amount']); ?></td>
	<td style="width:25%">
	<a href="<?php echo site_url('quotes/edit/'.$quote['quote_id']);?>" class="btn btn-xs btn-primary"><i class="fa fa-check"> Edit </i></a>
	<a href="javascript:;" class="btn btn-info btn-xs" onclick="viewQuote('<?php echo $quote['quote_id']; ?>')"><i class="fa fa-search"> Preview </i></a>
	<a href="<?php echo site_url('quotes/viewpdf/'.$quote['quote_id']);?>" class="btn btn-warning btn-xs">Download pdf </a>
	</td>
	</tr>
	<?php
	}
}
else
{
?>
<tr class="no-cell-border">
<td colspan="7"> There are no quotes available at the moment.</td>
</tr>
<?php
}
?>
                  