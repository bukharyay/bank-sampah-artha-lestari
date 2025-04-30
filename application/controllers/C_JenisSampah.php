<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * Controller Jenis Sampah
 */

class C_JenisSampah extends MY_Controller
	{
	protected $allowed_roles = [ 'admin', 'petugas' ];
	public $user_session = [];

	public function __construct ()
		{
		parent::__construct ();
		$this->load->model ( 'M_Sampah' );
		$this->_check_auth ();
		}

	// ================= MAIN METHODS =================

	/**
	 * Display jenis sampah management page
	 */
	public function index ()
		{
		$data = [ 
			'title'             => 'Jenis Sampah',
			'greeting'          => get_greeting (),
			'data_jenis_sampah' => $this->M_Sampah->get_jenis_sampah (),
		];

		$this->_load_view ( $data );
		}

	// ================= CRUD OPERATIONS =================

	/**
	 * Add new jenis sampah
	 */
	public function add_jenis_sampah ()
		{
		if ( ! $this->_validate_jenis_sampah () )
			{
			$this->index ();
			return;
			}

		$data = $this->_get_jenis_sampah_data ();

		if ( $this->M_Sampah->add_jenis_sampah ( $data ) )
			{
			$this->session->set_flashdata ( 'success', 'Kategori Sampah berhasil ditambahkan!' );
			}
		else
			{
			$this->session->set_flashdata ( 'error', 'Gagal menambahkan Jenis sampah!' );
			}

		redirect ( 'Manage-Jenis-Sampah' );
		}

	/**
	 * Edit existing jenis sampah
	 */
	public function edit_jenis_sampah ( $id_jenis_sampah )
		{
		if ( ! $this->_validate_jenis_sampah () )
			{
			$this->index ();
			return;
			}

		$data = $this->_get_jenis_sampah_data ( true );

		if ( $this->M_Sampah->update_jenis_sampah ( $id_jenis_sampah, $data ) )
			{
			$this->session->set_flashdata ( 'success', 'Kategori Sampah berhasil diperbarui!' );
			}
		else
			{
			$this->session->set_flashdata ( 'error', 'Gagal memperbarui kategori sampah!' );
			}

		redirect ( 'Manage-Jenis-Sampah' );
		}

	/**
	 * Delete jenis sampah
	 */
	public function delete_jenis_sampah ( $id_jenis_sampah )
		{
		if ( $this->M_Sampah->delete_jenis_sampah ( $id_jenis_sampah ) )
			{
			$this->session->set_flashdata ( 'success', 'Kategori Sampah berhasil dihapus!' );
			}
		else
			{
			$this->session->set_flashdata ( 'error', 'Gagal menghapus kategori sampah!' );
			}

		redirect ( 'Manage-Jenis-Sampah' );
		}

	// ================= VALIDATION METHODS =================

	/**
	 * Check if jenis sampah exists
	 */
	public function check_jenis_sampah ( $id_jenis_sampah )
		{
		if ( ! $this->M_Sampah->jenis_sampah_exists ( $id_jenis_sampah ) )
			{
			$this->form_validation->set_message ( 'check_jenis_sampah', 'Jenis sampah tidak tersedia' );
			return false;
			}
		return true;
		}

	/**
	 * Validate jenis sampah input
	 */
	private function _validate_jenis_sampah ()
		{
		$this->load->library ( 'form_validation' );
		return $this->form_validation->run ( 'jenis_sampah' );
		}

	// ================= HELPER METHODS =================

	/**
	 * Get jenis sampah data from POST
	 */
	private function _get_jenis_sampah_data ( $is_edit = false )
		{
		$data = [ 
			'jenis_sampah' => $this->input->post ( 'jenis_sampah', true ),
		];

		if ( $is_edit )
			{
			$data[ 'id_jenis_sampah' ] = $this->input->post ( 'id_jenis_sampah', true );
			}

		return $data;
		}

	/**
	 * Load view with layout
	 */
	private function _load_view ( $data )
		{
		$views = [ 
			'Layout/App/V_header',
			'Layout/App/V_topbar',
			'Layout/App/V_sidebar',
			'Petugas/V_jenis_sampahlist',
			'Layout/App/V_footer',
		];

		foreach ( $views as $view )
			{
			$this->load->view ( $view, $data );
			}
		}
	}