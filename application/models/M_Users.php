<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class M_Users extends CI_Model
	{
	// Constants
	private const DEFAULT_AVATAR = 'default.png';

	// Table names
	private $tables = [ 
		'users'    => 'tb_users',
		'nasabah'  => 'tb_nasabah',
		'tabungan' => 'tb_tabungan_nasabah',
		'log'      => 'tb_log_aktivitas',
		'rt'       => 'tb_rt',
		'rw'       => 'tb_rw',
	];

	public function __construct ()
		{
		parent::__construct ();
		date_default_timezone_set ( 'Asia/Jakarta' );
		}

	/**
	 * Get all users with their related data
	 * @return array
	 */

	public function hitung_total_nasabah ()
		{
		return $this->db->where ( 'role', 'nasabah' )
			->count_all_results ( $this->tables[ 'users' ] );
		}

	public function get_staff_and_admins ()
		{
		return $this->db->select ( 'id_user' )
			->from ( 'tb_users' )
			->where_in ( 'role', [ 'petugas', 'admin' ] )
			->get ()
			->result_array ();
		}
	public function get_all_users ()
		{
		$select_fields = [ 
			"u.id_user",
			"u.email",
			"u.username",
			"u.role",
			"u.created_at as user_created_at",
			"u.updated_at as user_updated_at",
			"n.id_rt",
			"n.nama",
			"n.no_telfon",
			"n.alamat",
			"n.avatar",
			"n.created_at as nasabah_created_at",
			"n.updated_at as nasabah_updated_at",
		];

		return $this->db->select ( $select_fields )
			->from ( "{$this->tables[ 'users' ]} as u" )
			->join ( "{$this->tables[ 'nasabah' ]} as n", "u.id_user = n.id_user", "left" )
			->order_by ( 'u.id_user', 'DESC' )
			->get ()
			->result ();
		}
	public function get_all_nasabah ()
		{
		$select_fields = [ 
			"u.id_user",
			"u.email",
			"u.username",
			"u.role",
			"u.created_at as user_created_at",
			"u.updated_at as user_updated_at",
			"n.id_rt",
			"n.nama",
			"n.no_telfon",
			"n.alamat",
			"n.avatar",
			"n.created_at as nasabah_created_at",
			"n.updated_at as nasabah_updated_at",
			"rt.rt",
			"rw.rw",
			"CONCAT('[ RT ', rt.rt, ' / RW ', rw.rw, ']') as rt_rw",
			"t.jumlah_tabungan",
		];

		return $this->db->select ( $select_fields )
			->from ( $this->tables[ 'users' ] . ' u' )
			->join ( $this->tables[ 'nasabah' ] . ' n', "u.id_user = n.id_user", "left" )
			->join ( $this->tables[ 'rt' ] . ' rt', "n.id_rt = rt.id_rt", "left" )
			->join ( $this->tables[ 'rw' ] . ' rw', "rt.id_rw = rw.id_rw", "left" )
			->join ( $this->tables[ 'tabungan' ] . ' t', "n.id_nasabah = t.id_nasabah", "left" )
			->where ( "u.role", "nasabah" )
			->order_by ( 'user_created_at', 'DESC' )
			->get ()
			->result ();
		}

	/**
	 * Get user by ID with related data
	 * @param int $id_user
	 * @return object|null
	 */
	// public function get_user_by_id ( $id_user )
	// 	{
	// 	$select_fields = [ 
	// 		"u.*",
	// 		"n.id_nasabah",
	// 		"n.nama",
	// 		"n.no_telfon",
	// 		"n.alamat",
	// 		"n.avatar",
	// 	];

	// 	return $this->db->select ( $select_fields )
	// 		->from ( "{$this->tables[ 'users' ]} as u" )
	// 		->join ( "{$this->tables[ 'nasabah' ]} as n", "u.id_user = n.id_user", "left" )
	// 		->where ( "u.id_user", $id_user )
	// 		->get ()
	// 		->row ();
	// 	}

	public function get_user_by_id ( $id_user )
		{
		$select_fields = [ 
			"u.id_user",
			"u.email",
			"u.username",
			"u.role",
			"u.created_at as user_created_at",
			"u.updated_at as user_updated_at",
			"n.id_nasabah",
			"n.id_rt",
			"n.nama",
			"n.no_telfon",
			"n.alamat",
			"n.avatar",
			"n.ketua_pkk",
			"n.created_at as nasabah_created_at",
			"n.updated_at as nasabah_updated_at",
			"rt.rt",
			"rt.id_rw",
			"rw.rw",
		];

		$query = $this->db->select ( $select_fields )
			->from ( "{$this->tables[ 'users' ]} as u" )
			->join ( "{$this->tables[ 'nasabah' ]} as n", "u.id_user = n.id_user", "left" );

		$query->join ( "{$this->tables[ 'rt' ]} as rt", "n.id_rt = rt.id_rt", "left" )
			->join ( "{$this->tables[ 'rw' ]} as rw", "rt.id_rw = rw.id_rw", "left" );

		return $query->where ( "u.id_user", $id_user )
			->get ()
			->row ();
		}

	public function get_user_by_username ( $username )
		{
		$selected_fields = [ 
			"u.username",
		];
		$_username       = $this->db->select ( $selected_fields )
			->from ( "{$this->tables[ 'users' ]} as u" )
			->where ( "u.username", $username )
			->get ()->row ();
		return $_username;
		}

	/**
	 * Register new user
	 * @param array $data
	 * @return int|false
	 */
	public function register_user ( $data )
		{
		$this->db->trans_begin ();

		try
			{
			// Prepare user data
			$user_data = $this->prepare_user_data ( $data );
			$this->db->insert ( $this->tables[ 'users' ], $user_data );
			$id_user = $this->db->insert_id ();

			// Insert nasabah data if role is nasabah
			if ( $data[ 'role' ] === 'nasabah' )
				{
				$nasabah_data = $this->prepare_nasabah_data ( $data, $id_user );
				$this->db->insert ( $this->tables[ 'nasabah' ], $nasabah_data );
				}

			// Log the registration
			$this->log_activity ( $id_user, "Registrasi akun {$data[ 'role' ]} baru" );

			if ( $this->db->trans_status () === FALSE )
				{
				throw new Exception( 'Transaction failed' );
				}

			$this->db->trans_commit ();
			return $id_user;
			}
		catch ( Exception $e )
			{
			$this->db->trans_rollback ();
			log_message ( 'error', 'Error in register_user: ' . $e->getMessage () );
			return false;
			}
		}

	/**
	 * Update user data
	 * @param int $id_user
	 * @param array $data
	 * @return bool
	 */
	public function update_user ( $id_user, $data )
		{
		$this->db->trans_begin ();

		try
			{
			$this->update_user_table ( $id_user, $data );
			$this->update_nasabah_table ( $id_user, $data );

			if ( $this->db->trans_status () === FALSE )
				{
				throw new Exception( 'Transaction failed' );
				}

			$this->db->trans_commit ();
			return true;
			}
		catch ( Exception $e )
			{
			$this->db->trans_rollback ();
			log_message ( 'error', 'Error in update_user: ' . $e->getMessage () );
			return false;
			}
		}

	/**
	 * Delete user and related data
	 * @param int $id_user
	 * @return bool
	 */
	public function delete_user ( $id_user )
		{
		$this->db->trans_begin ();

		try
			{
			$user = $this->get_user_by_id ( $id_user );
			if ( ! $user )
				{
				throw new Exception( 'User not found' );
				}

			$this->db->delete ( $this->tables[ 'nasabah' ], [ 'id_user' => $id_user ] );
			$this->db->delete ( $this->tables[ 'users' ], [ 'id_user' => $id_user ] );

			if ( $this->db->trans_status () === FALSE )
				{
				throw new Exception( 'Transaction failed' );
				}

			$this->db->trans_commit ();
			return true;
			}
		catch ( Exception $e )
			{
			$this->db->trans_rollback ();
			log_message ( 'error', 'Error in delete_user: ' . $e->getMessage () );
			return false;
			}
		}

	/**
	 * Get RT list with optional RW filter
	 * @param int $rw
	 * @return array
	 */
	public function get_rt_list ( $rw = 0 )
		{
		$this->db->select ( '*' )
			->from ( $this->tables[ 'rt' ] )
			->join ( $this->tables[ 'rw' ], 'tb_rt.id_rw = tb_rw.id_rw', 'left' )
			->order_by ( 'tb_rw.id_rw', 'ASC' );

		if ( $rw > 0 )
			{
			$this->db->where ( 'tb_rt.id_rw', $rw );
			}

		return $this->db->get ()->result ();
		}

	// Add method to verify data

	public function get_nasabah ( $id_user )
		{
		$this->db->select ( 'nama' );
		$this->db->where ( 'id_user', $id_user );
		$query = $this->db->get ( 'tb_nasabah' );
		return $query->row ();
		}

	// Add method to check if RT exists
	public function check_rt_exists ( $id_rt )
		{
		return $this->db->where ( 'id_rt', $id_rt )
			->get ( $this->tables[ 'rt' ] )
			->num_rows () > 0;
		}
	public function email_exists ( $email, $user_id )
		{
		$this->db->where ( 'email', $email );
		if ( $user_id )
			{
			$this->db->where ( 'id_user !=', $user_id );
			}
		return $this->db->count_all_results ( 'tb_users' ) > 0;
		}


	public function username_exists ( $username, $user_id )
		{
		$this->db->where ( 'username', $username );
		if ( $user_id )
			{
			$this->db->where ( 'id_user !=', $user_id );
			}
		return $this->db->count_all_results ( 'tb_users' ) > 0;
		}

	// Add dashboard related methods
	// public function get_dashboard_data($role, $id_user = null)
	// {
	// 	$data = [];

	// 	switch ($role) {
	// 		case 'admin':
	// 			$data['total_nasabah'] = $this->db->where('role', 'nasabah')->count_all_results('tb_users');
	// 			$data['total_transaksi'] = $this->db->count_all_results('tb_transaksi_sampah');
	// 			$data['total_jenis_sampah'] = $this->db->count_all_results('tb_jenis_sampah');
	// 			$data['recent_transactions'] = $this->get_recent_transactions();
	// 			break;

	// 		case 'petugas':
	// 			$data['pending_transactions'] = $this->get_pending_transactions();
	// 			$data['today_transactions'] = $this->get_today_transactions();
	// 			$data['sampah_data'] = $this->get_sampah_data();
	// 			break;

	// 		case 'nasabah':
	// 			$data['my_transactions'] = $this->get_nasabah_transactions($id_user);
	// 			$data['total_setoran'] = $this->get_nasabah_total_setoran($id_user);
	// 			$data['latest_prices'] = $this->get_latest_prices();
	// 			break;
	// 	}

	// 	return $data;
	// }

	// private function get_recent_transactions($limit = 5)
	// {
	// 	$this->db->select('ts.*, n.nama as nama_nasabah, s.nama_sampah')
	// 		->from('tb_transaksi_sampah ts')
	// 		->join('tb_nasabah n', 'n.id_nasabah = ts.id_nasabah')
	// 		->join('tb_sampah s', 's.id_sampah = ts.id_sampah')
	// 		->order_by('ts.created_at', 'DESC')
	// 		->limit($limit);
	// 	return $this->db->get()->result();
	// }

	// private function get_pending_transactions()
	// {
	// 	return $this->db->where('status', 'pending')
	// 		->get('tb_transaksi_sampah')
	// 		->result();
	// }

	// private function get_nasabah_transactions($id_user)
	// {
	// 	$nasabah = $this->db->where('id_user', $id_user)
	// 		->get('tb_nasabah')
	// 		->row();

	// 	if ($nasabah) {
	// 		return $this->db->where('id_nasabah', $nasabah->id_nasabah)
	// 			->order_by('created_at', 'DESC')
	// 			->get('tb_transaksi_sampah')
	// 			->result();
	// 	}
	// 	return [];
	// }

	// Private helper methods
	private function prepare_user_data ( $data )
		{
		return [ 
			'email'      => $data[ 'email' ],
			'username'   => $data[ 'username' ],
			'password'   => $data[ 'password' ],
			'role'       => $data[ 'role' ],
			'created_at' => date ( 'Y-m-d H:i:s' ),
		];
		}

	private function prepare_nasabah_data ( $data, $id_user )
		{
		return [ 
			'id_user'    => $id_user,
			'id_rt'      => $data[ 'id_rt' ] ?? 0,
			'nama'       => $data[ 'nama' ] ?? '',
			'no_telfon'  => $data[ 'no_telfon' ] ?? 0,
			'avatar'     => self::DEFAULT_AVATAR,
			'alamat'     => $data[ 'alamat' ] ?? '',
			'created_at' => date ( 'Y-m-d H:i:s' ),
		];
		}

	private function log_activity ( $id_user, $action )
		{
		$log_data = [ 
			'id_user' => $id_user,
			'aksi'    => $action,
			'tanggal' => date ( 'Y-m-d H:i:s' ),
		];
		$this->db->insert ( $this->tables[ 'log' ], $log_data );
		}

	private function update_user_table ( $id_user, $data )
		{
		$user_fields = [ 'email', 'username', 'password', 'role' ];
		$user_data   = array_intersect_key ( $data, array_flip ( $user_fields ) );

		if ( ! empty ( $user_data ) )
			{
			$this->db->where ( 'id_user', $id_user )
				->update ( $this->tables[ 'users' ], $user_data );
			}
		}

	private function update_nasabah_table ( $id_user, $data )
		{
		$nasabah_fields = [ 'nama', 'no_telfon', 'avatar', 'alamat', 'id_rt' ];
		$nasabah_data   = array_intersect_key ( $data, array_flip ( $nasabah_fields ) );

		if ( ! empty ( $nasabah_data ) )
			{
			$this->db->where ( 'id_user', $id_user )
				->update ( $this->tables[ 'nasabah' ], $nasabah_data );
			}
		}
	}