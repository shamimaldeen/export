      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h3 class="pull-left">System Users</h3>
			<a href="<?php echo site_url('users/createuser'); ?>" class="btn btn-large btn-success pull-right"><i class="fa fa-plus"> Create User </i></a>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user"></i> List of users</h3>
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
                        <th>First Name <i class="fa fa-sort"></i></th>
                        <th>Last Name <i class="fa fa-sort"></i></th>
                        <th>Username <i class="fa fa-sort"></i></th>
                        <th>Email <i class="fa fa-sort"></i></th>
						<th>Created on <i class="fa fa-sort"></i></th>
						<th>Actions</th>
                      </tr>
                    </thead>
                    <tbody id="invoice_table_body">
					<?php
					if( isset($users) && $users->num_rows() > 0 )
					{
						foreach ($users->result_array() as $count => $user)
						{
						?>
						<tr>
                        <td><?php echo ucfirst($user['first_name']); ?></td>
                        <td><?php echo ucfirst($user['last_name']); ?></td>
                        <td><?php echo $user['username']; ?></td>
						<td><?php echo $user['user_email']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($user['user_date_created'])); ?></td>
						<td>
						<a href="<?php echo site_url('users/edituser/'.$user['user_id']); ?>" class="btn btn-xs btn-success"><i class="fa fa-check"> Edit </i></a>
						<a href="<?php echo site_url('users/delete/'.$user['user_id']);?>" onclick="return confirm('Are you sure you want to permanently delete this user?');" class="btn btn-danger btn-xs"><i class="fa fa-times"> Delete </i></a>
						</td>
						</tr>
						<?php
						}
					}
					else
					{
					?>
					<tr class="no-cell-border"><td> There are no users available at the moment.</td>
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