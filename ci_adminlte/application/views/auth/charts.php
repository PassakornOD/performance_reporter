<?php $this->load->view('reporter/header'); $i=10; ?>

	
<aside class="right-side">
<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			CPU Usege Daily
			<!--<small>Control panel</small>-->
		</h1>
	</section>

	<!-- Main content -->
	<section class="content">
		<!-- Main row -->
		<div class="row">
			<!-- Left col -->
			<section class="col-lg-10">
				<!-- Custom tabs (Charts with tabs)-->
				
				
				<?php foreach($datachart['list_group'] as $group){ ?>
					<div><h2><?PHP echo $group; ?></h2></div>
					<?php foreach($datachart['list_name'][$group] as $host){ ?>
						<?php $chart=$groupcharts;//foreach($groupcharts as $chart){ ?>
							<br/>
							<div><h3><?PHP echo $host->hostname; ?></h3></div>
							<div id="<?php echo $host->hostname."avg"; ?>"><?php echo $chart[0]['charts']; ?></div>
							<div id="<?php echo $host->hostname."peak"; ?>"><?php echo $chart[0]['charts']; ?></div>
							<div id="<?php echo $host->hostname."monthly"; ?>"><?php echo $chart[0]['charts']; ?></div>
							<br/>
						<?php //} ?>
					<?php } ?>
				<?php } ?>
				<!--<?php //foreach($groupcharts as $chart){ ?>
					<br/>
					<div><?php //print_r($chart['label'][$i++]);//echo $chart['label'][0]; ?></div>
					<div id="oasisavg" ><?php //echo $chart['charts']; ?></div>
					<br/>-->
				<?php //} echo $i;?>
			</section><!-- /.Left col -->
		</div><!-- /.row (main row) -->
	</section><!-- /.content -->
</aside><!-- /.right-side -->

<?php $this->load->view('reporter/footer'); ?>