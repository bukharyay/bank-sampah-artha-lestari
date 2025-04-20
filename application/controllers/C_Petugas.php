<?php
defined('BASEPATH') or exit('No direct script access allowed');


class C_Petugas extends CI_Controller
{
	private $allowed_roles = ['admin', 'petugas'];
	public $user_session = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->library('UserSession');
		$this->_check_auth();
	}

	private function _check_auth()
	{
		if (!in_array($this->session->userdata('role'), $this->allowed_roles)) {
			redirect('Auth-Login');
		}

		$this->user_session = $this->usersession->get_user_data();
	}

	public function index()
	{

		$data['title']    = 'Dashboard Petugas';
		$data['greeting'] = get_greeting();

		$this->load->view('Layout/App/V_header', $data);
		$this->load->view('Layout/App/V_topbar', $data);
		$this->load->view('Layout/App/V_sidebar', $data);
		$this->load->view('Admin/V_index', $data);
		$this->load->view('Layout/App/V_footer', $data);
	}

	public function nasabah()
	{

		$data = [
			'title'        => 'Management Nasabah',
			'rt_list'      => $this->M_Users->get_rt_list(),
			'greeting'     => get_greeting(),
			'data_nasabah' => $this->M_Users->get_all_nasabah(),
		];

		$this->load->view('Layout/App/V_header', $data);
		$this->load->view('Layout/App/V_topbar', $data);
		$this->load->view('Layout/App/V_sidebar', $data);
		$this->load->view('Admin/V_nasabahlist', $data);
		$this->load->view('Layout/App/V_footer', $data);
	}
}
