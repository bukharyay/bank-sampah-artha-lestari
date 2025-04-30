<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * Controller Home (Portal Informasi)
 */

class C_Home extends MY_Controller
	{
	protected $default_redirect = [ 
		'admin'   => 'Dashboard-Admin',
		'petugas' => 'Manage-Transaksi',
		'nasabah' => 'Dashboard-Nasabah',
	];

	public function __construct ()
		{
		parent::__construct ();
		$this->allowed_roles = [];
		$this->load->model ( [ 'M_Peta', 'M_Hasil_Karya' ] );
		}

	// ================= MAIN PAGES =================

	/**
	 * Display home page
	 */
	public function index ()
		{
		$data = $this->_get_base_data ( "Bank Sampah Artha Lestari" );
		$this->_load_views ( 'Home/V_index', $data );
		}

	/**
	 * Display single article page
	 */
	public function artikel ( $slug )
		{
		$karya = $this->M_Hasil_Karya->get_karya_by_slug ( $slug );
		if ( ! $karya ) show_404 ();

		$this->_track_article_view ( $karya->id_hasil_karya );

		$data = $this->_get_base_data ( $karya->judul . " | Bank Sampah Artha Lestari" );
		$data = array_merge ( $data, [ 
			'meta_title'       => strip_tags ( $karya->meta_title ),
			'meta_description' => strip_tags ( $karya->meta_description ),
			'karya'            => $karya,
			'related_articles' => $this->M_Hasil_Karya->get_related_karya (
				$karya->id_jenis_sampah,
				$karya->id_hasil_karya,
			),
		] );

		$this->_load_views ( 'Home/V_artikel', $data );
		}

	/**
	 * Display all articles page with pagination
	 */
	public function semua_artikel ( $offset = 0 )
		{
		$this->load->library ( 'pagination' );

		$filter_data       = $this->_prepare_article_filters ();
		$pagination_config = $this->_get_pagination_config ( $filter_data );

		$data = $this->_get_base_data ( "Semua Artikel - Bank Sampah Artha Lestari" );
		$data = array_merge ( $data, [ 
			'karya'                   => $this->M_Hasil_Karya->get_filtered_karya ( $filter_data ),
			'categories'              => $this->M_Hasil_Karya->get_categories_with_count (),
			'total_articles'          => $this->M_Hasil_Karya->hitung_total_karya (),
			'pagination'              => $this->pagination->initialize ( $pagination_config )->create_links (),
			'active_category'         => $filter_data[ 'id_jenis_sampah' ] ?? null,
			'active_subcategory'      => $filter_data[ 'id_sampah' ] ?? null,
			'subcategories'           => isset ( $filter_data[ 'id_jenis_sampah' ] ) ?
				$this->M_Hasil_Karya->get_sampah_by_jenis ( $filter_data[ 'id_jenis_sampah' ] ) : [],
			'active_category_name'    => $this->uri->segment ( 3 ) ?
				$this->M_Hasil_Karya->get_jenis_sampah_by_slug ( $this->uri->segment ( 3 ) )->jenis_sampah : null,
			'active_subcategory_name' => $this->uri->segment ( 4 ) ?
				$this->M_Hasil_Karya->get_sampah_by_slug ( $this->uri->segment ( 4 ) )->nama_sampah : null
		] );

		$this->_load_views ( 'Home/V_artikel_all', $data );
		}

	/**
	 * Display organization structure page
	 */
	public function struktur_organisasi ()
		{
		$data = $this->_get_base_data ( "Struktur Organisasi" );
		$this->_load_views ( 'Home/V_struktur', $data );
		}

	/**
	 * Display working area page
	 */
	public function wilayah_kerja ()
		{
		$data = $this->_get_base_data ( "Wilayah Kerja" );
		$this->_load_views ( 'Home/V_wilayah', $data );
		}

	/**
	 * Display about us page
	 */
	public function tentang_kami ()
		{
		$data = $this->_get_base_data ( "Tentang Kami" );
		$this->_load_views ( 'Home/V_tentang', $data );
		}

	// ================= HELPER METHODS =================

	/**
	 * Get base data for all pages
	 */
	protected function _get_base_data ( $title )
		{
		return [ 
			'title'     => $title,
			'login'     => $this->session->userdata ( 'is_login' ) ?
				( $this->default_redirect[ $this->session->userdata ( 'role' ) ] ?? 'Auth-Login' ) :
				'Auth-Login',
			'locations' => $this->M_Peta->get_locations (),
			'karya'     => $this->M_Hasil_Karya->get_all_karya ( 3 ),
		];
		}

	/**
	 * Load views with layout
	 */
	protected function _load_views ( $content_view, $data )
		{
		$this->load->view ( 'Layout/Home/V_header', $data );
		$this->load->view ( $content_view, $data );
		$this->load->view ( 'Layout/Home/V_footer', $data );
		}

	/**
	 * Track article view and increment count
	 */
	protected function _track_article_view ( $article_id )
		{
		if ( ! $this->session->userdata ( 'viewed_article_' . $article_id ) )
			{
			try
				{
				$this->M_Hasil_Karya->increment_read_count ( $article_id );
				$this->session->set_userdata ( 'viewed_article_' . $article_id, true );
				}
			catch ( Exception $e )
				{
				log_message ( 'error', 'Failed to increment read count: ' . $e->getMessage () );
				}
			}
		}

	/**
	 * Prepare article filters from URI segments
	 */
	protected function _prepare_article_filters ()
		{
		$filter_data = [ 
			'limit'  => 6,
			'offset' => html_escape ( $this->input->get ( 'per_page' ) ),
		];

		$category_slug    = $this->uri->segment ( 3 );
		$subcategory_slug = $this->uri->segment ( 4 );

		if ( $category_slug && $category_slug != 'semua' )
			{
			$category = $this->M_Hasil_Karya->get_jenis_sampah_by_slug ( $category_slug );
			if ( $category )
				{
				$filter_data[ 'id_jenis_sampah' ] = $category->id_jenis_sampah;
				if ( $subcategory_slug )
					{
					$subcategory = $this->M_Hasil_Karya->get_sampah_by_slug ( $subcategory_slug );
					if ( $subcategory )
						{
						$filter_data[ 'id_sampah' ] = $subcategory->id_sampah;
						}
					}
				}
			}

		return $filter_data;
		}

	/**
	 * Get pagination configuration
	 */
	protected function _get_pagination_config ( $filter_data )
		{
		$config = [ 
			'base_url'          => base_url ( 'artikel/semua' ),
			'total_rows'        => $this->M_Hasil_Karya->count_filtered_karya ( $filter_data ),
			'per_page'          => 6,
			'page_query_string' => true,
			'full_tag_open'     => '<nav><ul class="pagination justify-content-center">',
			'full_tag_close'    => '</ul></nav>',
			'attributes'        => [ 'class' => 'page-link' ],
			'first_link'        => '&laquo;',
			'last_link'         => '&raquo;',
			'next_link'         => '&rsaquo;',
			'prev_link'         => '&lsaquo;',
			'cur_tag_open'      => '<li class="page-item active"><a class="page-link" href="#">',
			'cur_tag_close'     => '</a></li>',
			'num_tag_open'      => '<li class="page-item">',
			'num_tag_close'     => '</li>',
		];

		return $config;
		}

	/**
	 * Format date/time in Indonesian
	 */
	public function _format_waktu ( $date_string, $format = 'hari, bulan tanggal tahun' )
		{
		if ( empty ( $date_string ) ) return '';

		$date         = new DateTime( $date_string );
		$replacements = [ 
			'hari'    => $this->_get_indonesian_day ( $date->format ( 'l' ) ),
			'bulan'   => $this->_get_indonesian_month ( $date->format ( 'F' ) ),
			'tanggal' => $date->format ( 'j' ),
			'tahun'   => $date->format ( 'Y' ),
		];

		return str_replace ( array_keys ( $replacements ), array_values ( $replacements ), $format );
		}

	/**
	 * Get Indonesian day name
	 */
	protected function _get_indonesian_day ( $english_day )
		{
		$days = [ 
			'Sunday'    => 'Minggu',
			'Monday'    => 'Senin',
			'Tuesday'   => 'Selasa',
			'Wednesday' => 'Rabu',
			'Thursday'  => 'Kamis',
			'Friday'    => 'Jumat',
			'Saturday'  => 'Sabtu',
		];
		return $days[ $english_day ] ?? $english_day;
		}

	/**
	 * Get Indonesian month name
	 */
	protected function _get_indonesian_month ( $english_month )
		{
		$months = [ 
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
		return $months[ $english_month ] ?? $english_month;
		}
	}