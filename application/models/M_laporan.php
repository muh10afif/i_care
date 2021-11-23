<?php 


defined('BASEPATH') OR exit('No direct script access allowed');

class M_laporan extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->db_2 = $this->load->database('database_hrd', TRUE);
    }

    /***********************************************************************/
    /*
    /*                       PENGELUARAN BULANAN
    /*
    /***********************************************************************/

    // export data
    public function get_data_export($tgl_awal, $tgl_akhir)
    {
        $this->db_2->select('dj.tgl_transaksi, dj.keterangan, dc.deskripsi_coa, dc.no_coa_des, a.pengguna as nama_lengkap, dj.debit');
        $this->db_2->from('detail_jurnal as dj');
        $this->db_2->join('des_coa as dc', 'dc.no_coa_des = dj.coa', 'inner');
        $this->db_2->join('anggota as a', 'CAST(a.id_anggota as VARCHAR) = CAST(dj.pelaksana as VARCHAR)', 'inner');
        $this->db_2->join('posisi as p', 'p.id_posisi = a.id_posisi', 'inner');
        $this->db_2->join('bagian as b','b.id_bagian = p.id_bagian', 'inner');
        $this->db_2->where('b.id_bagian', 4);
        $this->db_2->where('dj.id_group', 8);
        $this->db_2->order_by('dj.tgl_transaksi', 'asc');
        
        if ($tgl_awal != '' && $tgl_akhir != '') {

            $tgl_awal   = nice_date($tgl_awal, 'Y-m-d'); 
            $tgl_akhir  = nice_date($tgl_akhir, 'Y-m-d');

            $this->db_2->where("CAST(dj.tgl_transaksi AS VARCHAR) BETWEEN '$tgl_awal' AND '$tgl_akhir+1'");
        }

        return $this->db_2->get();
        
    }

    public function get_data_peng_bulanan($dt)
    {
        $this->_get_datatables_peng_bulanan($dt);

        if ($this->input->post('length') != -1) {
            $this->db_2->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db_2->get()->result_array();
        }
    }

    var $kolom_order_peng_bulanan = [null, 'CAST(dj.tgl_transaksi as VARCHAR)', 'dj.keterangan', 'a.pengguna', 'dc.no_coa_des', 'dc.deskripsi_coa'];
    var $kolom_cari_peng_bulanan  = ['CAST(dj.tgl_transaksi as VARCHAR)', 'LOWER(dj.keterangan)', 'LOWER(a.pengguna)', 'dc.no_coa_des', 'LOWER(dc.deskripsi_coa)'];
    var $order_peng_bulanan       = ['dj.tgl_transaksi  ' => 'desc'];

    public function _get_datatables_peng_bulanan($dt)
    {
        $this->db_2->select('dj.tgl_transaksi, dj.keterangan, dc.deskripsi_coa, dc.no_coa_des, a.pengguna, dj.debit');
        $this->db_2->from('detail_jurnal as dj');
        $this->db_2->join('des_coa as dc', 'dc.no_coa_des = dj.coa', 'inner');
        $this->db_2->join('anggota as a', 'CAST(a.id_anggota as VARCHAR) = CAST(dj.pelaksana as VARCHAR)', 'inner');
        $this->db_2->join('posisi as p', 'p.id_posisi = a.id_posisi', 'inner');
        $this->db_2->join('bagian as b','b.id_bagian = p.id_bagian', 'inner');
        $this->db_2->where('b.id_bagian', 4);
        $this->db_2->where('dj.id_group', 8);
        
        if ($dt['tanggal_awal'] != '' && $dt['tanggal_akhir'] != '') {

            $tgl_awal   = nice_date($dt['tanggal_awal'], 'Y-m-d'); 
            $tgl_akhir  = nice_date($dt['tanggal_akhir'], 'Y-m-d');

            $this->db_2->where("CAST(dj.tgl_transaksi AS VARCHAR) BETWEEN '$tgl_awal' AND '$tgl_akhir+1'");
        }
        
        $b = 0;

        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_peng_bulanan;

        foreach ($kolom_cari as $cari) {
            if ($input_cari) {
                if ($b === 0) {
                    $this->db_2->group_start();
                    $this->db_2->like($cari, $input_cari);
                } else {
                    $this->db_2->or_like($cari, $input_cari);
                }

                if ((count($kolom_cari) - 1) == $b ) {
                    $this->db_2->group_end();
                }
            }

            $b++;
        }

        if (isset($_POST['order'])) {

            $kolom_order = $this->kolom_order_peng_bulanan;
            $this->db_2->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_peng_bulanan)) {
            
            $order = $this->order_peng_bulanan;
            $this->db_2->order_by(key($order), $order[key($order)]);
            
        }

    }

    public function jumlah_semua_peng_bulanan($dt)
    {
        $this->db_2->select('dj.tgl_transaksi, dj.keterangan, dc.deskripsi_coa, dc.no_coa_des, a.pengguna, dj.debit');
        $this->db_2->from('detail_jurnal as dj');
        $this->db_2->join('des_coa as dc', 'dc.no_coa_des = dj.coa', 'inner');
        $this->db_2->join('anggota as a', 'CAST(a.id_anggota as VARCHAR) = CAST(dj.pelaksana as VARCHAR)', 'inner');
        $this->db_2->join('posisi as p', 'p.id_posisi = a.id_posisi', 'inner');
        $this->db_2->join('bagian as b','b.id_bagian = p.id_bagian', 'inner');
        $this->db_2->where('b.id_bagian', 4);
        $this->db_2->where('dj.id_group', 8);
        
        if ($dt['tanggal_awal'] != '' && $dt['tanggal_akhir'] != '') {

            $tgl_awal   = nice_date($dt['tanggal_awal'], 'Y-m-d'); 
            $tgl_akhir  = nice_date($dt['tanggal_akhir'], 'Y-m-d');

            $this->db_2->where("CAST(dj.tgl_transaksi AS VARCHAR) BETWEEN '$tgl_awal' AND '$tgl_akhir+1'");
        }

        return $this->db_2->count_all_results();
        
    }

    public function jumlah_filter_peng_bulanan($dt)
    {
        $this->_get_datatables_peng_bulanan($dt);
        return $this->db_2->get()->num_rows();
        
    }

    /***********************************************************************/
    /*
    /*                          BIAYA PER COA
    /*
    /***********************************************************************/

    public function get_data_biaya_p_bulan($dt)
    {
        $this->db_2->distinct();
        $this->db_2->select('d.tgl_transaksi, c.deskripsi_coa, c.no_coa_des');
        $this->db_2->from('detail_jurnal as d');
        $this->db_2->join('des_coa as c', 'c.no_coa_des = d.coa', 'inner');
        $this->db_2->where('d.id_group', 8);
        

        if ($dt['bulan_awal'] != '' && $dt['bulan_akhir'] != '') {

            $bln_awal   = nice_date($dt['bulan_awal'], 'Y-m'); 
            $bln_akhir  = nice_date($dt['bulan_akhir'], 'Y-m');

            $this->db_2->where("CAST(d.tgl_transaksi AS VARCHAR) BETWEEN '$bln_awal' AND '$bln_akhir+1'");
        }

        $this->db_2->order_by('d.tgl_transaksi', 'DESC');

        return $this->db_2->get();
        

    }

    public function get_data_detail_jurnal_coa($a, $k)
    {
        $this->db_2->select('d.tgl_transaksi, c.deskripsi_coa, c.no_coa_des');
        $this->db_2->from('detail_jurnal as d');
        // $this->db_2->join('karyawan as k', 'CAST(k.id_karyawan as VARCHAR) = d.pelaksana', 'inner');
        $this->db_2->join('anggota as a', 'CAST(a.id_anggota as VARCHAR) = CAST(d.pelaksana as VARCHAR)', 'inner');
        $this->db_2->join('posisi as p', 'p.id_posisi = a.id_posisi', 'inner');
        $this->db_2->join('bagian as b','b.id_bagian = p.id_bagian', 'inner');
        $this->db_2->join('des_coa as c', 'c.no_coa_des = d.coa', 'inner');
        $this->db_2->where('b.id_bagian', 4);
        $this->db_2->where('d.id_group', 8);

        if ($a != '' && $k != '') {

            $bulan_awal  = nice_date($a, 'Y-m');
            $bulan_akhir = nice_date($k, 'Y-m');

            // $this->db_2->where("CAST(d.tgl_transaksi as VARCHAR) BETWEEN '$bulan_awal' AND '$bulan_akhir+2'");

            $this->db_2->where("to_char(d.tgl_transaksi, 'YYYY-MM') BETWEEN '$bulan_awal' AND '$bulan_akhir'");
        }

        return $this->db_2->get();
    }

    public function get_data_detail_jurnal_coa_2($a, $k)
    {
        $this->db_2->select('c.deskripsi_coa, c.no_coa_des');
        $this->db_2->from('detail_jurnal as d');
        $this->db_2->join('anggota as a', 'CAST(a.id_anggota as VARCHAR) = CAST(d.pelaksana as VARCHAR)', 'inner');
        $this->db_2->join('posisi as p', 'p.id_posisi = a.id_posisi', 'inner');
        $this->db_2->join('bagian as b','b.id_bagian = p.id_bagian', 'inner');
        $this->db_2->join('des_coa as c', 'c.no_coa_des = d.coa', 'inner');
        $this->db_2->where('b.id_bagian', 4);
        $this->db_2->where('d.id_group', 8);
        
        if ($a != '' && $k != '') {

            $bulan_awal  = nice_date($a, 'Y-m');
            $bulan_akhir = nice_date($k, 'Y-m');

            $this->db_2->where("to_char(d.tgl_transaksi, 'YYYY-MM') BETWEEN '$bulan_awal' AND '$bulan_akhir'");
        }

        $this->db_2->group_by('c.no_coa_des');
        $this->db_2->group_by('c.deskripsi_coa');

        return $this->db_2->get();
    }

    public function get_cetak_coa($bulan, $no_coa)
    {
        $this->db_2->select('sum(debit) as total');
        $this->db_2->from('detail_jurnal as d');
        $this->db_2->join('anggota as a', 'CAST(a.id_anggota as VARCHAR) = CAST(d.pelaksana as VARCHAR)', 'inner');
        $this->db_2->join('posisi as p', 'p.id_posisi = a.id_posisi', 'inner');
        $this->db_2->join('bagian as b','b.id_bagian = p.id_bagian', 'inner');
        $this->db_2->join('des_coa as c', 'c.no_coa_des = d.coa', 'inner');
        $this->db_2->where('b.id_bagian', 4);
        $this->db_2->where('d.id_group', 8);

        $this->db_2->where("CAST(d.tgl_transaksi as VARCHAR) LIKE '%$bulan%'");
        $this->db_2->where('d.coa', $no_coa);
        
        return $this->db_2->get();
    }

    public function get_cetak_coa_jumlah($bulan)
    {
        $this->db_2->select('sum(debit) as total');
        $this->db_2->from('detail_jurnal as d');
        $this->db_2->join('anggota as a', 'CAST(a.id_anggota as VARCHAR) = CAST(d.pelaksana as VARCHAR)', 'inner');
        $this->db_2->join('posisi as p', 'p.id_posisi = a.id_posisi', 'inner');
        $this->db_2->join('bagian as b','b.id_bagian = p.id_bagian', 'inner');
        $this->db_2->join('des_coa as c', 'c.no_coa_des = d.coa', 'inner');
        $this->db_2->where('b.id_bagian', 4);
        $this->db_2->where('d.id_group', 8);

        $this->db_2->where("CAST(d.tgl_transaksi as VARCHAR) LIKE '%$bulan%'");
        
        return $this->db_2->get();
    }

    /***********************************************************************/
    /*
    /*                          BIAYA PER PIC
    /*
    /***********************************************************************/

    public function get_data_detail_jurnal($a, $k)
    {
        $this->db_2->join('anggota as a', 'CAST(a.id_anggota as VARCHAR) = CAST(d.pelaksana as VARCHAR)', 'inner');
        $this->db_2->join('posisi as p', 'p.id_posisi = a.id_posisi', 'inner');
        $this->db_2->join('bagian as b','b.id_bagian = p.id_bagian', 'inner');
        $this->db_2->join('des_coa as c', 'c.no_coa_des = d.coa', 'inner');
        $this->db_2->where('b.id_bagian', 4);
        $this->db_2->where('d.id_group', 8);

        if ($a != '' && $k != '') {

            $bulan_awal  = nice_date($a, 'Y-m');
            $bulan_akhir = nice_date($k, 'Y-m');

            $this->db_2->where("to_char(d.tgl_transaksi, 'YYYY-MM') BETWEEN '$bulan_awal' AND '$bulan_akhir'");
        }

        return $this->db_2->get('detail_jurnal as d');
    }

    public function get_data_detail_jurnal_pic($a, $k)
    {
        $this->db_2->select('a.pengguna as nama_lengkap, d.pelaksana as id_pic');
        $this->db_2->from('detail_jurnal as d');
        $this->db_2->join('anggota as a', 'CAST(a.id_anggota as VARCHAR) = CAST(d.pelaksana as VARCHAR)', 'inner');
        $this->db_2->join('posisi as p', 'p.id_posisi = a.id_posisi', 'inner');
        $this->db_2->join('bagian as b','b.id_bagian = p.id_bagian', 'inner');
        $this->db_2->join('des_coa as c', 'c.no_coa_des = d.coa', 'inner');
        $this->db_2->where('b.id_bagian', 4);
        $this->db_2->where('d.id_group', 8);

        if ($a != '' && $k != '') {

            $bulan_awal  = nice_date($a, 'Y-m');
            $bulan_akhir = nice_date($k, 'Y-m');

            $this->db_2->where("to_char(d.tgl_transaksi, 'YYYY-MM') BETWEEN '$bulan_awal' AND '$bulan_akhir'");
        }

        $this->db_2->group_by('a.id_anggota');
        $this->db_2->group_by('a.pengguna');
        $this->db_2->group_by('d.pelaksana');
        
        return $this->db_2->get();
    }

    public function get_cetak_pic($bulan, $id_pic)
    {
        $this->db_2->select('sum(d.debit) as total');
        $this->db_2->from('detail_jurnal as d');
        $this->db_2->join('anggota as a', 'CAST(a.id_anggota as VARCHAR) = CAST(d.pelaksana as VARCHAR)', 'inner');
        $this->db_2->join('posisi as p', 'p.id_posisi = a.id_posisi', 'inner');
        $this->db_2->join('bagian as b','b.id_bagian = p.id_bagian', 'inner');
        $this->db_2->join('des_coa as c', 'c.no_coa_des = d.coa', 'inner');
        $this->db_2->where('b.id_bagian', 4);
        $this->db_2->where('d.id_group', 8);
        $this->db_2->where("CAST(d.tgl_transaksi as VARCHAR) LIKE '%$bulan%'");
        $this->db_2->where('d.pelaksana', $id_pic);
        
        return $this->db_2->get();
    }

    public function get_cetak_pic_jumlah($bulan)
    {
        $this->db_2->select('sum(d.debit) as total');
        $this->db_2->from('detail_jurnal as d');
        $this->db_2->join('anggota as a', 'CAST(a.id_anggota as VARCHAR) = CAST(d.pelaksana as VARCHAR)', 'inner');
        $this->db_2->join('posisi as p', 'p.id_posisi = a.id_posisi', 'inner');
        $this->db_2->join('bagian as b','b.id_bagian = p.id_bagian', 'inner');
        $this->db_2->join('des_coa as c', 'c.no_coa_des = d.coa', 'inner');
        $this->db_2->where('b.id_bagian', 4);
        $this->db_2->where('d.id_group', 8);
        $this->db_2->where("CAST(d.tgl_transaksi as VARCHAR) LIKE '%$bulan%'");
        
        return $this->db_2->get();
    }

}

/* End of file M_laporan.php */
