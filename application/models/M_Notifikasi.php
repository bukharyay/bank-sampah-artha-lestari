<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class M_Notifikasi extends CI_Model
  {
  private $tables = [ 
    'nasabah'    => 'tb_nasabah',
    'rt'         => 'tb_rt',
    'rw'         => 'tb_rw',
    'sampah'     => 'tb_sampah',
    'jenis'      => 'tb_jenis_sampah',
    'harga'      => 'tb_harga_sampah',
    'transaksi'  => 'tb_transaksi_sampah',
    'tabungan'   => 'tb_tabungan_nasabah',
    'notifikasi' => 'tb_notifikasi',
  ];

  public function __construct ()
    {
    parent::__construct ();
    date_default_timezone_set ( 'Asia/Jakarta' );
    }

  // Tambah notifikasi baru
  public function tambah ( $data )
    {
    $this->db->insert ( $this->tables[ 'notifikasi' ], $data );
    return $this->db->insert_id ();
    }

  // Dapatkan notifikasi untuk user tertentu
  public function get_notifikasi ( $id_user, $limit = 5 )
    {
    $this->db->where ( 'id_user', $id_user );
    $this->db->order_by ( 'dibaca', 'ASC' ); // Prioritize unread notifications
    $this->db->order_by ( 'created_at', 'DESC' );
    $this->db->limit ( $limit );
    return $this->db->get ( $this->tables[ 'notifikasi' ] )->result ();
    }

  // Hitung notifikasi belum dibaca
  public function count_unread ( $id_user )
    {
    $this->db->where ( 'id_user', $id_user );
    $this->db->where ( 'dibaca', 0 );
    return $this->db->count_all_results ( $this->tables[ 'notifikasi' ] );
    }

  // Tandai notifikasi sebagai dibaca
  public function mark_as_read ( $id_notifikasi )
    {
    $this->db->where ( 'id_notifikasi', $id_notifikasi );
    $this->db->update ( $this->tables[ 'notifikasi' ], [ 'dibaca' => 1 ] );
    return $this->db->affected_rows ();
    }

  // Tandai semua notifikasi sebagai dibaca
  public function mark_all_as_read ( $id_user )
    {
    $this->db->where ( 'id_user', $id_user );
    $this->db->where ( 'dibaca', 0 );
    $this->db->update ( $this->tables[ 'notifikasi' ], [ 'dibaca' => 1 ] );
    return $this->db->affected_rows ();
    }

  /**
   * Get paginated notifications
   * @param int $id_user
   * @param int $limit
   * @param int $offset
   * @return mixed
   */
  public function get_paginated_notifications ( $id_user, $limit = 10, $offset = 0 )
    {
    $this->db->where ( 'id_user', $id_user );
    $this->db->order_by ( 'created_at', 'DESC' );
    $this->db->limit ( $limit, $offset );
    return $this->db->get ( $this->tables[ 'notifikasi' ] )->result ();
    }

  /**
   * Count all notifications for a user
   * @param int $id_user
   * @return int
   */
  public function count_all_notifications ( $id_user )
    {
    $this->db->where ( 'id_user', $id_user );
    return $this->db->count_all_results ( $this->tables[ 'notifikasi' ] );
    }

  /**
   * Create notification for multiple users
   * @param array $user_ids
   * @param string $title
   * @param string $message
   * @param string $type
   * @return bool
   */
  public function bulk_notify ( $user_ids, $title, $message, $type = 'info' )
    {
    if ( empty ( $user_ids ) )
      {
      return false;
      }

    $notifications = [];
    $now           = date ( 'Y-m-d H:i:s' );

    foreach ( $user_ids as $user_id )
      {
      $notifications[] = [ 
        'id_user'    => $user_id,
        'judul'      => $title,
        'pesan'      => $message,
        'tipe'       => $type,
        'created_at' => $now,
      ];
      }

    return $this->db->insert_batch ( $this->tables[ 'notifikasi' ], $notifications );
    }
  }