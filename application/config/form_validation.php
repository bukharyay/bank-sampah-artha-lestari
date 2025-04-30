<?php

$config = [
	'login'               => [
		[
			'field' => 'username',
			'label' => 'Username',
			'rules' => 'trim|required',
		],
		[
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'trim|required',
		],
	],
	'register'            => [
		[
			'field'  => 'username',
			'label'  => 'Username',
			'rules'  => 'trim|required|is_unique[tb_users.username]',
			'errors' => [
				'is_unique' => 'Username sudah digunakan',
			],
		],
		[
			'field'  => 'email',
			'label'  => 'Email',
			'rules'  => 'trim|required|valid_email|is_unique[tb_users.email]',
			'errors' => [
				'is_unique' => 'Email sudah digunakan',
			],
		],
		[
			'field'  => 'password',
			'label'  => 'Password',
			'rules'  => 'trim|required|min_length[6]|matches[password_confirmation]',
			'errors' => [
				'min_length' => 'Password minimal berisi 6 karakter',
				'matches'    => 'Password tidak sama',
			],
		],
		[
			'field'  => 'password_confirmation',
			'label'  => 'Konfirmasi Password',
			'rules'  => 'trim|required|min_length[6]|matches[password]',
			'errors' => [
				'min_length' => 'Password minimal berisi 6 karakter',
				'matches'    => 'Password tidak sama',
			],
		],
		[
			'field' => 'nama',
			'label' => 'Nama',
			'rules' => 'trim|required|max_length[64]',
		],
		[
			'field' => 'no_telfon',
			'label' => 'No Telepon',
			'rules' => 'trim|max_length[18]',
		],
		[
			'field' => 'alamat',
			'label' => 'Alamat',
			'rules' => 'trim',
		],
		[
			'field' => 'id_rt',
			'label' => 'RT',
			'rules' => 'trim|required|numeric|callback_check_rt_exists',
		],
	],

	'manage-add-user'     => [
		[
			'field'  => 'username',
			'label'  => 'Username',
			'rules'  => 'trim|required|is_unique[tb_users.username]',
			'errors' => [
				'is_unique' => 'Username sudah digunakan',
			],
		],
		[
			'field'  => 'email',
			'label'  => 'Email',
			'rules'  => 'trim|required|valid_email|is_unique[tb_users.email]',
			'errors' => [
				'is_unique' => 'Email sudah digunakan',
			],
		],
		[
			'field' => 'role',
			'label' => 'Role',
			'rules' => 'trim|required',
		],
		[
			'field'  => 'password',
			'label'  => 'Password',
			'rules'  => 'trim|required|min_length[6]|matches[password_confirmation]',
			'errors' => [
				'min_length' => 'Password minimal berisi 6 karakter',
				'matches'    => 'Password tidak sama',
			],
		],
		[
			'field'  => 'password_confirmation',
			'label'  => 'Konfirmasi Password',
			'rules'  => 'trim|required|min_length[6]|matches[password]',
			'errors' => [
				'min_length' => 'Password minimal berisi 6 karakter',
				'matches'    => 'Password tidak sama',
			],
		],
	],
	'manage-add-nasabah'  => [
		[
			'field'  => 'username',
			'label'  => 'Username',
			'rules'  => 'trim|required|is_unique[tb_users.username]',
			'errors' => [
				'is_unique' => 'Username sudah digunakan',
			],
		],
		[
			'field'  => 'email',
			'label'  => 'Email',
			'rules'  => 'trim|required|valid_email|is_unique[tb_users.email]',
			'errors' => [
				'is_unique' => 'Email sudah digunakan',
			],
		],
		[
			'field'  => 'password',
			'label'  => 'Password',
			'rules'  => 'trim|required|min_length[6]|matches[password_confirmation]',
			'errors' => [
				'min_length' => 'Password minimal berisi 6 karakter',
				'matches'    => 'Password tidak sama',
			],
		],
		[
			'field'  => 'password_confirmation',
			'label'  => 'Konfirmasi Password',
			'rules'  => 'trim|required|min_length[6]|matches[password]',
			'errors' => [
				'min_length' => 'Password minimal berisi 6 karakter',
				'matches'    => 'Password tidak sama',
			],
		],
		[
			'field' => 'nama',
			'label' => 'Nama',
			'rules' => 'trim|required|max_length[64]',
		],
		[
			'field' => 'no_telfon',
			'label' => 'No Telepon',
			'rules' => 'trim|max_length[18]',
		],
		[
			'field' => 'alamat',
			'label' => 'Alamat',
			'rules' => 'trim',
		],
		[
			'field' => 'id_rt',
			'label' => 'RT',
			'rules' => 'trim|numeric|callback_check_rt_exists',
		],
	],
	'manage-edit-user'    => [
		[
			'field' => 'username',
			'label' => 'Username',
			'rules' => 'trim|required|callback_check_username_exists',
		],
		[
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim|required|valid_email|callback_check_email_exists',
		],
		[
			'field'  => 'password',
			'label'  => 'Password',
			'rules'  => 'trim|min_length[6]|matches[password_confirmation]',
			'errors' => [
				'min_length' => 'Password minimal berisi 6 karakter',
				'matches'    => 'Password tidak sama',
			],
		],
		[
			'field'  => 'password_confirmation',
			'label'  => 'Konfirmasi Password',
			'rules'  => 'trim|min_length[6]|matches[password]',
			'errors' => [
				'min_length' => 'Password minimal berisi 6 karakter',
				'matches'    => 'Password tidak sama',
			],
		],
	],
	'manage-edit-nasabah' => [
		[
			'field' => 'username',
			'label' => 'Username',
			'rules' => 'trim|required|callback_check_username_exists',
		],
		[
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim|required|valid_email|callback_check_email_exists',
		],
		[
			'field'  => 'password',
			'label'  => 'Password',
			'rules'  => 'trim|min_length[6]|matches[password_confirmation]',
			'errors' => [
				'min_length' => 'Password minimal berisi 6 karakter',
				'matches'    => 'Password tidak sama',
			],
		],
		[
			'field'  => 'password_confirmation',
			'label'  => 'Konfirmasi Password',
			'rules'  => 'trim|min_length[6]|matches[password]',
			'errors' => [
				'min_length' => 'Password minimal berisi 6 karakter',
				'matches'    => 'Password tidak sama',
			],
		],
		[
			'field' => 'nama',
			'label' => 'Nama',
			'rules' => 'trim|required|max_length[64]',
		],
		[
			'field' => 'no_telfon',
			'label' => 'No Telepon',
			'rules' => 'trim|max_length[18]',
		],
		[
			'field' => 'alamat',
			'label' => 'Alamat',
			'rules' => 'trim',
		],
		[
			'field' => 'id_rt',
			'label' => 'RT',
			'rules' => 'trim|numeric|callback_check_rt_exists',
		],
	],
	'jenis_sampah'        => [
		[
			'field'  => 'jenis_sampah',
			'label'  => 'Jenis Sampah',
			'rules'  => 'trim|required|is_unique[tb_jenis_sampah.jenis_sampah]',
			'errors' => [
				'required'  => 'Jenis Sampah tidak boleh kosong!',
				'is_unique' => 'Jenis Sampah sudah ada',
			],
		],
	],
	'sampah'              => [
		[
			'field'  => 'id_jenis_sampah',
			'label'  => 'Jenis Sampah',
			'rules'  => 'trim|required|numeric|callback_check_jenis_sampah',
			'errors' => [
				'required'           => 'Jenis sampah harus dipilih',
				'numeric'            => 'Format jenis sampah tidak valid',
				'check_jenis_sampah' => 'Jenis sampah tidak tersedia',
			],
		],
		[
			'field'  => 'nama_sampah',
			'label'  => 'Sampah',
			'rules'  => 'trim|required|min_length[3]|max_length[100]|regex_match[/^[a-zA-Z0-9\s-]+$/]',
			'errors' => [
				'required'    => 'Nama sampah harus diisi',
				'min_length'  => 'Nama sampah minimal 3 karakter',
				'max_length'  => 'Nama sampah maksimal 100 karakter',
				'regex_match' => 'Nama sampah hanya boleh mengandung huruf, angka, spasi dan strip',
			],
		],
	],
	'harga_sampah'        => [
		[
			'field'  => 'id_sampah',
			'label'  => 'Sampah',
			'rules'  => 'trim|required|numeric|callback_check_sampah|callback_check_harga',
			'errors' => [
				'required'     => 'Sistem tidak valid',
				'numeric'      => 'Format tidak valid',
				'check_sampah' => 'Sampah tidak valid',
			],
		],
		[
			'field'  => 'harga_per_kg',
			'label'  => 'Harga Sampah',
			'rules'  => 'trim|required|numeric|min_length[3]|max_length[100]',
			'errors' => [
				'required'   => 'Harga sampah harus diisi',
				'min_length' => 'Harga sampah minimal 3 angka',
				'max_length' => 'Harga sampah maksimal 100 angka',
			],
		],
		[
			'field'  => 'periode',
			'label'  => 'Periode',
			'rules'  => 'trim|required|date|min_length[3]|max_length[100]|callback_validate_date',
			'errors' => [
				'required'   => 'Harga sampah harus diisi',
				'min_length' => 'Harga sampah minimal 3 angka',
				'max_length' => 'Harga sampah maksimal 100 angka',
			],
		],
	],
	'transaksi'           => [
		[
			'field' => 'kode_transaksi',
			'label' => 'Kode Transaksi',
			'rules' => 'trim',
		],
		[
			'field'  => 'id_nasabah',
			'label'  => 'Pilih Nasabah',
			'rules'  => 'trim|required|numeric',
			'errors' => [
				'required' => 'Pilih Nasabah terlebih dahulu',
				'numeric'  => 'Format tidak valid',
			],
		],
		[
			'field' => 'tanggal_transaksi',
			'label' => 'Tanggal Transaksi',
			'rules' => 'trim',
		],
		[
			'field'  => 'id_sampah',
			'label'  => 'Pilih Sampah',
			'rules'  => 'trim|required|numeric',
			'errors' => [
				'required' => 'Pilih Sampah terlebih dahulu',
				'numeric'  => 'Format tidak valid',
			],
		],
		[
			'field'  => 'berat',
			'label'  => 'Berat Sampah',
			'rules'  => 'trim|required|numeric|greater_than[0]',
			'errors' => [
				'required'     => 'Berat sampah harus diisi',
				'numeric'      => 'Berat harus berupa angka',
				'greater_than' => 'Berat harus lebih dari 0',
			],
		],
		[
			'field' => 'catatan_transaksi',
			'label' => 'Catatan Transaksi',
			'rules' => 'trim',
		],
	],
	'add_peta'            => [
		[
			'field'  => 'nama_lokasi',
			'label'  => 'Nama Lokasi',
			'rules'  => 'trim',
			'errors' => [
				'required' => 'Nama Lokasi tidak boleh kosong',
			],
		],
		[
			'field'  => 'latitude',
			'label'  => 'Latitude',
			'rules'  => 'trim|required',
			'errors' => [
				'required' => 'Klik 2x di Maps terlebih dahulu',
			],
		],
		[
			'field'  => 'longitude',
			'label'  => 'Longitude',
			'rules'  => 'trim|required',
			'errors' => [
				'required' => 'Klik 2x di Maps terlebih dahulu',
			],
		],
		[
			'field'  => 'alamat',
			'label'  => 'alamat',
			'rules'  => 'trim|required',
			'errors' => [
				'required' => 'Alamat tidak boleh kosong',
			],
		],
	],
];
