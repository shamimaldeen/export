<script type="text/javascript">
    $(function()
    {
        // Display the create invoice modal
        $('#modal-enter-payment').modal('show');
		$('.date').datepicker( {autoclose: true, format: 'dd-mm-yyyy'} );
		$(".date").datepicker("setDate", new Date());
		
		$('#btn_add_payment').click(function()
        {
            $.post("<?php echo site_url('invoices/addpayment'); ?>", {
                invoice_id: $('#invoice_id').val(),
                payment_amount: $('#payment_amount').val(),
                payment_method_id: $('#payment_method_id').val(),
                payment_date: $('#payment_date').val(),
                payment_note: $('#payment_note').val()
            },
            function(data) {
                var response = JSON.parse(data);
                if (response.success == '1')
                {
                    // The validation was successful and payment was added
                    window.location = "<?php echo $_SERVER['HTTP_REFERER']; ?>";
                }
                else
                {
                    // The validation was not successful
                    $('.control-group').removeClass('has-error');
                    for (var key in response.validation_errors) {
                        $('#' + key).parent().parent().addClass('has-error');

                    }
                }
            });
        });
	});
</script>
<div id="modal-enter-payment" class="modal" style="width:400px">
	<div class="modal-header">
		<a data-dismiss="modal" class="close">&times;</a>
		<label class="control-label">Invoice Number : <?php echo $invoice->invoice_number; ?> </label>
	</div>
	<div class="modal-body">
	
	<div class="col-lg-12">
		<form class="form-horizontal" method="POST" action="<?php echo site_url('invoices/addpayment');?>">
			<input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $invoice->invoice_id; ?>">
			<div class="control-group error">
				<label class="control-label">Amount: </label>
				<div class="controls">
					<input type="text" name="payment_amount" class="form-control" id="payment_amount" value="">
				</div>
			</div>
			<label class="control-label">Payment Date: </label>
			<div class="form-group input-group date" style="margin-left:0;">
               <input size="16" type="text" name="payment_date" class="form-control" id="payment_date" readonly />
                <span class="input-group-addon add-on"><i class="fa fa-calendar" style="display: inline"></i></span>
            </div>

			<div class="control-group">
				<label class="control-label">Payment Method: </label>
				<div class="controls">
					<select name="payment_method_id" class="form-control" id="payment_method_id">
						<?php echo $payment_methods;?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Note: </label>
				<div class="controls">
					<textarea name="payment_note" class="form-control" id="payment_note"></textarea>
				</div>

			</div>
		</form>
	
	<div style="clear:both"></div>
	<div class="modal-footer">
		<button class="btn btn-primary" id="btn_add_payment" type="button"><i class="fa fa-check"></i> Save Payment</button>
        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
	</div>
	</div>
	</div>
</div>