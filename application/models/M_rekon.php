<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_rekon extends CI_Model {

    public function get_data($tabel)
    {
        return $this->db->get($tabel);
        
    }

    public function cari_data($tabel, $where)
    {
        return $this->db->get_where($tabel, $where);
    }

    public function cari_data_histori($tabel, $where)
    {
        $this->db->order_by('add_time', 'desc');
        return $this->db->get_where($tabel, $where);
    }

    public function input_data($tabel, $data)
    {
        $this->db->insert($tabel, $data);
    }

    public function cari_cabang_bank($id_cab_asuransi)
    {
        $this->db->distinct();
        $this->db->select('cab.id_cabang_bank, cab.cabang_bank');
        $this->db->from('debitur as d');
        $this->db->join('m_capem_bank as cap', 'cap.id_capem_bank = d.id_capem_bank', 'inner');
        $this->db->join('m_cabang_bank as cab', 'cab.id_cabang_bank = cap.id_cabang_bank', 'inner');
        $this->db->where('d.id_cabang_as', $id_cab_asuransi);
        
        return $this->db->get();
        
    }

    public function get_periode_cab()
    {
        $this->db->select('*');
        $this->db->from('rekonsiliasi');
        $a  = $this->db->get()->result();
        $ar = array();
        foreach ($a as $b) {
            $ar[] = $b->id_periode;
        }
        $im = implode(",", $ar);
        $hasil = explode(",", $im);

        $this->db->select('cab.cabang_bank, p.id_periode, mp.nama_periode');
        $this->db->from('periode as p');
        $this->db->join('m_cabang_bank as cab', 'cab.id_cabang_bank = p.id_cabang_bank', 'inner');
        $this->db->join('m_periode as mp', 'mp.id_periode = p.m_periode', 'inner');
        
        if ($hasil[0] != "") {
            $this->db->where_not_in('p.id_periode', $hasil);
        }
        
        return $this->db->get();
    }

    public function get_rekon_deb($id_periode)
    {
        $this->_get_datatables_query_rekon_deb($id_periode);

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_rekon_deb = [null, 'mp.nama_periode', 'd.nama_debitur', 'ca.cabang_asuransi', 'b.bank', 'cb.cabang_bank'];
    var $kolom_cari_rekon_deb  = ['LOWER(mp.nama_periode)', 'LOWER(d.nama_debitur)', 'LOWER(ca.cabang_asuransi)', 'LOWER(b.bank)', 'LOWER(cb.cabang_bank)'];
    var $order_rekon_deb       = ['p.id_periode' => 'desc'];

    public function _get_datatables_query_rekon_deb($id_periode)
    {
        $this->db->select('*');
        $this->db->from('rekonsiliasi');
        $a  = $this->db->get()->result();
        $ar = array();
        foreach ($a as $b) {
            $ar[] = $b->id_periode;
        }
        $im = implode(",", $ar);
        $hasil = explode(",", $im);

        $this->db->select('p.id_periode, d.nama_debitur, mp.nama_periode, ca.cabang_asuransi, cb.cabang_bank, b.bank');
        $this->db->from('periode as p');
        $this->db->join('m_periode as mp', 'mp.id_periode = p.m_periode', 'inner');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = p.id_cabang_as', 'inner');
        $this->db->join('m_cabang_bank as cb', 'cb.id_cabang_bank = p.id_cabang_bank', 'inner');
        $this->db->join('m_capem_bank as cp', 'cp.id_cabang_bank = cb.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cb.id_bank', 'inner');
        $this->db->join('debitur as d', 'd.id_capem_bank = cp.id_capem_bank', 'inner');
        
        if ($hasil[0] != "") {
            $this->db->where_not_in('p.id_periode', $hasil);
        }
        
        if ($id_periode != 'a') {
            $this->db->where('p.id_periode', $id_periode);
        }

        $b = 0;

        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_rekon_deb;

        foreach ($kolom_cari as $cari) {
            if ($input_cari) {
                if ($b === 0) {
                    $this->db->group_start();
                    $this->db->like($cari, $input_cari);
                } else {
                    $this->db->or_like($cari, $input_cari);
                }

                if ((count($kolom_cari) - 1) == $b ) {
                    $this->db->group_end();
                }
            }

            $b++;
        }

        if (isset($_POST['order'])) {

            $kolom_order = $this->kolom_order_rekon_deb;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_rekon_deb)) {
            
            $order = $this->order_rekon_deb;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
    }

    public function jumlah_semua_rekon_deb($id_periode)
    {
        $this->db->select('*');
        $this->db->from('rekonsiliasi');
        $a  = $this->db->get()->result();
        $ar = array();
        foreach ($a as $b) {
            $ar[] = $b->id_periode;
        }
        $im = implode(",", $ar);
        $hasil = explode(",", $im);

        $this->db->select('p.id_periode, d.nama_debitur, mp.nama_periode, ca.cabang_asuransi, cb.cabang_bank, b.bank');
        $this->db->from('periode as p');
        $this->db->join('m_periode as mp', 'mp.id_periode = p.m_periode', 'inner');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = p.id_cabang_as', 'inner');
        $this->db->join('m_cabang_bank as cb', 'cb.id_cabang_bank = p.id_cabang_bank', 'inner');
        $this->db->join('m_capem_bank as cp', 'cp.id_cabang_bank = cb.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cb.id_bank', 'inner');
        $this->db->join('debitur as d', 'd.id_capem_bank = cp.id_capem_bank', 'inner');
        
        if ($hasil[0] != "") {
            $this->db->where_not_in('p.id_periode', $hasil);
        }

        if ($id_periode != 'a') {
            $this->db->where('p.id_periode', $id_periode);
        }

        return $this->db->count_all_results();
    }

    public function jumlah_filter_rekon_deb($id_periode)
    {
        $this->_get_datatables_query_rekon_deb($id_periode);
        return $this->db->get()->num_rows();
        
    }

    // menampilkan list periode rekon
    public function list_periode_rekon()
    {
        $this->db->select('mp.id_periode, mp.nama_periode');
        $this->db->from('periode as p');
        $this->db->join('m_periode as mp', 'mp.id_periode = p.m_periode', 'inner');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = p.id_cabang_as', 'inner');
        $this->db->join('m_cabang_bank as cb', 'cb.id_cabang_bank = p.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cb.id_bank', 'inner');
        $this->db->join('rekonsiliasi as r', 'r.id_periode = p.id_periode', 'inner');
        $this->db->join('bar as br', 'br.id_bar = r.id_bar', 'left');
        $this->db->join('invoice as i', 'i.id_invoice = r.id_invoice', 'left');

        $this->db->group_by('mp.id_periode');
        $this->db->group_by('mp.nama_periode');

        return $this->db->get();
    }
    
    public function get_rekon($id_periode)
    {
        $this->_get_datatables_query_rekon($id_periode);

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_rekon = [null, 'mp.nama_periode', 'ca.cabang_asuransi', 'b.bank', 'cb.cabang_bank', 'br.no_bar', 'i.no_invoice', "LOWER(CAST(to_char(p.add_time, 'DD-Mon-YYYY HH24:MI:SS') AS VARCHAR))", 'g.username'];
    var $kolom_cari_rekon  = ['LOWER(mp.nama_periode)', 'LOWER(ca.cabang_asuransi)', 'LOWER(b.bank)', 'LOWER(cb.cabang_bank)', 'LOWER(br.no_bar)', 'LOWER(i.no_invoice)', "LOWER(CAST(to_char(p.add_time, 'DD-Mon-YYYY HH24:MI:SS') AS VARCHAR))", 'g.username'];
    var $order_rekon       = ['r.id_rekon' => 'desc'];

    public function _get_datatables_query_rekon($id_periode)
    {
        $this->db->select('r.id_rekon, p.id_periode, mp.nama_periode, br.no_bar, i.no_invoice,ca.cabang_asuransi, cb.cabang_bank, b.bank, p.add_time, g.username');
        $this->db->from('periode as p');
        $this->db->join('m_periode as mp', 'mp.id_periode = p.m_periode', 'inner');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = p.id_cabang_as', 'inner');
        $this->db->join('m_cabang_bank as cb', 'cb.id_cabang_bank = p.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cb.id_bank', 'inner');
        $this->db->join('rekonsiliasi as r', 'r.id_periode = p.id_periode', 'inner');
        $this->db->join('bar as br', 'br.id_bar = r.id_bar', 'left');
        $this->db->join('invoice as i', 'i.id_invoice = r.id_invoice', 'left');
        $this->db->join('pengguna as g', 'g.id_pengguna = p.created_by', 'left');
        
        if ($id_periode != 'a') {
            $this->db->where('p.m_periode', $id_periode);
        }

        $b = 0;

        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_rekon;

        foreach ($kolom_cari as $cari) {
            if ($input_cari) {
                if ($b === 0) {
                    $this->db->group_start();
                    $this->db->like($cari, $input_cari);
                } else {
                    $this->db->or_like($cari, $input_cari);
                }

                if ((count($kolom_cari) - 1) == $b ) {
                    $this->db->group_end();
                }
            }

            $b++;
        }

        if (isset($_POST['order'])) {

            $kolom_order = $this->kolom_order_rekon;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_rekon)) {
            
            $order = $this->order_rekon;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
    }

    public function jumlah_semua_rekon($id_periode)
    {
        $this->db->select('r.id_rekon, p.id_periode, mp.nama_periode, br.no_bar, i.no_invoice,ca.cabang_asuransi, cb.cabang_bank, b.bank');
        $this->db->from('periode as p');
        $this->db->join('m_periode as mp', 'mp.id_periode = p.m_periode', 'inner');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = p.id_cabang_as', 'inner');
        $this->db->join('m_cabang_bank as cb', 'cb.id_cabang_bank = p.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cb.id_bank', 'inner');
        $this->db->join('rekonsiliasi as r', 'r.id_periode = p.id_periode', 'inner');
        $this->db->join('bar as br', 'br.id_bar = r.id_bar', 'left');
        $this->db->join('invoice as i', 'i.id_invoice = r.id_invoice', 'left');
        
        if ($id_periode != 'a') {
            $this->db->where('p.m_periode', $id_periode);
        }

        return $this->db->count_all_results();
    }

    public function jumlah_filter_rekon($id_periode)
    {
        $this->_get_datatables_query_rekon($id_periode);

        return $this->db->get()->num_rows();
        
    }

    public function list_bank_rekon()
    {
        $this->db->select("b.id_bank, b.bank");
		$this->db->from('debitur as d');
		$this->db->join('m_capem_bank as cap', 'cap.id_capem_bank = d.id_capem_bank', 'inner');
		$this->db->join('m_cabang_bank as cab', 'cab.id_cabang_bank = cap.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cab.id_bank', 'inner');
        $this->db->join('m_cabang_asuransi as asu','asu.id_cabang_asuransi = d.id_cabang_as','INNER');
		$this->db->join('m_korwil_asuransi as kor','kor.id_korwil_asuransi = asu.id_korwil_asuransi','INNER');
        $this->db->join('m_asuransi as asr', 'asr.id_asuransi = kor.id_asuransi', 'inner');

        $this->db->group_by('b.id_bank');
        $this->db->group_by('b.bank');

        return $this->db->get();
        
    }

    public function get_debitur_r($bank, $cb_bank)
    {
        $this->_get_datatables_query_debitur_r($bank, $cb_bank); 

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_m_debitur_r = [null, 'd.nama_debitur', 'asu.cabang_asuransi', 'b.bank', 'cab.cabang_bank'];
    var $kolom_cari_m_debitur_r  = ['LOWER(d.nama_debitur)', 'LOWER(asu.cabang_asuransi)', 'LOWER(b.bank)', 'LOWER(cab.cabang_bank)'];
    var $order_m_debitur_r       = ['d.id_debitur' => 'desc'];

    public function _get_datatables_query_debitur_r($bank, $cb_bank)
    {
        $this->db->select("d.id_debitur, d.nama_debitur, d.no_reff, asu.cabang_asuransi, cab.cabang_bank, b.bank, d.subrogasi_as, d.recoveries_awal_asuransi, (SELECT sum(nominal) as tot_nominal_as FROM tr_recov_as where id_debitur=d.id_debitur)");
		$this->db->from('debitur as d');
		$this->db->join('m_capem_bank as cap', 'cap.id_capem_bank = d.id_capem_bank', 'inner');
		$this->db->join('m_cabang_bank as cab', 'cab.id_cabang_bank = cap.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cab.id_bank', 'inner');
        $this->db->join('m_cabang_asuransi as asu','asu.id_cabang_asuransi = d.id_cabang_as','INNER');
		$this->db->join('m_korwil_asuransi as kor','kor.id_korwil_asuransi = asu.id_korwil_asuransi','INNER');
        $this->db->join('m_asuransi as asr', 'asr.id_asuransi = kor.id_asuransi', 'inner');

        if ($bank != 'a') {
            $this->db->where('b.id_bank', $bank);
        }
        if ($cb_bank != 'a') {
            $this->db->where('cab.id_cabang_bank', $cb_bank);
        }
        
        $b = 0;

        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_m_debitur_r;

        foreach ($kolom_cari as $cari) {
            if ($input_cari) {
                if ($b === 0) {
                    $this->db->group_start();
                    $this->db->like($cari, $input_cari);
                } else {
                    $this->db->or_like($cari, $input_cari);
                }

                if ((count($kolom_cari) - 1) == $b ) {
                    $this->db->group_end();
                }
            }

            $b++;
        }

        if (isset($_POST['order'])) {

            $kolom_order = $this->kolom_order_m_debitur_r;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_m_debitur_r)) {
            
            $order = $this->order_m_debitur_r;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
    }

    public function jumlah_semua_debitur_r($bank, $cb_bank)
    {
        $this->db->select("d.id_debitur, d.nama_debitur, d.no_reff, asu.cabang_asuransi, cab.cabang_bank, b.bank, d.subrogasi_as, d.recoveries_awal_asuransi, (SELECT sum(nominal) as tot_nominal_as FROM tr_recov_as where id_debitur=d.id_debitur)");
		$this->db->from('debitur as d');
		$this->db->join('m_capem_bank as cap', 'cap.id_capem_bank = d.id_capem_bank', 'inner');
		$this->db->join('m_cabang_bank as cab', 'cab.id_cabang_bank = cap.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cab.id_bank', 'inner');
        $this->db->join('m_cabang_asuransi as asu','asu.id_cabang_asuransi = d.id_cabang_as','INNER');
		$this->db->join('m_korwil_asuransi as kor','kor.id_korwil_asuransi = asu.id_korwil_asuransi','INNER');
        $this->db->join('m_asuransi as asr', 'asr.id_asuransi = kor.id_asuransi', 'inner');

        if ($bank != 'a') {
            $this->db->where('b.id_bank', $bank);
        }
        if ($cb_bank != 'a') {
            $this->db->where('cab.id_cabang_bank', $cb_bank);
        }

        return $this->db->count_all_results();
    }

    public function jumlah_filter_debitur_r($bank, $cb_bank)
    {
        $this->_get_datatables_query_debitur_r($bank, $cb_bank);

        return $this->db->get()->num_rows();
        
    }

    public function get_periode_rekon()
    {
        $this->_get_datatables_query_periode_rekon();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_periode_rekon = [null, 'mp.nama_periode', 'CAST(p.tgl_bayar_awal as VARCHAR)','CAST(p.tgl_bayar_akhir as VARCHAR)', 'ca.cabang_asuransi', 'b.bank', 'cb.cabang_bank', "LOWER(CAST(to_char(p.add_time, 'DD-Mon-YYYY HH24:MI:SS') AS VARCHAR))", 'g.username'];
    var $kolom_cari_periode_rekon  = ['LOWER(mp.nama_periode)', 'CAST(p.tgl_bayar_awal as VARCHAR)','CAST(p.tgl_bayar_akhir as VARCHAR)', 'LOWER(ca.cabang_asuransi)', 'LOWER(b.bank)', 'LOWER(cb.cabang_bank)', "LOWER(CAST(to_char(p.add_time, 'DD-Mon-YYYY HH24:MI:SS') AS VARCHAR))", 'LOWER(g.username)'];
    var $order_periode_rekon       = ['p.id_periode' => 'desc'];

    public function _get_datatables_query_periode_rekon()
    {
        $this->db->select('mp.nama_periode, p.tgl_bayar_awal, p.tgl_bayar_akhir, ca.cabang_asuransi, cb.cabang_bank, b.bank, p.add_time, g.username');
        $this->db->from('periode as p');
        $this->db->join('m_periode as mp', 'mp.id_periode = p.m_periode', 'inner');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = p.id_cabang_as', 'inner');
        $this->db->join('m_cabang_bank as cb', 'cb.id_cabang_bank = p.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cb.id_bank', 'inner');
        $this->db->join('pengguna as g', 'g.id_pengguna = p.created_by', 'left');
        
        $b = 0;

        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_periode_rekon;

        foreach ($kolom_cari as $cari) {
            if ($input_cari) {
                if ($b === 0) {
                    $this->db->group_start();
                    $this->db->like($cari, $input_cari);
                } else {
                    $this->db->or_like($cari, $input_cari);
                }

                if ((count($kolom_cari) - 1) == $b ) {
                    $this->db->group_end();
                }
            }

            $b++;
        }

        if (isset($_POST['order'])) {

            $kolom_order = $this->kolom_order_periode_rekon;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_periode_rekon)) {
            
            $order = $this->order_periode_rekon;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
    }

    public function jumlah_semua_periode_rekon()
    {
        $this->db->select('mp.nama_periode, p.tgl_bayar_awal, p.tgl_bayar_akhir, ca.cabang_asuransi, cb.cabang_bank, b.bank, p.add_time, g.username');
        $this->db->from('periode as p');
        $this->db->join('m_periode as mp', 'mp.id_periode = p.m_periode', 'inner');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = p.id_cabang_as', 'inner');
        $this->db->join('m_cabang_bank as cb', 'cb.id_cabang_bank = p.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cb.id_bank', 'inner');
        $this->db->join('pengguna as g', 'g.id_pengguna = p.created_by', 'left');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_periode_rekon()
    {
        $this->_get_datatables_query_periode_rekon();

        return $this->db->get()->num_rows();
    }

    public function get_periode()
    {
        $this->_get_datatables_query_periode();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_periode = [null, 'nama_periode'];
    var $kolom_cari_periode  = ['LOWER(nama_periode)'];
    var $order_periode       = ['nama_periode' => 'desc'];

    public function _get_datatables_query_periode()
    {
        $this->db->from('m_periode');
        
        $b = 0;

        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_periode;

        foreach ($kolom_cari as $cari) {
            if ($input_cari) {
                if ($b === 0) {
                    $this->db->group_start();
                    $this->db->like($cari, $input_cari);
                } else {
                    $this->db->or_like($cari, $input_cari);
                }

                if ((count($kolom_cari) - 1) == $b ) {
                    $this->db->group_end();
                }
            }

            $b++;
        }

        if (isset($_POST['order'])) {

            $kolom_order = $this->kolom_order_periode;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_periode)) {
            
            $order = $this->order_periode;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
    }

    public function jumlah_semua_periode()
    {
        $this->db->from('m_periode');
        return $this->db->count_all_results();
    }

    public function jumlah_filter_periode()
    {
        $this->_get_datatables_query_periode();
        return $this->db->get()->num_rows();
        
    }

    // 06-04-2021
    public function get_recov_as($id_debitur)
    {
        $this->db->select('t.*, p.username');
        $this->db->from('tr_recov_as as t');
        $this->db->join('pengguna as p', 'p.id_pengguna = t.created_by', 'left');
        $this->db->where('t.id_debitur', $id_debitur);
        
        return $this->db->get();
    }

    // 12-04-2021
    public function get_debitur_rba($bank, $cb_bank)
    {
        $this->_get_datatables_query_debitur_rba($bank, $cb_bank); 

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_m_debitur_rba = [null, 'd.nama_debitur', 'asu.cabang_asuransi', 'b.bank', 'cab.cabang_bank'];
    var $kolom_cari_m_debitur_rba  = ['LOWER(d.nama_debitur)', 'LOWER(asu.cabang_asuransi)', 'LOWER(b.bank)', 'LOWER(cab.cabang_bank)'];
    var $order_m_debitur_rba       = ['d.id_debitur' => 'desc'];

    public function _get_datatables_query_debitur_rba($bank, $cb_bank)
    {
        if ($this->input->post('jenis') == 'asuransi') {
            $this->db->select("d.id_debitur, d.nama_debitur, d.no_reff, asu.cabang_asuransi, cab.cabang_bank, b.bank, d.subrogasi_as, d.recoveries_awal_asuransi, (SELECT sum(nominal) as tot_nominal_as FROM tr_recov_as where id_debitur=d.id_debitur)");
        } else {
            $this->db->select("d.id_debitur, d.nama_debitur, d.no_reff, asu.cabang_asuransi, cab.cabang_bank, b.bank, d.subrogasi_as, d.recoveries_awal_bank, (SELECT sum(nominal) as tot_nominal_as FROM tr_recov_bank where id_debitur=d.id_debitur)");
        }
        
		$this->db->from('debitur as d');
		$this->db->join('m_capem_bank as cap', 'cap.id_capem_bank = d.id_capem_bank', 'inner');
		$this->db->join('m_cabang_bank as cab', 'cab.id_cabang_bank = cap.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cab.id_bank', 'inner');
        $this->db->join('m_cabang_asuransi as asu','asu.id_cabang_asuransi = d.id_cabang_as','INNER');
		$this->db->join('m_korwil_asuransi as kor','kor.id_korwil_asuransi = asu.id_korwil_asuransi','INNER');
        $this->db->join('m_asuransi as asr', 'asr.id_asuransi = kor.id_asuransi', 'inner');

        if ($bank != 'a') {
            $this->db->where('b.id_bank', $bank);
        }
        if ($cb_bank != 'a') {
            $this->db->where('cab.id_cabang_bank', $cb_bank);
        }
        
        $b = 0;

        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_m_debitur_rba;

        foreach ($kolom_cari as $cari) {
            if ($input_cari) {
                if ($b === 0) {
                    $this->db->group_start();
                    $this->db->like($cari, $input_cari);
                } else {
                    $this->db->or_like($cari, $input_cari);
                }

                if ((count($kolom_cari) - 1) == $b ) {
                    $this->db->group_end();
                }
            }

            $b++;
        }

        if (isset($_POST['order'])) {

            $kolom_order = $this->kolom_order_m_debitur_rba;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_m_debitur_rba)) {
            
            $order = $this->order_m_debitur_rba;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
    }

    public function jumlah_semua_debitur_rba($bank, $cb_bank)
    {
        if ($this->input->post('jenis') == 'asuransi') {
            $this->db->select("d.id_debitur, d.nama_debitur, d.no_reff, asu.cabang_asuransi, cab.cabang_bank, b.bank, d.subrogasi_as, d.recoveries_awal_asuransi, (SELECT sum(nominal) as tot_nominal_as FROM tr_recov_as where id_debitur=d.id_debitur)");
        } else {
            $this->db->select("d.id_debitur, d.nama_debitur, d.no_reff, asu.cabang_asuransi, cab.cabang_bank, b.bank, d.subrogasi_as, d.recoveries_awal_bank, (SELECT sum(nominal) as tot_nominal_as FROM tr_recov_bank where id_debitur=d.id_debitur)");
        }
		$this->db->from('debitur as d');
		$this->db->join('m_capem_bank as cap', 'cap.id_capem_bank = d.id_capem_bank', 'inner');
		$this->db->join('m_cabang_bank as cab', 'cab.id_cabang_bank = cap.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cab.id_bank', 'inner');
        $this->db->join('m_cabang_asuransi as asu','asu.id_cabang_asuransi = d.id_cabang_as','INNER');
		$this->db->join('m_korwil_asuransi as kor','kor.id_korwil_asuransi = asu.id_korwil_asuransi','INNER');
        $this->db->join('m_asuransi as asr', 'asr.id_asuransi = kor.id_asuransi', 'inner');

        if ($bank != 'a') {
            $this->db->where('b.id_bank', $bank);
        }
        if ($cb_bank != 'a') {
            $this->db->where('cab.id_cabang_bank', $cb_bank);
        }

        return $this->db->count_all_results();
    }

    public function jumlah_filter_debitur_rba($bank, $cb_bank)
    {
        $this->_get_datatables_query_debitur_rba($bank, $cb_bank);

        return $this->db->get()->num_rows();
        
    }

}

/* End of file M_rekon.php */
