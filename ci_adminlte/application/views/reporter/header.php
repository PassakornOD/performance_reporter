<?php ?>
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
        <!-- Theme style -->
        

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
					    <li class="dropdown user user-menu">
							<a href="logout" class="dropdown-toggle">
                                <i class="glyphicon glyphicon-user"></i>
                                <span>Log out</span>
                            </a>
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
						
							<H1> MFEC </H1>
                            <!-- Display User profile -->
							
                        </div>
                    </div>
                    <!-- search form -->
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
						<li class="treeview">
                            <a href="#">
                                <i class="fa fa-user"></i> <span>User</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu" style="display: none;">
                                <li><a href="index"><i class="fa fa-angle-double-right"></i>User Information</a></li>
                                <li><a href="checkdt"><i class="fa fa-angle-double-right"></i>Check Status</a></li>    
                            </ul>
                        </li>
						<li class="treeview">
                            <a href="#">
                                <i class="fa fa-table"></i> <span>Database</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu" style="display: none;">
                                <li><a href="condb"><i class="fa fa-angle-double-right"></i>Update User</a></li>  
                            </ul>
                        </li>
						<li class="treeview">
                            <a href="#">
                                <i class="fa fa-cogs"></i> <span>Management</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu" style="display: none;">
                                <li><a href="limitfn"><i class="fa fa-angle-double-right"></i>User Limit</a></li>
                                <li><a href="chconline"><i class="fa fa-angle-double-right"></i>Check User Online</a></li>    
								<li><a href="lastlg"><i class="fa fa-angle-double-right"></i>User Last Login</a></li> 

                            </ul>
                        </li>
						<li class="treeview">
                            <a href="#">
                                <i class="fa fa-bar-chart"></i> <span>Statistic</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu" style="display: none;">
								<li><a href="usstat3"><i class="fa fa-angle-double-right"></i>Usage Statistic</a></li>
								<li><a href="usstat2"><i class="fa fa-angle-double-right"></i>Usage Statistic(Date)</a></li>
                                <li><a href="usstat"><i class="fa fa-angle-double-right"></i>Usage Statistic(Time)</a></li>
								<li><a href="logpdf"><i class="fa fa-angle-double-right"></i>Usage Log</a></li>
                            </ul>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
		