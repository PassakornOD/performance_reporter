<?php $this->load->view('reporter/header'); ?>

<aside class="right-side">
<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Export Report
			<!--<small>Control panel</small>-->
		</h1>
	</section>

	<!-- Main content -->
	<div class="wrapper">
		<div class="row" style="margin:20px auto; width=50%;">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-bar-chart-o fa-fw"></i><span> Area Chart Example </span>
					</div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                    <div id="morris-area-chart"></div>
						<form method="post" action="">
							<fieldset>
							<div style="display:inline-table">
							<?php foreach($hg_q as $hgq){ ?>
								<div class="col-lg-3">
									<div class="checkbox">
									  <label>
										<input type="checkbox" value="<?php echo $hgq['hgroup']; ?>" name="hostgroupchk[]">
										<span> <?php echo $hgq['hgroup']; ?></span>
									  </label>
									</div>
								</div>
							<?php } ?>
							</div>
								<div style="margin:30px auto; width:50%"> 
									<label for="period"></label>
										Start Date 
									<input type="date" name="startdate" id="datepicker" value="" />
										Stop Date 
									<input type="date" name="stopdate" id="datepicker2" value="" />
								<div>
								<div style="margin:20px;">
									<input type="submit" class="btn btn-lg btn-success btn-block" name="btchk" value="submit" />
								</div>
								<?php //echo anchor('reporter', 'Login' , array('class' => 'btn btn-lg btn-success btn-block', 'name' => 'btn')); ?>
							</fieldset>
						</form>
				
                    </div>
                        <!-- /.panel-body -->
                </div>
                    <!-- /.panel -->
			</div>
		</div>
	</div>
</aside><!-- /.right-side -->

<?php $this->load->view('reporter/footer'); ?>