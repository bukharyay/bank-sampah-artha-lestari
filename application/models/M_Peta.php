<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class M_Peta extends CI_Model
	{
	private $tables = [ 
		'lokasi' => 'tb_lokasi',
		'rt'     => 'tb_rt',
		'rw'     => 'tb_rw',
	];

	public function __construct ()
		{
		parent::__construct ();
		date_default_timezone_set ( 'Asia/Jakarta' );
		}


	public function save_location ( $data )
		{
		return $this->db->insert ( $this->tables[ 'lokasi' ], $data );
		}
	public function update_location ( $id_lokasi, $data )
		{
		// Verify valid ID
		if ( ! is_numeric ( $id_lokasi ) || $id_lokasi <= 0 )
			{
			log_message ( 'error', 'Invalid location ID: ' . $id_lokasi );
			return false;
			}

		$this->db->trans_start ();

		try
			{
			// Verify location exists first
			$exists = $this->db->where ( 'id_lokasi', $id_lokasi )
				->from ( $this->tables[ 'lokasi' ] )
				->count_all_results ();

			if ( ! $exists )
				{
				$this->db->trans_rollback ();
				log_message ( 'error', 'Location not found: ' . $id_lokasi );
				return false;
				}


			// Perform update
			$this->db->where ( 'id_lokasi', $id_lokasi );
			$result = $this->db->update ( $this->tables[ 'lokasi' ], $data );

			$this->db->trans_complete ();

			if ( ! $this->db->trans_status () || ! $result )
				{
				log_message ( 'error', 'Database error updating location: ' . $this->db->error ()[ 'message' ] );
				return false;
				}

			return true;

			}
		catch ( Exception $e )
			{
			$this->db->trans_rollback ();
			log_message ( 'error', 'Exception updating location: ' . $e->getMessage () );
			return false;
			}
		}

	public function hapus_location ( $id_lokasi )
		{
		try
			{
			$this->db->trans_start ();
			$this->db->where ( 'id_lokasi', $id_lokasi );
			$result = $this->db->delete ( $this->tables[ 'lokasi' ] );

			$this->db->trans_complete ();
			return $this->db->trans_status () && $result;

			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error deleting lokasi : ' . $e->getMessage () );
			return false;
			}
		}

	public function get_locations ()
		{
		$this->db->select ( 'longitude AS Lon, latitude AS Lat, nama_lokasi AS Desc, id_lokasi, alamat, tanggal_dibuat' );
		$query = $this->db->get ( $this->tables[ 'lokasi' ] );
		return $query->result_array ();
		}

	}