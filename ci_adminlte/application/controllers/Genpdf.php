<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GenPdf extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user','',TRUE);
		$this->load->library('Pdf');
	}
	function LoadData($file)
	{
		//Read file lines
		$lines=file($file);
		$data=array();
		foreach($lines as $line)
			$data[]=explode(';',chop($line));
		return $data;
	}
	
	function BasicTable($header,$data)
	{
		//Header
		$w=array(20,20,20,30,30,20,20);
		//Header
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],7,$header[$i],1,0,'C');
		$this->Ln();
		//Data
		foreach ($data as $eachResult) 
		{
			$this->Cell(20,6,$eachResult["Username"],1);
			$this->Cell(20,6,$eachResult["MAC Address"],1);
			$this->Cell(20,6,$eachResult["AP\'s IP Address"],1);
			$this->Cell(30,6,$eachResult["Start time"],1,0,'C');
			$this->Cell(30,6,$eachResult["Stop time"],1);
			$this->Cell(20,6,$eachResult["Upload"],1);
			$this->Cell(20,6,$eachResult["Download"],1);
			$this->Ln();
		}
	}
	
	function createpdf()
	{
		$pdf=new FPDF();
		$header=array('Username','MAC Address','AP\'s IP Address','Start time','Stop time','Upload','Download');
		
		$result=$this->user->logpdf();
		
		$pdf->SetFont('Arial','',10);
		$pdf->AddPage('L');
		$pdf->BasicTable($header,$result);
		
		$pdf->Output("Logfile.pdf","D");
	}

}
?>