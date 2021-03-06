<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// shared_options : highcharts global settings, like interface or language
$config['shared_options'] = array(
	'chart' => array(
		'backgroundColor' => array(
			'linearGradient' => array(0, 0, 500, 500),
			'stops' => array(
				//array(0, 'rgb(255, 255, 255)'),
				//array(1, 'rgb(240, 240, 255)')
			)
		),
		'shadow' =>  false
	)
);

// Template Example
$config['chart_template'] = array(
	'chart' => array(
		'renderTo' => '',
		'defaultSeriesType' => 'column',
		'backgroundColor' => array(
			'linearGradient' => array(0, 500, 0, 0),
			'stops' => array(
				//array(0, 'rgb(255, 255, 255)'),
				//array(1, 'rgb(190, 200, 255)')
			)
		),
     ),
     'colors' => array(
     	 '#ED561B', '#50B432','#ED561B', '#50B432'
     ),
     'credits' => array(
     	'enabled'=> true,
     	'text'	=> 'highcharts library on GitHub',
		'href' => 'https://github.com/ronan-gloo/codeigniter-highcharts-library'
     ),
     'title' => array(
		'text' => 'Template from config file'
     ),
     'legend' => array(
     	'enabled' => false
     ),
    'yAxis' => array(
		'title' => array(
			'text' => 'population'
		)
	),
	'xAxis' => array(
		'title' => array(
			'text' => 'Countries'
		)
	),
	'tooltip' => array(
		'shared' => true
	)
);
	
	$config['cpu_template'] = array(
	'chart' => array(
		'renderTo' => '',
		'defaultSeriesType' => 'spline',
		'backgroundColor' => array(
			'linearGradient' => array(0, 0, 0, 0),
			'stops' => array(
				//array(0, 'rgb(255, 255, 255)')
				//array(1, 'rgb(190, 200, 255)')
			)
		),
		'spacingBottom' => 30,
        'spacingTop' => 30,
        'spacingLeft' => 10,
        'spacingRight' => 10
     ),
     'colors' => array(
		'#ED561B', '#50B432','#ED561B', '#50B432'
     ),
     'credits' => array(
     	'enabled'=> true,
     	'text'	=> 'highcharts library on GitHub',
		'href' => 'https://github.com/ronan-gloo/codeigniter-highcharts-library'
     ),
     'title' => array(
		'text' => 'Template from config file'
     ),
     'legend' => array(
     	'enabled' => true,
        'borderColor' => '#000000',
        'borderWidth' => 1
     ),
    'yAxis' => array(
		'title' => array(
			'text' => 'Percent'
		),
		'min' => 0, 
			'max' => 100
	),
	'xAxis' => array(
		'title' => array(
			'text' => ''
		),
		'labels' => array('rotation'=> -45, 'align' => 'right', 'style' => array('font' => 'normal 10px Verdana, sans-serif' )) 
	),
	'exporting' => array(
		'enabled' => true
	),
	'tooltip' => array(
		'shared' => true
	)
);