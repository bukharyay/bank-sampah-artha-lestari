<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class M_Hasil_Karya extends CI_Model
	{
	public function __construct ()
		{
		parent::__construct ();
		}

	public function get_all_karya ( $limit = 0 )
		{
		$this->db->select ( 'hk.*, u.username as author, js.jenis_sampah as kategori_nama, s.nama_sampah as subkategori_nama' );
		$this->db->from ( 'tb_hasil_karya hk' );
		$this->db->join ( 'tb_users u', 'u.id_user = hk.id_user' );
		$this->db->join ( 'tb_jenis_sampah js', 'js.id_jenis_sampah = hk.id_jenis_sampah', 'left' );
		$this->db->join ( 'tb_sampah s', 's.id_sampah = hk.id_sampah', 'left' );
		$this->db->order_by ( 'hk.tanggal_dibuat', 'DESC' );
		if ( $limit > 0 )
			{
			$this->db->limit ( $limit );
			}
		return $this->db->get ()->result ();
		}

	public function get_karya_by_id ( $id )
		{
		$this->db->select ( 'hk.*, u.username as author, js.jenis_sampah as kategori_nama, s.nama_sampah as subkategori_nama' );
		$this->db->from ( 'tb_hasil_karya hk' );
		$this->db->join ( 'tb_users u', 'u.id_user = hk.id_user' );
		$this->db->join ( 'tb_jenis_sampah js', 'js.id_jenis_sampah = hk.id_jenis_sampah', 'left' );
		$this->db->join ( 'tb_sampah s', 's.id_sampah = hk.id_sampah', 'left' );
		$this->db->where ( 'hk.id_hasil_karya', $id );
		return $this->db->get ()->row ();
		}

	public function get_karya_by_slug ( $slug )
		{
		$this->db->select ( 'hk.*, u.username as author, js.jenis_sampah as kategori_nama, s.nama_sampah as subkategori_nama' );
		$this->db->from ( 'tb_hasil_karya hk' );
		$this->db->join ( 'tb_users u', 'u.id_user = hk.id_user' );
		$this->db->join ( 'tb_jenis_sampah js', 'js.id_jenis_sampah = hk.id_jenis_sampah', 'left' );
		$this->db->join ( 'tb_sampah s', 's.id_sampah = hk.id_sampah', 'left' );
		$this->db->where ( 'hk.slug', $slug );
		$this->db->where ( 'status', 'published' );
		return $this->db->get ()->row ();
		}
	public function hitung_karya_terbaru_bulan_ini ()
		{
		$this->db->where ( 'MONTH(tanggal_dibuat)', date ( 'm' ) );
		$this->db->where ( 'YEAR(tanggal_dibuat)', date ( 'Y' ) );
		return $this->db->count_all_results ( 'tb_hasil_karya' );
		}
	public function increment_read_count ( $id_hasil_karya )
		{
		$this->db->set ( 'read_count', 'read_count+1', FALSE );
		$this->db->where ( 'id_hasil_karya', $id_hasil_karya );
		$this->db->update ( 'tb_hasil_karya' );
		}

	public function get_related_karya ( $id_jenis_sampah, $exclude_id, $limit = 3 )
		{
		$this->db->select ( 'hk.*, u.username as author, js.jenis_sampah as kategori_nama, s.nama_sampah as subkategori_nama' );
		$this->db->from ( 'tb_hasil_karya hk' );
		$this->db->join ( 'tb_users u', 'u.id_user = hk.id_user' );
		$this->db->join ( 'tb_jenis_sampah js', 'js.id_jenis_sampah = hk.id_jenis_sampah', 'left' );
		$this->db->join ( 'tb_sampah s', 's.id_sampah = hk.id_sampah', 'left' );
		$this->db->where ( 'hk.id_jenis_sampah', $id_jenis_sampah );
		$this->db->where ( 'hk.id_hasil_karya !=', $exclude_id );
		$this->db->where ( 'hk.status', 'published' );
		$this->db->order_by ( 'hk.id_hasil_karya', 'DESC' );
		$this->db->limit ( $limit );
		$query = $this->db->get ();

		return $query->result ();
		}

	public function get_paginated_karya ( $limit, $offset )
		{
		$this->db->select ( 'hk.*, u.username as author, js.jenis_sampah as kategori_nama' );
		$this->db->from ( 'tb_hasil_karya hk' );
		$this->db->join ( 'tb_users u', 'u.id_user = hk.id_user' );
		$this->db->join ( 'tb_jenis_sampah js', 'js.id_jenis_sampah = hk.id_jenis_sampah', 'left' );
		$this->db->order_by ( 'hk.tanggal_dibuat', 'DESC' );
		$this->db->order_by ( 'hk.id_hasil_karya', 'DESC' );
		$this->db->limit ( $limit, $offset );
		return $this->db->get ()->result ();
		}

	public function get_categories_with_count ()
		{
		$this->db->select ( 'js.id_jenis_sampah, js.jenis_sampah, COUNT(hk.id_hasil_karya) as article_count' );
		$this->db->from ( 'tb_jenis_sampah js' );
		$this->db->join ( 'tb_hasil_karya hk', 'hk.id_jenis_sampah = js.id_jenis_sampah AND hk.status = "published"', 'left' );
		$this->db->group_by ( 'js.id_jenis_sampah' );
		$this->db->order_by ( 'js.jenis_sampah', 'ASC' );
		return $this->db->get ()->result ();
		}
	public function get_filtered_karya ( $filters = [] )
		{
		$this->db->select ( 'hk.*, u.username as author, js.jenis_sampah as kategori_nama, s.nama_sampah as subkategori_nama' );
		$this->db->from ( 'tb_hasil_karya hk' );
		$this->db->join ( 'tb_users u', 'u.id_user = hk.id_user' );
		$this->db->join ( 'tb_jenis_sampah js', 'js.id_jenis_sampah = hk.id_jenis_sampah', 'left' );
		$this->db->join ( 'tb_sampah s', 's.id_sampah = hk.id_sampah', 'left' );

		// Apply filters
		if ( isset ( $filters[ 'id_jenis_sampah' ] ) )
			{
			$this->db->where ( 'hk.id_jenis_sampah', $filters[ 'id_jenis_sampah' ] );
			}

		if ( isset ( $filters[ 'id_sampah' ] ) )
			{
			$this->db->where ( 'hk.id_sampah', $filters[ 'id_sampah' ] );
			}

		$this->db->where ( 'hk.status', 'published' );
		$this->db->order_by ( 'hk.tanggal_dibuat', 'DESC' );

		if ( isset ( $filters[ 'limit' ] ) )
			{
			$this->db->limit ( $filters[ 'limit' ], $filters[ 'offset' ] ?? 0 );
			}

		return $this->db->get ()->result ();
		}

	public function count_filtered_karya ( $filters = [] )
		{
		$this->db->from ( 'tb_hasil_karya hk' );

		// Apply filters
		if ( isset ( $filters[ 'id_jenis_sampah' ] ) )
			{
			$this->db->where ( 'hk.id_jenis_sampah', $filters[ 'id_jenis_sampah' ] );
			}

		if ( isset ( $filters[ 'id_sampah' ] ) )
			{
			$this->db->where ( 'hk.id_sampah', $filters[ 'id_sampah' ] );
			}

		$this->db->where ( 'hk.status', 'published' );
		return $this->db->count_all_results ();
		}
	public function get_jenis_sampah_by_slug ( $slug )
		{
		// $search_term = str_replace ( '-', ' ', $slug );
		$search_term = str_replace ( '--', '/', $slug ); // Konversi kembali

		$this->db->where ( 'jenis_sampah', $search_term );
		return $this->db->get ( 'tb_jenis_sampah' )->row ();
		}

	public function get_sampah_by_slug ( $slug )
		{
		$this->db->where ( 'nama_sampah', str_replace ( '-', ' ', $slug ) );
		return $this->db->get ( 'tb_sampah' )->row ();
		}
	public function add_karya ( $data )
		{
		// Generate excerpt automatically
		$data[ 'excerpt' ] = $this->_generate_excerpt ( $data[ 'konten' ] );

		// Set default values
		$slug                     = $data[ 'judul' ] . '-' . date ( 'Y-m-d gis' );
		$data[ 'status' ]           = 'published';
		$data[ 'slug' ]             = url_title ( $slug, '-', true );
		$data[ 'read_count' ]       = 0;
		$data[ 'gambar' ]           = isset ( $data[ 'gambar' ] ) ? $data[ 'gambar' ] : 'default.png';
		$data[ 'gambar_alt' ]       = 'Gambar ilustrasi ' . $data[ 'judul' ];
		$data[ 'meta_title' ]       = $data[ 'judul' ];
		$data[ 'meta_description' ] = $data[ 'excerpt' ];
		$data[ 'tanggal_dibuat' ]   = date ( 'Y-m-d H:i:s' );

		$this->db->insert ( 'tb_hasil_karya', $data );
		return $this->db->insert_id ();
		}

	private function _generate_excerpt ( $konten, $length = 160 )
		{
		$clean_text = strip_tags ( $konten );
		$clean_text = trim ( preg_replace ( '/\s+/', ' ', $clean_text ) );
		return character_limiter ( $clean_text, $length );
		}

	public function update_karya ( $id, $data )
		{
		$slug                   = $data[ 'judul' ] . '-' . date ( 'Y-m-d gis' );
		$data[ 'slug' ]           = url_title ( $slug, '-', true );
		$data[ 'tanggal_dibuat' ] = date ( 'Y-m-d H:i:s' );
		$this->db->where ( 'id_hasil_karya', $id );
		return $this->db->update ( 'tb_hasil_karya', $data );
		}

	public function delete_karya ( $id )
		{
		$this->db->where ( 'id_hasil_karya', $id );
		return $this->db->delete ( 'tb_hasil_karya' );
		}

	public function get_recent_karya ( $limit = 3 )
		{
		$this->db->select ( 'hk.*, u.username as author, js.jenis_sampah as kategori_nama, s.nama_sampah as subkategori_nama' );
		$this->db->from ( 'tb_hasil_karya hk' );
		$this->db->join ( 'tb_users u', 'u.id_user = hk.id_user' );
		$this->db->join ( 'tb_jenis_sampah js', 'js.id_jenis_sampah = hk.id_jenis_sampah', 'left' );
		$this->db->join ( 'tb_sampah s', 's.id_sampah = hk.id_sampah', 'left' );
		$this->db->order_by ( 'hk.tanggal_dibuat', 'DESC' );
		$this->db->limit ( $limit );
		return $this->db->get ()->result ();
		}
	public function hitung_total_karya ()
		{
		return $this->db->count_all_results ( 'tb_hasil_karya' );
		}
	public function get_all_jenis_sampah ()
		{
		$this->db->order_by ( 'jenis_sampah', 'ASC' );
		return $this->db->get ( 'tb_jenis_sampah' )->result ();
		}


	public function get_sampah_by_jenis ( $id_jenis_sampah )
		{
		$this->db->select ( 's.id_jenis_sampah, s.id_sampah, s.nama_sampah, COUNT(hk.id_hasil_karya) as article_count' );
		$this->db->from ( 'tb_sampah s' );
		$this->db->join ( 'tb_hasil_karya hk', 'hk.id_sampah = s.id_sampah AND hk.status = "published"', 'left' );
		$this->db->group_by ( 's.id_sampah' );
		$this->db->where ( 's.id_jenis_sampah', $id_jenis_sampah );
		$this->db->order_by ( 's.nama_sampah', 'ASC' );
		return $this->db->get ()->result ();
		}
	}