<div class="row">
<div class="col-lg-6">
<h4 style="margin-left:20px">Clients Contact Report</h4>
</div>
</div>
<?php 
if(isset($clients))
{
	$countries = config_item('country_list');
	foreach($clients->result_array() as $count=>$client)
	{?>
		<div class="contact-record">
		<div class="row">
			<div class="col-lg-12">
			<h3 style="color:#31708f"><?php echo $client['client_name']; ?></h3>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<div class="contact-details">	
				<p><span>Address : </span><?php echo $client['client_address']; ?></p>
				<p><span>Phone : </span><?php echo $client['client_phone']; ?></p>
				<p><span>Email : </span><?php echo ($client['client_email'] !='') ? $client['client_email'] : 'N/A' ; ?></p>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="contact-details">
				<p><span>City : </span><?php echo ($client['client_city'] !='') ? $client['client_city'] : 'N/A' ; ?></p>
				<p><span>Country : </span><?php echo ($client['client_country'] !='') ? $countries[$client['client_country']] : 'N/A' ; ?></p>
				<p><span>Fax : </span><?php echo ($client['client_fax'] !='') ? $client['client_fax'] : 'N/A' ; ?></p>
				</div>
			</div>
		</div>
		</div>
	<?php
	}
}
?>