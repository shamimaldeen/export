<script type="text/javascript">
$(function()
{
$('#modal-email-client').modal('show');
});
</script>
<div class="modal" id="modal-email-client" style="width:1000px;left:40%;font-size:11px">
<div class="modal-header">
	<a data-dismiss="modal" class="close">&times;</a>
	<label class="control-label">Email Client : #<?php echo $quote_details->quote_id; ?> </label>
</div>
<div class="modal-body">
<div class="row">
<div class="col-lg-12">
	<form class="form-horizontal">
	<div class="col-lg-6">
		<input type="hidden" id="quote_id" name="quote_id" value="<?php echo $quote_details->quote_id; ?>"/>
		<div class="control-group">
				<label class="control-label">Client / Email  </label>
				<div class="controls">
					<input type="text" name="client_name" value="<?php echo ucwords($quote_details->client_name).' - '.$quote_details->client_email; ?>" readonly class="form-control" id="client_name" />
				</div>
		</div>
		<br/>
		<div class="control-group">
			<label class="control-label">Quote Number </label>
			<div class="controls">
				<input type="text" name="quote_number" id="quote_number" value="<?php echo $quote_details->quote_id; ?>" readonly class="form-control" />
			</div>
		</div>
		<br/>
		<div class="control-group">
			<label class="control-label">Email Subject</label>
			<div class="controls">
				<input type="text" name="email_subject" id="email_subject" value="<?php echo $quote_details->quote_subject; ?>" class="form-control" />
			</div>
		</div>
		<br/>
		<div class="control-group">
		<label class="control-label">Email Template</label>
		<div class="controls">
		<select name="email_template" class="form-control" id="email_template" onchange="javascript: get_template(this.value)">
		<?php echo $email_templates; ?>
		</select>
		</div>
		</div>
		<br/>
		<p>Pdf quote will be attached to the email. <a href="<?php echo site_url('quotes/viewpdf/'.$quote_details->quote_id);?>">View Pdf quote</a> </p>
	</div>
	<div class="col-lg-6">
		<div class="control-group">
		<label class="control-label">Email Body</label>
		<div class="controls">
		<textarea name="email_body" id="email_body" class="form-control" rows="12"></textarea>
		</select>
		</div>
		</div>
		<br/>
		<a href="javascript: void(0);" onclick="javascript: ajax_email_quote();" class="btn btn-large btn-success pull-right"  style="margin-right:10px" id="bttn_send_email"><i class="fa fa-envelope"></i> Send Email </a>
	</div>
	</form>
</div>
</div>
<hr/>
</div>
<div class="loading"></div>
</div>

