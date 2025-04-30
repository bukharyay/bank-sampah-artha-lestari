<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class M_Transaksi extends CI_Model
	{
	private $tables = [ 
		'nasabah'   => 'tb_nasabah',
		'rt'        => 'tb_rt',
		'rw'        => 'tb_rw',
		'sampah'    => 'tb_sampah',
		'jenis'     => 'tb_jenis_sampah',
		'harga'     => 'tb_harga_sampah',
		'transaksi' => 'tb_transaksi_sampah',
		'tabungan'  => 'tb_tabungan_nasabah',
	];

	public function __construct ()
		{
		parent::__construct ();
		date_default_timezone_set ( 'Asia/Jakarta' );
		}

	public function hitung_total_transaksi ()
		{
		return $this->db->count_all_results ( $this->tables[ 'transaksi' ] );
		}

	public function hitung_total_transaksi_minggu_kemarin ()
		{
		$start_last_week = date ( 'Y-m-d', strtotime ( 'last week monday' ) );
		$end_last_week   = date ( 'Y-m-d', strtotime ( 'last week sunday' ) );

		$this->db->where ( 'DATE(tanggal_transaksi) >=', $start_last_week );
		$this->db->where ( 'DATE(tanggal_transaksi) <=', $end_last_week );
		return $this->db->count_all_results ( $this->tables[ 'transaksi' ] );
		}

	public function hitung_total_transaksi_minggu_ini ()
		{
		$start_this_week = date ( 'Y-m-d', strtotime ( 'monday this week' ) );
		$end_this_week   = date ( 'Y-m-d', strtotime ( 'sunday this week' ) );

		$this->db->where ( 'DATE(tanggal_transaksi) >=', $start_this_week );
		$this->db->where ( 'DATE(tanggal_transaksi) <=', $end_this_week );
		return $this->db->count_all_results ( $this->tables[ 'transaksi' ] );
		}

	public function get_history_transaksi_30hari ()
		{
		$tanggal_awal = date ( 'Y-m-d', strtotime ( '-30 days' ) );

		return $this->db->select ( "DATE(tanggal_transaksi) as tanggal, COUNT(*) as jumlah, SUM(total_harga) as nilai, SUM(berat) as berat" )
			->from ( $this->tables[ 'transaksi' ] )
			->where ( 'tanggal_transaksi >=', $tanggal_awal )
			->group_by ( 'DATE(tanggal_transaksi)' )
			->order_by ( 'tanggal', 'ASC' )
			->get ()
			->result_array ();
		}

	public function get_ringkasan_bulanan ()
		{
		return $this->db->select ( "
            COUNT(*) as total,
            SUM(berat) as berat,
            SUM(total_harga) as nilai,
            DATE_FORMAT(tanggal_transaksi, '%Y-%m') as bulan
        " )
			->from ( $this->tables[ 'transaksi' ] )
			->group_by ( "DATE_FORMAT(tanggal_transaksi, '%Y-%m')" )
			->order_by ( 'bulan', 'DESC' )
			->limit ( 12 )
			->get ()
			->result ();
		}
	public function get_ringkasan_bulanan_graph ()
		{
		return $this->db->select ( "
            COUNT(*) as total,
            SUM(berat) as berat,
            SUM(total_harga) as nilai,
            DATE_FORMAT(tanggal_transaksi, '%Y-%m') as bulan
        " )
			->from ( $this->tables[ 'transaksi' ] )
			->group_by ( "DATE_FORMAT(tanggal_transaksi, '%Y-%m')" )
			->order_by ( 'bulan', 'ASC' )
			->limit ( 12 )
			->get ()
			->result ();
		}

	public function checkout ( $kode_transaksi ) : mixed
		{
		$selected_field = [ 
			"ts.id_transaksi",
			"ts.kode_transaksi",
			"ts.id_user as id_user_petugas",
			"ts.id_nasabah",
			"ts.id_sampah",
			"ts.id_harga",
			"ts.berat",
			"ts.total_harga",
			"ts.tanggal_transaksi",
			"ts.status",
			"ts.catatan_transaksi",
			"ts.created_at",
			"s.id_jenis_sampah",
			"s.nama_sampah",
			"n.id_user as id_user_nasabah",
			"n.id_rt",
			"n.nama",
			"n.no_telfon",
			"n.avatar",
			"n.alamat",
			"n.ketua_pkk",
		];

		return $this->db->select ( $selected_field )
			->from ( "{$this->tables[ 'transaksi' ]} as ts" )
			->join ( "{$this->tables[ 'sampah' ]} as s", "ts.id_sampah = s.id_sampah" )
			->join ( "{$this->tables[ 'nasabah' ]} as n", "ts.id_nasabah = n.id_nasabah" )
			->where ( "ts.kode_transaksi", $kode_transaksi )
			->order_by ( "ts.kode_transaksi", "DESC" )
			->order_by ( "ts.tanggal_transaksi", "DESC" )
			->get ()->row_object ();
		}
	public function checkout_process ( $kode_transaksi, $data ) : mixed
		{
		try
			{
			$this->db->trans_start ();

			$update_data = [ 
				'id_harga'    => $data[ 'id_harga' ],
				'total_harga' => $data[ 'total_harga' ],
				'status'      => 'dicatat',
			];
			$this->db->where ( 'kode_transaksi', $kode_transaksi );
			$result = $this->db->update ( $this->tables[ 'transaksi' ], $update_data );

			// Get the nasabah ID from the transaction
			$transaksi = $this->db->select ( 'id_nasabah, total_harga' )
				->from ( $this->tables[ 'transaksi' ] )
				->where ( 'kode_transaksi', $kode_transaksi )
				->get ()
				->row ();

			if ( $transaksi )
				{
				$id_nasabah  = $transaksi->id_nasabah;
				$total_harga = $transaksi->total_harga;

				// Check if nasabah already has a record in tb_tabungan_nasabah
				$tabungan = $this->db->select ( 'jumlah_tabungan' )
					->from ( $this->tables[ 'tabungan' ] )
					->where ( 'id_nasabah', $id_nasabah )
					->get ()
					->row ();

				if ( $tabungan )
					{
					$new_jumlah_tabungan = $tabungan->jumlah_tabungan + $total_harga;
					$this->db->where ( 'id_nasabah', $id_nasabah );
					$this->db->update ( $this->tables[ 'tabungan' ], [ 'jumlah_tabungan' => $new_jumlah_tabungan ] );
					}
				else
					{
					$this->db->insert ( $this->tables[ 'tabungan' ], [ 'id_nasabah' => $id_nasabah, 'jumlah_tabungan' => $total_harga ] );
					}
				}

			$this->db->trans_complete ();
			return $this->db->trans_status () && $result;
			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error updating sampah: ' . $e->getMessage () );
			return false;
			}
		}
	public function history_terakhir ( $limit = 10 )
		{
		return $this->db->select ( '*' )
			->from ( $this->tables[ 'transaksi' ] )
			->join ( $this->tables[ 'sampah' ], "{$this->tables[ 'transaksi' ]}.id_sampah = {$this->tables[ 'sampah' ]}.id_sampah" )
			->join ( $this->tables[ 'nasabah' ], "{$this->tables[ 'transaksi' ]}.id_nasabah = {$this->tables[ 'nasabah' ]}.id_nasabah" )
			->order_by ( "{$this->tables[ 'transaksi' ]}.tanggal_transaksi", "DESC" )
			->order_by ( "{$this->tables[ 'transaksi' ]}.kode_transaksi", "DESC" )
			->limit ( $limit )
			->get ()->result ();
		}

	public function get_filtered_history ( $filters = [] )
		{
		$this->db->select ( '
        ts.*, 
        ts.kode_transaksi,
        ts.berat,
        ts.total_harga,
        ts.status,
        ts.tanggal_transaksi,
        n.nama,
        n.id_rt,
        s.nama_sampah,
        rt.rt,
        rw.rw
    ' )
			->from ( 'tb_transaksi_sampah ts' )
			->join ( 'tb_nasabah n', 'ts.id_nasabah = n.id_nasabah' )
			->join ( 'tb_sampah s', 'ts.id_sampah = s.id_sampah' )
			->join ( 'tb_rt rt', 'n.id_rt = rt.id_rt' )
			->join ( 'tb_rw rw', 'rt.id_rw = rw.id_rw' )
			->order_by ( 'ts.tanggal_transaksi', 'DESC' );

		// Apply status filter
		if ( ! empty ( $filters[ 'status' ] ) )
			{
			$this->db->where ( 'ts.status', $filters[ 'status' ] );
			}

		// Apply date range filter
		if ( ! empty ( $filters[ 'start_date' ] ) && ! empty ( $filters[ 'end_date' ] ) )
			{
			$this->db->where ( 'DATE(ts.tanggal_transaksi) >=', $filters[ 'start_date' ] );
			$this->db->where ( 'DATE(ts.tanggal_transaksi) <=', $filters[ 'end_date' ] );
			}
		elseif ( ! empty ( $filters[ 'start_date' ] ) )
			{
			$this->db->where ( 'DATE(ts.tanggal_transaksi) >=', $filters[ 'start_date' ] );
			}
		elseif ( ! empty ( $filters[ 'end_date' ] ) )
			{
			$this->db->where ( 'DATE(ts.tanggal_transaksi) <=', $filters[ 'end_date' ] );
			}

		// Apply RT filter
		if ( ! empty ( $filters[ 'id_rt' ] ) )
			{
			$this->db->where ( 'n.id_rt', $filters[ 'id_rt' ] );
			}

		// Apply search filter
		if ( ! empty ( $filters[ 'search' ] ) )
			{
			$this->db->group_start ()
				->like ( 'n.nama', $filters[ 'search' ] )
				->or_like ( 'ts.kode_transaksi', $filters[ 'search' ] )
				->or_like ( 's.nama_sampah', $filters[ 'search' ] )
				->group_end ();
			}

		return $this->db->get ()->result ();
		}

	public function history_transaksi ( $status = null, $start_date = null, $end_date = null, $id_rt = null, $id_rw = null )
		{
		$this->db->select ( '*' )
			->from ( $this->tables[ 'transaksi' ] )
			->join ( $this->tables[ 'sampah' ], "{$this->tables[ 'transaksi' ]}.id_sampah = {$this->tables[ 'sampah' ]}.id_sampah" )
			->join ( $this->tables[ 'nasabah' ], "{$this->tables[ 'transaksi' ]}.id_nasabah = {$this->tables[ 'nasabah' ]}.id_nasabah" )
			->join ( $this->tables[ 'rt' ], "{$this->tables[ 'nasabah' ]}.id_rt = {$this->tables[ 'rt' ]}.id_rt" )
			->join ( $this->tables[ 'rw' ], "{$this->tables[ 'rt' ]}.id_rw = {$this->tables[ 'rw' ]}.id_rw" )
			->order_by ( "CASE 
            WHEN {$this->tables[ 'transaksi' ]}.status = 'diterima' THEN 1
            WHEN {$this->tables[ 'transaksi' ]}.status = 'dicatat' THEN 2
            WHEN {$this->tables[ 'transaksi' ]}.status = 'dibawa' THEN 3
            ELSE 4 
        END", "ASC" )
			->order_by ( "{$this->tables[ 'transaksi' ]}.kode_transaksi", "DESC" )
			->order_by ( "{$this->tables[ 'transaksi' ]}.tanggal_transaksi", "DESC" );

		// Apply status filter
		if ( $status )
			{
			$this->db->where ( "{$this->tables[ 'transaksi' ]}.status", $status );
			}

		// Apply date range filter
		if ( $start_date && $end_date )
			{
			$this->db->where ( "DATE({$this->tables[ 'transaksi' ]}.tanggal_transaksi) >=", $start_date );
			$this->db->where ( "DATE({$this->tables[ 'transaksi' ]}.tanggal_transaksi) <=", $end_date );
			}

		// Apply RT filter
		if ( $id_rt )
			{
			$this->db->where ( "{$this->tables[ 'nasabah' ]}.id_rt", $id_rt );
			}

		// Apply RW filter
		if ( $id_rw )
			{
			$this->db->where ( "{$this->tables[ 'rt' ]}.id_rw", $id_rw );
			}

		return $this->db->get ()->result ();
		}
	public function get_rt_list ()
		{
		return $this->db->order_by ( 'rt', 'ASC' )->get ( 'tb_rt' )->result ();
		}

	public function get_rw_list ()
		{
		return $this->db->order_by ( 'rw', 'ASC' )->get ( 'tb_rw' )->result ();
		}
	public function get_rt_rw_list ()
		{
		$this->db->select ( 't.id_rt, t.rt, t.id_rw, w.rw, t.nama_ketua_pkk, t.created_at, t.updated_at' )
			->from ( 'tb_rt t' )
			->join ( 'tb_rw w', 't.id_rw = w.id_rw' )
			->order_by ( 'w.rw', 'ASC' )
			->order_by ( 't.rt', 'ASC' );
		return $this->db->get ()->result ();
		}
	public function generate_kode_transaksi ()
		{
		$this->db->select ( 'kode_transaksi' );
		$this->db->order_by ( 'id_transaksi', 'DESC' );
		$this->db->limit ( 1 );
		$query = $this->db->get ( $this->tables[ 'transaksi' ] );

		if ( $query->num_rows () > 0 )
			{
			$last_kode = $query->row ()->kode_transaksi;
			$nomor     = (int) substr ( $last_kode, -5 );
			$nomor++;
			}
		else
			{
			$nomor = 1;
			}

		return 'BSAL-' . str_pad ( $nomor, 5, '0', STR_PAD_LEFT );
		}

	public function add_transaksi ( $data )
		{
		try
			{
			$this->db->trans_start ();

			$kode_transaksi = $this->generate_kode_transaksi ();

			$insert_data = [ 
				'kode_transaksi'    => $kode_transaksi,
				'id_user'           => $data[ 'id_user' ],
				'id_nasabah'        => $data[ 'id_nasabah' ],
				'id_sampah'         => $data[ 'id_sampah' ],
				'berat'             => $data[ 'berat' ],
				'catatan_transaksi' => $data[ 'catatan_transaksi' ],
				'status'            => 'diterima',
			];

			$this->db->insert ( $this->tables[ 'transaksi' ], $insert_data );

			$this->db->trans_complete ();
			return $this->db->trans_status ();
			}
		catch ( Exception $e )
			{
			log_message ( 'error', 'Error inserting transaksi: ' . $e->getMessage () );
			return false;
			}
		}
	}