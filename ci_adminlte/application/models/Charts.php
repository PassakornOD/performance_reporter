<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Charts extends CI_Model{
	
	public function __construct(){
		
		parent::__construct();
		
	}
	
	public function daily_charts($dataatti, $flag){
		
		$graph_data=$this->_cdaily_data($dataatti, $flag);
		$this->load->library('highcharts');
		$this->highcharts
			->initialize('cpu_template') // load template
			->set_dimensions(900, 435)	// dimension: width, height
			->set_title('Sar dd-mm-yyyy to dd-mm-yyyy', 'hostgroup gggg hostname nnnn')
			->push_xAxis($graph_data['axis']) // we use push to not override template config
			->set_serie($graph_data['usr'])
			->set_serie($graph_data['sys'], 'sys')
			->set_serie($graph_data['wio'], 'wio')
			->set_serie($graph_data['idle'], 'idle'); // ovverride serie name 
		
		// we want to display the second serie as sline. First parameter is the serie name
		$this->highcharts->set_serie_options(array('type' => 'area','stacking' => null ,'lineColor' => '#000000', 'lineWidth' => '0.1',
                'shadow' => false, 'marker' => array('enabled' => false)), 'sys');
		$this->highcharts->set_serie_options(array('type' => 'area','stacking' => null ,'lineColor' => '#000000', 'lineWidth' => '0.1',
                'shadow' => false, 'marker' => array('enabled' => false)), 'wio');
		$this->highcharts->set_serie_options(array('type' => 'area','stacking' => null ,'lineColor' => '#000000', 'lineWidth' => '0.1',
                'shadow' => false, 'marker' => array('enabled' => false)), 'idle');
		//$this->highcharts->render_to('charts_display');
		$data['charts'] = $this->highcharts->render();
		$this->load->view('auth/charts', $data);
		//return $data;
	}
	
	function _cdaily_data($dataatts, $flag)
	{	
		//print_r($dataatts['usrdata']);
		$data['usr']['data'] = array($dataatts['usrdata']);
		$data['usr']['name'] = 'Users by Language';
		$data['sys']['data'] = array($dataatts['sysdata']);
		$data['sys']['name'] = 'World Population';
		$data['wio']['data'] = array($dataatts['wiodata']);
		$data['wio']['name'] = 'World Population';
		$data['idle']['data'] = array($dataatts['idledata']);
		$data['idle']['name'] = 'World Population';
		$data['axis']['datatime'] = array($dataatts['datedata']);

		return $data;
	}
}
?>