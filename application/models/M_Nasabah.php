<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class M_Nasabah extends CI_Model
	{
	private $tables = [ 
		'users'          => 'tb_users',
		'sampah'         => 'tb_sampah',
		'nasabah'        => 'tb_nasabah',
		'rt'             => 'tb_rt',
		'rw'             => 'tb_rw',
		'tabungan'       => 'tb_tabungan_nasabah',
		'transaksi'      => 'tb_transaksi_sampah',
		'tarik_tabungan' => 'tb_penarikan_dana',
		'tarik_rt'       => 'tb_penarikan_rt',
	];

	public function __construct ()
		{
		parent::__construct ();
		date_default_timezone_set ( 'Asia/Jakarta' );
		}

	public function hitung_total_tabungan ()
		{
		$result = $this->db->select_sum ( 'jumlah_tabungan' )
			->get ( $this->tables[ 'tabungan' ] )
			->row ();
		return $result->jumlah_tabungan ?? 0;
		}
	public function get_average_tabungan ()
		{
		$this->db->select_avg ( 'jumlah_tabungan', 'rata_rata' );
		$result = $this->db->get ( $this->tables[ 'tabungan' ] )->row ();
		return $result->rata_rata ?? 0;
		}

	public function get_top_nasabah ()
		{
		$this->db->select ( 'n.nama, tn.jumlah_tabungan' )
			->from ( $this->tables[ 'tabungan' ] . ' tn' )
			->join ( $this->tables[ 'nasabah' ] . ' n', 'tn.id_nasabah = n.id_nasabah' )
			->order_by ( 'tn.jumlah_tabungan', 'DESC' )
			->limit ( 1 );
		return $this->db->get ()->row () ?? (object) [ 'nama' => 'N/A', 'jumlah_tabungan' => 0 ];
		}
	public function get_distribusi_tabungan_per_rt ()
		{
		return $this->db->select ( "
            rt.rt, 
            rw.rw,
            SUM(tn.jumlah_tabungan) as total,
            CONCAT('RT ', rt.rt, ' / RW ', rw.rw) as rt_rw
        " )
			->from ( $this->tables[ 'tabungan' ] . ' tn' )
			->join ( $this->tables[ 'nasabah' ] . ' n', 'tn.id_nasabah = n.id_nasabah' )
			->join ( $this->tables[ 'rt' ] . ' rt', 'n.id_rt = rt.id_rt' )
			->join ( $this->tables[ 'rw' ] . ' rw', 'rt.id_rw = rw.id_rw' )
			->group_by ( 'rt.id_rt' )
			->get ()
			->result ();
		}

	public function get_total_tabungan_by_rt ( $rt )
		{
		$this->db->select_sum ( 'tn.jumlah_tabungan', 'total' )
			->from ( $this->tables[ 'tabungan' ] . ' tn' )
			->join ( $this->tables[ 'nasabah' ] . ' n', 'tn.id_nasabah = n.id_nasabah' )
			->join ( $this->tables[ 'rt' ] . ' rt', 'n.id_rt = rt.id_rt' )
			->where ( 'rt.rt', $rt );

		$result = $this->db->get ()->row ();
		return $result->total ?? 0;
		}

	public function get_avg_tabungan_by_rt ( $rt )
		{
		$this->db->select_avg ( 'tn.jumlah_tabungan', 'rata_rata' )
			->from ( $this->tables[ 'tabungan' ] . ' tn' )
			->join ( $this->tables[ 'nasabah' ] . ' n', 'tn.id_nasabah = n.id_nasabah' )
			->join ( $this->tables[ 'rt' ] . ' rt', 'n.id_rt = rt.id_rt' )
			->where ( 'rt.rt', $rt );

		$result = $this->db->get ()->row ();
		return $result->rata_rata ?? 0;
		}

	public function get_top_nasabah_by_rt ( $rt )
		{
		$this->db->select ( 'n.nama, tn.jumlah_tabungan' )
			->from ( $this->tables[ 'tabungan' ] . ' tn' )
			->join ( $this->tables[ 'nasabah' ] . ' n', 'tn.id_nasabah = n.id_nasabah' )
			->join ( $this->tables[ 'rt' ] . ' rt', 'n.id_rt = rt.id_rt' )
			->where ( 'rt.rt', $rt )
			->order_by ( 'tn.jumlah_tabungan', 'DESC' )
			->limit ( 1 );

		return $this->db->get ()->row () ?? (object) [ 'nama' => 'N/A', 'jumlah_tabungan' => 0 ];
		}

	public function get_distribusi_tabungan_per_rt_filtered ( $rt = null, $rw = null )
		{
		$this->db->select ( "
        rt.rt, 
        rw.rw,
        SUM(tn.jumlah_tabungan) as total,
        CONCAT('RT ', rt.rt, ' / RW ', rw.rw) as rt_rw
    " )
			->from ( $this->tables[ 'tabungan' ] . ' tn' )
			->join ( $this->tables[ 'nasabah' ] . ' n', 'tn.id_nasabah = n.id_nasabah' )
			->join ( $this->tables[ 'rt' ] . ' rt', 'n.id_rt = rt.id_rt' )
			->join ( $this->tables[ 'rw' ] . ' rw', 'rt.id_rw = rw.id_rw' );

		if ( $rt )
			{
			$this->db->where ( 'rt.rt', $rt );
			}

		if ( $rw )
			{
			$this->db->where ( 'rw.rw', $rw );
			}

		return $this->db->group_by ( 'rt.id_rt' )
			->get ()
			->result ();
		}


	public function search_nasabah ( $search_term = '' )
		{
		try
			{
			$this->db->select ( [ 
				"n.id_nasabah",
				"n.nama",
				"rt.rt",
				"rw.rw",
			] )
				->from ( "{$this->tables[ 'nasabah' ]} n" )
				->join ( "{$this->tables[ 'rt' ]} rt", "n.id_rt = rt.id_rt" )
				->join ( "{$this->tables[ 'rw' ]} rw", "rt.id_rw = rw.id_rw" )
				->group_start ()
				->like ( "n.nama", $search_term, 'both' )
				->or_like ( "rt.rt", $search_term, 'both' )
				->or_like ( "rw.rw", $search_term, 'both' )
				->group_end ()
				->order_by ( "n.nama", "ASC" )
				->order_by ( "rw.rw", "ASC" )
				->order_by ( "rt.rt", "ASC" );

			$query = $this->db->get ();

			if ( ! $query->num_rows () )
				{
				return [];
				}

			$results = [];
			foreach ( $query->result () as $row )
				{
				$results[] = [ 
					'id'   => $row->id_nasabah,
					'text' => htmlspecialchars ( $row->nama ) . ' - RW ' .
						htmlspecialchars ( $row->rw ) . ' / RT ' .
						htmlspecialchars ( $row->rt ),
				];
				}

			return $results;

			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Search nasabah error: ' . $e->getMessage () );
			return [];
			}
		}

	public function get_user ( $id_nasabah )
		{
		try
			{
			$id_user = $this->db->select ( '*' )
				->from ( $this->tables[ 'nasabah' ] )
				->where ( 'id_nasabah', $id_nasabah )
				->get ();

			return $id_user->num_rows () > 0 ? (object) $id_user->row () : null;
			}
		catch ( Exception $e )
			{
			return $e;
			}
		}
	public function get_riwayat_tarik_tabungan ( $id_nasabah = null, $id_rt = null )
		{
		try
			{
			$query = $this->db->select ( '*' )
				->from ( $this->tables[ 'tarik_tabungan' ] )
				->join ( "{$this->tables[ 'nasabah' ]}", "{$this->tables[ 'nasabah' ]}.id_nasabah = {$this->tables[ 'tarik_tabungan' ]}.id_nasabah" )
				->join ( "{$this->tables[ 'rt' ]}", "{$this->tables[ 'rt' ]}.id_rt = {$this->tables[ 'nasabah' ]}.id_rt" )
				->join ( "{$this->tables[ 'rw' ]}", "{$this->tables[ 'rw' ]}.id_rw = {$this->tables[ 'rt' ]}.id_rw" );
			if ( $id_nasabah != null )
				{
				$this->db->where ( "{$this->tables[ 'nasabah' ]}.id_nasabah", $id_nasabah );
				}
			if ( $id_rt != null )
				{
				$this->db->where ( "{$this->tables[ 'rt' ]}.id_rt", $id_rt );
				}

			$this->db->order_by ( "{$this->tables[ 'tarik_tabungan' ]}.tanggal_penarikan", 'DESC' );

			$query = $this->db->get ();

			if ( $query->num_rows () > 0 )
				{
				return $query->result ();
				}
			else
				{
				return null;
				}

			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error getting tabungan nasabah: ' ) . $e->getMessage ();
			}
		}
	public function get_tabungan ( $id_nasabah )
		{
		try
			{
			$query = $this->db->select ( '*' )
				->from ( $this->tables[ 'tabungan' ] )
				->where ( "id_nasabah", $id_nasabah );

			$this->db->order_by ( "{$this->tables[ 'tabungan' ]}.tanggal_update", 'DESC' );

			$query = $this->db->get ();

			if ( $query->num_rows () > 0 )
				{
				return $query->row ();
				}
			else
				{
				return null;
				}

			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error getting tabungan nasabah: ' ) . $e->getMessage ();
			}
		}
	public function get_all_tabungan ( $rt = null )
		{
		try
			{
			$query = $this->db->select ( '*' )
				->from ( $this->tables[ 'tabungan' ] )
				->join ( $this->tables[ 'nasabah' ], "{$this->tables[ 'nasabah' ]}.id_nasabah = {$this->tables[ 'tabungan' ]}.id_nasabah" );
			if ( $rt != null )
				{
				$this->db->where ( "{$this->tables[ 'nasabah' ]}.id_rt", $rt );
				}

			$this->db->order_by ( "{$this->tables[ 'tabungan' ]}.tanggal_update", 'DESC' );

			$query = $this->db->get ();

			if ( $query->num_rows () > 0 )
				{
				return $query->result ();
				}
			else
				{
				return null;
				}

			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error getting tabungan nasabah: ' ) . $e->getMessage ();
			}
		}
	public function get_tabungan_rt ( $rt = null )
		{
		try
			{
			$query = $this->db->select ( '*' )
				->from ( $this->tables[ 'tarik_rt' ] )
				->join ( $this->tables[ 'nasabah' ], "{$this->tables[ 'nasabah' ]}.id_nasabah = {$this->tables[ 'tarik_rt' ]}.id_nasabah_ketua" )
				->join ( $this->tables[ 'rt' ], "{$this->tables[ 'rt' ]}.id_rt = {$this->tables[ 'nasabah' ]}.id_rt" )
				->join ( $this->tables[ 'rw' ], "{$this->tables[ 'rw' ]}.id_rw = {$this->tables[ 'rt' ]}.id_rw" );
			if ( $rt != null )
				{
				$this->db->where ( "{$this->tables[ 'rt' ]}.id_rt", $rt );
				}
			;
			$this->db->order_by ( "{$this->tables[ 'tarik_rt' ]}.tanggal_penarikan", 'DESC' );

			$query = $this->db->get ();

			if ( $query->num_rows () > 0 )
				{
				return $query->result ();
				}
			else
				{
				return null;
				}

			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error getting tabungan nasabah: ' ) . $e->getMessage ();
			}
		}

	public function get_transaksi_nasabah ( $id_nasabah )
		{
		try
			{
			$query = $this->db->select ( '*' )
				->from ( "{$this->tables[ 'transaksi' ]} ts" )
				->join ( "{$this->tables[ 'sampah' ]} s", "s.id_sampah = ts.id_sampah" )
				->join ( "{$this->tables[ 'nasabah' ]} n", "n.id_nasabah = ts.id_nasabah" )
				->where ( "n.id_nasabah", $id_nasabah )
				->order_by ( "ts.tanggal_transaksi", "DESC" );

			$query = $this->db->get ();

			if ( $query->num_rows () > 0 )
				{
				return $query->result ();
				}
			else
				{
				return null;
				}
			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error getting tabungan nasabah: ' ) . $e->getMessage ();
			}
		}
	public function get_transaksi_berat ( $id_nasabah )
		{
		try
			{
			$query = $this->db->select_sum ( 'berat', 'total_berat' )
				->from ( $this->tables[ 'transaksi' ] )
				->where ( "id_nasabah", $id_nasabah )
				->where ( 'status !=', 'diterima' );
			$query = $this->db->get ();

			if ( $query->num_rows () > 0 )
				{
				return $query->row ();
				}
			else
				{
				return null;
				}
			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error getting tabungan nasabah: ' ) . $e->getMessage ();
			}
		}

	public function get_periode_transaksi ( $id_nasabah )
		{
		try
			{
			$this->db->select ( 'MIN(tanggal_transaksi) as tanggal_awal, MAX(tanggal_transaksi) as tanggal_akhir' );
			$this->db->from ( $this->tables[ 'transaksi' ] );
			$this->db->where ( 'id_nasabah', $id_nasabah );
			$this->db->where ( 'status !=', 'diterima' );

			$query = $this->db->get ();

			if ( $query->num_rows () > 0 )
				{
				return $query->row ();
				}
			else
				{
				return null;
				}

			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error getting tabungan nasabah: ' ) . $e->getMessage ();
			}
		}

	public function get_total_sampah_disetorkan ( $id_nasabah )
		{
		try
			{
			// Get total available waste types
			$total_sampah = $this->db->select ( 'COUNT(*) as total_sampah' )
				->from ( $this->tables[ 'sampah' ] )
				->get ()
				->row ()
				->total_sampah ?? 0;

			// Get count of distinct waste types deposited by this nasabah
			$used_sampah_count = $this->db->select ( 'COUNT(DISTINCT id_sampah) as used_sampah_count' )
				->from ( $this->tables[ 'transaksi' ] )
				->where ( 'id_nasabah', $id_nasabah )
				->where ( 'status !=', 'diterima' )
				->get ()
				->row ()
				->used_sampah_count ?? 0;


			return (object) [ 
				'total_sampah'   => (int) $total_sampah,
				'sampah_disetor' => (int) $used_sampah_count
			];


			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error getting tabungan nasabah: ' ) . $e->getMessage ();
			return (object) [ 
				'total_sampah'   => 0,
				'sampah_disetor' => 0,
			];
			}
		}
	public function get_nasabah_rt_rw ( $id_nasabah )
		{
		try
			{
			// Select specific columns instead of * for better performance
			$select_fields = [ 
				'n.*',
				'n.id_nasabah',
				'rt.id_rt',
				'rt.rt',
				'rt.nama_ketua_pkk',
				'rw.id_rw',
				'rw.rw',
				'u.id_user',
				'u.email',
				'u.username',
				'u.role',
			];

			$query = $this->db->select ( $select_fields )
				->from ( "{$this->tables[ 'nasabah' ]} as n" )
				->join ( "{$this->tables[ 'users' ]} as u", 'n.id_user = u.id_user', 'left' )
				->join ( "{$this->tables[ 'rt' ]} as rt", 'n.id_rt = rt.id_rt', 'left' )
				->join ( "{$this->tables[ 'rw' ]} as rw", 'rt.id_rw = rw.id_rw', 'left' )
				->where ( 'n.id_nasabah', $id_nasabah )
				->get ();

			if ( ! $query )
				{
				throw new Exception( 'Database query failed' );
				}

			return $query->num_rows () > 0 ? (object) $query->row () : null;

			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error getting nasabah RT/RW data: ' . $e->getMessage () );
			return null;
			}
		}

	// public function tarik_dana_rt ( $id_rt, $id_nasabah_ketua )
	// 	{
	// 	$this->db->trans_start ();

	// 	try
	// 		{
	// 		// 1. Verify the nasabah is a PKK leader
	// 		$ketua = $this->db->select ( 'ketua_pkk' )
	// 			->from ( 'tb_nasabah' )
	// 			->where ( 'id_nasabah', $id_nasabah_ketua )
	// 			->get ()
	// 			->row ();

	// 		if ( ! $ketua || $ketua->ketua_pkk != 1 )
	// 			{
	// 			throw new Exception( "Hanya ketua PKK yang dapat melakukan penarikan dana RT" );
	// 			}

	// 		// 2. Get all nasabah in the same RT
	// 		$nasabah_rt = $this->db->select ( 'id_nasabah' )
	// 			->from ( 'tb_nasabah' )
	// 			->where ( 'id_rt', $id_rt )
	// 			->get ()
	// 			->result_array ();

	// 		if ( empty ( $nasabah_rt ) )
	// 			{
	// 			throw new Exception( "Tidak ada nasabah di RT ini" );
	// 			}

	// 		$total_penarikan = 0;
	// 		$nasabah_ids     = array_column ( $nasabah_rt, 'id_nasabah' );

	// 		$user_ids        = [];
	// 		$nasabah_data    = [];

	// 		// Prepare data for notification
	// 		foreach ( $nasabah_rt as $nasabah )
	// 			{
	// 			$user_ids[]                         = $nasabah->id_user;
	// 			$nasabah_data[ $nasabah->id_nasabah ] = $nasabah;
	// 			}

	// 		// 3. Process each nasabah's transactions and savings
	// 		foreach ( $nasabah_ids as $id_nasabah )
	// 			{
	// 			// Get all 'dicatat' transactions for this nasabah
	// 			$transactions = $this->db->select ( 'id_transaksi, total_harga' )
	// 				->from ( 'tb_transaksi_sampah' )
	// 				->where ( 'id_nasabah', $id_nasabah )
	// 				->where ( 'status', 'dicatat' )
	// 				->get ()
	// 				->result ();

	// 			if ( ! empty ( $transactions ) )
	// 				{
	// 				// Calculate total to withdraw
	// 				$nasabah_total   = array_sum ( array_column ( $transactions, 'total_harga' ) );
	// 				$total_penarikan += $nasabah_total;

	// 				// Update transactions status to 'dibawa'
	// 				$this->db->where ( 'id_nasabah', $id_nasabah )
	// 					->where ( 'status', 'dicatat' )
	// 					->update ( 'tb_transaksi_sampah', [ 'status' => 'dibawa' ] );

	// 				// Update nasabah's savings
	// 				$this->db->set ( 'jumlah_tabungan', "jumlah_tabungan - $nasabah_total", false )
	// 					->where ( 'id_nasabah', $id_nasabah )
	// 					->update ( 'tb_tabungan_nasabah' );

	// 				// Record withdrawal for this nasabah
	// 				$this->db->insert ( 'tb_penarikan_dana', [ 
	// 					'id_nasabah'       => $id_nasabah,
	// 					'jumlah_penarikan' => $nasabah_total,
	// 					'status'           => 'berhasil',
	// 				] );
	// 				}
	// 			}

	// 		// 4. Record RT-level withdrawal summary
	// 		if ( $total_penarikan > 0 )
	// 			{
	// 			$this->db->insert ( 'tb_penarikan_rt', [ 
	// 				'id_rt'             => $id_rt,
	// 				'id_nasabah_ketua'  => $id_nasabah_ketua,
	// 				'total_penarikan'   => $total_penarikan,
	// 				'tanggal_penarikan' => date ( 'Y-m-d H:i:s' ),
	// 				'status'            => 'berhasil',
	// 			] );
	// 			}
	// 		else
	// 			{
	// 			throw new Exception( "Tidak ada Tabungan di RT ini" );
	// 			}


	// 		$this->db->trans_complete ();

	// 		return [ 
	// 			'success'         => $this->db->trans_status (),
	// 			'total_penarikan' => $total_penarikan,
	// 			'jumlah_nasabah'  => count ( $nasabah_ids ),
	// 		];

	// 		}
	// 	catch ( Exception $e )
	// 		{
	// 		$this->db->trans_rollback ();
	// 		log_message ( 'error', 'Penarikan dana RT error: ' . $e->getMessage () );
	// 		return [ 
	// 			'success' => false,
	// 			'message' => $e->getMessage (),
	// 		];
	// 		}
	// 	}


	public function tarik_dana_rt ( $id_rt, $id_nasabah_ketua )
		{
		$this->db->trans_start ();

		try
			{
			// 1. Verify the nasabah is a PKK leader
			$ketua = $this->db->select ( 'ketua_pkk, nama' )
				->from ( 'tb_nasabah' )
				->where ( 'id_nasabah', $id_nasabah_ketua )
				->get ()
				->row ();

			if ( ! $ketua || $ketua->ketua_pkk != 1 )
				{
				throw new Exception( "Hanya ketua PKK yang dapat melakukan penarikan dana RT" );
				}

			// 2. Get all nasabah in the same RT with their user IDs
			$nasabah_rt = $this->db->select ( 'tb_nasabah.id_nasabah, tb_nasabah.nama, tb_nasabah.id_user, tb_tabungan_nasabah.jumlah_tabungan' )
				->from ( 'tb_nasabah' )
				->join ( 'tb_tabungan_nasabah', 'tb_tabungan_nasabah.id_nasabah = tb_nasabah.id_nasabah', 'left' )
				->where ( 'tb_nasabah.id_rt', $id_rt )
				->get ()
				->result ();

			if ( empty ( $nasabah_rt ) )
				{
				throw new Exception( "Tidak ada nasabah di RT ini" );
				}

			$total_penarikan = 0;
			$user_ids        = [];
			$nasabah_data    = [];

			// Prepare data for notification
			foreach ( $nasabah_rt as $nasabah )
				{
				$user_ids[]                           = $nasabah->id_user;
				$nasabah_data[ $nasabah->id_nasabah ] = $nasabah;
				}

			// 3. Process each nasabah's transactions and savings
			foreach ( $nasabah_rt as $nasabah )
				{
				// Get all 'dicatat' transactions for this nasabah
				$transactions = $this->db->select ( 'id_transaksi, total_harga' )
					->from ( 'tb_transaksi_sampah' )
					->where ( 'id_nasabah', $nasabah->id_nasabah )
					->where ( 'status', 'dicatat' )
					->get ()
					->result ();

				if ( ! empty ( $transactions ) )
					{
					// Calculate total to withdraw
					$nasabah_total   = array_sum ( array_column ( $transactions, 'total_harga' ) );
					$total_penarikan += $nasabah_total;

					// Update transactions status to 'dibawa'
					$this->db->where ( 'id_nasabah', $nasabah->id_nasabah )
						->where ( 'status', 'dicatat' )
						->update ( 'tb_transaksi_sampah', [ 'status' => 'dibawa' ] );

					// Update nasabah's savings
					$this->db->set ( 'jumlah_tabungan', "jumlah_tabungan - $nasabah_total", false )
						->where ( 'id_nasabah', $nasabah->id_nasabah )
						->update ( 'tb_tabungan_nasabah' );

					// Record withdrawal for this nasabah
					$this->db->insert ( 'tb_penarikan_dana', [ 
						'id_nasabah'       => $nasabah->id_nasabah,
						'jumlah_penarikan' => $nasabah_total,
						'status'           => 'berhasil',
					] );

					// Send notification to this nasabah
					$this->load->model ( 'M_Notifikasi' );
					$data_notifikasi = [ 
						'id_user' => $nasabah->id_user,
						'judul'   => 'Penarikan Dana RT',
						'pesan'   => "Ketua PKK {$ketua->nama} telah menarik tabungan Anda sebesar Rp " . number_format ( $nasabah_total, 0, ',', '.' ) .
							". Saldo sekarang: Rp " . number_format ( ( $nasabah->jumlah_tabungan - $nasabah_total ), 0, ',', '.' ),
						'tipe'    => 'info',
					];
					$this->M_Notifikasi->tambah ( $data_notifikasi );
					}
				}

			// 4. Record RT-level withdrawal summary
			if ( $total_penarikan > 0 )
				{
				$this->db->insert ( 'tb_penarikan_rt', [ 
					'id_rt'             => $id_rt,
					'id_nasabah_ketua'  => $id_nasabah_ketua,
					'total_penarikan'   => $total_penarikan,
					'tanggal_penarikan' => date ( 'Y-m-d H:i:s' ),
					'status'            => 'berhasil',
				] );

				$rt_info = $this->db->select ( '*' )
					->from ( 'tb_rt' )
					->join ( 'tb_rw', 'tb_rw.id_rw = tb_rt.id_rw' )
					->where ( 'tb_rt.id_rt', $id_rt )
					->get ()
					->row ();

				// Send notification to all staff/admin
				$this->load->model ( 'M_Notifikasi' );
				$this->load->model ( 'M_Users' );

				// Get all staff/admin user IDs
				$staff_admins    = $this->M_Users->get_staff_and_admins ();
				$staff_admin_ids = array_column ( $staff_admins, 'id_user' );

				if ( ! empty ( $staff_admin_ids ) )
					{
					$data_notifikasi_staff = [ 
						'id_user' => $staff_admin_ids,
						'judul'   => 'Penarikan Dana RT',
						'pesan'   => "Ketua PKK {$ketua->nama} telah melakukan penarikan dana RT {$rt_info->rt}/RW {$rt_info->rw} " .
							"sebesar Rp " . number_format ( $total_penarikan, 2, ',', '.' ) .
							" dari " . count ( $nasabah_rt ) . " nasabah",
						'tipe'    => 'info',
					];
					$this->M_Notifikasi->bulk_notify (
						$data_notifikasi_staff[ 'id_user' ],
						$data_notifikasi_staff[ 'judul' ],
						$data_notifikasi_staff[ 'pesan' ],
						$data_notifikasi_staff[ 'tipe' ],
					);
					}
				}
			else
				{
				throw new Exception( "Tidak ada Tabungan di RT ini" );
				}

			$this->db->trans_complete ();

			return [ 
				'success'         => $this->db->trans_status (),
				'total_penarikan' => $total_penarikan,
				'jumlah_nasabah'  => count ( $nasabah_rt ),
			];
			}
		catch ( Exception $e )
			{
			$this->db->trans_rollback ();
			log_message ( 'error', 'Penarikan dana RT error: ' . $e->getMessage () );
			return [ 
				'success' => false,
				'message' => $e->getMessage (),
			];
			}
		}
	public function history_transaksi ( $id_nasabah )
		{
		$this->db->select ( 'DATE(tanggal_transaksi) as tanggal_transaksi, SUM(berat) as total_berat' );
		$this->db->from ( $this->tables[ 'transaksi' ] );
		$this->db->where ( 'id_nasabah', $id_nasabah );
		$this->db->group_by ( 'DATE(tanggal_transaksi)' );
		$this->db->order_by ( 'tanggal_transaksi', 'ASC' );
		$query = $this->db->get ();

		return $query->result ();
		}

	}