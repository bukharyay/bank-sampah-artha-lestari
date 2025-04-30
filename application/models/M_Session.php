<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );


class M_Session extends CI_Model
	{
	public function __construct ()
		{
		parent::__construct ();
		$this->load->model ( [ 'M_Users' ] );
		}
	public function delete_user_sessions ( $user_id )
		{
		$this->db->where ( "data LIKE '%id_user|s:\"" . strlen ( $user_id ) . ":\"" . $user_id . "\"%'" )
			->delete ( 'ci_sessions' );
		}

	public function force_logout_user ( $user_id )
		{
		$id = $this->M_Users->get_user_by_id ( $user_id );
		if ( $id )
			{
			$username = $id->username;

			$query    = $this->db->get ( 'ci_sessions' );
			$sessions = $query->result ();

			foreach ( $sessions as $session )
				{
				$session_data = [];
				$raw_data     = $session->data;

				$data_parts = explode ( ';', $raw_data );

				foreach ( $data_parts as $part )
					{
					$part = trim ( $part );
					if ( empty ( $part ) ) continue;

					if ( strpos ( $part, '|' ) !== false )
						{
						list( $key, $value ) = explode ( '|', $part, 2 );

						// Bersihkan dan parsing value
						if ( strpos ( $value, 's:' ) === 0 || strpos ( $value, 'i:' ) === 0 || strpos ( $value, 'b:' ) === 0 )
							{
							// Coba unserialize value
							$parsed = @unserialize ( $value . ';' );
							if ( $parsed === false && $value !== 'b:0' )
								{
								// Fallback jika unserialize gagal
								$session_data[ $key ] = $value;
								}
							else
								{
								$session_data[ $key ] = $parsed;
								}
							}
						else
							{
							// Ambil apa adanya
							$session_data[ $key ] = $value;
							}
						}
					}

				// Cek apakah username cocok
				if ( isset ( $session_data[ 'username' ] ) && $session_data[ 'username' ] === $username )
					{
					$this->db->where ( 'id', $session->id );
					$this->db->delete ( 'ci_sessions' );
					}
				}
			}
		}


	public function is_user_active ( $user_id )
		{
		$pattern = 'id_user|s:' . strlen ( $user_id ) . ':"' . $user_id . '"';
		return $this->db->where ( 'data LIKE "%' . $this->db->escape_like_str ( $pattern ) . '%"' )
			->count_all_results ( 'ci_sessions' ) > 0;
		}
	}