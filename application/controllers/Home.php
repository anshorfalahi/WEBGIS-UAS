<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Home_model', 'hm');
	}

	public function datamasjid()
	{
		$data = $this->hm->get_masjid();
		echo json_encode ($data);
	}

	public function index()
	{
		$data['masjid'] = $this->hm->get_masjid();
		$this->load->view('v_home', $data);
	}

	public function detailmasjid($id)
	{
		$data['id_mas']= $id;
		$data['dok'] = $this->hm->get_dok($id);
		$data['masjid'] = $this->hm->get_masjid_byid($id);
		$this->load->view('v_detil', $data);
	}
}


