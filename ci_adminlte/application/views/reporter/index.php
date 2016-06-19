<?php $this->load->view('reporter/header'); ?>

<aside class="right-side">
<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Dashboard
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
				<?php foreach($hgs as $hg){ ?>
				<div class="nav-tabs-custom" id="User Information">
					<!-- Tabs within a box -->
					<ul class="nav nav-tabs pull-right">
						<li class="pull-left header"><i class="fa fa-inbox"></i><?php echo $hg['hgroup']; ?></li>
					</ul>
					<div class="tab-content no-padding">
						<!-- Morris chart - Sales -->
						<div style="position: relative;">
							<table class="table table-condensed">
								<!-- On rows -->
								<thead>
									<tr>
										<th>hostname</th>
										<th>Model</th>
										<th>CPU</th>
										<th>OS</th>
										<th>Serial</th>
										<th>Location</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach($hns as $hn){ ?>
									<tr>
										<td><?php echo $hn->hostname; ?></td>
										<td><?php echo $hn->Model; ?></td>
										<td><?php echo $hn->CPU; ?></td>
										<td><?php echo $hn->OS; ?></td>
										<td><?php echo $hn->Serial; ?></td>
										<td><?php echo $hn->Location; ?></td>
									</tr>
								<?php } ?>
								</tbody>	
							</table>
						</div>
					</div>
				</div><!-- /.nav-tabs-custom -->
			<?php } ?>
			</section><!-- /.Left col -->
		</div><!-- /.row (main row) -->
	</section><!-- /.content -->
</aside><!-- /.right-side -->

<?php $this->load->view('reporter/footer'); ?>
