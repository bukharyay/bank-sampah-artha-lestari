<?php
defined('BASEPATH') or exit('No direct script access allowed');


class C_Admin extends CI_Controller
{
	private $allowed_roles = ['admin'];
	public $user_session = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['M_Transaksi', 'M_Nasabah', 'M_Hasil_Karya', 'M_Users', 'M_Area']);
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
		// Get transaction history
		$history = $this->M_Transaksi->get_history_transaksi_30hari();

		// Prepare Chart data
		$labels             = [];
		$transaction_counts = [];
		$transaction_values = [];
		$transaction_weight = [];

		foreach ($history as $item) {
			$date                 = date('d F Y', strtotime($item['tanggal']));
			$labels[]             = $date;
			$transaction_counts[] = (int) $item['jumlah'];
			$transaction_values[] = (float) $item['nilai'] ?? 0;
			$transaction_weight[] = (float) $item['berat'] ?? 0;
		}

		$histori_bulanan = $this->M_Transaksi->get_ringkasan_bulanan();

		// Prepare Chart data
		$labels_bulanan          = [];
		$total_transaksi_bulanan = [];
		$total_nilai_bulanan     = [];
		$total_berat_bulanan     = [];

		foreach ($histori_bulanan as $item) {
			$date                      = date('F Y', strtotime($item->bulan));
			$labels_bulanan[]          = $date;
			$total_transaksi_bulanan[] = (int) $item->total;
			$total_nilai_bulanan[]     = (float) $item->nilai ?? 0;
			$total_berat_bulanan[]     = (float) $item->berat ?? 0;
		}

		$filter_rt = $this->input->get('rt');
		$filter_rw = $this->input->get('rw');

		$data = [
			'title'                         => 'Dashboard Admin',
			'greeting'                      => get_greeting(),
			'filter_rt'                     => $filter_rt,
			'filter_rw'                     => $filter_rw,

			'total_nasabah'                 => $this->M_Users->hitung_total_nasabah(),
			'total_transaksi'               => $this->M_Transaksi->hitung_total_transaksi(),
			'total_tabungan'                => $this->M_Nasabah->hitung_total_tabungan(),
			'total_karya'                   => $this->M_Hasil_Karya->hitung_total_karya(),
			'total_rt'                      => $this->M_Area->count_rt(),
			'total_rw'                      => $this->M_Area->count_rw(),

			'avg_tabungan'                  => $this->M_Nasabah->get_average_tabungan(),
			'top_nasabah'                   => $this->M_Nasabah->get_top_nasabah(),
			'distribusi_tabungan'           => $this->M_Nasabah->get_distribusi_tabungan_per_rt(),

			'transaksi_terakhir'            => $this->M_Transaksi->history_terakhir(),
			'hasil_karya_terakhir'          => $this->M_Hasil_Karya->get_recent_karya(2),
			'tarik_tabungan_terakhir'       => $this->M_Nasabah->get_riwayat_tarik_tabungan(null, null),
			'rt_list'                       => $this->M_Transaksi->get_rt_list(),
			'rt_rw_list'                    => $this->M_Transaksi->get_rt_rw_list(),
			'history_transaksi_bulanan'     => $history,
			'ringkasan_transaksi_bulanan'   => $this->M_Transaksi->get_ringkasan_bulanan(),
			'distribusi_tabungan_per_rt'    => $this->M_Nasabah->get_distribusi_tabungan_per_rt(),

			'bulan_ini'                     => $this->_format_waktu(date('F'), 'bulan'),

			// Chart data 1
			'label_transaksi'               => $labels,
			'data_jumlah_transaksi'         => $transaction_counts,
			'data_nilai_transaksi'          => $transaction_values,
			'data_berat_transaksi'          => $transaction_weight,

			// Chart data 2
			'label_transaksi_bulanan'       => $labels_bulanan,
			'data_jumlah_transaksi_bulanan' => $total_transaksi_bulanan,
			'data_nilai_transaksi_bulanan'  => $total_nilai_bulanan,
			'data_berat_transaksi_bulanan'  => $total_berat_bulanan,
		];

		$this->_load_view($data);
	}
	private function _load_view($data)
	{
		$views = [
			'Layout/App/V_header',
			'Layout/App/V_topbar',
			'Layout/App/V_sidebar',
			'Admin/V_index',
			'Layout/App/V_footer',
		];

		foreach ($views as $view) {
			$this->load->view($view, $data);
		}
	}

	// Dynamic Format Waktu 
	private function _format_waktu($date_string, $format = 'hari, bulan tanggal tahun')
	{
		if (empty($date_string)) {
			return '';
		}

		$date = new DateTime($date_string);

		$hari_list = [
			'Sunday'    => 'Minggu',
			'Monday'    => 'Senin',
			'Tuesday'   => 'Selasa',
			'Wednesday' => 'Rabu',
			'Thursday'  => 'Kamis',
			'Friday'    => 'Jumat',
			'Saturday'  => 'Sabtu',
		];

		$bulan_list = [
			'January'   => 'Januari',
			'February'  => 'Februari',
			'March'     => 'Maret',
			'April'     => 'April',
			'May'       => 'Mei',
			'June'      => 'Juni',
			'July'      => 'Juli',
			'August'    => 'Agustus',
			'September' => 'September',
			'October'   => 'Oktober',
			'November'  => 'November',
			'December'  => 'Desember',
		];

		$nama_hari  = $hari_list[$date->format('l')];
		$nama_bulan = $bulan_list[$date->format('F')];
		$tanggal    = $date->format('j');
		$tahun      = $date->format('Y');

		$replacements = [
			'hari'    => $nama_hari,
			'bulan'   => $nama_bulan,
			'tanggal' => $tanggal,
			'tahun'   => $tahun,
		];

		$result = $format;
		foreach ($replacements as $key => $value) {
			$result = str_replace($key, $value, $result);
		}

		return $result;
	}
}
