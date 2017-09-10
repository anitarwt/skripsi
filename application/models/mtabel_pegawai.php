<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mtabel_pegawai extends CI_Model
{

    public function tambah()
    {
        $j = $this->input->post('id');
        $a = $this->input->post('nama');
        $b = $this->input->post('jk');
        $c = $this->input->post('tanggal');
        $d = $this->input->post('alamat');
        $e = $this->input->post('email');
        $f = $this->input->post('hp');
        $g = $this->input->post('pendidikan');
        $h = $this->input->post('pengalaman');
        $i = $this->input->post('divisi');
        $j = $this->upload->data('file');

        $data = array(
            'nama_alternatif' => $a,
            'jk' => $b,
            'tanggal_lahir' => $c,
            'alamat' => $d,
            'email' => $e,
            'no_hp' => $f,
            'pendidikan' => $g,
            'pengalaman_kerja' => $h,
            'divisi' => $i,
            'file' => $j['file_name'],
           

        );
        $query = $this->db->insert('wp_alternatif', $data);
        return $query;
    }

    public function tampil()
    {

        $query = $this->db->get('wp_alternatif');
        return $query;
    }


    function tampil_id($data)
    {
        $this->db->select('*');
        $this->db->from('wp_alternatif');
        $this->db->where('id_alternatif', $data);
        $query = $this->db->get();
        $result = $query->result();
// echo '<pre>';
// var_dump($result);die;
// echo '</pre>';
        return $result;
    }

    public function edit($id, $data)
    {

        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $jk = $this->input->post('jk');
        $tgl = $this->input->post('tanggal_lahir');
        $alamat = $this->input->post('alamat');
        $email = $this->input->post('email');
        $pendidikan = $this->input->post('pendidikan');
        $pengalaman = $this->input->post('pengalaman');
        $no_hp = $this->input->post('hp');
        $divisi = $this->input->post('divisi');
        $file = $this->upload->data('file');

        $data = array(
            'id_alternatif' => $id,
            'nama_alternatif' => $nama,
            'jk' => $jk,
            'tanggal_lahir' => $tgl,
            'alamat' => $alamat,
            'email' => $email,
            'no_hp' => $no_hp,
            'pendidikan' => $pendidikan,
            'pengalaman_kerja' => $pengalaman,
            'divisi' => $divisi,
            'file' => $file['file_name']
        );

        $this->db->where('id_alternatif', $id);
        return $this->db->update('wp_alternatif', $data);


    }

    public function hapus($id)
    {
        return $this->db->delete('wp_alternatif', array('id_alternatif' => $id));
    }

     public function report(){
         $query = $this->db->query("SELECT * from wp_alternatif");
       if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
        
    }
}


/* End of file mtabel_wp_alternatif.php */
/* Location: ./application/models/mtabel_wp_alternatif.php */