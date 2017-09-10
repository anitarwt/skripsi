<?php
session_start();
class Manajer extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->model('mtabel_kriteria');
		$this->load->model('mtabel_pegawai');
        $this->load->model('mtabel_user');
        $this->load->model('mtabel_nilai');

		if ($this->session->userdata('username')=="") {
			redirect('/login');
		}elseif($this->session->userdata('level') == 'staff'){
			redirect('/staff/index');
		}
	}

	public function index()
	{
		 $data = array(
					'error' => '',
					'username' => $this->session->userdata('username')
				);
		   $data['report'] = $this->mtabel_pegawai->report();
       $this->template->load('manajer/static_hrd', 'manajer/dashbord_user',$data);
		
	}

 public function tambah_user()
    {

        $this->template->load('manajer/static_hrd', 'manajer/tambah_user');

    }

    public function tambah_userdb()
    {

        $this->form_validation->set_rules('user', 'username', 'trim|required|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('pass', 'password', 'trim|required|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('lev', 'level', 'trim|required|');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('info', 'Gagal dimasukan');
            $this->template->load('manajer/static_hrd', 'manajer/tambah_user');

        } else {

            $this->mtabel_user->tambah(); //akses model untuk menyimpan ke database
            redirect('/manajer/tabel_user');
        }

    }

    public function edit_user($id)
    {

        $data['user'] = $this->mtabel_user->tampil();
        $data['single_user'] = $this->mtabel_user->tampil_id($id);
        $this->template->load('manajer/static_hrd', 'manajer/edit_user', $data);

    }

    public function edit_userdb()
    {
        if ($data = $this->input->post()) {
            $query = $this->mtabel_user->edit($id, $data);
            $this->mtabel_user->tampil_id();
            $this->session->set_flashdata('info', 'Data Berhasil diedit');
            redirect('/manajer/tabel_user');
        } else {
            $this->session->set_flashdata('info', 'Data Gagal di edit');
            redirect('/manajer/tabel_user');
        }

    }

    public function tampil_user()
    {

        $data['user'] = $this->mtabel_user->tampil()->result();

        $this->template->load('manajer/static_hrd', 'manajer/tabel_user', $data);
    }


    function hapus_user($id)
    {
        $this->mtabel_user->hapus($id);
        if ($this->db->affected_rows()) {
            $this->session->set_flashdata('info', 'Data Berhasil dihapus');
            redirect('/manajer/tabel_user');
        } else {
            $this->session->set_flashdata('info', 'Data Gagal dihapus');
            redirect('/manajer/tabel_user');
        }

    }



public function logout() {
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('level');
		session_destroy();
		redirect('/login');
	}
	
	 private function weighted_product($divisi){
        //proses weighted product

        //fetch semua alternatif
        foreach ($this->db->get("wp_alternatif")->result() as $alt){

            $id = $alt->id_alternatif;

            //cari vector s
            $data_bobot_kali_nilai = $this->db->query("
            select  
            n.nilai,bobot/(select sum(bobot) from wp_kriteria) as bobot 
            from wp_kriteria k 
            left join wp_nilai n 
            on k.id_kriteria=n.id_kriteria and n.id_alternatif=$id
             
            join wp_alternatif a on a.id_alternatif=n.id_alternatif
            ".($divisi?" and divisi='$divisi'" : ""))->result();

            $s = 1;

            foreach ($data_bobot_kali_nilai as $c){
                $s*=pow($c->nilai,$c->bobot);
            }

            //simpan vector s
            $this->db->set("vektor_s",$s)->where("id_alternatif",$id)->update("wp_alternatif");
        }
        $total_s = $this->db->query("select SUM(x.vektor_s) as total from wp_alternatif x")->row()->total;

        $total_s = $total_s==0 ? 1:$total_s;

        //insert vector v

        $this->db->query("update wp_alternatif set vektor_v = vektor_s/$total_s");
    }
    public function tampil_rangking($divisi="")
    {
        $this->weighted_product($divisi);
         if($divisi)
            $this->db->where("divisi",$divisi);
          $data['kriteria'] = $this->db->order_by("id_kriteria")->get("wp_kriteria")->result();
        $data['nilai'] = $this->mtabel_nilai->tampil();
        $data['rangking'] = $this->db->order_by("vektor_v","desc")->get("wp_alternatif")->result();
        $this->template->load('manajer/static_hrd', 'manajer/tampil_rangking', $data);
    }
     public function cetak($divisi=""){

$data = array( 'title' => 'Laporan Excel');
    $this->weighted_product($divisi);
        if($divisi)
        $this->db->where("divisi",$divisi);
          $data['kriteria'] = $this->db->order_by("id_kriteria")->get("wp_kriteria")->result();
        $data['nilai'] = $this->mtabel_nilai->tampil();
        $data['rangking'] = $this->db->order_by("vektor_v","desc")->get("wp_alternatif")->result();
        $this->load->view ('manajer/tampil_report', $data);
    }



}

		
