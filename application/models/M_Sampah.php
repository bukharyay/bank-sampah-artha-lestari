<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class M_Sampah extends CI_Model
	{
	private $tables = [ 
		'sampah' => 'tb_sampah',
		'jenis'  => 'tb_jenis_sampah',
		'harga'  => 'tb_harga_sampah',
	];

	public function __construct ()
		{
		parent::__construct ();
		date_default_timezone_set ( 'Asia/Jakarta' );
		}


	public function search_sampah ( $search_term = '' )
		{
		$field = "
		 s.id_sampah,
		 s.id_jenis_sampah,
		 s.nama_sampah,
		 s.created_at AS sampah_created_at,
		 s.updated_at AS sampah_updated_at,
		 j.id_jenis_sampah AS id_jenis,
		 j.jenis_sampah AS jenis_sampah";

		$query = $this->db->select ( $field )
			->from ( "{$this->tables[ 'sampah' ]} as s" )
			->join ( "{$this->tables[ 'jenis' ]} as j", "s.id_jenis_sampah = j.id_jenis_sampah" )
			->like ( "s.nama_sampah", $search_term, 'both' )
			->order_by ( 's.nama_sampah', 'ASC' )
			->get ();


		if ( $query->num_rows () == 0 )
			{
			return [];
			}

		$results = [];
		foreach ( $query->result () as $row )
			{
			$results[] = [ 
				'id'   => $row->id_sampah,
				'text' => htmlspecialchars ( $row->jenis_sampah ) . ' - ' . htmlspecialchars ( $row->nama_sampah ),
			];
			}

		return $results;
		}
	public function search_harga_sampah_by_id ( $id )
		{
		$field = "h.id_harga,
		 h.id_sampah,
		 h.harga_per_kg,
		 h.periode,
		 h.created_at AS harga_created_at,
		 s.id_sampah,
		 s.id_jenis_sampah,
		 s.nama_sampah,
		 s.created_at AS sampah_created_at,
		 s.updated_at AS sampah_updated_at,
		 j.id_jenis_sampah AS id_jenis,
		 j.jenis_sampah AS jenis_sampah";

		$query = $this->db->select ( $field )
			->from ( "{$this->tables[ 'harga' ]} as h" )
			->join ( "{$this->tables[ 'sampah' ]} as s", "h.id_sampah = s.id_sampah" )
			->join ( "{$this->tables[ 'jenis' ]} as j", "s.id_jenis_sampah = j.id_jenis_sampah" )
			->where ( "s.id_sampah", $id )
			->order_by ( 'h.periode', 'DESC' )
			->order_by ( 'h.created_at', 'DESC' )
			->limit ( 1 )
			->get ()->row_object ();

		return $query;
		}
	public function search_harga_sampah ( $search_term = '' )
		{
		$field = "h.id_harga,
		 h.id_sampah,
		 h.harga_per_kg,
		 h.periode,
		 h.created_at AS harga_created_at,
		 s.id_jenis_sampah,
		 s.nama_sampah,
		 s.created_at AS sampah_created_at,
		 s.updated_at AS sampah_updated_at,
		 j.id_jenis_sampah AS id_jenis,
		 j.jenis_sampah AS jenis_sampah";

		$subquery = $this->db->select ( $field )
			->from ( "{$this->tables[ 'harga' ]} as h" )
			->join ( "{$this->tables[ 'sampah' ]} as s", "h.id_sampah = s.id_sampah" )
			->join ( "{$this->tables[ 'jenis' ]} as j", "s.id_jenis_sampah = j.id_jenis_sampah" )
			->like ( "s.nama_sampah", $search_term, 'both' )
			->order_by ( 'h.periode', 'DESC' )
			->order_by ( 'h.created_at', 'DESC' )
			->get_compiled_select ();

		$query = $this->db->query (
			"SELECT *
		    FROM (
		        SELECT *,
		            ROW_NUMBER() OVER (PARTITION BY id_sampah ORDER BY periode DESC, harga_created_at DESC) AS rn
		        FROM ({$subquery}) AS RankedPrices
		    ) AS RankedPrices
		    WHERE rn = 1 
		    ORDER BY nama_sampah ASC",
		);

		if ( $query->num_rows () == 0 )
			{
			return [];
			}

		$results = [];
		foreach ( $query->result () as $row )
			{
			$results[] = [ 
				'id'   => $row->id_harga,
				'text' => htmlspecialchars ( $row->jenis_sampah ) . ' - ' . htmlspecialchars ( $row->nama_sampah ) . ' = Rp. ' . number_format ( $row->harga_per_kg, 0, ',', '.' ) . '/kg'
			];
			}

		return $results;
		}

	public function get_latest_prices ()
		{
		$field =
			'h.id_harga,
	h.id_sampah,
	h.harga_per_kg,
	h.periode,
	h.created_at AS harga_created_at, 
	s.id_jenis_sampah, 
	s.nama_sampah, 
	s.created_at AS sampah_created_at, 
	s.updated_at AS sampah_updated_at, 
	j.id_jenis_sampah AS id_jenis,
	j.jenis_sampah AS jenis_sampah';


		$subquery = $this->db->select ( $field )
			->from ( "{$this->tables[ 'harga' ]} as h" )
			->join ( "{$this->tables[ 'sampah' ]} as s", "h.id_sampah = s.id_sampah" )
			->join ( "{$this->tables[ 'jenis' ]} as j", "s.id_jenis_sampah = j.id_jenis_sampah" )
			->order_by ( 'h.periode', 'DESC' )
			->order_by ( 'h.created_at', 'DESC' )
			->get_compiled_select ();


		$query = $this->db->query ( "
            SELECT *
            FROM (
                SELECT *,
                    ROW_NUMBER() OVER (PARTITION BY id_sampah ORDER BY periode DESC, harga_created_at DESC) AS rn
                FROM ($subquery) AS RankedPrices
            ) AS RankedPrices
            WHERE rn = 1
            ORDER BY nama_sampah ASC
        " );

		return $query->result ();
		}


	public function get_all_harga ()
		{
		try
			{
			$select_field = [ 
				"h.*",
				"s.id_sampah",
				"s.nama_sampah",
			];

			return $this->db->select ( $select_field )
				->from ( "{$this->tables[ 'harga' ]} as h" )
				->join ( "{$this->tables[ 'sampah' ]} as s", "h.id_sampah = s.id_sampah" )
				->where ( "h.id_harga IN (
                SELECT sub.id_harga FROM (
                    SELECT id_harga, id_sampah
                    FROM {$this->tables[ 'harga' ]}
                    ORDER BY periode DESC, created_at DESC
                ) as sub
                GROUP BY sub.id_sampah
            )" )
				->order_by ( "s.nama_sampah", "ASC" )
				->get ()
				->result ();
			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error getting all sampah: ' . $e->getMessage () );
			return [];
			}
		}



	public function existing_harga ( $data )
		{
		try
			{

			return $this->db->select ( 'id_harga' )
				->from ( $this->tables[ 'harga' ] )
				->where ( 'id_sampah', $data[ 'id_sampah' ] )
				->where ( 'periode', $data[ 'periode' ] )
				->get ()
				->row ();


			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error updating harga: ' . $e->getMessage () );
			return false;
			}
		}
	public function update_harga ( $data )
		{
		try
			{
			$this->db->trans_start ();

			if ( empty ( $this->existing_harga ( $data ) ) )
				{
				$harga_data = [ 
					'id_sampah'    => $data[ 'id_sampah' ],
					'harga_per_kg' => $data[ 'harga_per_kg' ],
					'periode'      => $data[ 'periode' ],
				];

				$this->db->insert ( $this->tables[ 'harga' ], $harga_data );
				}
			else
				{
				return false;
				}
			$this->db->trans_complete ();

			return $this->db->trans_status ();
			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error updating harga: ' . $e->getMessage () );
			return false;
			}
		}

	public function get_last_harga ( $id_sampah, $check = null )
		{
		$select_field = [ 
			"h.*",
			"s.id_sampah",
			"s.nama_sampah",
		];

		$this->db->select ( $select_field );
		$this->db->from ( "{$this->tables[ 'harga' ]} as h" );
		$this->db->join ( "{$this->tables[ 'sampah' ]} as s", "h.id_sampah = s.id_sampah" );
		$this->db->where ( 'h.id_sampah', $id_sampah );
		if ( $check == null )
			{
			$this->db->where ( 'h.periode >= NOW() - INTERVAL 1 WEEK' );
			}
		$this->db->order_by ( 'h.periode', 'DESC' );
		$this->db->order_by ( 'h.created_at', 'DESC' );
		$this->db->limit ( 1 );
		$query = $this->db->get ();

		return $query->num_rows () > 0 ? $query->row () : [ 'error' => 'Data lama tidak bisa dirollback!' ];
		}

	public function rollback_latest_harga ( $id_sampah )
		{
		$this->db->trans_start ();

		try
			{
			$current_price = $this->db->select ( 'id_harga, id_sampah, harga_per_kg' )
				->from ( 'tb_harga_sampah' )
				->where ( 'id_sampah', $id_sampah )
				->order_by ( 'periode', 'DESC' )
				->limit ( 1 )
				->get ()
				->row ();

			if ( ! $current_price )
				{
				throw new Exception( "No price found for this sampah" );
				}

			$affected_transactions = $this->db->select ( 'ts.id_nasabah, ts.total_harga, tn.jumlah_tabungan' )
				->from ( 'tb_transaksi_sampah ts' )
				->join ( 'tb_tabungan_nasabah tn', 'ts.id_nasabah = tn.id_nasabah', 'left' )
				->where ( 'ts.id_harga', $current_price->id_harga )
				->where ( 'ts.status', 'dicatat' )
				->get ()
				->result ();

			$total_to_deduct  = 0;
			$affected_nasabah = [];

			foreach ( $affected_transactions as $trans )
				{
				$total_to_deduct += $trans->total_harga;
				$affected_nasabah[ $trans->id_nasabah ] = true;
				}

			$this->db->where ( 'id_harga', $current_price->id_harga )
				->delete ( 'tb_harga_sampah' );

			foreach ( array_keys ( $affected_nasabah ) as $id_nasabah )
				{
				$this->db->set ( 'jumlah_tabungan', "jumlah_tabungan - $total_to_deduct", false )
					->where ( 'id_nasabah', $id_nasabah )
					->update ( 'tb_tabungan_nasabah' );
				}

			$this->db->trans_complete ();
			return $this->db->trans_status ();

			}
		catch ( Exception $e )
			{
			$this->db->trans_rollback ();
			log_message ( 'error', 'Rollback error: ' . $e->getMessage () );
			return false;
			}
		}


	public function get_all_sampah ()
		{
		try
			{
			$select_field = [ 
				"s.*",
				"j.id_jenis_sampah",
				"j.jenis_sampah",
			];

			return $this->db->select ( $select_field )
				->from ( "{$this->tables[ 'sampah' ]} as s" )
				->join ( "{$this->tables[ 'jenis' ]} as j", "s.id_jenis_sampah = j.id_jenis_sampah", "left" )
				->order_by ( "s.id_sampah", "DESC" )
				->get ()
				->result ();
			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error getting all sampah: ' . $e->getMessage () );
			return [];
			}
		}

	public function get_jenis_sampah ()
		{
		try
			{
			return $this->db->select ( '*' )
				->from ( $this->tables[ 'jenis' ] )
				->order_by ( 'jenis_sampah', 'ASC' )
				->get ()
				->result ();
			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error getting jenis sampah: ' . $e->getMessage () );
			return [];
			}
		}

	public function add_sampah ( $data )
		{
		try
			{
			$this->db->trans_start ();

			$insert_data = [ 
				'id_jenis_sampah' => $data[ 'id_jenis_sampah' ],
				'nama_sampah'     => $data[ 'nama_sampah' ],
			];

			$result  = $this->db->insert ( $this->tables[ 'sampah' ], $insert_data );
			$last_id = $this->db->insert_id ();

			$harga_data = [ 
				'id_sampah'    => $last_id,
				'harga_per_kg' => 0,
				'periode'      => date ( 'Y-m-d', strtotime ( '-1 week' ) ),
			];

			$this->db->insert ( $this->tables[ 'harga' ], $harga_data );

			$this->db->trans_complete ();

			return $this->db->trans_status () && $result;
			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error adding sampah: ' . $e->getMessage () );
			return false;
			}
		}

	public function add_jenis_sampah ( $data )
		{
		try
			{
			$this->db->trans_start ();

			$insert_data = [ 
				'jenis_sampah' => $data[ 'jenis_sampah' ],
			];

			$result = $this->db->insert ( $this->tables[ 'jenis' ], $insert_data );
			$this->db->trans_complete ();

			return $this->db->trans_status () && $result;
			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error adding jenis sampah: ' . $e->getMessage () );
			return false;
			}
		}

	public function update_sampah ( $id_sampah, $data )
		{
		try
			{
			$this->db->trans_start ();

			$update_data = [ 
				'id_jenis_sampah' => $data[ 'id_jenis_sampah' ],
				'nama_sampah'     => $data[ 'nama_sampah' ],
			];
			$this->db->from ( $this->tables[ 'sampah' ] );

			$this->db->where ( 'id_sampah', $id_sampah );
			$result = $this->db->update ( $this->tables[ 'sampah' ], $update_data );

			$this->db->trans_complete ();
			return $this->db->trans_status () && $result;
			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error updating sampah: ' . $e->getMessage () );
			return false;
			}
		}

	public function update_jenis_sampah ( $id_jenis_sampah, $data )
		{
		try
			{
			$this->db->trans_start ();

			$update_data = [ 
				'id_jenis_sampah' => $data[ 'id_jenis_sampah' ],
				'jenis_sampah'    => $data[ 'jenis_sampah' ],
			];

			$this->db->from ( $this->tables[ 'jenis' ] );

			$this->db->where ( 'id_jenis_sampah', $id_jenis_sampah );
			$result = $this->db->update ( $this->tables[ 'jenis' ], $update_data );

			$this->db->trans_complete ();
			return $this->db->trans_status () && $result;
			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error updating jenis sampah: ' . $e->getMessage () );
			return false;
			}
		}

	public function delete_sampah ( $id_sampah )
		{
		try
			{
			$this->db->trans_start ();
			$this->db->from ( $this->tables[ 'sampah' ] );
			$this->db->where ( 'id_sampah', $id_sampah );
			$result = $this->db->delete ( $this->tables[ 'sampah' ] );

			$this->db->trans_complete ();
			return $this->db->trans_status () && $result;
			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error deleting sampah: ' . $e->getMessage () );
			return false;
			}
		}
	public function delete_jenis_sampah ( $id_jenis_sampah )
		{
		try
			{
			$this->db->trans_start ();
			$this->db->from ( $this->tables[ 'jenis' ] );
			$this->db->where ( 'id_jenis_sampah', $id_jenis_sampah );
			$result = $this->db->delete ( $this->tables[ 'jenis' ] );

			$this->db->trans_complete ();
			return $this->db->trans_status () && $result;
			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error deleting jenis sampah: ' . $e->getMessage () );
			return false;
			}
		}

	public function sampah_exists ( $id_sampah )
		{
		try
			{
			return $this->db->where ( 'id_sampah', $id_sampah )
				->get ( $this->tables[ 'sampah' ] )
				->num_rows () > 0;
			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error checking sampah: ' . $e->getMessage () );
			return false;
			}
		}
	public function jenis_sampah_exists ( $id_jenis_sampah )
		{
		try
			{
			return $this->db->where ( 'id_jenis_sampah', $id_jenis_sampah )
				->get ( $this->tables[ 'jenis' ] )
				->num_rows () > 0;
			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error checking jenis sampah: ' . $e->getMessage () );
			return false;
			}
		}

	public function get_sampah_by_id ( $id_sampah )
		{
		try
			{
			return $this->db->select ( 's.*, js.jenis_sampah' )
				->from ( "{$this->tables[ 'sampah' ]} s" )
				->join ( "{$this->tables[ 'jenis' ]} js", 's.id_jenis_sampah = js.id_jenis_sampah', 'left' )
				->where ( 's.id_sampah', $id_sampah )
				->get ()
				->row ();
			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error getting sampah by ID: ' . $e->getMessage () );
			return null;
			}
		}
	}