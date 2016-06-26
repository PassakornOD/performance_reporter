<?php //$this->load->view('reporter/header'); ?>

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
			width: 20%;
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
<body>
	<?php foreach($charts as $chart){ ?>
		<div id="<?php ?>" ><?php print_r($chart);//echo $chart['charts']; ?></div>
	<?php } ?>
</body>
<?php //$this->load->view('reporter/footer'); ?>