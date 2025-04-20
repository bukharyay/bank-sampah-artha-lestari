<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class UserSession
  {
  protected $CI;

  public function __construct ()
    {
    // Get the CodeIgniter super object
    $this->CI =& get_instance ();
    // Load the M_Users model
    $this->CI->load->model ( 'M_Users' );
    }

  public function get_user_data ()
    {
    // Ambil ID user dari session
    $user_id = $this->CI->session->userdata ( 'id_user' );
    // Ambil data user dari database
    return $this->CI->M_Users->get_user_by_id ( $user_id );
    }
  }