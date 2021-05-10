<?php $this->load->view('common/header'); ?>
<div id="wrapper">
<!-- Sidebar -->
<?php $this->load->view('common/navigation'); ?>      
<div id="page-wrapper" style="min-height: 700px;">
	<div class="container-fluid">
		<?php $this->load->view($pagecontent); ?> 
	</div>
</div>
</div><!-- /#wrapper -->

<?php $this->load->view('common/footer'); ?>
    
