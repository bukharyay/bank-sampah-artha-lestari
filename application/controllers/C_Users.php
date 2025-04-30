<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * C_Users Controller
 * Handles user management operations
 */
class C_Users extends MY_Controller
	{
	protected $allowed_roles = [ 'admin' ];
	private $default_avatar = 'default.png';
	public $user_session = [];


	public function __construct ()
		{
		parent::__construct ();
		$this->load->model ( [ 'M_Users', 'M_Session' ] );
		$this->_check_auth ();
		}

	/**
	 * Display user management page
	 */
	public function index ()
		{

		$data = [ 
			'title'      => 'Management User',
			'rt_list'    => $this->M_Users->get_rt_list (),
			'greeting'   => get_greeting (),
			'data_users' => $this->M_Users->get_all_users (),
		];

		$this->_load_view ( $data );
		}



	/**
	 * Load views with error handling
	 */
	private function _load_view ( $data )
		{
		$views = [ 
			'Layout/App/V_header',
			'Layout/App/V_topbar',
			'Layout/App/V_sidebar',
			'Admin/V_userlist',
			'Layout/App/V_footer',
		];

		foreach ( $views as $view )
			{
			$this->load->view ( $view, $data );
			}
		}

	/**
	 * Add new user
	 */
	public function add_user ()
		{
		try
			{
			if ( $this->input->post ( 'role' ) === 'nasabah' )
				{
				if ( ! $this->form_validation->run ( 'manage-add-nasabah' ) )
					{
					return $this->index ();
					}
				}
			else
				{
				if ( ! $this->form_validation->run ( 'manage-add-user' ) )
					{
					return $this->index ();
					}
				}

			$data = $this->_get_user_data ();

			if ( ! empty ( $_FILES[ 'avatar' ][ 'name' ] ) )
				{
				$avatar = $this->_handle_avatar_upload ();
				if ( $avatar )
					{
					$data[ 'avatar' ] = $avatar;
					}
				}

			if ( $this->M_Users->register_user ( $data ) )
				{
				$this->session->set_flashdata ( 'success', 'User berhasil ditambahkan!' );
				}
			else
				{
				throw new Exception( 'Gagal menambahkan user' );
				}
			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error in add_user: ' . $e->getMessage () );
			$this->session->set_flashdata ( 'error', 'Gagal menambahkan user!' );
			}

		redirect ( 'Manage-Users' );
		}

	/**
	 * Update existing user
	 */
	public function edit_user ( $id_user )
		{
		try
			{

			$user = $this->M_Users->get_user_by_id ( $id_user );
			if ( ! $user )
				{
				throw new Exception( 'User  not found' );
				}

			$role = $user->role;

			if ( $role === 'nasabah' )
				{
				if ( ! $this->form_validation->run ( 'manage-edit-nasabah' ) )
					{
					return $this->index ();
					}
				}
			else
				{
				if ( ! $this->form_validation->run ( 'manage-edit-user' ) )
					{
					return $this->index ();
					}
				}

			$data = $this->_get_user_data ( true );

			if ( ! empty ( $_FILES[ 'avatar' ][ 'name' ] ) )
				{
				$avatar = $this->_handle_avatar_upload ();
				if ( $avatar )
					{
					$data[ 'avatar' ] = $avatar;
					$this->_delete_old_avatar ( $id_user );
					}
				}

			if ( $this->M_Users->update_user ( $id_user, $data ) )
				{
				$this->session->set_flashdata ( 'success', 'User berhasil diupdate!' );
				}
			else
				{
				throw new Exception( 'Gagal mengupdate user' );
				}
			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error in edit_user: ' . $e->getMessage () );
			$this->session->set_flashdata ( 'error', 'Gagal mengupdate user!' );
			}

		redirect ( 'Manage-Users' );
		}
	/**
	 * Delete user
	 */
	public function delete_user ( $id_user )
		{
		try
			{
			if ( ! $this->_validate_user_id ( $id_user ) )
				{
				throw new Exception( 'Invalid user ID' );
				}
			$this->_delete_old_avatar ( $id_user );
			if ( $this->M_Users->delete_user ( $id_user ) )
				{
				$this->session->set_flashdata ( 'success', 'User berhasil dihapus dan dilogoutkan!' );
				}
			else
				{
				throw new Exception( 'Gagal menghapus user' );
				}
			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error in delete_user: ' . $e->getMessage () );
			$this->session->set_flashdata ( 'error', 'Gagal menghapus user!' );
			}

		redirect ( 'Manage-Users' );
		}

	/**
	 * Validate user ID
	 */
	private function _validate_user_id ( $id_user )
		{
		return $this->M_Users->get_user_by_id ( $id_user ) !== null;
		}

	/**
	 * Get user data from POST
	 */

	private function _get_user_data ( $is_update = false )
		{
		$data     = [ 
			'email'     => $this->input->post ( 'email', TRUE ),
			'username'  => $this->input->post ( 'username', TRUE ),
			'role'      => $this->input->post ( 'role', TRUE ),
			'id_rt'     => $this->input->post ( 'id_rt', TRUE ),
			'nama'      => $this->input->post ( 'nama', TRUE ),
			'no_telfon' => $this->input->post ( 'no_telfon', TRUE ),
			'alamat'    => $this->input->post ( 'alamat', TRUE ),
		];
		$password = $this->input->post ( 'password' );
		if ( ! empty ( $password ) )
			{
			$data[ 'password' ] = password_hash ( $this->input->post ( 'password' ), PASSWORD_DEFAULT );
			}
		elseif ( ! $is_update )
			{
			$data[ 'password' ] = password_hash ( $this->input->post ( 'password' ), PASSWORD_DEFAULT );
			}

		return $data;
		}

	/**
	 * Handle avatar upload
	 */
	private function _handle_avatar_upload ()
		{
		$config[ 'upload_path' ]   = './assets/profile/avatars';
		$config[ 'allowed_types' ] = 'gif|jpg|jpeg|png';
		$config[ 'max_size' ]      = 2048;
		$config[ 'encrypt_name' ]  = TRUE;

		$this->load->library ( 'upload', $config );

		if ( ! $this->upload->do_upload ( 'avatar' ) )
			{
			$this->session->set_flashdata ( 'error', $this->upload->display_errors () );
			return false;
			}

		return $this->upload->data ( 'file_name' );
		}

	/**
	 * Delete old avatar file
	 */
	private function _delete_old_avatar ( $id_user )
		{
		$user = $this->M_Users->get_user_by_id ( $id_user );
		if ( $user && $user->avatar !== $this->default_avatar )
			{
			$file_path = './assets/profile/avatars/' . $user->avatar;
			if ( file_exists ( $file_path ) )
				{
				unlink ( $file_path );
				}
			}
		}

	/**
	 * Log user activity
	 */
	private function _log_activity ( $action, $description )
		{
		$log_data = [ 
			'user_id'     => $this->session->userdata ( 'id_user' ),
			'action'      => $action,
			'description' => $description,
			'ip_address'  => $this->input->ip_address (),
			'user_agent'  => $this->input->user_agent (),
			'created_at'  => date ( 'Y-m-d H:i:s' ),
		];
		}
	public function format_waktu ( $date_string = "2025-01-01 01:00:00" )
		{
		$date          = new DateTime( $date_string );
		$hari          = [ 'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu' ];
		$bulan         = [ 'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret', 'April' => 'April', 'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September', 'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember' ];
		$nama_hari     = $hari[ $date->format ( 'l' ) ];
		$nama_bulan    = $bulan[ $date->format ( 'F' ) ];
		$formated_date = "{$nama_hari}, {$date->format ( 'd' )} {$nama_bulan} {$date->format ( 'Y' )} | {$date->format ( 'H:i' )} WIB";

		return $formated_date;
		}

	public function check_username_exists ( $username )
		{
		$user_id = $this->input->post ( 'id_user' );
		if ( $this->M_Users->username_exists ( $username, $user_id ) )
			{
			$this->form_validation->set_message ( 'check_username_exists', 'Username sudah digunakan' );
			return FALSE;
			}
		return TRUE;
		}

	public function check_email_exists ( $email )
		{
		$user_id = $this->input->post ( 'id_user' );
		if ( $this->M_Users->email_exists ( $email, $user_id ) )
			{
			$this->form_validation->set_message ( 'check_email_exists', 'Email sudah digunakan' );
			return FALSE;
			}
		return TRUE;
		}

	public function check_rt_exists ( $id_rt )
		{
		if ( $this->M_Users->check_rt_exists ( $id_rt ) )
			{
			return TRUE;
			}
		$this->form_validation->set_message ( 'check_rt_exists', 'RT tidak ditemukan' );
		return FALSE;
		}
	}