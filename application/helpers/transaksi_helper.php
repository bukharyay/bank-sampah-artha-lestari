<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

if ( ! function_exists ( 'count_transaksi_diterima' ) )
  {
  function count_transaksi_diterima ()
    {
    $CI =& get_instance ();
    $CI->db->where ( 'status', 'diterima' );
    return $CI->db->count_all_results ( 'tb_transaksi_sampah' );
    }
  }