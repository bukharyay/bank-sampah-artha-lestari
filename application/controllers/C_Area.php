<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * Controller Area & Wilayah RT RW
 */

class C_Area extends MY_Controller
	{
	protected $allowed_roles = [ 'admin', 'petugas' ];
	public $user_session = [];

	public function __construct ()
		{
		parent::__construct ();
		$this->load->model ( 'M_Area' );
		$this->_check_auth ();
		}

	// ================= MAIN AREA VIEW =================

	/**
	 * Display area management page
	 */
	public function index ()
		{
		$data = [ 
			'title'    => 'Manajemen Area',
			'greeting' => get_greeting (),
			'rw_list'  => $this->M_Area->get_all_rw (),
			'rt_list'  => $this->M_Area->get_all_rt (),
		];

		$this->_load_view ( $data );
		}

	/**
	 * Load area management view
	 */
	private function _load_view ( $data )
		{
		$views = [ 
			'Layout/App/V_header',
			'Layout/App/V_topbar',
			'Layout/App/V_sidebar',
			'Petugas/V_area',
			'Layout/App/V_footer',
		];

		foreach ( $views as $view )
			{
			$this->load->view ( $view, $data );
			}
		}

	// ================= RW MANAGEMENT =================

	/**
	 * Add new RW
	 */
	public function rw_add ()
		{
		$this->form_validation->set_rules ( 'rw', 'Nomor RW', 'required|numeric' );

		if ( $this->form_validation->run () === false )
			{
			$this->_json_response ( [ 
				'status' => 'error',
				'errors' => $this->form_validation->error_array (),
			], 412 );
			return;
			}

		$data = [ 'rw' => $this->input->post ( 'rw' ) ];

		if ( $this->M_Area->is_rw_exists ( $data[ 'rw' ] ) )
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => [ 'RW sudah ada' ],
			], 409 );
			return;
			}

		if ( $this->M_Area->add_rw ( $data ) )
			{
			$this->_json_response ( [ 
				'status'  => 'success',
				'message' => 'RW berhasil ditambahkan',
				'data'    => $this->M_Area->get_all_rw (),
			] );
			}
		else
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'Gagal menambahkan RW',
			], 500 );
			}
		}

	/**
	 * Edit existing RW
	 */
	public function rw_edit ( $id_rw )
		{
		$rw = $this->M_Area->get_rw ( $id_rw );
		if ( ! $rw )
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'Data RW tidak ditemukan',
			], 404 );
			return;
			}

		$this->form_validation->set_rules ( 'rw', 'Nomor RW', 'required|numeric' );

		if ( $this->form_validation->run () === false )
			{
			$this->_json_response ( [ 
				'status' => 'error',
				'errors' => $this->form_validation->error_array (),
			], 412 );
			return;
			}

		$new_rw = $this->input->post ( 'rw' );

		if ( $rw->rw != $new_rw && $this->M_Area->is_rw_exists ( $new_rw ) )
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => [ 'RW sudah ada' ],
			], 409 );
			return;
			}

		if ( $this->M_Area->update_rw ( $id_rw, [ 'rw' => $new_rw ] ) )
			{
			$this->_json_response ( [ 
				'status'  => 'success',
				'message' => 'RW berhasil diupdate',
				'data'    => $this->M_Area->get_all_rw (),
			] );
			}
		else
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'Gagal mengupdate RW',
			], 500 );
			}
		}

	/**
	 * Delete RW
	 */
	public function rw_delete ( $id_rw )
		{
		$rw = $this->M_Area->get_rw ( $id_rw );
		if ( ! $rw )
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'Data RW tidak ditemukan',
			], 404 );
			return;
			}

		if ( $this->M_Area->count_rt_in_rw ( $id_rw ) > 0 )
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'Tidak bisa menghapus RW karena masih memiliki RT',
			], 400 );
			return;
			}

		if ( $this->M_Area->delete_rw ( $id_rw ) )
			{
			$this->_json_response ( [ 
				'status'  => 'success',
				'message' => 'RW berhasil dihapus',
				'data'    => $this->M_Area->get_all_rw (),
			] );
			}
		else
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'Gagal menghapus RW',
			], 500 );
			}
		}

	// ================= RT MANAGEMENT =================

	/**
	 * Add new RT
	 */
	public function rt_add ()
		{
		$this->form_validation->set_rules ( 'id_rw', 'RW', 'required' );
		$this->form_validation->set_rules ( 'rt', 'Nomor RT', 'required|numeric' );

		if ( $this->form_validation->run () === false )
			{
			$this->_json_response ( [ 
				'status' => 'error',
				'errors' => $this->form_validation->error_array (),
			], 412 );
			return;
			}

		$id_rw = $this->input->post ( 'id_rw' );
		$rt    = $this->input->post ( 'rt' );

		if ( $this->M_Area->is_rt_exists ( $id_rw, $rt ) )
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'RT sudah ada di RW tersebut',
			], 409 );
			return;
			}

		$data = [ 
			'id_rw'          => $id_rw,
			'rt'             => $rt,
			'nama_ketua_pkk' => null,
		];

		if ( $this->M_Area->add_rt ( $data ) )
			{
			$this->_json_response ( [ 
				'status'  => 'success',
				'message' => 'RT berhasil ditambahkan',
				'data'    => $this->M_Area->get_all_rt (),
			] );
			}
		else
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'Gagal menambahkan RT',
			], 500 );
			}
		}

	/**
	 * Edit existing RT
	 */
	public function rt_edit ( $id_rt )
		{
		$rt = $this->M_Area->get_rt ( $id_rt );
		if ( ! $rt )
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'Data RT tidak ditemukan',
			], 404 );
			return;
			}

		$this->form_validation->set_rules ( 'id_rw', 'RW', 'required' );
		$this->form_validation->set_rules ( 'rt', 'Nomor RT', 'required|numeric' );

		if ( $this->form_validation->run () === false )
			{
			$this->_json_response ( [ 
				'status' => 'error',
				'errors' => $this->form_validation->error_array (),
			], 412 );
			return;
			}

		$id_rw     = $this->input->post ( 'id_rw' );
		$rt_number = $this->input->post ( 'rt' );

		if (
			( $rt->id_rw != $id_rw || $rt->rt != $rt_number ) &&
			$this->M_Area->is_rt_exists ( $id_rw, $rt_number, $id_rt )
		)
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'RT sudah ada di RW tersebut',
			], 409 );
			return;
			}

		$data = [ 
			'id_rw' => $id_rw,
			'rt'    => $rt_number,
		];

		if ( $this->M_Area->update_rt ( $id_rt, $data ) )
			{
			$this->_json_response ( [ 
				'status'  => 'success',
				'message' => 'RT berhasil diupdate',
				'data'    => $this->M_Area->get_all_rt (),
			] );
			}
		else
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'Gagal mengupdate RT',
			], 500 );
			}
		}

	/**
	 * Delete RT
	 */
	public function rt_delete ( $id_rt )
		{
		$rt = $this->M_Area->get_rt ( $id_rt );
		if ( ! $rt )
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'Data RT tidak ditemukan',
			], 404 );
			return;
			}

		if ( $this->M_Area->count_nasabah_in_rt ( $id_rt ) > 0 )
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'Tidak bisa menghapus RT karena masih memiliki Nasabah',
			], 400 );
			return;
			}

		if ( $this->M_Area->delete_rt ( $id_rt ) )
			{
			$this->_json_response ( [ 
				'status'  => 'success',
				'message' => 'RT berhasil dihapus',
				'data'    => $this->M_Area->get_all_rt (),
			] );
			}
		else
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'Gagal menghapus RT',
			], 500 );
			}
		}

	// ================= KETUA PKK MANAGEMENT =================

	/**
	 * Display PKK leader management page
	 */
	public function ketua_pkk ( $id_rt )
		{
		$rt = $this->M_Area->get_rw_by_rt ( $id_rt );
		if ( ! $rt ) show_404 ();

		$data = [ 
			'title'         => 'Set Ketua PKK',
			'greeting'      => get_greeting (),
			'rt'            => $rt,
			'nasabah_list'  => $this->M_Area->get_nasabah_by_rt ( $id_rt ),
			'current_ketua' => $this->M_Area->get_current_ketua_pkk ( $id_rt ),
		];

		$this->_load_ketua_pkk_view ( $data );
		}

	/**
	 * Load PKK leader management view
	 */
	private function _load_ketua_pkk_view ( $data )
		{
		$views = [ 
			'Layout/App/V_header',
			'Layout/App/V_topbar',
			'Layout/App/V_sidebar',
			'Petugas/V_ketua_pkk',
			'Layout/App/V_footer',
		];

		foreach ( $views as $view )
			{
			$this->load->view ( $view, $data );
			}
		}

	/**
	 * Set PKK leader
	 */
	public function set_ketua_pkk ( $id_rt )
		{
		$this->form_validation->set_rules ( 'id_nasabah', 'Nasabah', 'required' );

		if ( $this->form_validation->run () === false )
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'Nasabah harus dipilih',
			], 412 );
			return;
			}

		$id_nasabah = $this->input->post ( 'id_nasabah' );

		$nasabah = $this->db->get_where ( 'tb_nasabah', [ 
			'id_nasabah' => $id_nasabah,
			'id_rt'      => $id_rt,
		] )->row ();

		if ( ! $nasabah )
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'Nasabah tidak valid',
			], 400 );
			return;
			}

		if ( $this->M_Area->set_ketua_pkk ( $id_rt, $id_nasabah ) )
			{
			$this->_json_response ( [ 
				'status'  => 'success',
				'message' => 'Ketua PKK berhasil diupdate',
				'data'    => $this->M_Area->get_rt ( $id_rt ),
			] );
			}
		else
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'Gagal mengupdate Ketua PKK',
			], 500 );
			}
		}

	/**
	 * Remove PKK leader
	 */
	public function remove_ketua_pkk ( $id_rt )
		{
		$rt = $this->M_Area->get_rt ( $id_rt );
		if ( ! $rt )
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'Data RT tidak ditemukan',
			], 404 );
			return;
			}

		if ( $this->M_Area->remove_ketua_pkk ( $id_rt ) )
			{
			$this->_json_response ( [ 
				'status'  => 'success',
				'message' => 'Ketua PKK berhasil dicopot',
				'data'    => $this->M_Area->get_rt ( $id_rt ),
			] );
			}
		else
			{
			$this->_json_response ( [ 
				'status'  => 'error',
				'message' => 'Gagal mencopot Ketua PKK',
			], 500 );
			}
		}

	// ================= HELPER METHODS =================

	/**
	 * Send JSON response
	 */
	private function _json_response ( $data, $status_code = 200 )
		{
		// Ensure all error messages are arrays
		if ( $data[ 'status' ] === 'error' && isset ( $data[ 'message' ] ) && ! is_array ( $data[ 'message' ] ) )
			{
			$data[ 'message' ] = [ $data[ 'message' ] ];
			}

		$this->output
			->set_status_header ( $status_code )
			->set_content_type ( 'application/json' )
			->set_output ( json_encode ( $data ) );
		}
	}