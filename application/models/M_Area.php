<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Area extends CI_Model
{
	private $tables = [
		'rt' => 'tb_rt',
		'rw' => 'tb_rw',
	];
	public function __construct()
	{
		parent::__construct();
	}

	public function count_rt()
	{
		return $this->db->count_all_results($this->tables['rt']);
	}
	public function count_rw()
	{
		return $this->db->count_all_results($this->tables['rw']);
	}

	// ================= RW METHODS =================
	public function get_all_rw()
	{
		$this->db->order_by('rw', 'ASC');
		return $this->db->get('tb_rw')->result();
	}

	public function get_rw($id_rw)
	{
		return $this->db->get_where('tb_rw', ['id_rw' => $id_rw])->row();
	}
	public function get_rw_by_rt($id_rt)
	{
		$this->db->join('tb_rw as rw', "rw.id_rw = rt.id_rw");
		return $this->db->get_where('tb_rt as rt', ['rt.id_rt' => $id_rt])->row();
	}

	public function add_rw($data)
	{
		$this->db->insert('tb_rw', $data);
		return $this->db->insert_id();
	}

	public function update_rw($id_rw, $data)
	{
		$this->db->where('id_rw', $id_rw);
		return $this->db->update('tb_rw', $data);
	}

	public function delete_rw($id_rw)
	{
		$this->db->where('id_rw', $id_rw);
		return $this->db->delete('tb_rw');
	}

	public function is_rw_exists($rw, $exclude_id = null)
	{
		if ($exclude_id) {
			$this->db->where('id_rw !=', $exclude_id);
		}
		$this->db->where('rw', $rw);
		return $this->db->get('tb_rw')->num_rows() > 0;
	}

	public function count_rt_in_rw($id_rw)
	{
		$this->db->where('id_rw', $id_rw);
		return $this->db->get('tb_rt')->num_rows();
	}
	public function count_nasabah_in_rt($id_rt)
	{
		$this->db->where('id_rt', $id_rt);
		return $this->db->get('tb_nasabah')->num_rows();
	}

	// ================= RT METHODS =================
	public function get_all_rt()
	{
		$this->db->select('tb_rt.*, tb_rw.rw');
		$this->db->from('tb_rt');
		$this->db->join('tb_rw', 'tb_rt.id_rw = tb_rw.id_rw');
		$this->db->order_by('tb_rw.rw, tb_rt.rt', 'ASC');
		return $this->db->get()->result();
	}

	public function get_rt($id_rt)
	{
		return $this->db->get_where('tb_rt', ['id_rt' => $id_rt])->row();
	}

	public function add_rt($data)
	{
		$this->db->insert('tb_rt', $data);
		return $this->db->insert_id();
	}

	public function update_rt($id_rt, $data)
	{
		$this->db->where('id_rt', $id_rt);
		return $this->db->update('tb_rt', $data);
	}

	public function delete_rt($id_rt)
	{
		$this->db->where('id_rt', $id_rt);
		return $this->db->delete('tb_rt');
	}

	public function is_rt_exists($id_rw, $rt, $exclude_id = null)
	{
		if ($exclude_id) {
			$this->db->where('id_rt !=', $exclude_id);
		}
		$this->db->where('id_rw', $id_rw);
		$this->db->where('rt', $rt);
		return $this->db->get('tb_rt')->num_rows() > 0;
	}

	// ================= KETUA PKK METHODS =================
	public function get_nasabah_by_rt($id_rt)
	{
		$this->db->join('tb_rt as rt', "rt.id_rt = n.id_rt");
		$this->db->join('tb_rw as rw', "rw.id_rw = rt.id_rw");
		$this->db->where('n.id_rt', $id_rt);
		return $this->db->get('tb_nasabah as n')->result();
	}

	public function get_current_ketua_pkk($id_rt)
	{
		$this->db->where('id_rt', $id_rt);
		$this->db->where('ketua_pkk', 1);
		return $this->db->get('tb_nasabah')->row();
	}

	public function set_ketua_pkk($id_rt, $id_nasabah)
	{
		$this->db->trans_start();

		// Reset semua ketua PKK di RT ini
		$this->db->where('id_rt', $id_rt);
		$this->db->update('tb_nasabah', ['ketua_pkk' => 0]);

		// Set nasabah yang dipilih sebagai ketua PKK
		$this->db->where('id_nasabah', $id_nasabah);
		$this->db->update('tb_nasabah', ['ketua_pkk' => 1]);

		// Update nama ketua di tabel RT
		$nasabah = $this->db->get_where('tb_nasabah', ['id_nasabah' => $id_nasabah])->row();
		$this->db->where('id_rt', $id_rt);
		$this->db->update('tb_rt', ['nama_ketua_pkk' => $nasabah->nama]);

		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	public function remove_ketua_pkk($id_rt)
	{
		$this->db->trans_start();

		// Reset semua ketua PKK di RT ini
		$this->db->where('id_rt', $id_rt);
		$this->db->update('tb_nasabah', ['ketua_pkk' => 0]);

		// Update tabel RT
		$this->db->where('id_rt', $id_rt);
		$this->db->update('tb_rt', ['nama_ketua_pkk' => null]);

		$this->db->trans_complete();

		return $this->db->trans_status();
	}
}
