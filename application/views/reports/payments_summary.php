<script type="text/javascript">
    $(function()
    {
		$('.date').datepicker( {autoclose: true, format: 'dd-mm-yyyy'} );
		$(".date").datepicker("setDate", new Date());
	});
</script>
<div class="row">
<div class="col-lg-3">
	<div class="form-group">
		<label>Client : </label>
		<select name="client_id" id="client_id" class="form-control">
		<?php echo $clients; ?>
		</select>
	</div>
</div>

<div class="col-lg-3">
	<label>From : </label>
	<div class="form-group input-group date" style="margin-left:0;">
	   <input class="form-control" size="16" type="text" name="from_date" readonly id="from_date"/>
		<span class="input-group-addon add-on"><i class="fa fa-calendar" style="display: inline"></i></span>
	</div>
</div>

<div class="col-lg-3">
	<label>To : </label>
	<div class="form-group input-group date" style="margin-left:0;">
	   <input class="form-control" size="16" type="text" name="to_date" readonly id="to_date"/>
		<span class="input-group-addon add-on"><i class="fa fa-calendar" style="display: inline"></i></span>
	</div>
</div>
<div class="col-lg-3">
	<label> </label>
	<div class="form-group input-group" style="margin-left:0;">
	<a href="javascript: void(0);" onclick="javascript: payments_summary();" class="btn btn-large btn-success pull-right"  style="margin-right:10px" id="bttn_save_invoice"><i class="fa fa-check"></i> Generate Report </a>
	</div>
</div>
</div>

<div class="row">
	<div class="col-lg-12">
	<p><span class="bold-text" >Payments Summary</span></p>
	</div>
</div>
	<table class="table table-bordered">
	<thead>
	  <tr class="table_header">
		<th>DATE </th>
		<th>PAYMENT METHOD</th>
		<th>CLIENT</th>
		<th class="text-right">AMOUNT</th>
	  </tr>
	</thead>
	<tbody>
<?php
if( isset($payments) && $payments->num_rows()>0)
{
?>
	<?php
	$total = 0;
	foreach ($payments->result_array() as $count => $payment)
	{
	?>
	  <tr class="transaction-row">
		<td><?php echo format_date($payment['payment_date']);?></td>
		<td><?php echo $payment['payment_method_name'];?></td>
		<td><?php echo ucwords($payment['client_name']);?></td>
		<td class="text-right"><?php echo format_amount($payment['payment_amount']); ?></td>
	  </tr>
	<?php
		$total = $total + $payment['payment_amount'];
	}
	?>
	<tr class="table_header">
	<td>TOTAL </td>
	<td></td>
	<td></td>
	<td class="text-right"><?php echo format_amount($total); ?></td>
	</tr>
<?php
}
else
{
?>
<tr class="no-cell-border transaction-row">
<td colspan="7"> There are no records to display at the moment.</td>
</tr>
<?php
}
?>
</tbody>
</table>