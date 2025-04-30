<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * Controller Transaksi
 */

class C_Transaksi extends MY_Controller
	{
	protected $allowed_roles = [ 'admin', 'petugas' ];
	public $user_session = [];

	public function __construct ()
		{
		parent::__construct ();
		$this->load->model ( 'M_Sampah' );
		$this->load->model ( 'M_Users' );
		$this->load->model ( 'M_Nasabah' );
		$this->load->model ( 'M_Transaksi' );
		$this->load->model ( 'M_Notifikasi' );
		$this->_check_auth ();
		}

	public function validate_date ( $date = '0-0-0' )
		{
		$d           = DateTime::createFromFormat ( 'Y-m-d', $date );
		$currentDate = new DateTime();

		if ( $d && $d->format ( 'Y-m-d' ) === $date )
			{
			if ( $d > $currentDate )
				{
				$this->form_validation->set_message ( 'validate_date', 'Tanggal tidak boleh lebih dari tanggal sekarang.' );
				return FALSE;
				}
			return TRUE;
			}
		else
			{
			$this->form_validation->set_message ( 'validate_date', 'Tanggal tidak valid. Format yang benar adalah YYYY-MM-DD.' );
			return FALSE;
			}
		}

	public function search_pilih_nasabah ()
		{
		$search_term = $this->input->get ( 'search' ) ?? '';
		$nasabah     = $this->M_Nasabah->search_nasabah ( $search_term );
		$this->output
			->set_content_type ( 'application/json' )
			->set_output ( json_encode ( $nasabah ) );
		}

	public function index ()
		{
		$data = [ 
			'title'                      => 'Transaksi',
			'greeting'                   => get_greeting (),
			'data_sampah'                => $this->M_Sampah->get_all_sampah (),
			'data_jenis_sampah'          => $this->M_Sampah->get_jenis_sampah (),
			'data_harga_sampah'          => $this->M_Sampah->get_latest_prices (),
			'kode_transaksi'             => $this->M_Transaksi->generate_kode_transaksi (),
			'history_transaksi_terakhir' => $this->M_Transaksi->history_terakhir ( 6 ),
			'history_transaksi'          => $this->M_Transaksi->history_transaksi (),
		];

		$this->_load_view ( $data );
		}

	private function _load_view ( $data )
		{
		$views = [ 
			'Layout/App/V_header',
			'Layout/App/V_topbar',
			'Layout/App/V_sidebar',
			'Petugas/V_transaksi',
			'Layout/App/V_footer',
		];

		foreach ( $views as $view )
			{
			$this->load->view ( $view, $data );
			}
		}

	public function get_last_harga ( $id_sampah )
		{
		$last_harga = $this->M_Sampah->get_last_harga ( $id_sampah, 'transaksi' );
		$this->output
			->set_content_type ( 'application/json' )
			->set_output ( json_encode ( $last_harga ) );
		}

	public function add_transaksi ()
		{
		if ( ! $this->_validate_transaksi () )
			{
			$this->output
				->set_status_header ( 412 )
				->set_content_type ( 'application/json' )
				->set_output ( json_encode ( [ 
					'status' => 'error',
					'errors' => validation_errors_array (),
				] ) );
			return;
			}

		$data            = $this->_get_transaksi_data ();
		$id_user_nasabah = $this->M_Nasabah->get_user ( $data[ 'id_nasabah' ] );
		$sampah          = $this->M_Sampah->get_sampah_by_id ( $data[ 'id_sampah' ] );

		$data_notifikasi = [ 
			'id_user' => $id_user_nasabah->id_user,
			'judul'   => 'Transaksi Diterima',
			'pesan'   => "Transaksi {$this->M_Transaksi->generate_kode_transaksi ()} sampah {$sampah->nama_sampah} anda telah diterima",
			'tipe'    => 'success',
		];

		if ( $this->M_Transaksi->add_transaksi ( $data ) )
			{
			$this->M_Notifikasi->tambah ( $data_notifikasi );
			$this->output
				->set_content_type ( 'application/json' )
				->set_output ( json_encode ( [ 
					'status'   => 'success',
					'message'  => 'Transaksi berhasil ditambahkan!',
					'redirect' => site_url ( 'Manage-Transaksi' ),
				] ) );
			}
		else
			{
			$this->output
				->set_status_header ( 500 )
				->set_content_type ( 'application/json' )
				->set_output ( json_encode ( [ 
					'status'  => 'error',
					'message' => 'Gagal menambahkan transaksi!',
				] ) );
			}
		}

	public function checkout ( $kode_transaksi )
		{
		$data = $this->_get_checkout_data ( $kode_transaksi );

		if ( $data[ 'status' ] === 'dicatat' )
			{
			redirect ( 'Manage-Transaksi' );
			return;
			}

		$data[ 'title' ] = 'Checkout';
		$this->_load_checkout_view ( $data );
		}

	private function _load_checkout_view ( $data )
		{
		$views = [ 
			'Layout/App/V_header',
			'Layout/App/V_topbar',
			'Layout/App/V_sidebar',
			'Petugas/V_checkout',
			'Layout/App/V_footer',
		];

		foreach ( $views as $view )
			{
			$this->load->view ( $view, $data );
			}
		}

	private function _get_checkout_data ( $kode_transaksi )
		{
		$checkout = $this->M_Transaksi->checkout ( $kode_transaksi );
		$harga    = $this->M_Sampah->get_last_harga ( $checkout->id_sampah, 'transaksi' );
		$total    = ( $checkout->berat / 1000 ) * $harga->harga_per_kg;

		return [ 
			'kode_transaksi'    => $kode_transaksi,
			'tanggal_transaksi' => $checkout->tanggal_transaksi,
			'nama_sampah'       => $checkout->nama_sampah,
			'berat'             => $checkout->berat,
			'harga_per_kg'      => $harga->harga_per_kg,
			'status'            => $checkout->status,
			'total'             => number_format ( $total, 2, ',', '.' ),
		];
		}

	public function laporan ()
		{
		$data = [ 
			'title'             => 'Riwayat Transaksi',
			'greeting'          => get_greeting (),
			'rt_list'           => $this->M_Users->get_rt_list (),
			'current_filters'   => [ 
				'status'     => $this->input->get ( 'status' ),
				'start_date' => $this->input->get ( 'start_date' ),
				'end_date'   => $this->input->get ( 'end_date' ),
				'id_rt'      => $this->input->get ( 'id_rt' ),
				'search'     => $this->input->get ( 'search' ),
			],
			'history_transaksi' => $this->M_Transaksi->get_filtered_history ( $this->input->get () ),
		];

		$this->_load_laporan_view ( $data );
		}

	private function _load_laporan_view ( $data )
		{
		$views = [ 
			'Layout/App/V_header',
			'Layout/App/V_topbar',
			'Layout/App/V_sidebar',
			'Petugas/V_laporan',
			'Layout/App/V_footer',
		];

		foreach ( $views as $view )
			{
			$this->load->view ( $view, $data );
			}
		}

	public function print_checkout ( $kode_transaksi )
		{
		$data            = $this->_get_checkout_data ( $kode_transaksi );
		$data[ 'title' ] = "Checkout-{$data[ 'kode_transaksi' ]}";
		$this->load->view ( 'Petugas/V_print_checkout', $data );
		}

	public function checkout_process ()
		{
		$kode_transaksi = $this->input->post ( 'kode_transaksi', true );
		if ( ! $kode_transaksi )
			{
			$this->output
				->set_status_header ( 400 )
				->set_content_type ( 'application/json' )
				->set_output ( json_encode ( [ 
					'status'  => 'error',
					'message' => 'Kode transaksi tidak valid.',
				] ) );
			return;
			}

		$checkout = $this->M_Transaksi->checkout ( $kode_transaksi );
		if ( ! $checkout )
			{
			$this->output
				->set_status_header ( 404 )
				->set_content_type ( 'application/json' )
				->set_output ( json_encode ( [ 
					'status'  => 'error',
					'message' => 'Transaksi tidak ditemukan.',
				] ) );
			return;
			}

		$harga = $this->M_Sampah->get_last_harga ( $checkout->id_sampah, 'transaksi' );
		if ( ! $harga )
			{
			$this->output
				->set_status_header ( 404 )
				->set_content_type ( 'application/json' )
				->set_output ( json_encode ( [ 
					'status'  => 'error',
					'message' => 'Harga tidak ditemukan.',
				] ) );
			return;
			}

		$total_harga = ( $checkout->berat / 1000 ) * $harga->harga_per_kg;
		$data        = [ 
			'id_harga'    => $harga->id_harga,
			'total_harga' => $total_harga,
		];

		$id_user_nasabah = $this->M_Nasabah->get_user ( $checkout->id_nasabah );
		$sampah          = $this->M_Sampah->get_sampah_by_id ( $checkout->id_sampah );
		$data_notifikasi = [ 
			'id_user' => $id_user_nasabah->id_user,
			'judul'   => 'Transaksi Diproses',
			'pesan'   => "Transaksi {$checkout->kode_transaksi} sampah {$sampah->nama_sampah} anda sedang diproses",
			'tipe'    => 'success',
		];

		if ( $this->M_Transaksi->checkout_process ( $kode_transaksi, $data ) )
			{
			$this->M_Notifikasi->tambah ( $data_notifikasi );
			$this->output
				->set_content_type ( 'application/json' )
				->set_output ( json_encode ( [ 
					'status'   => 'success',
					'message'  => 'Transaksi berhasil dicheckout!',
					'redirect' => site_url ( 'Manage-Transaksi' ),
				] ) );
			}
		else
			{
			$this->output
				->set_status_header ( 500 )
				->set_content_type ( 'application/json' )
				->set_output ( json_encode ( [ 
					'status'  => 'error',
					'message' => 'Gagal mencheckout transaksi!',
				] ) );
			}
		}

	private function _validate_transaksi ()
		{
		$this->load->library ( 'form_validation' );
		return $this->form_validation->run ( 'transaksi' );
		}

	private function _get_transaksi_data ()
		{
		if ( in_array ( $this->session->userdata ( 'role' ), $this->allowed_roles ) )
			{
			$id_user = $this->session->userdata ( 'id_user' );
			}

		return [ 
			'id_user'           => $id_user,
			'id_nasabah'        => $this->input->post ( 'id_nasabah', TRUE ),
			'id_sampah'         => $this->input->post ( 'id_sampah', TRUE ),
			'catatan_transaksi' => $this->input->post ( 'catatan_transaksi', TRUE ),
			'berat'             => $this->input->post ( 'berat', TRUE ),
		];
		}
	}