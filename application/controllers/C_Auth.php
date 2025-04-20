<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Users');
		date_default_timezone_set('Asia/Jakarta');
	}

	private function cek()
	{
		if ($this->session->userdata('is_login') == TRUE) {
			$user_session_role = $this->session->userdata('role');
			switch ($user_session_role) {
				case 'admin':
					redirect('Dashboard-Admin', 'refresh');
					break;
				case 'petugas':
					redirect('Manage-Transaksi', 'refresh');
					break;
				default:
					redirect('Dashboard-Nasabah', 'refresh');
					break;
			}
		}
	}


	public function index()
	{

		$this->cek();
		$data['title'] = 'Login';
		if ($this->form_validation->run('login') == false) {
			$this->load->view('Layout/Auth/V_header', $data);
			$this->load->view('Auth/V_login', $data);
			$this->load->view('Layout/Auth/V_footer', $data);
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$username = $this->input->post('username', true);
		$password = $this->input->post('password', true);

		$check_users = $this->db->get_where('tb_users', ['username' => $username])->row_array();

		if ($check_users) {
			if (password_verify($password, $check_users['password'])) {
				// Update last_login
				$this->db->where('id_user', $check_users['id_user'])
					->update('tb_users', ['last_login' => date('Y-m-d H:i:s')]);

				// Get user name based on role
				$name = $check_users['username']; // Default name
				if ($check_users['role'] === 'nasabah') {
					$nasabah = $this->M_Users->get_user_by_id($check_users['id_user']);
					$name    = $nasabah ? $nasabah->nama : 'Nasabah';
				}

				// Set session data
				$data = [
					'id_user'  => $check_users['id_user'],
					'name'     => $name,
					'role'     => $check_users['role'],
					'is_login' => true,
				];
				$this->session->set_userdata($data);

				// Log aktivitas
				$log_data = [
					'id_user' => $check_users['id_user'],
					'aksi'    => 'Login ke sistem',
					'tanggal' => date('Y-m-d H:i:s'),
				];
				$this->db->insert('tb_log_aktivitas', $log_data);

				// Redirect based on role
				switch ($check_users['role']) {
					case 'admin':
						redirect('Dashboard-Admin', 'refresh');
						break;
					case 'petugas':
						redirect('Manage-Transaksi', 'refresh');
						break;
					case 'nasabah':
						redirect('Dashboard-Nasabah', 'refresh');
						break;
					default:
						$this->logout();
						break;
				}
			} else {
				$this->session->set_flashdata('error', 'Password salah!');
				redirect('Auth-Login');
			}
		} else {
			$this->session->set_flashdata('warning', 'Pengguna tidak ditemukan');
			redirect('Auth-Login');
		}
	}

	public function register()
	{
		$this->cek();
		$data['rt_list'] = $this->M_Users->get_rt_list();
		$data['title']   = 'Register';

		if ($this->form_validation->run('register') == FALSE) {
			$this->load->view('Layout/Auth/V_header', $data);
			$this->load->view('Auth/V_register', $data);
			$this->load->view('Layout/Auth/V_footer', $data);
		} else {
			$this->_register_process();
		}
	}



	private function _register_process()
	{
		$user_data = [
			'email'    => $this->input->post('email', true),
			'username' => $this->input->post('username', true),
			'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
			'role'     => 'nasabah',
		];

		$nasabah_data = [
			'nama'      => $this->input->post('nama', true),
			'no_telfon' => $this->input->post('no_telfon', true),
			'avatar'    => 'default.png',
			'alamat'    => $this->input->post('alamat', true),
			'id_rt'     => $this->input->post('id_rt', true),
		];

		$data = array_merge($user_data, $nasabah_data);

		$id_user = $this->M_Users->register_user($data);

		if ($id_user) {
			$session_register = [
				'id_user'  => $id_user,
				'username' => $user_data['username'],
				'role'     => 'nasabah',
				'is_login' => true,
			];
			$this->session->set_userdata($session_register);
			$this->session->set_flashdata('message', 'Akun berhasil dibuat! Silakan login.');
			redirect('Auth-Login');
		} else {
			$this->session->set_flashdata('error', 'Terjadi kesalahan saat membuat akun.');
			redirect('Auth-Register');
		}
	}


	public function logout()
	{
		$this->session->sess_destroy();
		redirect('Auth-Login');
	}

	// Add callback for RT validation
	public function check_rt_exists($id_rt)
	{
		if ($this->M_Users->check_rt_exists($id_rt)) {
			return TRUE;
		}
		$this->form_validation->set_message('check_rt_exists', 'RT tidak ditemukan');
		return FALSE;
	}
}
