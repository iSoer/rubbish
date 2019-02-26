<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Redirect extends CI_Controller {

	public function __construct()
	{
			parent::__construct();
			$this->load->model('redirect_model');
	}

	public function create($status = '')
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['title'] = 'Генератор коротких ссылок';
		$data['status'] = $status;
		$data['archive_urls'] = $this->redirect_model->get_url();

		$this->form_validation->set_rules('url', 'Url', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header', $data);
			$this->load->view('pages/create', $data);
			$this->load->view('templates/footer');
		}
		else
		{	
			$last_id = $this->redirect_model->set_url();
			if($last_id !== FALSE){
				$last_id = $last_id['cnt'];
				if($last_id > 0){
					$small_url_id = $this->dig2link($last_id);
					if($small_url_id != ''){
						$this->redirect_model->set_small_url($last_id, $small_url_id);
					}
				}
				$data['small_url_id'] = $small_url_id; 
				$this->load->view('pages/success', $data);
			} else {
				$this->load->view('pages/error');
			}
		}
	}

	public function go_away($id=''){
		if( ($id = trim(strip_tags($id))) != '' ){
			$url = $this->redirect_model->get_url($id);
			if($url !== NULL && $url['url'] != ''){
				$this->load->view('pages/redirect', array('url' => $url['url']));
			}
		}
	}

	public function dig2link($id) {
		$digits='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$link='';
		while($id != 0){
			$dig = $id%62;
			$link = $digits[$dig].$link;
			$id = floor($id/62);
		}

		return $link;
	}

	public function link2dig($link) {
		$digits = array(
			'0'=>0,  '1'=>1,  '2'=>2,  '3'=>3,  '4'=>4,  '5'=>5,  '6'=>6,
			'7'=>7,  '8'=>8,  '9'=>9,  'a'=>10, 'b'=>11, 'c'=>12, 'd'=>13,
			'e'=>14, 'f'=>15, 'g'=>16, 'h'=>17, 'i'=>18, 'j'=>19, 'k'=>20,
			'l'=>21, 'm'=>22, 'n'=>23, 'o'=>24, 'p'=>25, 'q'=>26, 'r'=>27,
			's'=>28, 't'=>29, 'u'=>30, 'v'=>31, 'w'=>32, 'x'=>33, 'y'=>34,
			'z'=>35, 'A'=>36, 'B'=>37, 'C'=>38, 'D'=>39, 'E'=>40, 'F'=>41,
			'G'=>42, 'H'=>43, 'I'=>44, 'J'=>45, 'K'=>46, 'L'=>47, 'M'=>48,
			'N'=>49, 'O'=>50, 'P'=>51, 'Q'=>52, 'R'=>53, 'S'=>54, 'T'=>55,
			'U'=>56, 'V'=>57, 'W'=>58, 'X'=>59, 'Y'=>60, 'Z'=>61);
		
        $id = 0;
		for ($i=0; $i < strlen($link); $i++) {
			$id += $digits[$link[(strlen($link)-$i-1)]] * pow(62, $i);
		}
		return $id;
	}
	
	
}
