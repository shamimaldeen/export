<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?php echo site_url('dashboard'); ?>"> <img src="<?php echo base_url().IMAGESFOLDER.'logo.png'; ?>"></a>
  </div>
  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
      <li <?=(isset($activemenu) && $activemenu == 'dashboard') ? 'class="active"' : ''?>><a href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard </a></li>
      <li <?=(isset($activemenu) && $activemenu == 'invoices') ? 'class="active"' : ''?>><a href="<?php echo site_url('invoices'); ?>"><i class="fa fa-usd"></i> Invoices </a></li>
      <li <?=(isset($activemenu) && $activemenu == 'overdue') ? 'class="active"' : ''?>><a href="<?php echo site_url('invoices/overdue'); ?>"><i class="fa fa-gbp"></i> Overdue Invoices </a></li>
      <li <?=(isset($activemenu) && $activemenu == 'clients') ? 'class="active"' : ''?>><a href="<?php echo site_url('clients'); ?>"><i class="fa fa-user"></i> Clients </a></li>
      <li <?=(isset($activemenu) && $activemenu == 'quotes') ? 'class="active"' : ''?>><a href="<?php echo site_url('quotes');?>"><i class="fa fa-dashboard"></i> Quotes </a></li>
      <li <?=(isset($activemenu) && $activemenu == 'products') ? 'class="active"' : ''?>><a href="<?php echo site_url('products'); ?>"><i class="fa fa-money"></i> Products </a></li>
      <li <?=(isset($activemenu) && $activemenu == 'reports') ? 'class="active"' : ''?>><a href="<?php echo site_url('reports'); ?>"><i class="fa fa-signal"></i> Reports </a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right navbar-user">
    <li class="dropdown user-dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i> Settings <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo site_url('tax'); ?>"><i class="fa fa-euro"></i> Tax Rates </a></li>
          <li><a href="<?php echo site_url('users'); ?>"><i class="fa fa-user"></i> User Accounts </a></li>
  <li><a href="<?php echo site_url('payment_methods'); ?>"><i class="fa fa-usd"></i> Payment Methods </a></li>
          <li class="divider"></li>
  <li><a href="<?php echo site_url('email_templates'); ?>"><i class="fa fa-envelope"></i> Email Templates </a></li>
          <li class="divider"></li>
          <li><a href="<?php echo site_url('settings'); ?>"><i class="fa fa-cog"></i> System Config </a></li>
        </ul>
      </li>
      <li class="dropdown user-dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
  <i class="fa fa-user"></i> <?php echo ucfirst($this->session->userdata('firstname')).' '.ucfirst($this->session->userdata('lastname')); ?> <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo site_url('account/myprofile'); ?>"><i class="fa fa-user"></i> Profile </a></li>
          <li class="divider"></li>
          <li><a href="<?php echo site_url('account/logout'); ?>"><i class="fa fa-power-off"></i> Log Out </a></li>
        </ul>
      </li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>
