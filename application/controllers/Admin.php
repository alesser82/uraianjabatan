<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->helper('date');
		$this->load->database();
	}

	private function rulesForm($ket)
	{
		switch ($ket) {
			case 'hapus':
				return [
					['field' => 'npp',
					'label' => 'Npp',
					'rules' => 'trim|numeric|required'],
					['field' => 'katasandi',
					'label' => 'Katasandi',
					'rules' => 'required|trim']
				];
				break;
			case 'masuk':
				return [
					['field' => 'npp',
					'label' => 'Npp',
					'rules' => 'trim|numeric|required'],
					['field' => 'katasandi',
					'label' => 'Katasandi',
					'rules' => 'required']
				];
				break;
			case 'lupakatasandi':
				return [
					['field' => 'npp',
					'label' => 'Npp',
					'rules' => 'trim|required']
				];
				break;
			case 'ubahkatasandilama':
				return [
					['field' => 'katasandi1',
					'label' => 'Katasandi1',
					'rules' => 'trim|required'],
					['field' => 'katasandi2',
					'label' => 'Katasandi2',
					'rules' => 'trim|required|matches[katasandi1]']
				];
				break;
			case 'ubahkatasandibaru':
				return [
					[
						'field' => 'npp',
						'label' => 'Npp',
						'rules' => 'required|numeric|trim'
					],
					[
						'field' => 'katasandilama',
						'label' => 'Katasandilama',
						'rules' => 'required|trim'
					],
					[
						'field' => 'katasandibaru',
						'label' => 'Katasandibaru',
						'rules' => 'required|trim'
					],
					[
						'field' => 'katasandibaru2',
						'label' => 'Katasandibaru2',
						'rules' => 'required|trim|matches[katasandibaru]'
					],
				];
			default:
				return 0;
				break;
		}
	}

	public function index()
	{
		$data['judul'] = 'Company | Uraian Jabatan';
		$this->session->unset_userdata('npp_incomben');
		$this->load->view('admin/head',$data);
		$this->load->view('admin/index');
		$this->load->view('admin/foot');
	}

	public function masuk()
	{
		$data['judul'] = 'Company | Uraian Jabatan - Masuk';
		$this->session->unset_userdata('npp_incomben');
		$this->load->view('admin/head',$data);
		$this->load->view('admin/masuk');
		$this->load->view('admin/foot');
	}

	public function daftar($key = null)
	{
		if ($key !== null) {
			$npp = substr($key,0,32);
			$date = substr($key,32,32);
			if ($date == md5(date('d'))) {
				$all_admin = $this->Admin_model->tampilAdmin();
				$admin = array_filter($all_admin, function ($v) use ($npp)
				{
					return md5($v->npp) == $npp;
				});
				if (empty($admin)) {
					show_404();
				}else{
					foreach ($admin as $key => $value) {
						$npp = $value->npp;
						$status = $value->status;
					}
					if ($status == 0) {
						$this->load->model('Pemegangposisi_model','pemegangposisi');
						$this->load->model('UraianJabatan_model','uraianjabatan');
						$confirm = $this->Admin_model->daftarAkun($this->pemegangposisi, $this->uraianjabatan, $npp, 'confirm');
						if ($confirm > 0) {
							$this->session->set_flashdata(
							'message',
							'<div class="alert alert-info alert-dismissible fade show" role="alert">
								<strong>Berhasil Konfirmasi.</strong><br>
								<small>Akun sudah dapat digunakan.</small>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
							</div>'
							);
							redirect('admin/masuk');
						}else{
							$this->session->set_flashdata(
							'message',
							'<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<strong>Gagal Konfirmasi.</strong><br>
								<small>Ada kesalahan pada sistem.</small>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
							</div>'
							);
							redirect('admin/masuk');
						}
					}else{
						show_404();
					}
				}
			}else{
				show_404();
			}
		}else{
			$data['judul'] = 'Company | Uraian Jabatan - Daftar';
			$this->session->unset_userdata('npp_incomben');
			$this->load->view('admin/head',$data);
			$this->load->view('admin/daftar');
			$this->load->view('admin/foot');
		}
	}

	public function prosesDaftar()
	{
		// Deteksi masukkan
		if (!empty($this->input->post())) {
			$npp = htmlspecialchars($this->input->post('npp'));
			$npp = trim($npp);

			//Deteksi Jenis Masukkan
			if (is_numeric($npp)) {
				$admin = $this->Admin_model->tampilAdminDenganNpp();

				// Deteksi Ketersediaan Akun
				if (empty($admin)) {
					$this->load->model('UraianJabatan_model', 'uraianjabatan');
					$this->load->model('Pemegangposisi_model', 'pemegangposisi');

					// Deteksi Pemegang Posisi
					$result = $this->Admin_model->daftarAkun($this->pemegangposisi, $this->uraianjabatan,$npp);
					if ($result !== false) {
						$date = md5(date('d'));
						$npp = md5($npp);
						$key = $npp.$date;
						$email = $result;
						$url = base_url('admin/daftar/'. $key .'');

						// Deteksi Ketersediaan Email
						if ($email != '') {
							// Kirim Email
							$this->load->library('Phpmailer_library');
							$mail = $this->phpmailer_library->load();
							$mail->isSMTP();
							$mail->Host = 'smtp.gmail.com';
							$mail->SMTPAuth = true;
							$mail->Username = 'mramadhan123456@gmail.com';
							$mail->Password = 'rama1101987';
							$mail->SMTPSecure = 'tls';
							$mail->Port = 587;
							$mail->setFrom('mramadhan123456@gmail.com','Kantor');
							$mail->addAddress($email);
							$mail->addReplyTo('mramadhan123456@gmail.com', 'Kantor');
							$mail->Subject = 'Daftar Akun Admin Uraian Jabatan';
							$mail->AllowEmpty = true;
							$mail->isHTML(true);
							$mail->Debugoutput = 'html';
							$mailContent = 
							"
								<p>Akun akan diaktifkan jika menuju halaman <a href='". $url ."'>ini.</a></p>
							";
							$mail->Body = $mailContent;
							$mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) );
							if($mail->send()) {
								$this->session->set_flashdata(
								'message',
								'<div class="alert alert-info alert-dismissible fade show" role="alert">
									<strong>Berhasil Daftar.</strong><br>
									<small>Akun butuh dikonfirmasi melalui email.</small>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span></button>
								</div>'
								);
								redirect('admin/masuk');
							}else{
								$this->session->set_flashdata(
								'message',
								'<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<strong>NPP tidak terdaftar.</strong><br>
									<small>Silahkan isi kembali dengan benar.</small>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span></button>
								</div>'
								);
								redirect('admin/masuk');
							}
						}
					}
				}else{
					$this->session->set_flashdata(
						'message','<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal Daftar.</strong><br><small>Akun sudah terdaftar.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button></div></div>'
					);
					redirect('admin/masuk');
				}
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	public function ubahkatasandilama()
	{
		$data['judul'] = 'Company | Uraian Jabatan - Ubah Kata Sandi';
		if ($this->session->userdata('npp_incomben')) {
			$this->load->view('admin/head',$data);
			$this->load->view('admin/ubahkatasandi_masuk');
			$this->load->view('admin/foot');
		}else {
			redirect('admin/masuk');
		}
	}

	public function prosesMasuk()
	{
		$this->session->unset_userdata('npp_incomben');
		$ket = 'masuk';
		$validation = $this->form_validation->set_rules($this->rulesForm($ket));
		if ($validation->run()) {
			$result = $this->Admin_model->masukAplikasi();
			// var_dump($result);
			if ($result == 'admin_baru') {
				redirect('admin/ubahkatasandilama');
			}else if(is_array($result)){
				$admin = [
					'id_admin' => $result['id'],
					'npp' => $result['npp'],
					'nama' => $result['nama'],
					'status' => $result['status'],
					'org_id' => $result['org_id'],
					'masuk_admin' => true
				];
				$this->session->set_userdata($admin);
				redirect('uraianjabatan/tambah/');
			}else{
				$this->session->set_flashdata(
					'message','<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal masuk.</strong><br><small>Gunakan kata sandi lama atau kata sandi baru.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button></div></div>'
				);
				redirect('admin/masuk');
			}
        }else{
			$this->session->set_flashdata(
				'message','<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal masuk.</strong><br><small>Silahkan isi kembali dengan benar.</small><button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button></div></div>'
			);
			redirect('admin');
		}
	}

	public function reset($key)
	{
		if ($key != '') {
			$npp = substr($key,32,32);
			$date = substr($key,0,32);
			$admin = $this->Admin_model->tampilAdmin();
			$admin = array_filter($admin, function($v) use ($npp)
			{
				return md5($v->npp) === $npp;
			});
			if (!empty($admin)) {
				if ($date == md5(date('d'))) {
					foreach ($admin as $key => $value) {
						$data = 
						[
							'id' => $value->id,
							'npp' => $value->npp,
							'password' => 'hcsucofindo',
							'password_baru' => '',
							'nama' => $value->nama,
							'org_id' => $value->org_id,
							'status' => $value->status
						];
					}
					$this->db->replace('tbl_admin', $data);
					$result = $this->db->affected_rows();
					return $result;
				}else{
					return 0;
				}
			}else{
				return 0;
			}
		}else{
			show_404();
		}
	}

	public function lupakatasandi($key = null)
	{
		if ($key == null) {
			$data['judul'] = 'Company | Uraian Jabatan - Lupa Kata Sandi';
			$this->session->unset_userdata('npp_incomben');
			$this->load->view('admin/head',$data);
			$this->load->view('admin/lupakatasandi');
			$this->load->view('admin/foot');
		}else {
			$result = $this->reset($key);
			if ($result > 0) {
				$this->session->set_flashdata(
					'message',
					'<div class="alert alert-info alert-dismissible fade show" role="alert">
						<strong>Berhasil mengubah.</strong><br>
						<small>Kata sandi akun berhasil dibuat berdasarkan ketentuan awal.</small>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					</div>'
				);
				redirect('admin/masuk');
			}else{
				$this->session->set_flashdata(
					'message',
					'<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Gagal mengubah.</strong><br>
						<small>Akun tidak dikenal oleh sistem.</small>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					</div>'
				);
				redirect('admin/masuk');
			}
		}
	}

	public function prosesLupakatasandi()
	{
		$npp = $this->input->post('npp');
		if (!empty($npp)) {
			$ket = 'lupakatasandi';
			$validation = $this->form_validation->set_rules($this->rulesForm($ket));
			if ($validation->run()) {
				$admin = $this->Admin_model->tampilAdminDenganNpp();
				if ($admin != '') {
					$email_address = $admin['email'];
					$date = md5(date('d'));
					$npp = md5($npp);	
					$key = $date.$npp;
					$method = md5('reset');
					$url = base_url('admin/lupakatasandi/'. $key .'');
					$this->load->library('Phpmailer_library');
					$mail = $this->phpmailer_library->load();
					$mail->isSMTP();
					$mail->Host = 'smtp.gmail.com';
					$mail->SMTPAuth = true;
					$mail->Username = 'mramadhan123456@gmail.com';
					$mail->Password = 'rama1101987';
					$mail->SMTPSecure = 'tls';
					$mail->Port = 587;
					$mail->setFrom('mramadhan123456@gmail.com','Kantor');
					$mail->addAddress($email_address);
					$mail->addReplyTo('mramadhan123456@gmail.com', 'Kantor');
					$mail->Subject = 'Lupa Kata Sandi';
					$mail->AllowEmpty = true;
					$mail->isHTML(true);
					$mail->Debugoutput = 'html';
					$mailContent = 
					"
						<p>Kata sandi yang dibuat akan dibuat ulang sesuai ketetuan awal dengan menuju halaman <a href='". $url ."'>ini.</a></p>
					";
					$mail->Body = $mailContent;
					$mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) );
					if(!$mail->send()) {
						$this->session->set_flashdata(
						'message',
						'<div class="alert alert-info alert-dismissible fade show" role="alert">
							<strong>Berhasil Menemukan Akun.</strong><br>
							<small>Akun butuh dikonfirmasi melalui email.</small>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
						</div>'
						);
						redirect('admin/masuk');
					}else{
						$this->session->set_flashdata(
						'message',
						'<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<strong>NPP tidak terdaftar.</strong><br>
							<small>Silahkan isi kembali dengan benar.</small>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
						</div>'
						);
						redirect('admin/lupakatasandi');
					}
				}else{
					$this->session->set_flashdata(
					'message',
					'<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>NPP tidak terdaftar.</strong><br>
						<small>Silahkan isi kembali dengan benar.</small>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					</div>'
					);
					redirect('admin/lupakatasandi');
				}
			}else {
				$this->session->set_flashdata(
					'message',
					'<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Gagal mengubah.</strong><br>
						<small>Akun tidak dikenal oleh sistem.</small>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					</div>'
				);
				redirect('admin/masuk');
			}
		}else{
			show_404();
		}
		
	}

	public function prosesUbahKataSandiLama()
	{
		$ket = 'ubahkatasandilama';
		$validation = $this->form_validation->set_rules($this->rulesForm($ket));
		if ($validation->run()) {
			$result = $this->Admin_model->ubahKatasandi();
			if ($result > 0) {
				$this->session->set_flashdata(
				'message',
				'<div class="alert alert-info alert-dismissible fade show" role="alert">
					<strong>Kata sandi berhasil diubah.</strong><br>
					<small>Silahkan masuk ke dalam aplikasi.</small>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				</div>'
				);
				redirect('admin/masuk');
			}else {
				$this->session->set_flashdata(
				'message',
				'<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Gagal mengubah kata sandi.</strong><br>
					<small>Silahkan isi kembali untuk coba lagi.</small>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				</div>'
				);
			redirect('admin/ubahkatasandilama');
			}
		}else{
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<strong>Kata sandi tidak sama.</strong><br>
					<small>Silahkan isi kembali dengan benar.</small>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				</div>'
			);
			redirect('admin/ubahkatasandilama');
		}
	}

	public function ubahKataSandiBaru()
	{
		$session_data = [
            'id_jabatan',
            'id_tugas',
            'id_prasyarat',
            'id_tujuan',
            'id_tanggung_jawab',
            'id_dimensi',
            'id_ruang_lingkup',
            'id_wewenang',
            'id_hubungan_internal',
            'id_hubungan_eksternal',
            'id_kondisi',
            'id_pengetahuan_keterampilan',
            'id_set_kompetensi',
            'id_struktur_organisasi',
			'format',
			'id_pemegang_posisi',
			'npp_incomben',
			'format'
		];
		$this->session->unset_userdata($session_data);
		$data['judul'] = 'Company | Admin - ubah kata sandi';
        $data['konten'] = 'admin';
        $data['fungsi'] = 'admin-ubah_kata_sandi';
        $this->load->view('header',$data);
        $this->load->view('sidebar',$data);
        $this->load->view('admin/ubahkatasandi_menu',$data);
        $this->load->view('footer',$data);
	}

	public function prosesUbahKataSandiBaru()
	{	
		if ($this->input->post('npp')) {
			$validation = $this->form_validation->set_rules($this->rulesForm('ubahkatasandibaru'));
			if ($validation->run()) {
				$admin = $this->Admin_model->tampilAdmin();
				$admin = array_filter($admin, function($v)
				{
					return $v->npp == $this->input->post('npp');
				});
				if (!empty($admin)) {
					foreach ($admin as $key => $value) {
						if(!password_verify($this->input->post('katasandilama'), $value->password_baru)){
							$this->session->set_flashdata(
							'message',
							'<div class="alert alert-danger alert-dismissible fade show mr-3" role="alert">
								<strong>Gagal mengubah kata sandi.</strong><br>
								<small>Silahkan isi kembali dengan benar.</small>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
							</div>'
							);
							redirect('admin/ubahkatasandibaru');
						}else{
							$result = $this->Admin_model->ubahKatasandi('ubahkatasandibaru');
							if ($result > 0) {
								$this->session->set_flashdata(
								'message',
								'<div class="alert alert-info alert-dismissible fade show mr-3" role="alert">
									<strong>Berhasil mengubah kata sandi.</strong><br>
									<small>Kata sandi diubah dengan yang baru.</small>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span></button>
								</div>'
								);
								redirect('admin/ubahkatasandibaru');
							}else{
								$this->session->set_flashdata(
								'message',
								'<div class="alert alert-danger alert-dismissible fade show mr-3" role="alert">
									<strong>Gagal mengubah kata sandi.</strong><br>
									<small>Silahkan isi kembali dengan benar.</small>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span></button>
								</div>'
								);
								redirect('admin/ubahkatasandibaru');
							}
						}
					}
					// var_dump($admin);
				}else{
					$this->session->set_flashdata(
					'message',
					'<div class="alert alert-danger alert-dismissible fade show mr-3" role="alert">
						<strong>Gagal mengubah kata sandi.</strong><br>
						<small>Silahkan isi kembali dengan benar.</small>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					</div>'
					);
					redirect('admin/ubahkatasandibaru');
				}
			}else {
				$this->session->set_flashdata(
				'message',
				'<div class="alert alert-danger alert-dismissible fade show mr-3" role="alert">
					<strong>Gagal mengubah kata sandi.</strong><br>
					<small>Silahkan isi kembali dengan benar.</small>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				</div>'
				);
				redirect('admin/ubahkatasandibaru');
			}
		}else{
			show_404();
		}
	}

	public function hapusAkun()
	{
		$session_data = [
            'id_jabatan',
            'id_tugas',
            'id_prasyarat',
            'id_tujuan',
            'id_tanggung_jawab',
            'id_dimensi',
            'id_ruang_lingkup',
            'id_wewenang',
            'id_hubungan_internal',
            'id_hubungan_eksternal',
            'id_kondisi',
            'id_pengetahuan_keterampilan',
            'id_set_kompetensi',
            'id_struktur_organisasi',
			'format',
			'id_pemegang_posisi',
			'npp_incomben',
			'format'
		];
		$this->session->unset_userdata($session_data);
		$data['judul'] = 'Company | Admin - hapus akun';
        $data['konten'] = 'admin';
        $data['fungsi'] = 'admin-hapus_akun';
        $this->load->view('header',$data);
        $this->load->view('sidebar',$data);
        $this->load->view('admin/hapusakun',$data);
        $this->load->view('footer',$data);
	}

	public function prosesHapusAkun()
	{
		// Validasi masukkan
		if (!empty($this->input->post('npp'))) {
			$ket = 'hapus';
			$validation = $this->form_validation->set_rules($this->rulesForm($ket));
			if ($validation->run()) {
	
				// Validasi Karakter
				$npp = htmlspecialchars($this->input->post('npp'));
				$katasandi = htmlspecialchars($this->input->post('katasandi'));
	
				//Validasi Akun
				if ($npp == $this->session->npp) {
					$admin = $this->Admin_model->tampilAdminDenganNpp();
					if (password_verify($katasandi, $admin['password_baru'])) {
	
						// Hapus Akun
						$result = $this->Admin_model->hapusAkun($npp);
	
						// Periksa Hasil Proses Hapus
						if ($result > 0) {
							$session_data = [
								'id_admin',
								'npp',
								'nama',
								'status',
								'org_id',
								'masuk_admin'
							];
							$this->session->unset_userdata($session_data);
							$this->session->set_flashdata(
							'message',
							'<div class="alert alert-info alert-dismissible fade show" role="alert">
								<strong>Berhasil menghapus.</strong><br>
								<small>Akun berhasil dihapus sesuai formulir yang diisi.</small>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
							</div>'
							);
							redirect('admin/masuk');
						}else{
							$this->session->set_flashdata(
							'message',
							'<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<strong>Gagal menghapus.</strong><br>
								<small>Ada kesalahan pada proses menghapus.</small>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
							</div>'
							);
							redirect('admin/hapusakun');
						}
					}else{
						$this->session->set_flashdata(
							'message',
							'<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<strong>Gagal menghapus.</strong><br>
								<small>Akun tidak dikenal oleh sistem.</small>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
							</div>'
						);
						redirect('admin/hapusakun');
					}
				}else{
					$this->session->set_flashdata(
						'message',
						'<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<strong>Gagal menghapus.</strong><br>
							<small>Akun tidak dikenal oleh sistem.</small>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
						</div>'
					);
					redirect('admin/hapusakun');
				}
			}else{
				$this->session->set_flashdata(
					'message',
					'<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Gagal menghapus.</strong><br>
						<small>Akun tidak dikenal oleh sistem.</small>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					</div>'
				);
				redirect('admin/hapusakun');
			}
		}else{
			show_404();
		}
	}

	public function keluar()
	{
		$this->session->sess_destroy();
		redirect('admin/masuk');
	}

}