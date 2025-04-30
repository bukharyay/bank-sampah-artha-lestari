<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class MY_Controller extends CI_Controller
	{
	protected $allowed_roles = [];
	protected $user_session = [];
	protected $default_redirect = [ 
		'admin'   => 'Dashboard-Admin',
		'petugas' => 'Manage-Transaksi',
		'nasabah' => 'Dashboard-Nasabah',
	];

	public function __construct ()
		{
		parent::__construct ();
		}

	/**
	 * Check user authentication and authorization
	 */
	protected function _check_auth ()
		{
		$this->load->library ( 'UserSession' );

		// Check login
		if ( ! $this->session->userdata ( 'is_login' ) )
			{
			redirect ( 'Auth-Login' );
			}

		// Check role
		$current_role = $this->session->userdata ( 'role' );
		if ( ! empty ( $this->allowed_roles ) )
			{
			if ( ! in_array ( $current_role, $this->allowed_roles ) )
				{
				show_error ( 'The action you have requested is not allowed.', 403, 'Forbidden', 'error_403' );
				}
			}

		$this->user_session = $this->usersession->get_user_data ();
		}

	/**
	 * Redirect user based on their role
	 */
	protected function redirect_by_role ()
		{
		if ( $this->session->userdata ( 'is_login' ) )
			{
			$role = $this->session->userdata ( 'role' );
			redirect ( $this->default_redirect[ $role ] ?? 'Auth-Login' );
			}
		return;
		}
	}