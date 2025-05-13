<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Controller Admin 
 */

class C_Admin extends MY_Controller
{
	protected $allowed_roles = ['admin'];
	public $user_session = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'M_Transaksi',
			'M_Nasabah',
			'M_Hasil_Karya',
			'M_Users',
			'M_Area',
		]);

		$this->_check_auth();
	}

	/**
	 * Display admin dashboard
	 */
	public function index()
	{
		// Get transaction history
		$history             = $this->M_Transaksi->get_history_transaksi_30hari();
		$histori_bulanan     = $this->M_Transaksi->get_ringkasan_bulanan();
		$histori_bulanan_asc = $this->M_Transaksi->get_ringkasan_bulanan_graph();

		// Prepare chart data
		$chart_data     = $this->_prepare_chart_data($history, $histori_bulanan);
		$chart_data_asc = $this->_prepare_chart_data($history, $histori_bulanan_asc);

		// Calculate transaction differences
		$current_transactions = $this->M_Transaksi->hitung_total_transaksi_minggu_ini() ?? 0;
		$previous_transactions = $this->M_Transaksi->hitung_total_transaksi_minggu_kemarin() ?? 0;
		$transaction_difference = $current_transactions - $previous_transactions;

		// Status perbedaan transaksi
		if ($transaction_difference == 0) {
			$jumlah_perbedaan_transaksi = '';
			$status_perbedaan_transaksi = 'muted';
			$pesan_perbedaan_transaksi  = 'Jumlah transaksi sama seperti minggu lalu';
			$icon_perbedaan_transaksi   = 'swap';
		} elseif ($transaction_difference > 0) {
			$jumlah_perbedaan_transaksi = abs($transaction_difference);
			$status_perbedaan_transaksi = 'success';
			$pesan_perbedaan_transaksi  = 'Transaksi meningkat dari minggu lalu';
			$icon_perbedaan_transaksi   = 'up';
		} else {
			$jumlah_perbedaan_transaksi = abs($transaction_difference);
			$status_perbedaan_transaksi = 'danger';
			$pesan_perbedaan_transaksi  = 'Transaksi menurun dari minggu lalu';
			$icon_perbedaan_transaksi   = 'down';
		}

		// Get filters
		$filter_rt = $this->input->get('rt');
		$filter_rw = $this->input->get('rw');
		// var_dump ( $chart_data );
		// die;
		// Prepare dashboard data
		$data = [
			'title'                         => 'Dashboard Admin',
			'greeting'                      => get_greeting(),
			'filter_rt'                     => $filter_rt,
			'filter_rw'                     => $filter_rw,

			// User statistics
			'total_nasabah'                 => $this->M_Users->hitung_total_nasabah(),
			'new_nasabah_this_month'        => $this->M_Users->hitung_total_nasabah_bulan_ini(),

			// Transaction statistics
			'total_transaksi'               => $this->M_Transaksi->hitung_total_transaksi(),
			'transaksi_minggu_ini'          => $this->M_Transaksi->hitung_total_transaksi_minggu_ini(),
			'transaksi_minggu_kemarin'      => $this->M_Transaksi->hitung_total_transaksi_minggu_kemarin(),

			// Savings statistics
			'total_tabungan'                => $this->M_Nasabah->hitung_total_tabungan(),

			// Craft statistics
			'total_karya'                   => $this->M_Hasil_Karya->hitung_total_karya(),
			'new_karya_this_month'          => $this->M_Hasil_Karya->hitung_karya_terbaru_bulan_ini(),

			// Area statistics
			'total_rt'                      => $this->M_Area->count_rt(),
			'total_rw'                      => $this->M_Area->count_rw(),

			// Additional data
			'avg_tabungan'                  => $this->M_Nasabah->get_average_tabungan(),
			'top_nasabah'                   => $this->M_Nasabah->get_top_nasabah(),
			'distribusi_tabungan'           => $this->M_Nasabah->get_distribusi_tabungan_per_rt(),

			// Recent activities
			'transaksi_terakhir'            => $this->M_Transaksi->history_terakhir(),
			'hasil_karya_terakhir'          => $this->M_Hasil_Karya->get_recent_karya(6),
			'tarik_tabungan_terakhir'       => $this->M_Nasabah->get_riwayat_tarik_tabungan(null, null),
			'rt_list'                       => $this->M_Transaksi->get_rt_list(),
			'rt_rw_list'                    => $this->M_Transaksi->get_rt_rw_list(),
			'history_transaksi_bulanan'     => $history,
			'ringkasan_transaksi_bulanan'   => $this->M_Transaksi->get_ringkasan_bulanan(),
			'distribusi_tabungan_per_rt'    => $this->M_Nasabah->get_distribusi_tabungan_per_rt(),

			// Current month
			'bulan_ini'                     => $this->_format_waktu(date('F'), 'bulan'),

			// Chart data
			'label_transaksi'               => $chart_data['label_transaksi'],
			'data_jumlah_transaksi'         => $chart_data['data_jumlah_transaksi'],
			'data_nilai_transaksi'          => $chart_data['data_nilai_transaksi'],
			'data_berat_transaksi'          => $chart_data['data_berat_transaksi'],
			'label_transaksi_bulanan'       => $chart_data_asc['label_transaksi_bulanan'],
			'data_jumlah_transaksi_bulanan' => $chart_data_asc['data_jumlah_transaksi_bulanan'],
			'data_nilai_transaksi_bulanan'  => $chart_data_asc['data_nilai_transaksi_bulanan'],
			'data_berat_transaksi_bulanan'  => $chart_data_asc['data_berat_transaksi_bulanan'],
			'perbedaan_transaksi'           => $transaction_difference,
			'persentase_perubahan'          => $this->_calculate_percentage_change($current_transactions, $previous_transactions),
			'jumlah_perbedaan_transaksi' => $jumlah_perbedaan_transaksi,
			'status_perbedaan_transaksi' => $status_perbedaan_transaksi,
			'pesan_perbedaan_transaksi'  => $pesan_perbedaan_transaksi,
			'icon_perbedaan_transaksi'   => $icon_perbedaan_transaksi,

		];

		$this->_load_view($data);
	}

	/**
	 * Prepare chart data for dashboard
	 */
	private function _prepare_chart_data($history, $histori_bulanan)
	{
		$labels             = [];
		$transaction_counts = [];
		$transaction_values = [];
		$transaction_weight = [];

		foreach ($history as $item) {
			$date                 = date('d F Y', strtotime($item['tanggal']));
			$labels[]             = $date;
			$transaction_counts[] = (int) $item['jumlah'];
			$transaction_values[] = (float) ($item['nilai'] ?? 0);
			$transaction_weight[] = (float) ($item['berat'] ?? 0);
		}

		$labels_bulanan          = [];
		$total_transaksi_bulanan = [];
		$total_nilai_bulanan     = [];
		$total_berat_bulanan     = [];

		foreach ($histori_bulanan as $item) {
			$date                      = date('F Y', strtotime($item->bulan));
			$labels_bulanan[]          = $date;
			$total_transaksi_bulanan[] = (int) $item->total;
			$total_nilai_bulanan[]     = (float) ($item->nilai ?? 0);
			$total_berat_bulanan[]     = (float) ($item->berat ?? 0);
		}

		return [
			'label_transaksi'               => $labels,
			'data_jumlah_transaksi'         => $transaction_counts,
			'data_nilai_transaksi'          => $transaction_values,
			'data_berat_transaksi'          => $transaction_weight,
			'label_transaksi_bulanan'       => $labels_bulanan,
			'data_jumlah_transaksi_bulanan' => $total_transaksi_bulanan,
			'data_nilai_transaksi_bulanan'  => $total_nilai_bulanan,
			'data_berat_transaksi_bulanan'  => $total_berat_bulanan,
		];
	}

	/**
	 * Calculate percentage change between two values
	 */

	private function _calculate_percentage_change($current, $previous)
	{
		if ($previous == 0) {
			return $current == 0 ? 0 : 100;
		}

		$change = (($current - $previous) / $previous) * 100;
		return round(max(-100, min(100, $change)), 2);
	}


	/**
	 * Load admin dashboard view
	 */
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

	/**
	 * Format date/time string
	 */
	public function _format_waktu($date_string, $format = 'hari, bulan tanggal tahun')
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
