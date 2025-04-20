<?php
defined('BASEPATH') or exit('No direct script access allowed');


class C_Nasabah extends CI_Controller
{
	private $allowed_roles = ['nasabah'];
	public $user_session = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
		$this->load->model('M_Nasabah');
		$this->load->model('M_Users');
		$this->load->model('M_Peta');
		$this->load->library('UserSession');
		$this->_check_auth();
	}

	// Validasi Login Nasabah
	private function _check_auth()
	{
		if (!in_array($this->session->userdata('role'), $this->allowed_roles)) {
			redirect('Auth-Login');
		}
		$this->user_session = $this->usersession->get_user_data();
	}

	// View Role Nasabah
	public function index()
	{

		$id_nasabah = $this->user_session->id_nasabah ?? 0;

		$periode = $this->validatePeriode($_GET['periode'] ?? null);

		$data = [
			'title'             => 'Dashboard',
			'greeting'          => get_greeting(),
			'total_tabungan'    => $this->M_Nasabah->get_tabungan($id_nasabah)->jumlah_tabungan ?? 0,
			'total_berat'       => $this->M_Nasabah->get_transaksi_berat($id_nasabah)->total_berat,
			'periode_transaksi' => $this->M_Nasabah->get_periode_transaksi($id_nasabah),
			'setor_sampah'      => $this->M_Nasabah->get_total_sampah_disetorkan($id_nasabah),
			'wilayah'           => $this->M_Nasabah->get_nasabah_rt_rw($id_nasabah),
			'history_transaksi' => $this->M_Nasabah->history_transaksi($id_nasabah),
			'periode'           => $periode,
			'locations'         => $this->M_Peta->get_locations(),
		];

		$indonesianDays                   = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
		$data['label_transaksi']        = [];
		$data['data_history_transaksi'] = [];
		foreach ($data['history_transaksi'] as $transaction) {
			$dayIndex                           = date('w', strtotime($transaction->tanggal_transaksi));
			$data['label_transaksi'][]        = $indonesianDays[$dayIndex];
			$data['data_history_transaksi'][] = (float) $transaction->total_berat;
		}

		$this->_load_view($data);
	}

	public function profile()
	{
		$data = [
			'title'    => 'Profile Nasabah',
			'greeting' => get_greeting(),
			'rt_list'  => $this->M_Users->get_rt_list(),
		];

		$this->load->view('Layout/App/V_header', $data);
		$this->load->view('Layout/App/V_topbar', $data);
		$this->load->view('Layout/App/V_sidebar', $data);
		$this->load->view('Nasabah/V_profile', $data);
		$this->load->view('Layout/App/V_footer', $data);
	}

	public function tarik_tabungan()
	{
		if ($this->user_session->ketua_pkk != 1) {
			redirect('Auth-Login');
		}

		$rt   = $this->user_session->id_rt;
		$data = [
			'title'            => 'Tarik Tabungan',
			'greeting'         => get_greeting(),
			'rt_list'          => $this->M_Users->get_rt_list(),
			'tabungan_list'    => $this->M_Nasabah->get_all_tabungan($rt),
			'tarik_rt'         => $this->M_Nasabah->get_tabungan_rt($rt),
			'riwayat_all_dana' => $this->M_Nasabah->get_riwayat_tarik_tabungan(null, $rt),
		];

		$this->load->view('Layout/App/V_header', $data);
		$this->load->view('Layout/App/V_topbar', $data);
		$this->load->view('Layout/App/V_sidebar', $data);
		$this->load->view('Nasabah/V_tarik_tabungan', $data);
		$this->load->view('Layout/App/V_footer', $data);
	}

	public function format_waktu($date_string = "2025-01-01 01:00:00")
	{
		$date          = new DateTime($date_string);
		$hari          = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
		$bulan         = ['January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret', 'April' => 'April', 'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September', 'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'];
		$nama_hari     = $hari[$date->format('l')];
		$nama_bulan    = $bulan[$date->format('F')];
		$formated_date = "{$nama_hari}, {$date->format('d')} {$nama_bulan} {$date->format('Y')} | {$date->format('H:i')} WIB";

		return $formated_date;
	}

	public function update_profile($id_user)
	{
		try {

			$user = $this->M_Users->get_user_by_id($id_user);
			if (!$user) {
				throw new Exception('User  not found');
			}

			$role = $user->role;

			if ($role === 'nasabah') {
				if (!$this->form_validation->run('manage-edit-nasabah')) {
					return $this->profile();
				}
			} else {
				if (!$this->form_validation->run('manage-edit-user')) {
					return $this->profile();
				}
			}

			$data = $this->_get_user_data(true);

			if (!empty($_FILES['avatar']['name'])) {
				$avatar = $this->_handle_avatar_upload();
				if ($avatar) {
					$data['avatar'] = $avatar;
					$this->_delete_old_avatar($id_user);
				}
			}

			if ($this->M_Users->update_user($id_user, $data)) {
				$this->session->set_flashdata('success', 'Profile berhasil diupdate!');
			} else {
				throw new Exception('Gagal mengupdate user');
			}
		} catch (Exception $e) {
			log_message('error', 'Error in edit_user: ' . $e->getMessage());
			$this->session->set_flashdata('error', 'Gagal mengupdate user!');
		}

		redirect('Profile-Nasabah');
	}

	public function proses_tarik_tabungan()
	{
		if ($this->user_session->ketua_pkk != 1) {
			redirect('Auth-Login');
		}

		$id_rt            = $this->input->post('id_rt');
		$id_nasabah_ketua = $this->user_session->id_nasabah; // Assuming you store nasabah ID in session

		$result = $this->M_Nasabah->tarik_dana_rt($id_rt, $id_nasabah_ketua);

		if ($result['success']) {
			$response = [
				'status'  => 'success',
				'message' => 'Penarikan dana berhasil!',
				'data'    => [
					'total'   => $result['total_penarikan'],
					'nasabah' => $result['jumlah_nasabah'],
				],
			];
		} else {
			$response = [
				'status'  => 'error',
				'message' => $result['message'] ?? 'Gagal melakukan penarikan dana'
			];
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	public function riwayat_transaksi()
	{
		$rt   = $this->user_session->id_rt;
		$data = [
			'title'                     => 'Riwayat Transaksi',
			'greeting'                  => get_greeting(),
			'rt_list'                   => $this->M_Users->get_rt_list(),
			'tabungan_list'             => $this->M_Nasabah->get_all_tabungan($rt),
			'tarik_rt'                  => $this->M_Nasabah->get_tabungan_rt($rt),
			'riwayat_dana'              => $this->M_Nasabah->get_riwayat_tarik_tabungan($this->user_session->id_nasabah, $rt),
			'periode_tabungan'          => $this->M_Nasabah->get_periode_transaksi($this->user_session->id_nasabah),
			'history_transaksi_nasabah' => $this->M_Nasabah->get_transaksi_nasabah($this->user_session->id_nasabah),
		];

		$this->load->view('Layout/App/V_header', $data);
		$this->load->view('Layout/App/V_topbar', $data);
		$this->load->view('Layout/App/V_sidebar', $data);
		$this->load->view('Nasabah/V_riwayat_tabungan', $data);
		$this->load->view('Layout/App/V_footer', $data);
	}

	// Proses
	private function _get_user_data($is_update = false)
	{
		$data     = [
			'email'     => $this->input->post('email', TRUE),
			'username'  => $this->input->post('username', TRUE),
			'role'      => $this->input->post('role', TRUE),
			'id_rt'     => $this->input->post('id_rt', TRUE),
			'nama'      => $this->input->post('nama', TRUE),
			'no_telfon' => $this->input->post('no_telfon', TRUE),
			'alamat'    => $this->input->post('alamat', TRUE),
		];
		$password = $this->input->post('password');
		if (!empty($password)) {
			$data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
		} elseif (!$is_update) {
			$data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
		}

		return $data;
	}

	private function _handle_avatar_upload()
	{
		$config['upload_path']   = './assets/profile/avatars';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size']      = 2048;
		$config['encrypt_name']  = TRUE;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('avatar')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
			return false;
		}

		return $this->upload->data('file_name');
	}

	private function _delete_old_avatar($id_user)
	{
		$user = $this->M_Users->get_user_by_id($id_user);
		if ($user && $user->avatar !== $this->default_avatar) {
			$file_path = './assets/profile/avatars/' . $user->avatar;
			if (file_exists($file_path)) {
				unlink($file_path);
			}
		}
	}

	private function _load_view($data)
	{
		$views = [
			'Layout/App/V_header',
			'Layout/App/V_topbar',
			'Layout/App/V_sidebar',
			'Nasabah/V_index',
			'Layout/App/V_footer',
		];

		foreach ($views as $view) {
			$this->load->view($view, $data);
		}
	}

	private function validatePeriode($input)
	{
		$allowed_periods = ['semester', 'bulanan'];

		if (isset($input) && !empty($input)) {
			$periode = htmlspecialchars(trim($input));

			if (in_array($periode, $allowed_periods, true)) {
				return ucfirst($periode);
			}
		}
		return '';
	}

	// callback validation
	public function check_username_exists($username)
	{
		$user_id = $this->input->post('id_user'); // Ambil ID pengguna dari input
		if ($this->M_Users->username_exists($username, $user_id)) {
			$this->form_validation->set_message('check_username_exists', 'Username sudah digunakan');
			return FALSE;
		}
		return TRUE;
	}

	public function check_email_exists($email)
	{
		$user_id = $this->input->post('id_user'); // Ambil ID pengguna dari input
		if ($this->M_Users->email_exists($email, $user_id)) {
			$this->form_validation->set_message('check_email_exists', 'Email sudah digunakan');
			return FALSE;
		}
		return TRUE;
	}

	public function check_rt_exists($id_rt)
	{
		if ($this->M_Users->check_rt_exists($id_rt)) {
			return TRUE;
		}
		$this->form_validation->set_message('check_rt_exists', 'RT tidak ditemukan');
		return FALSE;
	}
}
