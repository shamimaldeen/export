  <script type="text/javascript">
	    $(function() {
			$('select[name="quote_status"]').change(function(){
			$('.loading').fadeIn('slow');
			var status = $(this).val();
			$.post("<?php echo site_url('quotes/ajax_filter_quotes'); ?>", {
                status: status,
            },
            function(data) {
               $('#invoice_table_body').html(data);
			   $('.loading').fadeOut('slow');
            });
				
			});
			
		});
</script>
<div class="loading"></div>
<div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">Quotes</h3>
			<a href="<?php echo site_url('quotes/newquote'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-plus"> New Quote </i></a>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> List of Quotes</h3>
              </div>
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

				<div class="alert alert-info alert-dismissable">
                <strong>Filter by Status :</strong>
                   <select name="quote_status" id="quote_status" class="form-control" style="width:20%">
						<option value=''>Select Option </option>
						<?php
						foreach($statuses as $key=>$status){
						?>
						<option value="<?=$key;?>" <?=($key == $selected_status) ? 'selected' : '' ;?>> <?=ucfirst($status['label']);?></option>
						<?php
						}
						?>
					</select>
                 </div>
                  <table class="table table-bordered table-striped tablesorter">
                    <thead>
                      <tr class="table_header">
						<th>Status</th>
                        <th>Quote No.</i></th>
                        <th>Date Issued</th>
						<th>Valid Until</th>
						<th>Client Name</th>
                        <th class="text-right">Amount </th>
						<th>Actions</th>
                      </tr>
                    </thead>
                    <tbody id="invoice_table_body">
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
                        <td><?php echo format_date($quote['date_created']); ?></td>
						<td><?php echo format_date($quote['valid_until']); ?></td>
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
					<td> There are no quotes available at the moment.</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					</tr>
					<?php
					}
					?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->
</div><!-- /#page-wrapper -->