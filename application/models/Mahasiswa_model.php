<?php 

use GuzzleHttp\Client;

class Mahasiswa_model extends CI_model {

    private $_client;

    public function __construct()
    {
        $this ->_client = new Client(['base_uri' => 'http://localhost:3030/api/', 'auth' => ['mamat', '4321']]) ;
    }

    public function getAllMahasiswa()
    {
        $res = $this->_client ->request('GET', 'mahasiswa', ['query' => ['key-token' => 'yukbisa']]);
        
        $data = json_decode($res ->getBody() ->getContents(), true)['data'];
        return $data;
    }

    public function tambahDataMahasiswa()
    {
        $data = [
            "nama" => $this->input->post('nama', true),
            "nrp" => $this->input->post('nrp', true),
            "email" => $this->input->post('email', true),
            "jurusan" => $this->input->post('jurusan', true),
            'key-token' => 'yukbisa'
        ];

        $this->_client ->request('POST', 'mahasiswa', ['form_params' => $data]);
    }

    public function hapusDataMahasiswa($id)
    {
        $this->_client ->request('DELETE', 'mahasiswa', ['form_params' => ['key-token' => 'yukbisa', 'id' => $id]]);
    }

    public function getMahasiswaById($id)
    {
        $res = $this->_client ->request('GET', 'mahasiswa', ['query' => ['key-token' => 'yukbisa', 'id' => $id]]);
        
        $data = json_decode($res ->getBody() ->getContents(), true)['data'][0];

        return $data;
    }

    public function ubahDataMahasiswa()
    {
        $data = [
            "nama" => $this->input->post('nama', true),
            "nrp" => $this->input->post('nrp', true),
            "email" => $this->input->post('email', true),
            "jurusan" => $this->input->post('jurusan', true),
            "id" => $this->input->post('id', true),
            'key-token' => 'yukbisa'
        ];

        $this->_client ->request('PUT', 'mahasiswa', ['form_params' => $data ]);
    }

    public function cariDataMahasiswa()
    {
        $keyword = $this->input->post('keyword', true);
        $this->db->like('nama', $keyword);
        $this->db->or_like('jurusan', $keyword);
        $this->db->or_like('nrp', $keyword);
        $this->db->or_like('email', $keyword);
        return $this->db->get('mahasiswa')->result_array();
    }
}