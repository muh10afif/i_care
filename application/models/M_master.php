<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_master extends CI_Model {

    public function get_data($tabel)
    {
        return $this->db->get($tabel);
        
    }

    public function get_data_order($tabel, $field, $order)
    {
        $this->db->order_by($field, $order);
        
        return $this->db->get($tabel);
        
    }

    public function input_data($tabel, $data)
    {
        $this->db->insert($tabel, $data);
        
    }

    public function cari_data($tabel, $where)
    {
        return $this->db->get_where($tabel, $where);
        
    }

    public function cari_data_order($tabel, $where, $field, $order)
    {
        $this->db->order_by($field, $order);
        
        return $this->db->get_where($tabel, $where);
        
    }

    public function ubah_data($tabel, $data, $where)
    {
        $this->db->where($where);
        $this->db->update($tabel, $data);
    }

    public function hapus_data($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    public function cari_data_debitur($id_debitur)
    {
        $this->db->select("d.id_debitur, d.no_klaim, d.nama_debitur, d.no_reff, d.tgl_klaim, asr.asuransi, asr.id_asuransi, d.*, asu.*, cap.*, cab.*, asu.cabang_asuransi, cab.cabang_bank, b.bank, cap.capem_bank, d.jenis_kredit, d.bunga, d.subrogasi_as, d.recoveries_awal_asuransi, (SELECT sum(nominal) as tot_nominal_as FROM tr_recov_as where id_debitur=d.id_debitur)");
		$this->db->from('debitur as d');
		$this->db->join('m_capem_bank as cap', 'cap.id_capem_bank = d.id_capem_bank', 'inner');
		$this->db->join('m_cabang_bank as cab', 'cab.id_cabang_bank = cap.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cab.id_bank', 'inner');
        $this->db->join('m_cabang_asuransi as asu','asu.id_cabang_asuransi = d.id_cabang_as','INNER');
		$this->db->join('m_korwil_asuransi as kor','kor.id_korwil_asuransi = asu.id_korwil_asuransi','INNER');
        $this->db->join('m_asuransi as asr', 'asr.id_asuransi = kor.id_asuransi', 'inner');
        $this->db->where('d.id_debitur', $id_debitur);
        
        return $this->db->get();
        
    }

    public function cari_cab_asuransi($id_asuransi)
    {
        $this->db->select('c.id_cabang_asuransi, c.cabang_asuransi');
        $this->db->from('m_asuransi as s');
        $this->db->join('m_korwil_asuransi as k', 'k.id_asuransi = s.id_asuransi', 'inner');
        $this->db->join('m_cabang_asuransi as c', 'c.id_korwil_asuransi = k.id_korwil_asuransi', 'inner');
        $this->db->where('s.id_asuransi', $id_asuransi);
        
        return $this->db->get();
        
    }

    // mencari cabang bank
    public function cari_cab_bank($id_bank)
    {
        $this->db->select('cb.cabang_bank, cb.id_cabang_bank');
        $this->db->from('m_bank as b');
        $this->db->join('m_cabang_bank as cb', 'cb.id_bank = b.id_bank', 'inner');
        $this->db->where('b.id_bank', $id_bank);
        
        return $this->db->get();
        
    }

    // mencari capem bank
    public function cari_cap_bank($id_cabang_bank)
    {
        $this->db->select('c.id_capem_bank, c.capem_bank');
        $this->db->from('m_cabang_bank as cb');
        $this->db->join('m_capem_bank as c', 'c.id_cabang_bank = cb.id_cabang_bank', 'inner');
        $this->db->where('cb.id_cabang_bank', $id_cabang_bank);
        
        return $this->db->get();
    }

    public function cari_data_deb($tabel, $no_klaim, $no_reff)
    {
        $this->db->where('no_klaim', "$no_klaim");
        $this->db->where('no_reff', "$no_reff");
        
        return $this->db->get($tabel);
        
    }

    /*****************************************************************************************************/
    /*
    /*                                              Karyawan
    /*
    /*****************************************************************************************************/

    // Master Karyawan
    public function get_data_karyawan()
    {
        $this->_get_datatables_query_karyawan();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_karyawan = [null, 'nama_lengkap', 'nik', 'telfon', 'alamat', 'k.verifikator'];
    var $kolom_cari_karyawan  = ['LOWER(nama_lengkap)', 'LOWER(nik)', 'LOWER(telfon)', 'LOWER(alamat)', 'CAST(k.verifikator AS VARCHAR)'];
    var $order_karyawan       = ['nama_lengkap' => 'asc'];

    public function _get_datatables_query_karyawan()
    {
        // SELECT k.nama_lengkap, k.nik, k.telfon, k.alamat
        // FROM karyawan as k 
        // JOIN penempatan as p ON p.id_karyawan = k.id_karyawan
        // GROUP BY k.id_karyawan

        // $this->db->select('k.nama_lengkap, k.nik, k.telfon, k.alamat, k.id_karyawan');
        // $this->db->from('karyawan as k');
        // $this->db->join('penempatan as p', 'p.id_karyawan = k.id_karyawan', 'inner');
        // $this->db->group_by('k.id_karyawan');

        $this->db->select('k.nama_lengkap, k.nik, k.telfon, k.alamat, k.id_karyawan, k.verifikator');
        $this->db->from('karyawan as k');

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_karyawan;

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

            $kolom_order = $this->kolom_order_karyawan;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_karyawan)) {
            
            $order = $this->order_karyawan;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_karyawan()
    {
        $this->db->select('k.nama_lengkap, k.nik, k.telfon, k.alamat, k.id_karyawan, k.verifikator');
        $this->db->from('karyawan as k');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_karyawan()
    {
        $this->_get_datatables_query_karyawan();

        return $this->db->get()->num_rows();
        
    }

    /*****************************************************************************************************/
    /*
    /*                                              Rekening
    /*
    /*****************************************************************************************************/

    // Master rekening
    public function get_data_rekening()
    {
        $this->_get_datatables_query_rekening();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_rekening = [null, 'no_rekening', 'cabang_asuransi'];
    var $kolom_cari_rekening  = ['LOWER(no_rekening)', 'LOWER(cabang_asuransi)'];
    var $order_rekening       = ['cabang_asuransi' => 'asc'];

    public function _get_datatables_query_rekening()
    {
        $this->db->from('rekening as r');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = r.id_cabang_asuransi', 'inner');
        
        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_rekening;

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

            $kolom_order = $this->kolom_order_rekening;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_rekening)) {
            
            $order = $this->order_rekening;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_rekening()
    {
        $this->db->from('rekening as r');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = r.id_cabang_asuransi', 'inner');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_rekening()
    {
        $this->_get_datatables_query_rekening();

        return $this->db->get()->num_rows();
        
    }

    /*****************************************************************************************************/
    /*
    /*                                              SPK
    /*
    /*****************************************************************************************************/

    // Master spk
    public function get_data_spk()
    {
        $this->_get_datatables_query_spk();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_spk = [null, '', 'ca.cabang_asuransi', 'k.no_rekening', 'CAST(r.tgl_mulai as VARCHAR)', 'CAST(r.tgl_akhir as VARCHAR)'];
    var $kolom_cari_spk  = ['', 'LOWER(ca.cabang_asuransi)', 'k.no_rekening', 'CAST(r.tgl_mulai as VARCHAR)', 'CAST(r.tgl_akhir as VARCHAR)'];
    var $order_spk       = ['ca.cabang_asuransi' => 'asc'];

    public function _get_datatables_query_spk()
    {
        $this->db->from('spk as r');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = r.id_cabang_asuransi', 'inner');
        $this->db->join('rekening as k', 'id_rekening', 'left');
        
        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_spk;

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

            $kolom_order = $this->kolom_order_spk;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_spk)) {
            
            $order = $this->order_spk;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_spk()
    {
        $this->db->from('spk as r');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = r.id_cabang_asuransi', 'inner');
        $this->db->join('rekening as k', 'id_rekening', 'left');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_spk()
    {
        $this->_get_datatables_query_spk();

        return $this->db->get()->num_rows();
        
    }

    /*****************************************************************************************************/
    /*
    /*                                              Pengguna
    /*
    /*****************************************************************************************************/

    // cari karyawan 
    public function cari_data_karyawan($tabel, $where)
    {
        $this->db->select('nama_lengkap');
        $this->db->from($tabel);
        $this->db->where($where);
        
        return $this->db->get();
        
    }

    // Master pengguna
    public function get_data_pengguna()
    {
        $this->_get_datatables_query_pengguna();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_pengguna = [null, "",'p.username', 'l.level', 'p.status_pengguna'];
    var $kolom_cari_pengguna  = ["",'LOWER(p.username)', 'LOWER(l.level)', 'CAST(p.status_pengguna)'];
    var $order_pengguna       = ['' => 'asc'];

    public function _get_datatables_query_pengguna()
    {
        $this->db->select('p.username, p.status_pengguna,l.level, p.id_pengguna, l.id_level, p.id_karyawan');
        $this->db->from('pengguna as p');
        //$this->db->join('karyawan as k', 'k.id_karyawan = p.id_karyawan', 'inner');
        $this->db->join('level as l', 'l.id_level = p.level', 'inner');
        
        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_pengguna;

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

            $kolom_order = $this->kolom_order_pengguna;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_pengguna)) {
            
            $order = $this->order_pengguna;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_pengguna()
    {
        $this->db->select('p.username, p.status_pengguna, l.level, p.id_pengguna, l.id_level, p.id_karyawan');
        $this->db->from('pengguna as p');
        //$this->db->join('karyawan as k', 'k.id_karyawan = p.id_karyawan', 'inner');
        $this->db->join('level as l', 'l.id_level = p.level', 'inner');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_pengguna()
    {
        $this->_get_datatables_query_pengguna();

        return $this->db->get()->num_rows();
        
    }

    /*****************************************************************************************************/
    /*
    /*                                              Bank
    /*
    /*****************************************************************************************************/

    // Master bank
    public function get_data_bank()
    {
        $this->_get_datatables_query_bank();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_bank = [null, 'bank', 'singkatan'];
    var $kolom_cari_bank  = ['LOWER(bank)', 'LOWER(singkatan)'];
    var $order_bank       = ['bank' => 'asc'];

    public function _get_datatables_query_bank()
    {
        $this->db->from('m_bank');

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_bank;

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

            $kolom_order = $this->kolom_order_bank;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_bank)) {
            
            $order = $this->order_bank;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_bank()
    {
        $this->db->from('m_bank');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_bank()
    {
        $this->_get_datatables_query_bank();

        return $this->db->get()->num_rows();
        
    }

    /*****************************************************************************************************/
    /*
    /*                                              Cabang Bank
    /*
    /*****************************************************************************************************/

    // Master cabang_bank
    public function get_data_cabang_bank()
    {
        $this->_get_datatables_query_cabang_bank();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_cabang_bank = [null, 'cabang_bank', 'bank'];
    var $kolom_cari_cabang_bank  = ['LOWER(cabang_bank)', 'LOWER(bank)'];
    var $order_cabang_bank       = ['cabang_bank' => 'asc'];

    public function _get_datatables_query_cabang_bank()
    {
        $this->db->from('m_cabang_bank as cb');
        $this->db->join('m_bank as b', 'b.id_bank = cb.id_bank', 'inner');
        
        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_cabang_bank;

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

            $kolom_order = $this->kolom_order_cabang_bank;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_cabang_bank)) {
            
            $order = $this->order_cabang_bank;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_cabang_bank()
    {
        $this->db->from('m_cabang_bank as cb');
        $this->db->join('m_bank as b', 'b.id_bank = cb.id_bank', 'inner');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_cabang_bank()
    {
        $this->_get_datatables_query_cabang_bank();

        return $this->db->get()->num_rows();
        
    }

    /*****************************************************************************************************/
    /*
    /*                                              Capem Bank
    /*
    /*****************************************************************************************************/

    // 09-03-2020

        public function get_data_capem_bank_excel()
        {
            $this->db->from('m_capem_bank as cb');
            $this->db->join('m_cabang_bank as b', 'b.id_cabang_bank = cb.id_cabang_bank', 'inner');
            $this->db->join('m_bank as n', 'n.id_bank = b.id_bank', 'inner');

            return $this->db->get();
        }

    // Akhir 09-03-2020

    // Master capem_bank
    public function get_data_capem_bank()
    {
        $this->_get_datatables_query_capem_bank();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_capem_bank = [null, 'n.bank', 'b.cabang_bank', 'cb.capem_bank'];
    var $kolom_cari_capem_bank  = ['LOWER(n.bank)', 'LOWER(b.cabang_bank)', 'LOWER(cb.capem_bank)'];
    var $order_capem_bank       = ['cb.capem_bank' => 'asc'];

    public function _get_datatables_query_capem_bank()
    {
        $this->db->from('m_capem_bank as cb');
        $this->db->join('m_cabang_bank as b', 'b.id_cabang_bank = cb.id_cabang_bank', 'inner');
        $this->db->join('m_bank as n', 'n.id_bank = b.id_bank', 'inner');
        
        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_capem_bank;

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

            $kolom_order = $this->kolom_order_capem_bank;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_capem_bank)) {
            
            $order = $this->order_capem_bank;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_capem_bank()
    {
        $this->db->from('m_capem_bank as cb');
        $this->db->join('m_cabang_bank as b', 'b.id_cabang_bank = cb.id_cabang_bank', 'inner');
        $this->db->join('m_bank as n', 'n.id_bank = b.id_bank', 'inner');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_capem_bank()
    {
        $this->_get_datatables_query_capem_bank();

        return $this->db->get()->num_rows();
        
    }

    /*****************************************************************************************************/
    /*
    /*                                              Asuransi
    /*
    /*****************************************************************************************************/

    // Master asuransi
    public function get_data_asuransi()
    {
        $this->_get_datatables_query_asuransi();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_asuransi = [null, 'asuransi'];
    var $kolom_cari_asuransi  = ['LOWER(asuransi)'];
    var $order_asuransi       = ['asuransi' => 'asc'];

    public function _get_datatables_query_asuransi()
    {
        $this->db->from('m_asuransi');

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_asuransi;

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

            $kolom_order = $this->kolom_order_asuransi;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_asuransi)) {
            
            $order = $this->order_asuransi;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_asuransi()
    {
        $this->db->from('m_asuransi');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_asuransi()
    {
        $this->_get_datatables_query_asuransi();

        return $this->db->get()->num_rows();
        
    }

    /*****************************************************************************************************/
    /*
    /*                                            Korwil Asuransi
    /*
    /*****************************************************************************************************/

    // Master korwil_asuransi
    public function get_data_korwil_asuransi()
    {
        $this->_get_datatables_query_korwil_asuransi();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_korwil_asuransi = [null, 'k.korwil_asuransi', 's.asuransi'];
    var $kolom_cari_korwil_asuransi  = ['LOWER(k.korwil_asuransi)', 'LOWER(s.asuransi)'];
    var $order_korwil_asuransi       = ['k.korwil_asuransi' => 'asc'];

    public function _get_datatables_query_korwil_asuransi()
    {
        $this->db->from('m_korwil_asuransi as k');
        $this->db->join('m_asuransi as s', 's.id_asuransi = k.id_asuransi', 'inner');

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_korwil_asuransi;

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

            $kolom_order = $this->kolom_order_korwil_asuransi;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_korwil_asuransi)) {
            
            $order = $this->order_korwil_asuransi;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_korwil_asuransi()
    {
        $this->db->from('m_korwil_asuransi as k');
        $this->db->join('m_asuransi as s', 's.id_asuransi = k.id_asuransi', 'inner');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_korwil_asuransi()
    {
        $this->_get_datatables_query_korwil_asuransi();

        return $this->db->get()->num_rows();
        
    }

    /*****************************************************************************************************/
    /*
    /*                                              Cabang Asuransi
    /*
    /*****************************************************************************************************/

    // 13-03-2020

        // ambil data unduh excel cabang asuransi
        public function get_data_cabang_asuransi_excel()
        {
            $this->db->from('m_cabang_asuransi as k');
            $this->db->join('m_korwil_asuransi as s', 's.id_korwil_asuransi = k.id_korwil_asuransi', 'inner');
            $this->db->join('m_asuransi as r', 'r.id_asuransi = s.id_asuransi', 'inner');

            return $this->db->get();
        }

    // Akhir 13-03-2020

    // Master cabang_asuransi
    public function get_data_cabang_asuransi()
    {
        $this->_get_datatables_query_cabang_asuransi();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_cabang_asuransi = [null, 'r.asuransi', 's.korwil_asuransi', 'k.cabang_asuransi', 'k.singkatan'];
    var $kolom_cari_cabang_asuransi  = ['LOWER(r.asuransi)', 'LOWER(r.asuransi)', 'LOWER(s.korwil_asuransi)', 'LOWER(k.cabang_asuransi)', 'LOWER(k.singkatan)'];
    var $order_cabang_asuransi       = ['k.cabang_asuransi' => 'asc'];

    public function _get_datatables_query_cabang_asuransi()
    {
        $this->db->from('m_cabang_asuransi as k');
        $this->db->join('m_korwil_asuransi as s', 's.id_korwil_asuransi = k.id_korwil_asuransi', 'inner');
        $this->db->join('m_asuransi as r', 'r.id_asuransi = s.id_asuransi', 'inner');

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_cabang_asuransi;

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

            $kolom_order = $this->kolom_order_cabang_asuransi;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_cabang_asuransi)) {
            
            $order = $this->order_cabang_asuransi;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_cabang_asuransi()
    {
        $this->db->from('m_cabang_asuransi as k');
        $this->db->join('m_korwil_asuransi as s', 's.id_korwil_asuransi = k.id_korwil_asuransi', 'inner');
        $this->db->join('m_asuransi as r', 'r.id_asuransi = s.id_asuransi', 'inner');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_cabang_asuransi()
    {
        $this->_get_datatables_query_cabang_asuransi();

        return $this->db->get()->num_rows();
        
    }

    /*****************************************************************************************************/
    /*
    /*                                                Debitur
    /*
    /*****************************************************************************************************/

    public function get_data_bank_3()
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

    // 13-03-2020

        public function get_debitur_excel($bank, $cb_bank, $spk)
        {
            $this->db->select("d.id_debitur, d.nama_debitur, d.no_klaim, d.id_care, d.no_reff, asu.cabang_asuransi, cab.cabang_bank, b.bank, d.subrogasi_as, d.recoveries_awal_asuransi, s.no_spk,  (SELECT sum(nominal) as tot_nominal_as FROM tr_recov_as where id_debitur=d.id_debitur)");
            $this->db->from('debitur as d');
            $this->db->join('m_capem_bank as cap', 'cap.id_capem_bank = d.id_capem_bank', 'inner');
            $this->db->join('m_cabang_bank as cab', 'cab.id_cabang_bank = cap.id_cabang_bank', 'inner');
            $this->db->join('m_bank as b', 'b.id_bank = cab.id_bank', 'inner');
            $this->db->join('m_cabang_asuransi as asu','asu.id_cabang_asuransi = d.id_cabang_as','INNER');
            $this->db->join('m_korwil_asuransi as kor','kor.id_korwil_asuransi = asu.id_korwil_asuransi','INNER');
            $this->db->join('m_asuransi as asr', 'asr.id_asuransi = kor.id_asuransi', 'inner');
            $this->db->join('spk as s', 's.id_spk = d.id_spk', 'left');

            if ($bank != 'a') {
                $this->db->where('b.id_bank', $bank);
            }
            if ($cb_bank != 'a') {
                $this->db->where('cab.id_cabang_bank', $cb_bank);
            }
            if ($spk != 'a') {
                if ($spk == 'null') {
                    $this->db->where("d.id_spk is null");
                } else {
                    $this->db->where('d.id_spk', $spk);
                }
            }

            $this->db->order_by('d.nama_debitur', 'asc');
            
            return $this->db->get();
            
        }

    // Akhir 13-03-2020

    public function get_data_m_debitur($bank, $cb_bank, $spk)
    {
        $this->_get_datatables_query_m_debitur($bank, $cb_bank, $spk);

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_m_debitur = [null, 'd.no_reff', 'd.no_klaim', 'd.nama_debitur', 'asu.cabang_asuransi', 'b.bank', 'cab.cabang_bank'];
    var $kolom_cari_m_debitur  = ['LOWER(d.no_reff)','LOWER(d.nama_debitur)', 'LOWER(asu.cabang_asuransi)', 'LOWER(b.bank)', 'LOWER(cab.cabang_bank)'];
    var $order_m_debitur       = ['d.id_debitur' => 'desc'];

    public function _get_datatables_query_m_debitur($bank, $cb_bank, $spk)
    {
        $this->db->select("d.id_debitur, d.nama_debitur, d.no_klaim, d.id_care, d.no_reff, asu.cabang_asuransi, cab.cabang_bank, b.bank, d.subrogasi_as, d.recoveries_awal_asuransi, (SELECT sum(nominal) as tot_nominal_as FROM tr_recov_as where id_debitur=d.id_debitur)");
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
        if ($spk != 'a') {
            if ($spk == 'null') {
                $this->db->where("d.id_spk is null");
            } else {
                $this->db->where('d.id_spk', $spk);
            }
        }
        
        $b = 0;

        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_m_debitur;

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

            $kolom_order = $this->kolom_order_m_debitur;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_m_debitur)) {
            
            $order = $this->order_m_debitur;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
    }

    public function jumlah_semua_m_debitur($bank, $cb_bank, $spk)
    {
        $this->db->select("d.id_debitur, d.nama_debitur, d.no_klaim,, d.id_care, d.no_reff, asu.cabang_asuransi, cab.cabang_bank, b.bank, d.subrogasi_as, d.recoveries_awal_asuransi, (SELECT sum(nominal) as tot_nominal_as FROM tot_recov_as where id_debitur=d.id_debitur)");
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
        if ($spk != 'a') {
            if ($spk == 'null') {
                $this->db->where("d.id_spk is null");
            } else {
                $this->db->where('d.id_spk', $spk);
            }
        }

        return $this->db->count_all_results();
    }

    public function jumlah_filter_m_debitur($bank, $cb_bank, $spk)
    {
        $this->_get_datatables_query_m_debitur($bank, $cb_bank, $spk);
        
        return $this->db->get()->num_rows();
        
    }
}

/* End of file M_master.php */
