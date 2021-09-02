<?php

class M_dashboard extends CI_Model {
    
    public function get_data_pengguna(){
        return $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();
    } 

    public function GetPegawai(){
        return $this->db->get_where('pengguna', ['id_permission' => '3'])->result();
    }

    public function GetKategori(){
        return $this->db->select('*')->from('kategori')->get()->result();
    }

    public function createIN($in,$data){
		$this->db->insert($in, $data);
	}

    public function readIN($in){
        $query = $this->db->select('*')->from($in)->get()->result();
        return $query;
    }
    
    public function updateIN($in,$wr,$id,$data){
        $this->db->where($wr, $id)->update($in, $data); 
    }

    public function deleteIN($in,$wr,$id){
        return $this->db->delete($in, array($wr => $id)); 
    }

    public function read_progress(){
        $query = $this->db->select('*')
            ->from('progress')
            ->join('pengguna','pengguna.id_pengguna = progress.id_pengguna')
            ->join('kategori','kategori.id_kategori = progress.id_kategori')
            ->get()->result();
        return $query;
    }
    
    public function cek_progress($id_pegawai,$tanggal){
        $query = $this->db->select('*')
            ->from('progress')
            ->where('id_pengguna',$id_pegawai)
            ->where('tanggal_progress',$tanggal)
            ->limit(1)
            ->get()->row_array();
        if($query > 0){
            $hasil = true;
        }else{
            $hasil = false;
        }
        return $hasil;
    }
    
    public function total_sensor($id_pegawai,$id_kategori,$firstDate,$lastDate){
        if($id_pegawai == '*' && $id_kategori == '*'){
            $query = $this->db->select('sum(jumlah) as total_sensor')->from('progress')
                ->where('tanggal_progress >=',$firstDate)->where('tanggal_progress <=',$lastDate)
                ->get()->row_array();
            return $query;
        }else if($id_pegawai == '*' && $id_kategori != '*'){
            $query = $this->db->select('sum(jumlah) as total_sensor')->from('progress')
                ->where('id_kategori',$id_kategori)
                ->where('tanggal_progress >=',$firstDate)->where('tanggal_progress <=',$lastDate)
                ->get()->row_array();
            return $query;
        }else if($id_pegawai != '*' && $id_kategori == '*'){
            $query = $this->db->select('sum(jumlah) as total_sensor')->from('progress')
                ->where('id_pengguna',$id_pegawai)
                ->where('tanggal_progress >=',$firstDate)->where('tanggal_progress <=',$lastDate)
                ->get()->row_array();
            return $query;
        }else{
            $query = $this->db->select('sum(jumlah) as total_sensor')->from('progress')
                ->where('id_pengguna',$id_pegawai)->where('id_kategori',$id_kategori)
                ->where('tanggal_progress >=',$firstDate)->where('tanggal_progress <=',$lastDate)
                ->get()->row_array();
            return $query;
        }
    }
    
    public function get_data_penyolderan($id_pegawai,$id_kategori,$date){
        if($id_pegawai == '*' && $id_kategori == '*'){
            $query = $this->db->select('sum(jumlah) as total')->from('progress')->where('tanggal_progress',$date)->get()->row_array();
            return $query;
        }else if($id_pegawai == '*' && $id_kategori != '*'){
            $query = $this->db->select('sum(jumlah) as total')->from('progress')->where('tanggal_progress',$date)->where('id_kategori',$id_kategori)->get()->row_array();
            return $query;
        }else if($id_pegawai != '*' && $id_kategori == '*'){
            $query = $this->db->select('sum(jumlah) as total')->from('progress')->where('tanggal_progress',$date)->where('id_pengguna',$id_pegawai)->get()->row_array();
            return $query;
        }else{
            $query = $this->db->select('sum(jumlah) as total')->from('progress')->where('tanggal_progress',$date)->where('id_pengguna',$id_pegawai)->where('id_kategori',$id_kategori)->get()->row_array();
            return $query;
        }
    }

    public function sumper_kategori($id_pegawai,$id_kategori,$firstDate,$lastDate){
        if($id_pegawai == '*'){
            $query = $this->db->select('nama_kategori , sum(jumlah) as total' )->from('progress')
            ->where('progress.id_kategori',$id_kategori)
            ->where('progress.tanggal_progress >=',$firstDate)->where('progress.tanggal_progress <=',$lastDate)
            ->join('kategori','kategori.id_kategori = progress.id_kategori')
            ->get()->row_array();
            return $query;
        }else{
            $query = $this->db->select('nama_kategori , sum(jumlah) as total' )->from('progress')
            ->where('progress.id_pengguna',$id_pegawai)->where('progress.id_kategori',$id_kategori)
            ->where('progress.tanggal_progress >=',$firstDate)->where('progress.tanggal_progress <=',$lastDate)
            ->join('kategori','kategori.id_kategori = progress.id_kategori')
            ->get()->row_array();
            return $query;
        }
    }

    public function sumper_pegawai($id_pegawai,$id_kategori,$firstDate,$lastDate){
        if($id_kategori == '*'){
            $query = $this->db->select('nama , sum(jumlah) as total' )->from('progress')
            ->where('progress.id_pengguna',$id_pegawai)
            ->where('progress.tanggal_progress >=',$firstDate)->where('progress.tanggal_progress <=',$lastDate)
            ->join('pengguna','pengguna.id_pengguna = progress.id_pengguna')
            ->get()->row_array();
            return $query;
        }else{
            $query = $this->db->select('nama , sum(jumlah) as total' )->from('progress')
            ->where('progress.id_pengguna',$id_pegawai)->where('progress.id_kategori',$id_kategori)
            ->where('progress.tanggal_progress >=',$firstDate)->where('progress.tanggal_progress <=',$lastDate)
            ->join('pengguna','pengguna.id_pengguna = progress.id_pengguna')
            ->get()->row_array();
            return $query;
        }
    }

}