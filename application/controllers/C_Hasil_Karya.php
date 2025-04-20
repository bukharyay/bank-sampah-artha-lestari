<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Hasil_Karya extends CI_Controller
{
	private $allowed_roles = ['admin', 'petugas'];
	public $user_session = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Hasil_Karya');
		$this->load->library('upload');
		$this->load->library('UserSession');
		$this->_check_auth();
	}

	private function _check_auth()
	{
		if (!in_array($this->session->userdata('role'), $this->allowed_roles)) {
			redirect('Auth-Login');
		}
		$this->user_session = $this->usersession->get_user_data();
	}

	public function index()
	{
		$data = [
			"title"    => 'Manajemen Hasil Karya',
			'greeting' => get_greeting(),
			"karya"    => $this->M_Hasil_Karya->get_all_karya(),
		];

		$this->load->view('Layout/App/V_header', $data);
		$this->load->view('Layout/App/V_topbar', $data);
		$this->load->view('Layout/App/V_sidebar', $data);
		$this->load->view('Petugas/V_hasil_karya', $data);
		$this->load->view('Layout/App/V_footer', $data);
	}

	public function add()
	{
		$data = [
			"title"        => 'Add Hasil Karya',
			'greeting'     => get_greeting(),
			'jenis_sampah' => $this->M_Hasil_Karya->get_all_jenis_sampah(),
		];

		$this->load->view('Layout/App/V_header', $data);
		$this->load->view('Layout/App/V_topbar', $data);
		$this->load->view('Layout/App/V_sidebar', $data);
		$this->load->view('Petugas/V_hasil_karya_add', $data);
		$this->load->view('Layout/App/V_footer', $data);
	}
	public function get_subkategori()
	{
		$id_jenis_sampah = $this->input->post('id_jenis_sampah');
		$subkategori     = $this->M_Hasil_Karya->get_sampah_by_jenis($id_jenis_sampah);

		echo json_encode($subkategori);
	}
	public function save()
	{
		$this->form_validation->set_rules('judul', 'Judul', 'required|max_length[255]');
		$this->form_validation->set_rules('konten', 'Konten', 'required');
		$this->form_validation->set_rules('id_jenis_sampah', 'Kategori Sampah', 'required|numeric');
		$this->form_validation->set_rules('id_sampah', 'Subkategori Sampah', 'numeric');

		if ($this->form_validation->run() == FALSE) {
			$response = [
				'status'  => 'error',
				'message' => validation_errors(),
			];
			echo json_encode($response);
			return;
		}

		// Prepare data
		$data = [
			'id_user'         => $this->session->userdata('id_user'),
			'judul'           => $this->input->post('judul'),
			'konten'          => $this->input->post('konten'),
			'id_jenis_sampah' => $this->input->post('id_jenis_sampah'),
			'id_sampah'       => $this->input->post('id_sampah') ?: null,
			'gambar'          => 'default.jpg',
		];

		// Handle file upload
		if (!empty($_FILES['gambar']['name'])) {
			$config['upload_path']   = './assets/uploads/karya/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['max_size']      = 2048;
			$config['encrypt_name']  = TRUE;

			$this->upload->initialize($config);

			if ($this->upload->do_upload('gambar')) {
				$upload_data      = $this->upload->data();
				$data['gambar'] = $upload_data['file_name'];
			} else {
				echo json_encode([
					'status'  => 'error',
					'message' => $this->upload->display_errors(),
				]);
				return;
			}
		}

		// Save to database
		if ($this->M_Hasil_Karya->add_karya($data)) {
			$response = [
				'status'  => 'success',
				'message' => 'Hasil karya berhasil ditambahkan',
			];
		} else {
			$response = [
				'status'  => 'error',
				'message' => 'Gagal menambahkan hasil karya',
			];
		}

		echo json_encode($response);
	}
	public function edit($id)
	{
		$data = [
			'title'        => 'Edit Hasil Karya',
			'greeting'     => get_greeting(),
			'jenis_sampah' => $this->M_Hasil_Karya->get_all_jenis_sampah(),
			'karya'        => $this->M_Hasil_Karya->get_karya_by_id($id),
		];

		$this->load->view('Layout/App/V_header', $data);
		$this->load->view('Layout/App/V_topbar', $data);
		$this->load->view('Layout/App/V_sidebar', $data);
		$this->load->view('Petugas/V_hasil_karya_edit', $data);
		$this->load->view('Layout/App/V_footer', $data);
	}

	public function update($id)
	{
		$this->form_validation->set_rules('judul', 'Judul', 'required|max_length[255]');
		$this->form_validation->set_rules('konten', 'Konten', 'required');
		$this->form_validation->set_rules('id_jenis_sampah', 'Kategori Sampah', 'required|numeric');
		$this->form_validation->set_rules('id_sampah', 'Subkategori Sampah', 'numeric');

		if ($this->form_validation->run() == FALSE) {
			$response = [
				'status'  => 'error',
				'message' => validation_errors(),
			];
			echo json_encode($response);
			return;
		}

		// Prepare data
		$data = [
			'id_user'         => $this->session->userdata('id_user'),
			'judul'           => $this->input->post('judul'),
			'konten'          => $this->input->post('konten'),
			'id_jenis_sampah' => $this->input->post('id_jenis_sampah'),
			'id_sampah'       => $this->input->post('id_sampah') ?: null,
		];

		// Handle file upload
		if (!empty($_FILES['gambar']['name'])) {
			$config['upload_path']   = './assets/uploads/karya/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['max_size']      = 2048;
			$config['encrypt_name']  = TRUE;

			$this->upload->initialize($config);

			if ($this->upload->do_upload('gambar')) {
				$upload_data      = $this->upload->data();
				$data['gambar'] = $upload_data['file_name'];

				// Hapus gambar lama
				$old_image = $this->M_Hasil_Karya->get_karya_by_id($id)->gambar;
				if ($old_image !== 'default.jpg') {
					if ($old_image && file_exists('./assets/uploads/karya/' . $old_image)) {
						unlink('./assets/uploads/karya/' . $old_image);
					}
				}
			} else {
				echo json_encode([
					'status'  => 'error',
					'message' => $this->upload->display_errors(),
				]);
				return;
			}
		}

		// Save to database
		if ($this->M_Hasil_Karya->update_karya($id, $data)) {
			$response = [
				'status'  => 'success',
				'message' => 'Hasil karya berhasil diperbarui',
			];
		} else {
			$response = [
				'status'  => 'error',
				'message' => 'Gagal memperbarui hasil karya',
			];
		}

		echo json_encode($response);
	}



	public function delete($id)
	{
		// Hapus gambar
		$karya = $this->M_Hasil_Karya->get_karya_by_id($id);
		if ($karya->gambar !== 'default.jpg') {
			if ($karya->gambar && file_exists('./assets/uploads/karya/' . $karya->gambar)) {
				unlink('./assets/uploads/karya/' . $karya->gambar);
			}
		}

		if ($this->M_Hasil_Karya->delete_karya($id)) {
			$response = [
				'status'  => 'success',
				'message' => 'Hasil karya berhasil dihapus',
			];
		} else {
			$response = [
				'status'  => 'error',
				'message' => 'Gagal menghapus hasil karya',
			];
		}

		echo json_encode($response);
	}

	// Untuk tampilan depan
	public function detail($id)
	{
		$data['karya']        = $this->M_Hasil_Karya->get_karya_by_id($id);
		$data['recent_karya'] = $this->M_Hasil_Karya->get_recent_karya();
		$this->load->view('front/V_karya_detail', $data);
	}

	public function semua_karya()
	{
		$data['karya'] = $this->M_Hasil_Karya->get_all_karya();
		$this->load->view('front/V_semua_karya', $data);
	}
}
