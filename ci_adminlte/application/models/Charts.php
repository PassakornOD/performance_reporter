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
			->set_title('INTERNET WORLD USERS BY LANGUAGE', 'Top 5 Languages in 2010')
			->push_xAxis($graph_data['axis']) // we use push to not override template config
			->set_serie($graph_data['popul'])
			->set_serie($graph_data['tiew'], 'hi')
			->set_serie($graph_data['users'], 'Another description'); // ovverride serie name 
		
		// we want to display the second serie as sline. First parameter is the serie name
		$this->highcharts->set_serie_options(array('type' => 'area','stacking' => null ,'lineColor' => '#000000', 'lineWidth' => '0.1',
                'shadow' => false, 'marker' => array('enabled' => false)), 'Another description');
		$this->highcharts->set_serie_options(array('type' => 'area','stacking' => null ,'lineColor' => '#000000', 'lineWidth' => '0.1',
                'shadow' => false, 'marker' => array('enabled' => false)), 'hi');
		
		$data['charts'] = $this->highcharts->render();
		$this->load->view('auth/charts', $data);
		
	}
	
	function _cdaily_data($dataatts, $flag)
	{	
		
		$data['users']['data'] = array(3.6564837, 4.4948013, 5.3309074, 9.143700, 8.548200);
		$data['users']['name'] = 'Users by Language';
		$data['popul']['data'] = array(12.77528133, 13.65524982, 42.0469703, 12.6804433, 25.0372925);
		$data['popul']['name'] = 'World Population';
		$data['axis']['categories'] = array('English', 'Chinese', 'Spanish', 'Japanese', 'Portuguese');

		return $data;
	}
}
?>