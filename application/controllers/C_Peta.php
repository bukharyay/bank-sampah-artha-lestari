<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * Controller Peta Wilayah Kerja
 */
class C_Peta extends MY_Controller
	{
	protected $allowed_roles = [ 'admin', 'petugas' ];
	public $user_session;

	public function __construct ()
		{
		parent::__construct ();
		$this->load->model ( 'M_Peta' );
		$this->_check_auth ();
		}


	public function index ()
		{
		$data = [ 
			'title'     => 'Hasil Karya',
			'greeting'  => get_greeting (),
			'locations' => $this->M_Peta->get_locations (),
		];

		;
		$this->load->view ( 'Layout/App/V_header', $data );
		$this->load->view ( 'Layout/App/V_topbar', $data );
		$this->load->view ( 'Layout/App/V_sidebar', $data );
		$this->load->view ( 'Petugas/V_peta', $data );
		$this->load->view ( 'Layout/App/V_footer', $data );
		}

	public function add_peta ()
		{
		if ( ! $this->form_validation->run ( 'add_peta' ) )
			{
			$errors = [];
			foreach ( $this->input->post () as $key => $val )
				{
				if ( form_error ( $key ) )
					{
					$errors[ $key ] = form_error ( $key, '<div class="error">', '</div>' );
					}
				}
			$this->output
				->set_status_header ( 422 )
				->set_content_type ( 'application/json' )
				->set_output ( json_encode ( [ 
					'status' => 'error',
					'errors' => $errors,
				] ) );


			return;
			}
		else
			{
			$data = [ 
				'id_user'     => html_escape ( $this->session->userdata ( 'id_user' ) ),
				'nama_lokasi' => html_escape ( $this->input->post ( 'nama_lokasi', true ) ),
				'latitude'    => html_escape ( $this->input->post ( 'latitude', true ) ),
				'longitude'   => html_escape ( $this->input->post ( 'longitude', true ) ),
				'alamat'      => html_escape ( $this->input->post ( 'alamat', true ) ),
			];

			if ( $this->M_Peta->save_location ( $data ) )
				{
				$this->session->set_flashdata ( 'success', 'Titik Lokasi berhasil ditambahkan!' );
				return $this->output
					->set_content_type ( 'application/json' )
					->set_output ( json_encode ( [ 'status' => 'success' ] ) );
				}
			else
				{
				$this->session->set_flashdata ( 'error', 'Gagal menambahkan Titik Lokasi!' );
				return $this->output
					->set_status_header ( 500 )
					->set_content_type ( 'application/json' )
					->set_output ( json_encode ( [ 
						'status'  => 'error',
						'message' => 'Gagal menambahkan Titik Lokasi!',
					] ) );
				}
			}
		}


	public function update_peta ( $id_lokasi )
		{
		if ( ! $this->form_validation->run ( 'add_peta' ) )
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
				'id_user'        => html_escape ( $this->user_session->id_user ),
				'nama_lokasi'    => html_escape ( $this->input->post ( 'nama_lokasi', true ) ),
				'latitude'       => html_escape ( $this->input->post ( 'latitude', true ) ),
				'longitude'      => html_escape ( $this->input->post ( 'longitude', true ) ),
				'alamat'         => html_escape ( $this->input->post ( 'alamat', true ) ),
				'tanggal_dibuat' => date ( 'Y-m-d H:i:s' ),
			];

			if ( $this->M_Peta->update_location ( $id_lokasi, $data ) )
				{
				$this->session->set_flashdata ( 'success', 'Titik Lokasi berhasil diupdate!' );
				return $this->output
					->set_content_type ( 'application/json' )
					->set_output ( json_encode ( [ 'status' => 'success' ] ) );
				}
			else
				{
				$this->session->set_flashdata ( 'error', 'Gagal update Titik Lokasi!' );
				return $this->output
					->set_status_header ( 500 )
					->set_content_type ( 'application/json' )
					->set_output ( json_encode ( [ 
						'status'  => 'error',
						'message' => 'Gagal update Titik Lokasi!',
					] ) );
				}
			}
		}

	public function delete_peta ( $id_lokasi )
		{
		// Validasi ID lokasi
		if ( empty ( $id_lokasi ) || ! is_numeric ( $id_lokasi ) )
			{
			$this->session->set_flashdata ( 'error', 'Invalid peta' );
			redirect ( 'Peta-Wilayah' );
			return;
			}

		$id_lokasi_post = html_escape ( $this->input->post ( 'id_lokasi', true ) );

		if ( $id_lokasi_post == $id_lokasi )
			{
			if ( $this->M_Peta->hapus_location ( $id_lokasi_post ) )
				{
				$this->session->set_flashdata ( 'success', 'Peta deleted successfully!' );
				}
			else
				{
				$this->session->set_flashdata ( 'error', 'Failed to delete peta. Please try again.' );
				}
			}
		else
			{
			$this->session->set_flashdata ( 'error', 'Invalid peta.' );
			}
		redirect ( 'Peta-Wilayah' );
		return;
		}
	}