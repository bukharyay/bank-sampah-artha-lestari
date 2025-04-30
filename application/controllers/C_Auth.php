<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * Controller Autentikasi
 */

class C_Auth extends MY_Controller
	{
	public function __construct ()
		{
		parent::__construct ();
		$this->allowed_roles = [];
		$this->load->model ( 'M_Users' );
		date_default_timezone_set ( 'Asia/Jakarta' );
		}

	public function validate_field ()
		{
		$this->output->set_content_type ( 'application/json' );

		$field     = $this->input->post ( 'field' );
		$value     = $this->input->post ( 'value' );
		$form_type = $this->input->post ( 'form_type' );

		// Handle password fields together
		if ( in_array ( $field, [ 'password', 'password_confirmation' ] ) )
			{
			$_POST[ 'password' ]              = $this->input->post ( 'password' ) ?? '';
			$_POST[ 'password_confirmation' ] = $this->input->post ( 'password_confirmation' ) ?? '';
			}

		$_POST[ $field ] = $value;


		// Set validation rules based on field and form type
		$validation_config = $this->get_validation_rules ( $field, $form_type );

		$this->form_validation->set_rules (
			$field,
			$validation_config[ 'label' ],
			$validation_config[ 'rules' ],
			$validation_config[ 'errors' ],
		);

		// Special handling for password confirmation
		if ( $field === 'password_confirmation' && $form_type == 'register' )
			{
			$this->form_validation->set_rules (
				'password',
				'Password',
				'required|min_length[6]',
				[ 
					'required'   => 'Password harus diisi',
					'min_length' => 'Password minimal 6 karakter',
				],
			);
			}

		// Run validation
		if ( $this->form_validation->run () == FALSE )
			{
			$error = strip_tags ( form_error ( $field ) );
			return $this->output->set_output ( json_encode ( [ 'error' => $error ] ) );
			}

		// Additional custom validation if needed
		if ( method_exists ( $this, 'validate_' . $field ) )
			{
			$validation_result = $this->{'validate_' . $field} ( $value, $form_type );
			if ( $validation_result !== true )
				{
				return $this->output->set_output ( json_encode ( [ 'error' => $validation_result ] ) );
				}
			}

		return $this->output->set_output ( json_encode ( [ 'success' => true ] ) );
		}

	/**
	 * Returns validation rules configuration for each field
	 */
	protected function get_validation_rules ( $field, $form_type )
		{
		$rules = [ 
			'username'              => [ 
				'register' => [ 
					'label'  => 'Username',
					'rules'  => 'trim|required|min_length[3]|max_length[20]|is_unique[tb_users.username]',
					'errors' => [ 
						'required'   => 'Username harus diisi',
						'is_unique'  => 'Username sudah terdaftar',
						'min_length' => 'Username minimal 3 karakter',
						'max_length' => 'Username maksimal 20 karakter',
					],
				],
				'login'    => [ 
					'label'  => 'Username',
					'rules'  => 'trim|required|min_length[3]|max_length[20]',
					'errors' => [ 
						'required'   => 'Username harus diisi',
						'min_length' => 'Username minimal 3 karakter',
						'max_length' => 'Username maksimal 20 karakter',
					],
				],
			],
			'email'                 => [ 
				'register' => [ 
					'label'  => 'Email',
					'rules'  => 'trim|required|valid_email|is_unique[tb_users.email]',
					'errors' => [ 
						'required'    => 'Email harus diisi',
						'is_unique'   => 'Email sudah terdaftar',
						'valid_email' => 'Format email tidak valid',
					],
				],
				'login'    => [ 
					'label'  => 'Email',
					'rules'  => 'trim|required|valid_email',
					'errors' => [ 
						'required'    => 'Email harus diisi',
						'valid_email' => 'Format email tidak valid',
					],
				],
			],
			'password'              => [ 
				'register' => [ 
					'label'  => 'Password',
					'rules'  => 'required|min_length[6]',
					'errors' => [ 
						'required'   => 'Password harus diisi',
						'min_length' => 'Password minimal 6 karakter',
					],
				],
				'login'    => [ 
					'label'  => 'Password',
					'rules'  => 'required',
					'errors' => [ 
						'required' => 'Password harus diisi',
					],
				],
			],
			'password_confirmation' => [ 
				'register' => [ 
					'label'  => 'Password',
					'rules'  => 'required|min_length[6]|matches[password]',
					'errors' => [ 
						'required'   => 'Password harus diisi',
						'min_length' => 'Password minimal 6 karakter',
						'matches'    => 'Password tidak sama',
					],
				],
			],
			'nama'                  => [ 
				'register' => [ 
					'label'  => 'Nama Lengkap',
					'rules'  => 'trim|required|min_length[3]|max_length[100]',
					'errors' => [ 
						'required'   => 'Nama lengkap harus diisi',
						'min_length' => 'Nama minimal 3 karakter',
						'max_length' => 'Nama maksimal 100 karakter',
					],
				],
			],
			'id_rt'                 => [ 
				'register' => [ 
					'label'  => 'RT/RW',
					'rules'  => 'required|callback_check_rt_exists',
					'errors' => [ 
						'required'        => 'RT/RW harus dipilih',
						'check_rt_exists' => 'RT tidak ditemukan',
					],
				],
			],
			'alamat'                => [ 
				'register' => [ 
					'label'  => 'Alamat',
					'rules'  => 'trim',
					'errors' => [],
				],
			],
			'no_telfon'             => [ 
				'register' => [ 
					'label'  => 'No Telepon',
					'rules'  => 'trim|numeric|min_length[10]|max_length[13]',
					'errors' => [ 
						'numeric'    => 'Nomor telepon harus angka',
						'min_length' => 'Nomor telepon minimal 10 digit',
						'max_length' => 'Nomor telepon maksimal 13 digit',
					],
				],
			],
		];

		// Return null if field not found
		if ( ! isset ( $rules[ $field ] ) )
			{
			return null;
			}

		// For fields that don't change between form types
		if ( ! isset ( $rules[ $field ][ $form_type ] ) )
			{
			return $rules[ $field ][ 'register' ] ?? null;
			}

		return $rules[ $field ][ $form_type ];
		}

	/**
	 * Additional custom validation methods can be added as needed
	 * Method name format: validate_{fieldname}
	 */
	protected function validate_no_telfon ( $value, $form_type )
		{
		if ( empty ( $value ) )
			{
			return true;
			}

		if ( ! preg_match ( '/^[0-9]{10,13}$/', $value ) )
			{
			return 'Format nomor telepon tidak valid (10-13 angka)';
			}

		return true;
		}


	/**
	 * Display login page
	 */
	public function index ()
		{

		if ( $this->session->userdata ( 'is_login' ) )
			{
			$this->redirect_by_role ();
			}

		$data[ 'title' ] = 'Login';

		if ( $this->form_validation->run ( 'login' ) == false )
			{
			$this->load->view ( 'Layout/Auth/V_header', $data );
			$this->load->view ( 'Auth/V_login', $data );
			$this->load->view ( 'Layout/Auth/V_footer', $data );
			}
		else
			{
			$this->_login ();
			}
		}

	/**
	 * Handle login process
	 */
	private function _login ()
		{
		$username = $this->input->post ( 'username', true );
		$password = $this->input->post ( 'password', true );

		$user = $this->db->get_where ( 'tb_users', [ 'username' => $username ] )->row_array ();

		if ( ! $user )
			{
			$this->session->set_flashdata ( 'warning', 'Pengguna tidak ditemukan' );
			redirect ( 'Auth-Login' );
			return;
			}

		if ( ! password_verify ( $password, $user[ 'password' ] ) )
			{
			$this->session->set_flashdata ( 'error', 'Password salah!' );
			redirect ( 'Auth-Login' );
			return;
			}

		$this->_setup_user_session ( $user );
		$this->_log_activity ( $user[ 'id_user' ], 'Login ke sistem' );

		// Redirect based on role
		switch ($user[ 'role' ])
			{
			case 'admin':
				redirect ( 'Dashboard-Admin' );
				break;
			case 'petugas':
				redirect ( 'Manage-Transaksi' );
				break;
			case 'nasabah':
				redirect ( 'Dashboard-Nasabah' );
				break;
			default:
				$this->logout ();
				break;
			}
		}

	public function session_valid_id ( $session_id )
		{
		return preg_match ( '/^[-,a-zA-Z0-9]{1,128}$/', $session_id ) > 0;
		}

	/**
	 * Set up user session after successful login
	 */
	private function _setup_user_session ( $user )
		{
		$session_id = session_id ();

		$this->session->sess_regenerate ();


		if ( $this->session_valid_id ( $session_id ) )
			{
			$this->db->where ( 'id', session_id () )->update ( 'ci_sessions', [ 
				'username' => $user[ 'username' ],
				'status'   => 1,
			] );
			}
		// Update last_login
		$this->db->where ( 'id_user', $user[ 'id_user' ] )
			->update ( 'tb_users', [ 'last_login' => date ( 'Y-m-d H:i:s' ) ] );

		// Get user name based on role
		$name = $user[ 'username' ];
		if ( $user[ 'role' ] === 'nasabah' )
			{
			$nasabah = $this->M_Users->get_user_by_id ( $user[ 'id_user' ] );
			$name    = $nasabah ? $nasabah->nama : 'Nasabah';
			}

		// Set session data
		$session_data = [ 
			'id_user'  => $user[ 'id_user' ],
			'name'     => $name,
			'role'     => $user[ 'role' ],
			'is_login' => true,
		];
		$this->session->set_userdata ( $session_data );
		$this->session->set_userdata ( 'username', $user[ 'username' ] );
		$this->session->set_userdata ( 'status', 1 );
		}

	/**
	 * Display registration page
	 */
	public function register ()
		{
		if ( $this->session->userdata ( 'is_login' ) )
			{
			$this->redirect_by_role ();
			}

		$data = [ 
			'rt_list' => $this->M_Users->get_rt_list (),
			'title'   => 'Register',
		];

		if ( $this->form_validation->run ( 'register' ) == false )
			{
			$this->load->view ( 'Layout/Auth/V_header', $data );
			$this->load->view ( 'Auth/V_register', $data );
			$this->load->view ( 'Layout/Auth/V_footer', $data );
			}
		else
			{
			$this->_register_process ();
			}
		}

	/**
	 * Handle registration process
	 */
	private function _register_process ()
		{
		$user_data = [ 
			'email'    => $this->input->post ( 'email', true ),
			'username' => $this->input->post ( 'username', true ),
			'password' => password_hash ( $this->input->post ( 'password' ), PASSWORD_DEFAULT ),
			'role'     => 'nasabah',
		];

		$nasabah_data = [ 
			'nama'      => $this->input->post ( 'nama', true ),
			'no_telfon' => $this->input->post ( 'no_telfon', true ),
			'avatar'    => 'default.png',
			'alamat'    => $this->input->post ( 'alamat', true ),
			'id_rt'     => $this->input->post ( 'id_rt', true ),
		];

		$combined_data = array_merge ( $user_data, $nasabah_data );
		$id_user       = $this->M_Users->register_user ( $combined_data );

		if ( ! $id_user )
			{
			$this->session->set_flashdata ( 'error', 'Terjadi kesalahan saat membuat akun.' );
			redirect ( 'Auth-Register' );
			return;
			}

		$this->_setup_new_user_session ( $id_user, $user_data[ 'username' ] );
		$this->_log_activity ( $id_user, 'Login akun baru ke sistem' );

		$this->session->set_flashdata ( 'message', 'Akun berhasil dibuat! Silakan login.' );
		redirect ( 'Auth-Login' );
		}

	/**
	 * Set up session for newly registered user
	 */
	private function _setup_new_user_session ( $id_user, $username )
		{
		$this->session->sess_regenerate ();

		$session_data = [ 
			'id_user'  => $id_user,
			'name'     => $username,
			'role'     => 'nasabah',
			'is_login' => true,
		];

		$this->session->set_userdata ( $session_data );
		$this->session->set_userdata ( 'username', $username );
		$this->session->set_userdata ( 'status', 1 );
		$this->db->where ( 'id', get_cookie ( 'ci_session' ) )->update ( 'ci_sessions', [ 
			'username' => $username,
			'status'   => 1,
		] );
		}

	/**
	 * Log user activity
	 */
	private function _log_activity ( $user_id, $action )
		{
		$log_data = [ 
			'id_user' => $user_id,
			'aksi'    => $action,
			'tanggal' => date ( 'Y-m-d H:i:s' ),
		];
		$this->db->insert ( 'tb_log_aktivitas', $log_data );
		}

	/**
	 * Log out user
	 */
	public function logout ()
		{
		$this->db->where ( 'username', $this->session->userdata ( 'username' ) )->delete ( 'ci_sessions' );
		$this->session->sess_destroy ();
		redirect ( 'Auth-Login' );
		}

	/**
	 * Check if RT exists
	 */
	public function check_rt_exists ( $id_rt )
		{
		if ( $this->M_Users->check_rt_exists ( $id_rt ) )
			{
			return true;
			}
		$this->form_validation->set_message ( 'check_rt_exists', 'RT tidak ditemukan' );
		return false;
		}
	}