<?php
defined('BASEPATH') or exit('No direct script access allowed');
class C_Notifikasi extends CI_Controller
{
	private $allowed_roles = ['admin', 'petugas', 'nasabah'];
	public $user_session = [];
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Notifikasi');
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
	public function get_notifikasi()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		}

		$id_user      = $this->session->userdata('id_user');
		$notifikasi   = $this->M_Notifikasi->get_notifikasi($id_user);
		$unread_count = $this->M_Notifikasi->count_unread($id_user);

		$response = [
			'success'      => true,
			'notifikasi'   => $notifikasi,
			'unread_count' => $unread_count,
		];

		echo json_encode($response);
	}

	public function mark_as_read($id_notifikasi)
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		}

		$this->M_Notifikasi->mark_as_read($id_notifikasi);
		echo json_encode(['success' => true]);
	}

	public function mark_all_as_read()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		}

		$id_user = $this->session->userdata('id_user');
		$this->M_Notifikasi->mark_all_as_read($id_user);
		echo json_encode(['success' => true]);
	}

	public function contoh_notifikasi()
	{
		$data = [
			'id_user' => $this->session->userdata('id_user'),
			'judul'   => 'Contoh Notifikasi',
			'pesan'   => 'Ini adalah contoh pesan notifikasi',
			'tipe'    => 'info',
		];

		$this->M_Notifikasi->tambah($data);
		echo 'Notifikasi berhasil dibuat';
	}

	public function semua()
	{
		$data = [
			'title'      => 'Semua Notifikasi',
			'notifikasi' => $this->M_Notifikasi->get_notifikasi($this->session->userdata('id_user'), 100),
		];

		$this->load->view('Layout/App/V_header', $data);
		$this->load->view('Layout/App/V_topbar', $data);
		$this->load->view('Layout/App/V_sidebar', $data);
		$this->load->view('Notifikasi/V_semua', $data);
		$this->load->view('Layout/App/V_footer', $data);

		$this->M_Notifikasi->mark_all_as_read($this->session->userdata('id_user'));
	}
}
