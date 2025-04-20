<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Transaksi extends CI_Controller
{
	private $allowed_roles = ['admin', 'petugas'];

	public $user_session = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Sampah');
		$this->load->model('M_Nasabah');
		$this->load->model('M_Transaksi');
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

	public function validate_date($date = '0-0-0')
	{
		// Check date format (YYYY-MM-DD)
		$d           = DateTime::createFromFormat('Y-m-d', $date);
		$currentDate = new DateTime();

		if ($d && $d->format('Y-m-d') === $date) {

			if ($d > $currentDate) {
				$this->form_validation->set_message('validate_date', 'Tanggal tidak boleh lebih dari tanggal sekarang.');
				return FALSE;
			}
			return TRUE;
		} else {
			$this->form_validation->set_message('validate_date', 'Tanggal tidak valid. Format yang benar adalah YYYY-MM-DD.');
			return FALSE;
		}
	}

	public function search_pilih_nasabah()
	{
		$search_term = $this->input->get('search') ?? '';

		$nasabah = $this->M_Nasabah->search_nasabah($search_term);
		echo json_encode($nasabah);
	}

	public function index()
	{

		$data = [
			'title'                      => 'Transaksi',
			'greeting'                   => get_greeting(),
			'data_sampah'                => $this->M_Sampah->get_all_sampah(),
			'data_jenis_sampah'          => $this->M_Sampah->get_jenis_sampah(),
			'data_harga_sampah'          => $this->M_Sampah->get_latest_prices(),
			'kode_transaksi'             => $this->M_Transaksi->generate_kode_transaksi(),
			'history_transaksi_terakhir' => $this->M_Transaksi->history_terakhir(),
			'history_transaksi'          => $this->M_Transaksi->history_transaksi(),
		];



		$this->_load_view($data);
	}


	private function _load_view($data)
	{
		$views = [
			'Layout/App/V_header',
			'Layout/App/V_topbar',
			'Layout/App/V_sidebar',
			'Petugas/V_transaksi',
			'Layout/App/V_footer',
		];

		foreach ($views as $view) {
			$this->load->view($view, $data);
		}
	}

	public function get_last_harga($id_sampah)
	{
		$last_harga = $this->M_Sampah->get_last_harga($id_sampah, 'transaksi');
		echo json_encode($last_harga);
	}

	public function add_transaksi()
	{
		if (!$this->_validate_transaksi()) {
			http_response_code(412);
			header('Content-Type: application/json');
			echo json_encode([
				'status' => 'error',
				'errors' => validation_errors(),
			]);
			return;
			// return $this->index ();
		} else {
			$data = $this->_get_transaksi_data();

			$id_user_nasabah = $this->M_Nasabah->get_user($data['id_nasabah']);
			$sampah          = $this->M_Sampah->get_sampah_by_id($data['id_sampah']);
			$data_notifikasi = [
				'id_user' => $id_user_nasabah->id_user,
				'judul'   => 'Transaksi Diterima',
				'pesan'   => "Transaksi {$this->M_Transaksi->generate_kode_transaksi()} sampah {$sampah->nama_sampah} anda telah diterima",
				'tipe'    => 'success',
			];

			if ($this->M_Transaksi->add_transaksi($data)) {
				$this->M_Notifikasi->tambah($data_notifikasi);
				$this->session->set_flashdata('success', 'Transaksi berhasil ditambahkan!');
				header('Content-Type: application/json');
				echo json_encode(['status' => 'success']);
			} else {
				$this->session->set_flashdata('error', 'Gagal menambahkan transaksi!');
				header('Content-Type: application/json');
				echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan transaksi!']);
			}
		}
	}

	public function checkout($kode_transaksi)
	{
		$data = $this->_get_checkout_data($kode_transaksi);

		if ($data['status'] === 'dicatat') {
			redirect('Manage-Transaksi');
			return;
		}

		$data['title'] = 'Checkout';

		$this->load->view('Layout/App/V_header', $data);
		$this->load->view('Layout/App/V_topbar', $data);
		$this->load->view('Layout/App/V_sidebar', $data);
		$this->load->view('Petugas/V_checkout', $data);
		$this->load->view('Layout/App/V_footer', $data);
	}

	private function _get_checkout_data($kode_transaksi)
	{
		$checkout = $this->M_Transaksi->checkout($kode_transaksi);

		$harga = $this->M_Sampah->get_last_harga($checkout->id_sampah, 'transaksi');
		$total = ($checkout->berat / 1000) * $harga->harga_per_kg;

		return [
			'kode_transaksi'    => $kode_transaksi,
			'tanggal_transaksi' => $checkout->tanggal_transaksi,
			'nama_sampah'       => $checkout->nama_sampah,
			'berat'             => $checkout->berat,
			'harga_per_kg'      => $harga->harga_per_kg,
			'status'            => $checkout->status,
			'total'             => number_format($total, 2, ',', '.'),
		];
	}

	public function laporan()
	{
		$rt   = $this->user_session->id_rt;
		$data = [
			'title'    => 'Riwayat Transaksi',
			'greeting' => get_greeting(),
			'rt_list'  => $this->M_Users->get_rt_list(),
		];

		// Get filter parameters from GET request
		$filters = [
			'status'     => $this->input->get('status'),
			'start_date' => $this->input->get('start_date'),
			'end_date'   => $this->input->get('end_date'),
			'id_rt'      => $this->input->get('id_rt'),
			'search'     => $this->input->get('search'),
		];

		$data['history_transaksi'] = $this->M_Transaksi->get_filtered_history($filters);
		$data['current_filters'] = $filters;

		$this->load->view('Layout/App/V_header', $data);
		$this->load->view('Layout/App/V_topbar', $data);
		$this->load->view('Layout/App/V_sidebar', $data);
		$this->load->view('Petugas/V_laporan', $data);
		$this->load->view('Layout/App/V_footer', $data);
	}
	public function print_checkout($kode_transaksi)
	{
		$data = $this->_get_checkout_data($kode_transaksi);
		$data['title'] = "Checkout-{$data['kode_transaksi']}";

		$this->load->view('Petugas/V_print_checkout', $data);
	}

	public function checkout_process()
	{
		$kode_transaksi = $this->input->post('kode_transaksi', true);
		if ($kode_transaksi) {
			$checkout = $this->M_Transaksi->checkout($kode_transaksi);

			if (!$checkout) {
				echo json_encode(['status' => 'error', 'message' => 'Transaksi tidak ditemukan.']);
				return;
			}

			$harga = $this->M_Sampah->get_last_harga($checkout->id_sampah, 'transaksi');

			if (!$harga) {
				echo json_encode(['status' => 'error', 'message' => 'Harga tidak ditemukan.']);
				return;
			}
			$total_harga = ($checkout->berat / 1000) * $harga->harga_per_kg;
			$data        = [
				'id_harga'    => $harga->id_harga,
				'total_harga' => $total_harga,
			];

			$id_user_nasabah = $this->M_Nasabah->get_user($checkout->id_nasabah);
			$sampah          = $this->M_Sampah->get_sampah_by_id($checkout->id_sampah);
			$data_notifikasi = [
				'id_user' => $id_user_nasabah->id_user,
				'judul'   => 'Transaksi Diproses',
				'pesan'   => "Transaksi {$checkout->kode_transaksi} sampah {$sampah->nama_sampah} anda sedang diproses",
				'tipe'    => 'success',
			];

			if ($this->M_Transaksi->checkout_process($kode_transaksi, $data)) {
				$this->M_Notifikasi->tambah($data_notifikasi);
				$this->session->set_flashdata('success', 'Transaksi berhasil dicheckout!');
				header('Content-Type: application/json');
				echo json_encode(['status' => 'success']);
			} else {
				$this->session->set_flashdata('error', 'Gagal mencheckout transaksi!');
				header('Content-Type: application/json');
				echo json_encode(['status' => 'error', 'message' => 'Gagal mencheckout transaksi!']);
			}
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Kode transaksi tidak valid.']);
		}
	}

	private function _validate_transaksi()
	{
		$this->load->library('form_validation');
		return $this->form_validation->run('transaksi');
	}

	private function _get_transaksi_data()
	{
		if (in_array($this->session->userdata('role'), $this->allowed_roles)) {
			$id_user = $this->session->userdata('id_user');
		}

		return [
			'id_user'           => $id_user,
			'id_nasabah'        => $this->input->post('id_nasabah', TRUE),
			'id_sampah'         => $this->input->post('id_sampah', TRUE),
			'catatan_transaksi' => $this->input->post('catatan_transaksi', TRUE),
			'berat'             => $this->input->post('berat', TRUE),
		];
	}
}
