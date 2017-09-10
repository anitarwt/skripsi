<?php
session_start();

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mtabel_user');
        $this->load->model('mtabel_pegawai');
        $this->load->model('mtabel_nilai');
        $this->load->model('mtabel_kriteria');
        $this->load->model('mtabel_bobot');
        $this->load->model('mtabel_rangking');
        $this->load->model('mtabel_vektor');
        if ($this->session->userdata('username') == "") {
            redirect('login');
        } elseif ($this->session->userdata('level') == 'manajer') {
            redirect('manajer/index');
        }
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

    public function index()
    {
        $data = array(
            'error' => '',
            'username' => $this->session->userdata('username')
        );

       $data['report'] = $this->mtabel_pegawai->report();
       $this->template->load('admin/static_admin', 'admin/dashbord_admin',$data);
       
    }

    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('level');
        session_destroy();
        redirect('/login');
    }

    
    public function tampil_pegawai()
    {

        $data['pegawai'] = $this->mtabel_pegawai->tampil()->result();

        $this->template->load('admin/static_admin', 'admin/tampil_pegawai', $data);
    }

    public function tampil_nilai()
    {
        $data['kriteria'] = $this->db->order_by("id_kriteria")->get("wp_kriteria")->result();
        $data['nilai'] = $this->mtabel_nilai->tampil();

        $this->template->load('admin/static_admin', 'admin/tampil_nilai', $data);
    }

    public function tampil_kriteria()
    {

        $data['kriteria'] = $this->mtabel_kriteria->tampil()->result();

        $this->template->load('admin/static_admin', 'admin/tampil_kriteria', $data);
    }

   
    public function tampil_rangking($divisi="")
    {
        $this->weighted_product($divisi);
         if($divisi)
            $this->db->where("divisi",$divisi);
         $data['kriteria'] = $this->db->order_by("id_kriteria")->get("wp_kriteria")->result();
        $data['nilai'] = $this->mtabel_nilai->tampil();

        $data['rangking'] = $this->db->order_by("vektor_v","desc")->get("wp_alternatif")->result();
        $this->template->load('admin/static_admin', 'admin/tampil_rangking', $data);
    }

    public function tampil_vektor($divisi="")
    {

        $this->weighted_product($divisi);
        if($divisi)
            $this->db->where("divisi",$divisi);

        $data['vektor'] = $this->db->get("wp_alternatif")->result();//$this->mtabel_vektor->tampil($divisi)->result();
        $this->template->load('admin/static_admin', 'admin/tampil_nilai_vektor', $data);
    }


   
    public function tambah_pegawai()
    {
        $this->template->load('admin/static_admin', 'admin/tambah_pegawai');
    }


    public function tambah_pegawaidb()
    {

        // 
        $this->form_validation->set_rules('nama', 'nama', 'trim|required');
        $this->form_validation->set_rules('jk', 'jenis kelamin', 'trim|required');
        $this->form_validation->set_rules('tanggal', 'tgl', 'trim|required');
        $this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'valid_email|required|');
        $this->form_validation->set_rules('hp', 'no handpone', 'numeric|required|');
        $this->form_validation->set_rules('pendidikan', 'pendidikan terakhir', 'trim|required|');
        $this->form_validation->set_rules('pengalaman', 'pengalaman kerja', 'trim|required|');
        $this->form_validation->set_rules('divisi', 'divisi', 'trim|required|');


        if ($this->form_validation->run() == FALSE) {
            $this->template->load('admin/static_admin', 'admin/tambah_pegawai');
        } else {
            $this->load->library('upload');
            $nmfile = "file_" . time(); //nama file saya beri nama langsung dan diikuti fungsi time
            $config['upload_path'] = './uploads/'; //path folder
            $config['allowed_types'] = 'zip|rar|'; //type yang dapat diakses bisa anda sesuaikan
            $config['max_size'] = '3072'; //maksimum besar file 3M
            $config['file_name'] = $nmfile; //nama yang terupload nantinya

            $this->upload->initialize($config);

            // if($_FILES['filefoto']['name'])
            //{
            if ($this->upload->do_upload('file')) {
                $gbr = $this->upload->data();

                $this->mtabel_pegawai->tambah($data); //akses model untuk menyimpan ke database
                $this->session->set_flashdata('info', 'Data Berhasil dimasukan');
                redirect('admin/tampil_pegawai'); //jika berhasil maka akan ditampilkan view upload
                //pesan yang muncul jika terdapat error dimasukkan pada session flashdat
            } else {
                $this->session->set_flashdata('info', 'Gagal dimasukan');
                redirect('admin/tambah_pegawai');  //jika gagal maka akan ditampilkan form upload

            }
        }
    }

    public function edit_pegawai($id)
    {

        $data['pegawai'] = $this->mtabel_pegawai->tampil();
        $data['single_pegawai'] = $this->mtabel_pegawai->tampil_id($id);
        $this->template->load('admin/static_admin', 'admin/edit_pegawai', $data);

    }

    public function edit_pegawaidb()
    {
        // if($this->input->post()){
        $this->load->library('upload');
        $nmfile = "file_" . time(); //nama file saya beri nama langsung dan diikuti fungsi time
        $config['upload_path'] = './uploads/'; //path folder
        $config['allowed_types'] = 'zip|rar|'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '3072';
        $config['overwrite'] = 'true';//maksimum besar file 3M
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->upload->initialize($config);

        if ($_POST) {

            $gbr = $this->upload->data();
            // $data['file'] = $gbr['file_name'];
            $query = $this->mtabel_pegawai->edit($id, $data);
            //$this->mtabel_pegawai->tampil_id();
            $this->session->set_flashdata('info', 'Data Berhasil diedit');
            // }else{
            //   $this->session->set_flashdata('info', 'Data gagal diupload');
            // }
            redirect('/admin/tampil_pegawai');
        } else {
            $this->session->set_flashdata('info', 'Data Gagal di edit');
            redirect('/admin/tampil_pegawai');
        }

        
    }

    function hapus_pegawai($id)
    {
        $this->mtabel_pegawai->hapus($id);
        if ($this->db->affected_rows()) {
            $this->session->set_flashdata('info', 'Data Berhasil dihapus');
            redirect('/admin/tampil_pegawai');
        } else {
            $this->session->set_flashdata('info', 'Data Gagal dihapus');
            redirect('/admin/tampil_pegawai');
        }


    }

    public function tambah_nilai()
    {

        $data['kriteria'] = $this->mtabel_rangking->ambil_kriteria();
        $data['alternatif'] = $this->mtabel_rangking->ambil_alternatif();

        $this->template->load('admin/static_admin', 'admin/tambah_nilai',$data);

    }

    public function tambah_nilaidb()
    {

        $this->mtabel_nilai->tambah(); //akses model untuk menyimpan ke database
        redirect('/admin/tampil_nilai');

    }

    public function edit_nilai($id)
    {
        $data["id"] = $id;
        $this->db->select("nama_alternatif");
        $this->db->from('wp_alternatif');
        $this->db->where("id_alternatif",$id);
        $data["nama_alternatif"] = $this->db->get()->row()->nama_alternatif;
        $data['kriteria'] = $this->mtabel_nilai->nilaiPeralternatif($id);
        $this->template->load('admin/static_admin', 'admin/edit_nilai', $data);
 
    }

    public function edit_nilaidb()
    {
        if ($data = $this->input->post()) {
            $query = $this->mtabel_nilai->edit();
            redirect('/admin/tampil_nilai');
        } else {
            $this->session->set_flashdata('info', 'Data Gagal di edit');
            redirect('/admin/tampil_nilai');
        }

    }


 

   public function hapus_nilai($id)
    {
        $this->mtabel_nilai->hapus($id);
        if ($this->db->affected_rows()) {
            $this->session->set_flashdata('info', 'Data Berhasil dihapus');
            redirect('admin/tampil_nilai');
        } else {
            $this->session->set_flashdata('info', 'Data Gagal dihapus');
            redirect('admin/tampil_nilai');
        }


    }

    public function tambah_kriteria()
    {

        $this->template->load('admin/static_admin', 'admin/tambah_kriteria');

    }

    public function tambah_kriteriadb()
    {

        $this->form_validation->set_rules('kriteria', 'kriteria', 'trim|required');
        $this->form_validation->set_rules('tipe_kriteria', 'tipe_kriteria', 'trim|required');
        $this->form_validation->set_rules('bobot', 'bobot', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('info', 'Gagal dimasukan');
            $this->template->load('admin/static_admin', 'admin/tambah_kriteria');

        } else {

            $this->mtabel_kriteria->tambah(); //akses model untuk menyimpan ke database
            redirect('/admin/tampil_kriteria');
        }

    }

    public function edit_kriteria($id)
    {

        $data['kriteria'] = $this->mtabel_kriteria->tampil();
        $data['single_kriteria'] = $this->mtabel_kriteria->tampil_id($id);
        $this->template->load('admin/static_admin', 'admin/edit_kriteria', $data);

    }

    public function edit_kriteriadb()
    {
        if ($data = $this->input->post()) {
            $query = $this->mtabel_kriteria->edit($id, $data);
            $this->mtabel_kriteria->tampil_id();
            $this->session->set_flashdata('info', 'Data Berhasil diedit');
            redirect('/admin/tampil_kriteria');
        } else {
            $this->session->set_flashdata('info', 'Data Gagal di edit');
            redirect('/admin/tampil_kriteria');
        }
    }

    public function hapus_kriteria($id)
    {
        $this->mtabel_kriteria->hapus($id);
        if ($this->db->affected_rows()) {
            $this->session->set_flashdata('info', 'Data Berhasil dihapus');
            redirect('/admin/tampil_kriteria');
        } else {
            $this->session->set_flashdata('info', 'Data Gagal dihapus');
            redirect('/admin/tampil_kriteria');
        }


    }


    public function tambah_rangking()
    {
        $data['kriteria'] = $this->mtabel_rangking->ambil_kriteria();
        $data['alternatif'] = $this->mtabel_rangking->ambil_alternatif();
        $this->template->load('admin/static_admin', 'admin/tambah_rangking', $data);
    }

    public function tambah_rangkingdb()
    {

        $this->form_validation->set_rules('kriteria', 'kriteria', 'callback_kriteria_check');
        $this->form_validation->set_rules('kriteria', '|is_unique[wp_rangking.id_kriteria]');


        if ($this->form_validation->run() == TRUE) {
            $this->mtabel_rangking->tambah();
            $this->session->set_flashdata('info', 'Data Berhasil diinput');
            redirect('/admin/tampil_rangking');
        } else {

            $this->session->set_flashdata('info', 'Data Gagal diinput'); //else untuk gagal duplicat key belum bisa
            redirect('/admin/tambah_rangking');
        }
    }

    public function edit_rangking($id)
    {

        $data['rangking'] = $this->mtabel_rangking->tampil();
        $data['single_rangking'] = $this->mtabel_rangking->tampil_id($id);
        $this->template->load('admin/static_admin', 'admin/edit_nilai_rangking', $data);

    }

    public function edit_rangkingdb()
    {
        if ($data = $this->input->post()) {
            $query = $this->mtabel_rangking->edit($id, $data);
            $this->mtabel_rangking->tampil_id();
            $this->session->set_flashdata('info', 'Data Berhasil diedit');
            redirect('/admin/tampil_rangking');
        } else {
            $this->session->set_flashdata('info', 'Data Gagal di edit');
            redirect('/admin/edit_rangking');
        }
    }

    public function hapus_rangking($id)
    {
        $this->mtabel_rangking->hapus($id);
        if ($this->db->affected_rows()) {
            $this->session->set_flashdata('info', 'Data Berhasil dihapus');
            redirect('/admin/tampil_rangking');
        } else {
            $this->session->set_flashdata('info', 'Data Gagal dihapus');
            redirect('/admin/tampil_rangking');
        }

    }
    public function cetak($divisi=""){

$data = array( 'title' => 'Laporan Excel');
 


    $this->weighted_product($divisi);
        if($divisi)
        $this->db->where("divisi",$divisi);
          $data['kriteria'] = $this->db->order_by("id_kriteria")->get("wp_kriteria")->result();
        $data['nilai'] = $this->mtabel_nilai->tampil();

        $data['rangking'] = $this->db->order_by("vektor_v","desc")->get("wp_alternatif")->result();
        $this->load->view ('admin/tampil_report', $data);
    }


}