<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * Controller Notifikasi
 */
class C_Notifikasi extends MY_Controller
	{
	protected $allowed_roles = [ 'admin', 'petugas', 'nasabah' ];
	public $user_session = [];
	public function __construct ()
		{
		parent::__construct ();
		$this->load->model ( 'M_Notifikasi' );
		$this->_check_auth ();
		}
	public function get_notifikasi ()
		{
		if ( ! $this->input->is_ajax_request () )
			{
			show_404 ();
			}

		$id_user      = $this->user_session->id_user;
		$notifikasi   = $this->M_Notifikasi->get_notifikasi ( $id_user );
		$unread_count = $this->M_Notifikasi->count_unread ( $id_user );

		$response = [ 
			'success'      => true,
			'notifikasi'   => $notifikasi,
			'unread_count' => $unread_count,
		];



		$this->output
			->set_content_type ( 'application/json' )
			->set_output ( json_encode ( $response ) );
		}

	// Tandai notifikasi sebagai dibaca
	public function mark_as_read ( $id_notifikasi )
		{
		if ( ! $this->input->is_ajax_request () )
			{
			show_404 ();
			}

		$this->M_Notifikasi->mark_as_read ( $id_notifikasi );
		$this->output
			->set_content_type ( 'application/json' )
			->set_output ( json_encode ( [ 'success' => true ] ) );
		}

	// Tandai semua notifikasi sebagai dibaca
	public function mark_all_as_read ()
		{
		if ( ! $this->input->is_ajax_request () )
			{
			show_404 ();
			}

		$id_user = $this->session->userdata ( 'id_user' );
		$this->M_Notifikasi->mark_all_as_read ( $id_user );
		$this->output
			->set_content_type ( 'application/json' )
			->set_output ( json_encode ( [ 'success' => true ] ) );
		}

	// Contoh membuat notifikasi
	public function contoh_notifikasi ()
		{
		$data = [ 
			'id_user' => $this->session->userdata ( 'id_user' ),
			'judul'   => 'Contoh Notifikasi',
			'pesan'   => 'Ini adalah contoh pesan notifikasi',
			'tipe'    => 'info',
		];

		$this->M_Notifikasi->tambah ( $data );
		echo 'Notifikasi berhasil dibuat';
		}

	// Di controller
	public function semua ()
		{
		$data = [ 
			'title'      => 'Semua Notifikasi',
			'notifikasi' => $this->M_Notifikasi->get_notifikasi ( $this->session->userdata ( 'id_user' ), 100 ),
		];

		$this->load->view ( 'Layout/App/V_header', $data );
		$this->load->view ( 'Layout/App/V_topbar', $data );
		$this->load->view ( 'Layout/App/V_sidebar', $data );
		$this->load->view ( 'Notifikasi/V_semua', $data );
		$this->load->view ( 'Layout/App/V_footer', $data );

		// Tandai semua sebagai dibaca saat halaman dimuat
		$this->M_Notifikasi->mark_all_as_read ( $this->session->userdata ( 'id_user' ) );
		}
	}