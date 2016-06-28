<?php $this->load->view('reporter/header'); ?>

	
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
				<?php foreach($charts as $chart){ ?>
					<br/>
					<div id="<?php ?>" ><?php print_r($chart);//echo $chart['peak']; ?></div>
					<div id="<?php ?>" ><?php print_r($chart);//echo $chart['average']; ?></div>
					<br/>
				<?php } ?>
			</section><!-- /.Left col -->
		</div><!-- /.row (main row) -->
	</section><!-- /.content -->
</aside><!-- /.right-side -->

<?php $this->load->view('reporter/footer'); ?>