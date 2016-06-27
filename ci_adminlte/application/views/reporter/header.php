<?php 
	if($this->session->userdata("user")== null){
		redirect('/','refresh');
	}
	$user_s=$this->session->userdata("user");
	$perm_s=$this->session->userdata("perm");
?>
<!DOCTYPE html>
<html len="en">
<head>
		<meta charset="UTF-8">
		<title>MFEC REPORTER</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		
		<link href="/ci_adminlte/bootstrap-3.3.2-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="/ci_adminlte/AdminLTE/css/AdminLTE.css" rel="stylesheet" type="text/css" />
		<link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		
		<script src="/ci_adminlte/AdminLTE/js/highcharts.js" type="text/javascript"></script>
		<script src="/ci_adminlte/AdminLTE/js/modules/exporting.js"></script>
		
		<!--Custom Script-->
        <script type="text/javascript" src="/ci_adminlte/AdminLTE/js/custom/cs_script.js"></script>
		
		 <!--date time picker Script-->		
        <!--<script type="text/javascript" src="jqueryui/js/jquery-1.5.1.min.js"></script>-->
    	<link type="text/css" href="/ci_adminlte/AdminLTE/css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="Stylesheet" />	
    	<script type="text/javascript" src="/ci_adminlte/AdminLTE/js/jquery-ui-1.8.13.custom.min.js"></script>
		<style type="text/css">
            div.ui-datepicker{
                 font-size:10px;
                }
        </style>

        <!-- Theme style -->
        	<style type="text/css">
		a, a:link, a:visited {
			color: #444;
			text-decoration: none;
		}
		a:hover {
			color: #000;
		}
		.left {
			float: left;
		}
		#menu {
			width: 50%; 
		}
		#g_render {
			width: 80%;
		}
		li {
			margin-bottom: 1em;
		}
	</style>
	<script type="text/javascript" src="http://www.google.com/jsapi"></script>
	<script type="text/javascript">
		google.load("jquery", "1.4.4");
	</script>
	<script type="text/javascript" src="http://www.highcharts.com/js/highcharts.js"></script>
	<script src="/ci_adminlte/AdminLTE/js/highcharts.js" type="text/javascript"></script>
	<script src="/ci_adminlte/AdminLTE/js/modules/exporting.js"></script>

</head>
<body class="skin-blue">
	<header class="header">
            <a href="index" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                MFEC REPORTER
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
				<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                 <div class="navbar-right">
                    <ul class="nav navbar-nav">
					    <li class="dropdown user user-menu" name"logout">
							<?php echo anchor('login/del_session', '<i class="glyphicon glyphicon-user"></i><span>Log out</span>'); ?>
						</li>
                    </ul>
                </div>
            </nav>
        </header>
					<aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left info">
						
							<H3><i class="fa fa-user" aria-hidden="true"></i> <?php echo $user_s; ?> </H3>
                            <!-- Display User profile -->
							
                        </div>
                    </div>
                    <!-- search form -->
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
						<li>
                            <?php echo anchor('reporter','<i class="fa fa-tachometer"></i> <span> Dashborad </span>'); ?>                            
                        </li>
						<li class="treeview">
                            <a href="#">
                                <i class="fa fa-bar-chart"></i> <span> Performance </span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu" style="display: none;">
                                <li><?php echo anchor('reporter/cpudaily', '<i class="fa fa-angle-double-right"></i> CPU Usage Daily'); ?></li>  
                                <li><?php echo anchor('reporter/cpumonthly', '<i class="fa fa-angle-double-right"></i> CPU Usage Monthly'); ?></li>  
                                <li><?php echo anchor('reporter/memdaily', '<i class="fa fa-angle-double-right"></i> Memory Usage Daily'); ?></li>  
                                <li><?php echo anchor('reporter/memmonthly', '<i class="fa fa-angle-double-right"></i> Memory Usage Monthly'); ?></li>  
                            </ul>							
                        </li>
						<li class="treeview">
                            <a href="#">
                                <i class="fa fa-cogs"></i> <span> Utilazation Statistic </span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu" style="display: none;">
                                <li><?php echo anchor('utilities', '<i class="fa fa-angle-double-right"></i> CPU Utilazation'); ?></li>
                                <li><?php echo anchor('utilities/memory', '<i class="fa fa-angle-double-right"></i> Memory Utilazation'); ?></li>    
                            </ul>
                        </li>
						<li class="treeview">
                            <a href="#">
                                <i class="fa fa-wrench"></i> <span> Manage Resource </span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu" style="display: none;">
                                <li><?php echo anchor('utilities', '<i class="fa fa-angle-double-right"></i> Add Resource'); ?></li>
                                <li><?php echo anchor('genpdf', '<i class="fa fa-angle-double-right"></i> Modifiy Resource'); ?></li>    
                            </ul>
                        </li>
						<li>
                            <?php echo anchor('genpdf', '<i class="fa fa-file-pdf-o"></i> <span> Report </span>'); ?>
                        </li>
						<li>
                            <?php echo anchor('reporter/faq', '<i class="fa fa-support"></i> <span> Faq </span>'); ?>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
		