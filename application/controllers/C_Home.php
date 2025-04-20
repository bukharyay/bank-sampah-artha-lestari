<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Home extends CI_Controller
{
	private $link = '';
	public function __construct()
	{
		ini_set('display_errors', 'on');

		parent::__construct();
		$this->load->model('M_Peta');
		$this->load->model('M_Hasil_Karya');
		$this->cek();
	}

	private function cek()
	{
		if ($this->session->userdata('is_login') == TRUE) {
			$user_session_role = $this->session->userdata('role');
			switch ($user_session_role) {
				case 'admin':
					$this->link = 'Dashboard-Admin';
					break;
				case 'petugas':
					$this->link = 'Manage-Transaksi';
					break;
				case 'nasabah':
					$this->link = 'Dashboard-Nasabah';
					break;
				default:
					$this->link = 'Auth-Login';
					break;
			}
		} else {
			$this->link = 'Auth-Login';
		}
	}

	public function index()
	{

		$data = [
			'title'     => "Bank Sampah Artha Lestari",
			'login'     => $this->link,
			'locations' => $this->M_Peta->get_locations(),
			"karya"     => $this->M_Hasil_Karya->get_all_karya(3),
		];

		$this->load->view('Layout/Home/V_header', $data);
		$this->load->view('Home/V_index', $data);
		$this->load->view('Layout/Home/V_footer', $data);
	}


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

	public function artikel($slug)
	{
		$karya = $this->M_Hasil_Karya->get_karya_by_slug($slug);

		if (!$karya) {
			show_404();
		}

		$data = [
			'title'            => "Bank Sampah Artha Lestari",
			'login'            => $this->link,
			'locations'        => $this->M_Peta->get_locations(),
			'karya'            => $this->M_Hasil_Karya->get_karya_by_slug($slug),
			'related_articles' => $this->M_Hasil_Karya->get_related_karya($karya->id_jenis_sampah, $karya->id_hasil_karya)
		];

		$this->M_Hasil_Karya->increment_read_count($karya->id_hasil_karya);

		$this->load->view('Layout/Home/V_header', $data);
		$this->load->view('Home/V_artikel', $data);
		$this->load->view('Layout/Home/V_footer', $data);
	}

	public function semua_artikel($offset = 0)
	{
		// Load pagination library
		$this->load->library('pagination');

		// Get filter parameters from URL segments
		$category_slug    = $this->uri->segment(3);
		$subcategory_slug = $this->uri->segment(4);
		$category_id      = null;
		$subcategory_id   = null;

		// Initialize filter data
		$filter_data = [
			'limit'  => 6,
			// 'offset' => $offset,
			'offset' => html_escape($this->input->get('per_page')),
		];

		// Build base URL for pagination
		$base_url             = base_url('artikel/semua');
		$config['base_url'] = $base_url;

		// Handle category filter
		if ($category_slug && $category_slug != 'semua') {
			$category = $this->M_Hasil_Karya->get_jenis_sampah_by_slug($category_slug);

			if ($category) {
				$category_id                      = $category->id_jenis_sampah;
				$filter_data['id_jenis_sampah'] = $category_id;
				$config['base_url']             = base_url('artikel/kategori/' . $category_slug);

				// Handle subcategory filter
				if ($subcategory_slug) {
					$subcategory = $this->M_Hasil_Karya->get_sampah_by_slug($subcategory_slug);
					if ($subcategory) {
						$subcategory_id             = $subcategory->id_sampah;
						$filter_data['id_sampah'] = $subcategory_id;
						$config['base_url']       = base_url('artikel/kategori/' . $category_slug . '/' . $subcategory_slug);
					}
				}
			}
		}

		// Get total rows and paginated data
		$total_rows = $this->M_Hasil_Karya->count_filtered_karya($filter_data);
		$karya      = $this->M_Hasil_Karya->get_filtered_karya($filter_data);

		// Initialize pagination
		$config['total_rows']        = $total_rows;
		$config['per_page']          = 6;
		$config['uri_segment']       = $subcategory_slug ? 5 : ($category_slug ? 4 : 3);
		$config['page_query_string'] = TRUE;

		// Bootstrap 5 Pagination config
		$config['full_tag_open']   = '<nav><ul class="pagination justify-content-center">';
		$config['full_tag_close']  = '</ul></nav>';
		$config['attributes']      = ['class' => 'page-link'];
		$config['first_link']      = '&laquo;';
		$config['first_tag_open']  = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['last_link']       = '&raquo;';
		$config['last_tag_open']   = '<li class="page-item">';
		$config['last_tag_close']  = '</li>';
		$config['next_link']       = '&rsaquo;';
		$config['next_tag_open']   = '<li class="page-item">';
		$config['next_tag_close']  = '</li>';
		$config['prev_link']       = '&lsaquo;';
		$config['prev_tag_open']   = '<li class="page-item">';
		$config['prev_tag_close']  = '</li>';
		$config['cur_tag_open']    = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close']   = '</a></li>';
		$config['num_tag_open']    = '<li class="page-item">';
		$config['num_tag_close']   = '</li>';

		$this->pagination->initialize($config);

		// Prepare view data
		$data = [
			'title'                   => "Semua Artikel - Bank Sampah Artha Lestari",
			'karya'                   => $karya,
			'categories'              => $this->M_Hasil_Karya->get_categories_with_count(),
			'total_articles'          => $this->M_Hasil_Karya->hitung_total_karya(),
			'pagination'              => $this->pagination->create_links(),
			'login'                   => $this->link,
			'active_category'         => $category_id,
			'active_subcategory'      => $subcategory_id,
			'subcategories'           => $category_id ? $this->M_Hasil_Karya->get_sampah_by_jenis($category_id) : [],
			'active_category_name'    => $category_id ? $category->jenis_sampah : null,
			'active_subcategory_name' => $subcategory_id ? $subcategory->nama_sampah : null
		];

		$this->load->view('Layout/Home/V_header', $data);
		$this->load->view('Home/V_artikel_all', $data);
		$this->load->view('Layout/Home/V_footer', $data);
	}
	public function artikel_by_category($category_slug)
	{
		// Decode slug khusus untuk karakter '/'
		$category_slug = str_replace('--', '/', $category_slug);
		$this->semua_artikel(0, $category_slug);
	}

	public function artikel_by_subcategory($category_slug, $subcategory_slug)
	{
		// Decode slug khusus untuk karakter '/'
		$category_slug    = str_replace('--', '/', $category_slug);
		$subcategory_slug = str_replace('--', '/', $subcategory_slug);
		$this->semua_artikel(0, $category_slug, $subcategory_slug);
	}

	public function struktur_organisasi()
	{
		$data = [
			'title'     => "Struktur Organisasi",
			'login'     => $this->link,
			'locations' => $this->M_Peta->get_locations(),
			"karya"     => $this->M_Hasil_Karya->get_all_karya(3),
		];

		$this->load->view('Layout/Home/V_header', $data);
		$this->load->view('Home/V_struktur', $data);
		$this->load->view('Layout/Home/V_footer', $data);
	}
	public function wilayah_kerja()
	{
		$data = [
			'title'     => "Wilayah Kerja",
			'login'     => $this->link,
			'locations' => $this->M_Peta->get_locations(),
			"karya"     => $this->M_Hasil_Karya->get_all_karya(3),
		];

		$this->load->view('Layout/Home/V_header', $data);
		$this->load->view('Home/V_wilayah', $data);
		$this->load->view('Layout/Home/V_footer', $data);
	}
	public function tentang_kami()
	{
		$data = [
			'title'     => "Tentang Kami",
			'login'     => $this->link,
			'locations' => $this->M_Peta->get_locations(),
			"karya"     => $this->M_Hasil_Karya->get_all_karya(3),
		];

		$this->load->view('Layout/Home/V_header', $data);
		$this->load->view('Home/V_tentang', $data);
		$this->load->view('Layout/Home/V_footer', $data);
	}
}
