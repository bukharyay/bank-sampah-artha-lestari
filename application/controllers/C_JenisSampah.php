<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_JenisSampah extends CI_Controller
{
	private $allowed_roles = ['admin', 'petugas'];
	public $user_session = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Sampah');
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

	public function check_jenis_sampah($id_jenis_sampah)
	{
		if (!$this->M_Sampah->jenis_sampah_exists($id_jenis_sampah)) {
			$this->form_validation->set_message('check_jenis_sampah', 'Jenis sampah tidak tersedia');
			return FALSE;
		}
		return TRUE;
	}

	public function index()
	{
		$data = [
			'title'             => 'Jenis Sampah',
			'greeting'          => get_greeting(),
			'data_jenis_sampah' => $this->M_Sampah->get_jenis_sampah(),
		];

		$this->_load_view($data);
	}

	private function _load_view($data)
	{
		$views = [
			'Layout/App/V_header',
			'Layout/App/V_topbar',
			'Layout/App/V_sidebar',
			'Petugas/V_jenis_sampahlist',
			'Layout/App/V_footer',
		];

		foreach ($views as $view) {
			$this->load->view($view, $data);
		}
	}

	private function _validate_jenis_sampah()
	{
		$this->load->library('form_validation');
		return $this->form_validation->run('jenis_sampah');
	}

	private function _get_jenis_sampah_data($isEdit = false)
	{

		$data = [
			'jenis_sampah' => $this->input->post('jenis_sampah', TRUE),
		];

		if ($isEdit) {
			$data['id_jenis_sampah'] = $this->input->post('id_jenis_sampah', true);
		}

		return $data;
	}

	public function add_jenis_sampah()
	{
		if (!$this->_validate_jenis_sampah()) {
			return $this->index();
		}

		$data = $this->_get_jenis_sampah_data();

		if ($this->M_Sampah->add_jenis_sampah($data)) {
			$this->session->set_flashdata('success', 'Kategori Sampah berhasil ditambahkan!');
		} else {
			$this->session->set_flashdata('error', 'Gagal menambahkan Jenis sampah!');
		}

		redirect('Manage-Jenis-Sampah');
	}

	public function edit_jenis_sampah($idjenisSampah)
	{
		$id_jenis_sampah = $this->input->post('id_jenis_sampah', true) == $idjenisSampah ? $idjenisSampah : '';
		if ($this->form_validation->run('jenis_sampah') == false) {
			$this->index();
		} else {
			if (!empty($id_jenis_sampah)) {
				if ($this->_edit_jenis_sampah_process($id_jenis_sampah)) {
					$this->session->set_flashdata('success', 'Kategori Sampah updated successfully!');
				} else {
					$this->session->set_flashdata('error', 'Failed to update kategori sampah. Please try again.');
				}
			} else {
				$this->session->set_flashdata('warning', 'Data Kategori Sampah tidak valid!');
				return FALSE;
			}
			redirect('Manage-Jenis-Sampah');
		}
	}

	private function _edit_jenis_sampah_process($idjenisSampah)
	{
		$data = $this->_get_jenis_sampah_data(true);

		return $this->M_Sampah->update_jenis_sampah($idjenisSampah, $data);
	}

	public function delete_jenis_sampah($idjenisSampah)
	{
		$id_jenis_sampah = $this->input->post('id_jenis_sampah', true) == $idjenisSampah ? $idjenisSampah : '';

		if (!empty($id_jenis_sampah)) {
			if ($this->M_Sampah->delete_jenis_sampah($idjenisSampah)) {
				$this->session->set_flashdata('success', 'Kategori Sampah deleted successfully!');
			} else {
				$this->session->set_flashdata('error', 'Failed to delete kategori sampah. Please try again.');
			}
			redirect('Manage-Jenis-Sampah');
		}
	}
}
