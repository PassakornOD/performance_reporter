<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Charts extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$data['home'] = strtolower(__CLASS__).'/';
		$this->load->vars($data);
	}
	
	public function get_data(){
		$n=0;
		$datachart=$this->session->userdata('datacharts');
		foreach($datachart['list_group'] as $group){
			//print_r($group);
			foreach($datachart['list_name'] as $namehost){
				print_r($namehost->hostname);
				$data[$n]=$this->daily_charts($datachart[$namehost->hostname_id], $namehost);
				//print_r($setdata);
				//print_r($namehost->hostname);
				print_r($data[$n]);
				$data['charts']=$data[$n];
				$n++;
				//$data['charts']=$this->daily_charts($setdata, $namehost);
				//$data['genchart']=array('hostname' => $namehost->hostname, 'mychart' => $data[$namehost->hostname]);
			}
		}
		$this->load->view('auth/charts', $data);
		
	}
	
	public function daily_charts($dataatti, $host, $flag =""){
		
		$graph_data=$this->_cdaily_data($dataatti);
		//print_r($graph_data['usr']['data'][0]);
		$this->load->library('highcharts');
		$this->highcharts
			->initialize('cpu_template') // load template
			->set_dimensions(900, 435)	// dimension: width, height
			->set_title('Sar dd-mm-yyyy to dd-mm-yyyy', 'hostgroup gggg hostname '. $host->hostname)
			->push_xAxis($graph_data['axis']) // we use push to not override template config
			->set_serie($graph_data['usr'])
			->set_serie($graph_data['sys'], 'sys')
			->set_serie($graph_data['wio'], 'wio')
			->set_serie($graph_data['idle'], 'idle'); // ovverride serie name 
		//print_r($host->hostname);
		// we want to display the second serie as sline. First parameter is the serie name
		$this->highcharts->set_serie_options(array('type' => 'area','stacking' => null ,'lineColor' => '#000000', 'lineWidth' => '0.1',
                'shadow' => false, 'marker' => array('enabled' => false)), 'sys');
		$this->highcharts->set_serie_options(array('type' => 'area','stacking' => null ,'lineColor' => '#000000', 'lineWidth' => '0.1',
                'shadow' => false, 'marker' => array('enabled' => false)), 'wio');
		$this->highcharts->set_serie_options(array('type' => 'area','stacking' => null ,'lineColor' => '#40ff00', 'lineWidth' => '0.1',
                'shadow' => false, 'marker' => array('enabled' => false)), 'idle');
		//$this->highcharts->render_to('charts_display');
		//print_r($host);
		$data['chart'][$host->hostname] = $this->highcharts->render();
		//print_r($data['chart']);
		//$this->load->view('auth/charts', $data);
		return $data;
	}
	
	function _cdaily_data($dataatts, $flag="")
	{	$datedata="";
		settype($usrdata , "float");
		
		$usrdata=0;
		$sysdata=0;
		$wiodata=0;
		$idledata=0;
		foreach($dataatts as $q){
			//print_r($q);
			
			$datedata = $q->datetime.", ";
			//$data['timedata'] .= "";
			$usrdata .= (float)($q->usr).", ";
			$sysdata .= (float)$q->sys.", ";
			$wiodata .= (float)$q->wio.", ";
			$idledata .= (float)$q->idle.", ";
		}
		//print_r($usrdata);
		//echo "<br/>";
		//echo "<br/>";
		$data['usr']['data'] = array($usrdata);
		$data['usr']['name'] = 'Usr';
		$data['sys']['data'] = array($sysdata);
		$data['sys']['name'] = 'sys';
		$data['wio']['data'] = array(20.77528133, 30.65524982, 4.0469703, 2.6804433, 50.0372925,);
		$data['wio']['name'] = 'wio';
		$data['idle']['data'] = array(3.6564837, 4.4948013, 5.3309074, 9.143700, 8.548200);
		$data['idle']['name'] = 'idle';
		$data['axis']['datatime'] = array('English', 'Chinese', 'Spanish', 'Japanese', 'Portuguese');
	
		return $data;
	}
	
	public function set_format($data_q){
	//print_r($data_q['hostname']);
		foreach($data_q as $q){
			//print_r($q);
			$datedata = $q->datetime.", ";
			//$data['timedata'] .= "";
			$usrdata = $q->usr.", ";
			$sysdata = $q->sys.", ";
			$wiodata = $q->wio.", ";
			$idledata = $q->idle.", ";
		}
		$data['datedata'] = $datedata;
		$data['usrdata'] = $usrdata;
		$data['sysdata'] = $sysdata;
		$data['wiodata'] = $wiodata;
		$data['idledata'] = $idledata;
		//print_r($data['usrdata']);
		return $data;
		
	}
	
	
	
	
	
	
	/**
	 * index function.
	 * Very basic example: juste draw some data
	 */
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
	 */
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
	 */
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
	 */
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
	 */
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
	 */
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
	 */
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
	 */
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
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */