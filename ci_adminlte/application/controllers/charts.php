<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Charts extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('coreperformance','',TRUE);
		$this->load->helper('url');
		$data['home'] = strtolower(__CLASS__).'/';
		$this->load->vars($data);
	}
	
	public function get_data(){
		$n=0;
		$type_flag="Peak";
		$datachart=$this->session->userdata('datacharts');
		//$data['charts']=$this->daily_charts($datachart['508'], $datachart['list_name']);
		//print_r($datachart['startdate']);
		foreach($datachart['list_group'] as $group){
			//print_r($group);
			//print_r($datachart['list_name']);
			foreach($datachart['list_name'][$group] as $namehost){
				//$this->set_format();
				//print_r($namehost);
				$datapeak[$namehost->hostname_id]=$this->coreperformance->cpu_usage_daily($namehost, $datachart['startdate'], $datachart['stopdate'], $type_flag);
				$chart=$this->daily_charts($datapeak[$namehost->hostname_id], $datachart['startdate'], $datachart['stopdate'], $namehost, $type_flag);
				$data['charts']=$chart;
				$dataavg[$namehost->hostname_id]=$this->coreperformance->cpu_usage_daily($namehost, $datachart['startdate'], $datachart['stopdate'], "Average");
				$chart=$this->daily_charts($dataavg[$namehost->hostname_id], $datachart['startdate'], $datachart['stopdate'], $namehost, "Average");
				//print_r($eachchart);
				//print_r($namehost->hostname);
				//print_r($data[$n]);
				$data['charts']=$chart;
				//print_r($data['charts']);
				//$this->load->view('auth/charts', $data);
				//$n++;
				
				//$data['charts']=$this->daily_charts($setdata, $namehost);
				//$data['genchart']=array('hostname' => $namehost->hostname, 'mychart' => $data[$namehost->hostname]);
			}
			$data['groupcharts'][]=$data['charts'];
		}
		//print_r($data);
		$this->load->view('auth/charts', $data);
		
	}
	
	public function daily_charts($dataatti, $start, $stop, $host, $type){
		
		$graph_data=$this->_cdaily_data($dataatti, $host->OS ,$type);
		$this->load->library('highcharts');
		//$chartsObj = new Highcharts();
		if(!empty($graph_data)){
			if($host->OS == "RedHat" || $host->OS == "Red Hat"){
				if($type=="Average"){
					$this->highcharts
						->initialize('cpu_template') // load template
						->set_dimensions(900, 495)	// dimension: width, height
						->set_title('Sar '. $start .  ' to '. $stop , 'Hostname : '. $host->hostname. '   Type : '. $type)
						->push_xAxis($graph_data[$host->hostname_id]['axis']) // we use push to not override template config
						->set_serie($graph_data[$host->hostname_id]['idle'], 'idle')
						->set_serie($graph_data[$host->hostname_id]['wio'], 'wio')
						->set_serie($graph_data[$host->hostname_id]['nice'], 'nice')
						->set_serie($graph_data[$host->hostname_id]['usr'], 'usr')
						->set_serie($graph_data[$host->hostname_id]['steal'], 'steal')
						->set_serie($graph_data[$host->hostname_id]['sys'], 'sys'); // ovverride serie name 
					//print_r($host->hostname);
					// we want to display the second serie as sline. First parameter is the serie name
					$this->highcharts->set_serie_options(array('type' => 'area','stacking' => 'normal' ,'lineColor' => '#000000', 'lineWidth' => '0.1',
							'shadow' => false, 'marker' => array('enabled' => false),'color' => '#92A8CD'), 'idle');
					$this->highcharts->set_serie_options(array('type' => 'area','stacking' => 'normal' ,'lineColor' => '#000000', 'lineWidth' => '0.1',
							'shadow' => false, 'marker' => array('enabled' => false),'color' => '#66ff33'), 'sys');
					$this->highcharts->set_serie_options(array('type' => 'area','stacking' => 'normal' ,'lineColor' => '#000000', 'lineWidth' => '0.1',
							'shadow' => false, 'marker' => array('enabled' => false),'color' => '#ffff00'), 'wio');
					$this->highcharts->set_serie_options(array('type' => 'area','stacking' => 'normal' ,'lineColor' => '#000000', 'lineWidth' => '0.1',
							'shadow' => false, 'marker' => array('enabled' => false),'color' => '#AA4643'), 'steal');
					$this->highcharts->set_serie_options(array('type' => 'area','stacking' => 'normal' ,'lineColor' => '#000000', 'lineWidth' => '0.1',
							'shadow' => false, 'marker' => array('enabled' => false),'color' => '#cc6666'), 'nice');
					$this->highcharts->set_serie_options(array('type' => 'area','stacking' => 'normal' ,'lineColor' => '#000000', 'lineWidth' => '0.1',
							'shadow' => false, 'marker' => array('enabled' => false),'color' => '#FFCC00'), 'usr');
					$this->highcharts->render_to($host->hostname."avg");
					$data['charts']=$this->highcharts->render();
			
				}else{
					$this->highcharts
						->initialize('cpu_template') // load template
						->set_dimensions(900, 495)	// dimension: width, height
						->set_title('Sar '. $start .  ' to '. $stop , 'Hostname : '. $host->hostname. '   Type : '. $type)
						->push_xAxis($graph_data[$host->hostname_id]['axis']) // we use push to not override template config
						->set_serie($graph_data[$host->hostname_id]['peak'], '%peak')
						->set_serie($graph_data[$host->hostname_id]['avg'], '%avg');
					$this->highcharts->set_serie_options(array('type' => 'spline','stacking' => null ,'lineColor' => '#ff0000', 'lineWidth' => '0.8',
							'shadow' => false, 'marker' => array('enabled' => true),'color' => '#AA4643'), '%peak');
					$this->highcharts->set_serie_options(array('type' => 'area','stacking' => null ,'lineColor' => '#000000', 'lineWidth' => '0.1',
							'shadow' => false, 'marker' => array('enabled' => false),'color' => '#92A8CD'), '%avg');
					$this->highcharts->render_to($host->hostname."peak");
					$data['charts']=$this->highcharts->render();
				}	
			}else{
				if($type=="Average"){
					$this->highcharts
						->initialize('cpu_template') // load template
						->set_dimensions(900, 495)	// dimension: width, height
						->set_title('Sar '. $start .  ' to '. $stop , 'Hostname : '. $host->hostname. '   Type : '. $type)
						->push_xAxis($graph_data[$host->hostname_id]['axis']) // we use push to not override template config
						->set_serie($graph_data[$host->hostname_id]['idle'], 'idle')
						->set_serie($graph_data[$host->hostname_id]['wio'], 'wio')
						->set_serie($graph_data[$host->hostname_id]['usr'], 'usr')
						->set_serie($graph_data[$host->hostname_id]['sys'], 'sys'); // ovverride serie name 
					//print_r($host->hostname);
					// we want to display the second serie as sline. First parameter is the serie name
					$this->highcharts->set_serie_options(array('type' => 'area','stacking' => 'normal' ,'lineColor' => '#000000', 'lineWidth' => '0.1',
							'shadow' => false, 'marker' => array('enabled' => false),'color' => '#92A8CD'), 'idle');
					$this->highcharts->set_serie_options(array('type' => 'area','stacking' => 'normal' ,'lineColor' => '#000000', 'lineWidth' => '0.1',
							'shadow' => false, 'marker' => array('enabled' => false),'color' => '#66ff33'), 'sys');
					$this->highcharts->set_serie_options(array('type' => 'area','stacking' => 'normal' ,'lineColor' => '#000000', 'lineWidth' => '0.1',
							'shadow' => false, 'marker' => array('enabled' => false),'color' => '#ffff00'), 'wio');
					$this->highcharts->set_serie_options(array('type' => 'area','stacking' => 'normal' ,'lineColor' => '#000000', 'lineWidth' => '0.1',
							'shadow' => false, 'marker' => array('enabled' => false),'color' => '#FFCC00'), 'usr');
					$this->highcharts->render_to($host->hostname."avg");
					$data['charts']=$this->highcharts->render();
			
				}else{
					$this->highcharts
						->initialize('cpu_template') // load template
						->set_dimensions(900, 495)	// dimension: width, height
						->set_title('Sar '. $start .  ' to '. $stop , 'Hostname : '. $host->hostname. '   Type : '. $type)
						->push_xAxis($graph_data[$host->hostname_id]['axis']) // we use push to not override template config
						->set_serie($graph_data[$host->hostname_id]['peak'], '%peak')
						->set_serie($graph_data[$host->hostname_id]['avg'], '%avg');
					$this->highcharts->set_serie_options(array('type' => 'spline','stacking' => null ,'lineColor' => '#ff0000', 'lineWidth' => '0.8',
							'shadow' => false, 'marker' => array('enabled' => true),'color' => '#AA4643'), '%peak');
					$this->highcharts->set_serie_options(array('type' => 'area','stacking' => null ,'lineColor' => '#000000', 'lineWidth' => '0.1',
							'shadow' => false, 'marker' => array('enabled' => false),'color' => '#92A8CD'), '%avg');
					$this->highcharts->render_to($host->hostname."peak");
					$data['charts']=$this->highcharts->render();
				}	
				
			}		
					
		
			return $data;
		}
	}
	
	function _cdaily_data($dataatts, $os, $flag)
	{
		if(!empty($dataatts)){
			foreach($dataatts as $q){
				//print_r($q);
				if($os == "RedHat" || $os == "Red Hat"){
					if($flag=="Average"){
						$data[$q->hostname_id]['nice']['data'][] = (float)$q->nice;
						$data[$q->hostname_id]['nice']['name'] = 'nice';
						$data[$q->hostname_id]['usr']['data'][] = (float)$q->usr;
						$data[$q->hostname_id]['usr']['name'] = 'Usr';
						$data[$q->hostname_id]['sys']['data'][] = (float)$q->sys;
						$data[$q->hostname_id]['sys']['name'] = 'sys';
						$data[$q->hostname_id]['wio']['data'][] = (float)$q->wio;
						$data[$q->hostname_id]['wio']['name'] = 'wio';
						$data[$q->hostname_id]['idle']['data'][] = (float)$q->idle;
						$data[$q->hostname_id]['idle']['name'] = 'idle';
						$data[$q->hostname_id]['steal']['data'][] = (float)$q->steal;
						$data[$q->hostname_id]['steal']['name'] = 'steal';
					}
					else{				
						$data[$q->hostname_id]['peak']['data'][] = 100-(float)$q->idle;
						$data[$q->hostname_id]['peak']['name'] = '%peak';
						$data[$q->hostname_id]['avg']['data'][] = (float)$q->avgcol;
						$data[$q->hostname_id]['avg']['name'] = '%avg';
					}
					$data[$q->hostname_id]['axis']['categories'][] = (String)$q->datetime;
				}else{
					if($flag=="Average"){
						$data[$q->hostname_id]['usr']['data'][] = (float)$q->usr;
						$data[$q->hostname_id]['usr']['name'] = 'Usr';
						$data[$q->hostname_id]['sys']['data'][] = (float)$q->sys;
						$data[$q->hostname_id]['sys']['name'] = 'sys';
						$data[$q->hostname_id]['wio']['data'][] = (float)$q->wio;
						$data[$q->hostname_id]['wio']['name'] = 'wio';
						$data[$q->hostname_id]['idle']['data'][] = (float)$q->idle;
						$data[$q->hostname_id]['idle']['name'] = 'idle';
					}
					else{				
						$data[$q->hostname_id]['peak']['data'][] = 100-(float)$q->idle;
						$data[$q->hostname_id]['peak']['name'] = '%peak';
						$data[$q->hostname_id]['avg']['data'][] = (float)$q->avgcol;
						$data[$q->hostname_id]['avg']['name'] = '%avg';
					}
					$data[$q->hostname_id]['axis']['categories'][] = (String)$q->datetime;
					
				}
			}
			return $data;
		}else{
			//echo "NO";
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function set_format($data_q){
		$data = array(); 
		$data[] = array( 
		"wio" => "2.52353" 
		); 
		$data[] = array( 
		"wio" => "35.0256" 
		); 
		$data[] = array( 
		"wio" => "892.145" 
		); 
		$data[] = array( 
		"wio" => "789.23" 
		); 
		$data[] = array( 
		"wio" => "4513" 
		); 
		 
		 print_r($data);
		foreach($data as $eachObject) { 
		echo $eachObject["wio"]; 
		echo "<br>"; 
		echo gettype($eachObject["wio"]); 
		echo "<br>"; 
		} 
		 
		 
		$correctData = array(); 
		$correctData["wio"] = []; 
		$correctData["wio"]["data"] = []; 
		 
		foreach($data as $eachObject) { 
		$correctData["wio"]["data"][] = (float)$eachObject["wio"]; 
		} 
		 print_r($correctData);
		foreach($correctData["wio"]["data"] as $eachData) { 
		echo $eachData; 
		echo "<br>"; 
		echo gettype($eachData); 
		echo "<br>"; 
		}
		
	}
	
	
	
	
	
	
	/**
	 * index function.
	 * Very basic example: juste draw some data
	
	function index()
	{
		// simple highcharts example
		$this->load->library('highcharts');
		
		// some data series
		$serie['data'] = array(20, 45, 60, 22, 6, 36);
		//$this->highcharts->set_type('column');
		$data['charts'] = $this->highcharts->set_serie($serie)->render();
		
		$data['charts'] = $this->highcharts->set_serie($serie)->render();
		$this->load->view('auth/charts', $data);
	}
	
	
	/**
	 * categories function.
	 * Lets go for a real world example
	 
	function categories()
	{		
		
		$graph_data = $this->_data();
			
		$this->load->library('highcharts');
	
		$this->highcharts->set_type('column'); // drauwing type
		$this->highcharts->set_title('INTERNET WORLD USERS BY LANGUAGE', 'Top 5 Languages in 2010'); // set chart title: title, subtitle(optional)
		$this->highcharts->set_axis_titles('language', 'population'); // axis titles: x axis,  y axis
		
		$this->highcharts->set_xAxis($graph_data['axis']); // pushing categories for x axis labels
		$this->highcharts->set_serie($graph_data['users']); // the first serie
		$this->highcharts->set_serie($graph_data['popul']); // second serie
		
		// we can user credits option to make a link to the source article. 
		// it's possible to pass an object instead of array (but object will be converted to array by the lib)
		//$credits->href = 'http://www.internetworldstats.com/stats7.htm';
		//$credits->text = "Article on Internet Wold Stats";
		//$this->highcharts->set_credits($credits);
		
		$this->highcharts->render_to('my_div'); // choose a specific div to render to graph
		
		$data['charts'] = $this->highcharts->render(); // we render js and div in same time
		$this->load->view('auth/charts', $data);
	}
	
	/**
	 * template function.
	 * Load basic graph structure form template located in config file
	 
	function template()
	{
		$graph_data = $this->_data();

		$this->load->library('highcharts');
		$this->highcharts
			->initialize('chart_template') // load template	
			->push_xAxis($graph_data['axis']) // we use push to not override template config
			->push_yAxis($graph_data['axis'])
			->set_serie($graph_data['users'])
			->set_serie($graph_data['popul'], 'Another description'); // ovverride serie name 
		
		// we want to display the second serie as sline. First parameter is the serie name
		$this->highcharts->set_serie_options(array('type' => 'spline'), 'Another description');
		
		$data['charts'] = $this->highcharts->render();
		$this->load->view('auth/charts', $data);
	}
	
	/**
	 * active_record function.
	 * Example by passing data from AR result() (not result_array())
	 * 
	 * @access public
	 * @return void
	 
	function active_record()
	{
		$result = $this->_ar_data();
		
		// set data for conversion
		$dat1['x_labels'] 	= 'contries'; // optionnal, set axis categories from result row
		$dat1['series'] 	= array('users', 'population'); // set values to create series, values are result rows
		$dat1['data']		= $result;
		
		// just made some changes to display only one serie with custom name
		$dat2 = $dat1;
		$dat2['series'] = array('custom name' => 'users');
		
		$this->load->library('highcharts');
		
		// displaying muli graphs
		$this->highcharts->from_result($dat1)->add(); // first graph: add() register the graph
		$this->highcharts
			->initialize('chart_template')
			->set_dimensions('', 200) // dimension: width, height
			->from_result($dat2)
			->add(); // second graph
		
		$data['charts'] = $this->highcharts->render();
		$this->load->view('auth/charts', $data);
	}
	


	
	/**
	 * data_get function.
	* Output data as array on json string
	 
	function data_get()
	{
		$this->load->library('highcharts');
		
		// some data series
		$serie['data'] = array(20, 45, 60, 22, 6, 36);
		$this->highcharts->set_serie($serie);
		
		$data['array']  = $this->highcharts->get_array();
		$data['json']   = $this->highcharts->get(); // false to keep data (dont clear current options)
		$this->load->view('charts', $data);

	}
	
	/**
	 * pie function.
	 * Draw a Pie, and run javascript callback functions
	 * 
	 * @access public
	 * @return void
	 
	function pie()
	{
		$this->load->library('highcharts');
		$serie['data']	= array(
			array('value one', 20), 
			array('value two', 45), 
			array('other value', 60)
		);
		$callback = "function() { return '<b>'+ this.point.name +'</b>: '+ this.y +' %'}";
		
		$tool->formatter = $callback;
		$plot->pie->dataLabels->formatter = $callback;
		
		$this->highcharts
			->set_type('pie')
			->set_serie($serie)
			->set_tooltip($tool)
			->set_plotOptions($plot);
		
		$data['charts'] = $this->highcharts->render();
		$this->load->view('auth/charts', $data);
	}
	
	
	// HELPERS FUNCTIONS
	/**
	 * _data function.
	 * data for examples
	 
	function _data()
	{
		$data['users']['data'] = array(3.6564837, 4.4948013, 5.3309074, 9.143700, 8.548200,);
		$data['users']['name'] = 'Users by Language';
		$data['popul']['data'] = array(12.77528133, 13.65524982, 42.0469703, 12.6804433, 25.0372925,);
		$data['popul']['name'] = 'World Population';
		$data['tiew']['data'] = array(20.77528133, 30.65524982, 4.0469703, 2.6804433, 50.0372925,);
		$data['tiew']['name'] = 'customdata';
		$data['axis']['categories'] = array('English', 'Chinese', 'Spanish', 'Japanese', 'Portuguese');

		return $data;
	}
	function _datachart()
	{	
		
		$data['users']['data'] = array(3.6564837, 4.4948013, 5.3309074, 9.143700, 8.548200);
		$data['users']['name'] = 'Users by Language';
		$data['popul']['data'] = array(12.77528133, 13.65524982, 42.0469703, 12.6804433, 25.0372925);
		$data['popul']['name'] = 'World Population';
		$data['axis']['categories'] = array('English', 'Chinese', 'Spanish', 'Japanese', 'Portuguese');

		return $data;
	}
	
	/**
	 * _ar_data function.
	 * simulate Active Record result
	 
	function _ar_data()
	{
		$data = $this->_data();
		foreach ($data['users']['data'] as $key => $val)
		{
			$output[] = (object)array(
				'users' 		=> $val,
				'population'	=> $data['popul']['data'][$key],
				'contries'		=> $data['axis']['categories'][$key]
			);
		}
		return $output;
	}
	*/
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */