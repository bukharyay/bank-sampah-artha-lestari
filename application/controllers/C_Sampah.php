<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * Controller Sampah dan Harga Sampah
 */

class C_Sampah extends MY_Controller
	{
	protected $allowed_roles = [ 'admin', 'petugas' ];
	public $user_session = [];

	public function __construct ()
		{
		parent::__construct ();
		$this->load->model ( 'M_Sampah' );
		$this->_check_auth ();
		}

	public function validate_date ( $date = '0-0-0' )
		{
		// Check date format (YYYY-MM-DD)
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

	public function check_jenis_sampah ( $id_jenis_sampah )
		{
		if ( ! $this->M_Sampah->jenis_sampah_exists ( $id_jenis_sampah ) )
			{
			$this->form_validation->set_message ( 'check_jenis_sampah', 'Jenis sampah tidak tersedia' );
			return FALSE;
			}
		return TRUE;
		}

	public function check_sampah ( $id_sampah )
		{
		if ( ! $this->M_Sampah->sampah_exists ( $id_sampah ) )
			{
			$this->form_validation->set_message ( 'check_sampah', 'Sampah tidak tersedia' );
			return FALSE;
			}
		return TRUE;
		}

	public function check_harga ( $id_sampah )
		{

		$data = [ 
			'id_sampah' => $this->input->post ( 'id_sampah' ),
			'periode'   => $this->input->post ( 'periode' ),
		];

		if ( $this->M_Sampah->existing_harga ( $data ) )
			{
			$this->form_validation->set_message ( 'check_harga', 'Data Harga untuk periode ini sudah digunakan, jika ada kesalahan mohon lakukan rollback' );
			return FALSE;
			}
		return TRUE;
		}

	public function search_pilih_sampah ()
		{
		$search_term = $this->input->get ( 'search' ) ?? '';

		$sampah = $this->M_Sampah->search_sampah ( $search_term );
		$this->output
			->set_content_type ( 'application/json' )
			->set_output ( json_encode ( $sampah ) );

		}

	public function index ()
		{
		$data = [ 
			'title'             => 'Sampah',
			'greeting'          => get_greeting (),
			'data_sampah'       => $this->M_Sampah->get_all_sampah (),
			'data_jenis_sampah' => $this->M_Sampah->get_jenis_sampah (),
			'data_harga_sampah' => $this->M_Sampah->get_latest_prices (),
		];


		$this->_load_view ( $data );
		}


	private function _load_view ( $data )
		{


		$views = [ 
			'Layout/App/V_header',
			'Layout/App/V_topbar',
			'Layout/App/V_sidebar',
			'Petugas/V_sampahlist',
			'Layout/App/V_footer',
		];


		foreach ( $views as $view )
			{
			$this->load->view ( $view, $data );
			}
		}
	public function update_harga ( $id_sampah )
		{
		$this->form_validation->set_error_delimiters ( '', '' );
		if ( ! $this->form_validation->run ( 'harga_sampah' ) )
			{
			http_response_code ( 412 );
			header ( 'Content-Type: application/json' );
			echo json_encode ( [ 
				'status' => 'error',
				'errors' => validation_errors (),
			] );
			}
		else
			{

			$data = [ 
				'id_sampah'    => $this->input->post ( 'id_sampah', true ) == $id_sampah ? $id_sampah : '0',
				'harga_per_kg' => $this->input->post ( 'harga_per_kg', true ),
				'periode'      => $this->input->post ( 'periode', true ) ?? date ( 'Y-m-d' )
			];


			if ( $this->M_Sampah->update_harga ( $data ) )
				{
				$this->session->set_flashdata ( 'success', 'Harga berhasil diupdate!' );
				header ( 'Content-Type: application/json' );
				echo json_encode ( [ 'status' => 'success' ] );
				}
			else
				{
				$this->session->set_flashdata ( 'error', 'Gagal update harga!' );
				header ( 'Content-Type: application/json' );
				echo json_encode ( [ 'status' => 'error', 'message' => 'Gagal update harga!' ] );
				}
			}
		}

	public function get_last_harga ( $id_sampah )
		{
		$last_harga = $this->M_Sampah->get_last_harga ( $id_sampah );
		echo json_encode ( $last_harga );
		}

	public function delete_harga ( $id_sampah )
		{
		$id_sampah_post = $this->input->post ( 'id_sampah', true ) == $id_sampah ? $id_sampah : '0';

		// Validate input
		if ( empty ( $id_sampah_post ) )
			{
			throw new Exception( "ID sampah tidak valid" );
			}

		if ( $this->M_Sampah->rollback_latest_harga ( $id_sampah_post ) )
			{
			$this->session->set_flashdata ( 'success', 'Harga berhasil dirollback!' );
			header ( 'Content-Type: application/json' );
			echo json_encode ( [ 'status' => "success" ] );
			}
		else
			{
			$this->session->set_flashdata ( 'error', 'Gagal rollback harga!' );
			header ( 'Content-Type: application/json' );
			echo json_encode ( [ 'status' => 'error', 'message' => 'Tidak ada cukup data untuk rollback.' ] );
			}

		}


	public function add_sampah ()
		{
		if ( ! $this->_validate_sampah () )
			{
			return $this->index ();
			}

		$data = $this->_get_sampah_data ();

		if ( $this->M_Sampah->add_sampah ( $data ) )
			{
			$this->session->set_flashdata ( 'success', 'Sampah berhasil ditambahkan!' );
			}
		else
			{
			$this->session->set_flashdata ( 'error', 'Gagal menambahkan sampah!' );
			}

		redirect ( 'Manage-Sampah' );
		}

	private function _validate_sampah ()
		{
		$this->load->library ( 'form_validation' );
		return $this->form_validation->run ( 'sampah' );
		}

	private function _get_sampah_data ()
		{
		return [ 
			'id_jenis_sampah' => html_escape ( $this->input->post ( 'id_jenis_sampah', TRUE ) ),
			'nama_sampah'     => html_escape ( $this->input->post ( 'nama_sampah', TRUE ) ),
		];
		}

	public function edit_sampah ( $idSampah )
		{
		$id_sampah = $this->input->post ( 'id_sampah', true ) == $idSampah ? $idSampah : '';
		if ( $this->form_validation->run ( 'sampah' ) == false )
			{
			$this->index ();
			}
		else
			{
			if ( $id_sampah != '' )
				{
				if ( $this->_edit_sampah_process ( $id_sampah ) )
					{
					$this->session->set_flashdata ( 'success', 'Sampah updated successfully!' );
					}
				else
					{
					$this->session->set_flashdata ( 'error', 'Failed to update sampah. Please try again.' );
					}
				}
			else
				{
				$this->session->set_flashdata ( 'warning', 'Data Sampah tidak valid!' );
				return FALSE;
				}
			redirect ( 'Manage-Sampah' );
			}
		}

	private function _edit_sampah_process ( $idSampah )
		{
		$data = [ 
			'id_jenis_sampah' => html_escape ( $this->input->post ( 'id_jenis_sampah', true ) ),
			'nama_sampah'     => html_escape ( $this->input->post ( 'nama_sampah', true ) ),
		];
		return $this->M_Sampah->update_sampah ( $idSampah, $data );
		}

	public function delete_sampah ( $id_sampah )
		{
		// Validasi ID sampah
		if ( empty ( $id_sampah ) || ! is_numeric ( $id_sampah ) )
			{
			$this->session->set_flashdata ( 'error', 'Invalid sampah ' );
			redirect ( 'Manage-Sampah' );
			return;
			}

		$id_sampah_post = html_escape ( $this->input->post ( 'id_sampah', true ) );

		if ( $id_sampah_post == $id_sampah )
			{
			if ( $this->M_Sampah->delete_sampah ( $id_sampah_post ) )
				{
				$this->session->set_flashdata ( 'success', 'Sampah deleted successfully!' );
				}
			else
				{
				$this->session->set_flashdata ( 'error', 'Failed to delete sampah. Please try again.' );
				}
			}
		else
			{
			$this->session->set_flashdata ( 'error', 'Invalid sampah.' );
			}
		redirect ( 'Manage-Sampah' );
		}
	}