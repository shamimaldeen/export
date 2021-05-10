<div id="page-wrapper">

<div class="row">
  <div class="col-lg-12">
	<h3 class="pull-left">Email Templates </h3>
	<a href="<?php echo site_url('email_templates/create'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-plus"> Create Template </i></a>
  </div>
</div><!-- /.row -->

<div class="row">
  <div class="col-lg-12">
	<div class="panel panel-primary">
	  <div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-user"></i> List of email templates</h3>
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
		  <table class="table table-bordered table-hover table-striped tablesorter">
			<thead>
			  <tr class="table_header">
				<th>Template Title <i class="fa fa-sort"></i></th>
				<th>Actions</th>
			  </tr>
			</thead>
			<tbody>
			<?php
			if( isset($email_templates) && $email_templates->num_rows() > 0 )
			{
				foreach ($email_templates->result_array() as $count => $email_template)
				{
				?>
				<tr>
				<td><?php echo $email_template['template_title']; ?></td>
				<td>
				<a href="<?php echo site_url('email_templates/edit/'.$email_template['template_id']); ?>" class="btn btn-xs btn-success"><i class="fa fa-check"> Edit </i></a>
				<a href="<?php echo site_url('email_templates/delete/'.$email_template['template_id']);?>" onclick="return confirm('Are you sure you want to permanently delete this email template?');" class="btn btn-danger btn-xs"><i class="fa fa-times"> Delete </i></a>
				</td>
				</tr>
				<?php
				}
			}
			else
			{
			?>
			<tr class="no-cell-border">
			<td> There are no templates available at the moment.</td>
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