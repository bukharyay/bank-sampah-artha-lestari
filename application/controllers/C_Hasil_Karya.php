<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * Controller Hasil Karya (Artikel)
 */

class C_Hasil_Karya extends MY_Controller
	{
	protected $allowed_roles = [ 'admin', 'petugas' ];
	public $user_session = [];
	protected $upload_config = [ 
		'upload_path'   => './assets/uploads/karya/',
		'allowed_types' => 'jpg|jpeg|png|gif',
		'max_size'      => 2048,
		'encrypt_name'  => true,
	];

	public function __construct ()
		{
		parent::__construct ();
		$this->load->model ( 'M_Hasil_Karya' );
		$this->load->library ( 'upload' );
		$this->_check_auth ();
		}

	// ================= MAIN METHODS =================

	/**
	 * Display karya management page
	 */
	public function index ()
		{
		$data = [ 
			'title'    => 'Manajemen Hasil Karya',
			'greeting' => get_greeting (),
			'karya'    => $this->M_Hasil_Karya->get_all_karya (),
		];

		$this->_load_admin_view ( 'Petugas/V_hasil_karya', $data );
		}

	/**
	 * Display add karya form
	 */
	public function add ()
		{
		$data = [ 
			'title'        => 'Add Hasil Karya',
			'greeting'     => get_greeting (),
			'jenis_sampah' => $this->M_Hasil_Karya->get_all_jenis_sampah (),
		];

		$this->_load_admin_view ( 'Petugas/V_hasil_karya_add', $data );
		}

	/**
	 * Display edit karya form
	 */
	public function edit ( $id )
		{
		$data = [ 
			'title'        => 'Edit Hasil Karya',
			'greeting'     => get_greeting (),
			'jenis_sampah' => $this->M_Hasil_Karya->get_all_jenis_sampah (),
			'karya'        => $this->M_Hasil_Karya->get_karya_by_id ( $id ),
		];

		$this->_load_admin_view ( 'Petugas/V_hasil_karya_edit', $data );
		}

	/**
	 * Display single karya detail (frontend)
	 */
	public function detail ( $id )
		{
		$data = [ 
			'karya'        => $this->M_Hasil_Karya->get_karya_by_id ( $id ),
			'recent_karya' => $this->M_Hasil_Karya->get_recent_karya (),
		];

		$this->load->view ( 'front/V_karya_detail', $data );
		}

	/**
	 * Display all karya (frontend)
	 */
	public function semua_karya ()
		{
		$data[ 'karya' ] = $this->M_Hasil_Karya->get_all_karya ();
		$this->load->view ( 'front/V_semua_karya', $data );
		}

	// ================= CRUD OPERATIONS =================

	/**
	 * Save new karya
	 */
	public function save ()
		{
		$this->_validate_karya_input ();

		if ( $this->form_validation->run () == false )
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => validation_errors (),
			], 422 );
			return;
			}

		$data             = $this->_prepare_karya_data ();
		$data[ 'gambar' ] = $this->_handle_image_upload () ?? 'default.jpg';

		if ( $this->M_Hasil_Karya->add_karya ( $data ) )
			{
			$this->_json_response ( [ 
				'status'  => 'success',
				'message' => 'Hasil karya berhasil ditambahkan',
			] );
			}
		else
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'Gagal menambahkan hasil karya',
			], 500 );
			}
		}

	/**
	 * Update existing karya
	 */
	public function update ( $id )
		{
		$this->_validate_karya_input ();

		if ( $this->form_validation->run () == false )
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => validation_errors (),
			], 422 );
			return;
			}

		$data      = $this->_prepare_karya_data ();
		$new_image = $this->_handle_image_upload ();

		if ( $new_image )
			{
			$this->_delete_old_image ( $id );
			$data[ 'gambar' ] = $new_image;
			}

		if ( $this->M_Hasil_Karya->update_karya ( $id, $data ) )
			{
			$this->_json_response ( [ 
				'status'  => 'success',
				'message' => 'Hasil karya berhasil diperbarui',
			] );
			}
		else
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'Gagal memperbarui hasil karya',
			], 500 );
			}
		}

	/**
	 * Delete karya
	 */
	public function delete ( $id )
		{
		$this->_delete_old_image ( $id );

		if ( $this->M_Hasil_Karya->delete_karya ( $id ) )
			{
			$this->_json_response ( [ 
				'status'  => 'success',
				'message' => 'Hasil karya berhasil dihapus',
			] );
			}
		else
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'Gagal menghapus hasil karya',
			], 500 );
			}
		}

	// ================= AJAX METHODS =================

	/**
	 * Get subcategories by jenis sampah ID
	 */
	public function get_subkategori ()
		{
		$id_jenis_sampah = $this->input->post ( 'id_jenis_sampah' );
		$subkategori     = $this->M_Hasil_Karya->get_sampah_by_jenis ( $id_jenis_sampah );

		$this->_json_response ( $subkategori );
		}

	// ================= HELPER METHODS =================

	/**
	 * Validate karya input
	 */
	private function _validate_karya_input ()
		{
		$this->form_validation->set_rules ( 'judul', 'Judul', 'required|max_length[255]' );
		$this->form_validation->set_rules ( 'konten', 'Konten', 'required' );
		$this->form_validation->set_rules ( 'id_jenis_sampah', 'Kategori Sampah', 'required|numeric' );
		$this->form_validation->set_rules ( 'id_sampah', 'Subkategori Sampah', 'numeric' );
		}

	/**
	 * Prepare karya data from POST
	 */
	private function _prepare_karya_data ()
		{
		return [ 
			'id_user'         => $this->user_session->id_user,
			'judul'           => $this->input->post ( 'judul' ),
			'konten'          => $this->input->post ( 'konten' ),
			'id_jenis_sampah' => $this->input->post ( 'id_jenis_sampah' ),
			'id_sampah'       => $this->input->post ( 'id_sampah' ) ?: null,
		];
		}

	/**
	 * Handle image upload
	 */
	private function _handle_image_upload ()
		{
		if ( empty ( $_FILES[ 'gambar' ][ 'name' ] ) )
			{
			return null;
			}

		$this->upload->initialize ( $this->upload_config );

		if ( ! $this->upload->do_upload ( 'gambar' ) )
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => $this->upload->display_errors (),
			], 422 );
			exit;
			}

		return $this->upload->data ( 'file_name' );
		}

	/**
	 * Delete old image file
	 */
	private function _delete_old_image ( $karya_id )
		{
		$karya = $this->M_Hasil_Karya->get_karya_by_id ( $karya_id );

		if (
			$karya->gambar !== 'default.jpg' &&
			file_exists ( $this->upload_config[ 'upload_path' ] . $karya->gambar )
		)
			{
			unlink ( $this->upload_config[ 'upload_path' ] . $karya->gambar );
			}
		}

	/**
	 * Load admin view with layout
	 */
	private function _load_admin_view ( $content_view, $data )
		{
		$views = [ 
			'Layout/App/V_header',
			'Layout/App/V_topbar',
			'Layout/App/V_sidebar',
			$content_view,
			'Layout/App/V_footer',
		];

		foreach ( $views as $view )
			{
			$this->load->view ( $view, $data );
			}
		}

	/**
	 * Send JSON response
	 */
	private function _json_response ( $data, $status_code = 200 )
		{
		$this->output
			->set_status_header ( $status_code )
			->set_content_type ( 'application/json' )
			->set_output ( json_encode ( $data ) );
		}
	}