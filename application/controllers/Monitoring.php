<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('Cek_login_lib'));
        $this->cek_login_lib->logged_in_false();
        
        $this->load->model(array('M_master', 'M_monitoring'));
        
    }
    
    /*****************************************************************************************************/
    /*
    /*                                              BAR
    /*
    /*****************************************************************************************************/
    
    public function index()
    {
        $this->bar();
    }

    public function bar()
    {
        $data = ['judul'    => 'BAR',
                 'periode'  => $this->M_monitoring->list_periode_bar('lihat')->result_array()
                ];

        $this->template->load('layout/template', 'monitoring/bar/V_bar', $data);
    }

    // proses upload TTD Bar
    public function upload_ttd_bar()
    {
        $id_rekon = $this->input->post('id_rekon');

        $br = $this->M_monitoring->cari_data('rekonsiliasi', array('id_rekon' => $id_rekon))->row_array();

        $id_bar = $br['id_bar'];

        $config['max_size']         = 2048;
        $config['allowed_types']    = "jpg|jpeg|png";
        $config['remove_spaces']    = TRUE;
        $config['overwrite']        = TRUE;
        $config['upload_path']      = FCPATH.'foto/bar/';

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ( !$this->upload->do_upload("foto")){

            echo json_encode(['hasil' => 0]);

        } else {

            $this->upload->do_upload('foto');
            $data           = array('upload_data' => $this->upload->data());
            $filename       = $data['upload_data']['file_name'];

            $pathinfo       = 'foto/bar/'.$filename;
            //$filetype = pathinfo($pathinfo, PATHINFO_EXTENSION);
            $filecontent    = file_get_contents($pathinfo);

            $base64         = rtrim(base64_encode($filecontent));

            $data = [ 'ttd_bar'  =>  $base64 ];

            $this->M_monitoring->ubah_data('bar', $data, array('id_bar' => $id_bar));

            echo json_encode(['hasil' => 1]);

        }
    }

    // menampilkan option periode
    public function option_periode_bar($aksi)
    {
        $periode  = $this->M_monitoring->list_periode_bar($aksi)->result_array();

        $option = "<option value='a'>-- Pilih Periode --</option>";

        foreach ($periode as $p) {
            $option .= "<option value='".$p['id_periode']."'>".nice_date($p['nama_periode'], 'F Y')."</option>";
        }

        $data = ['periode'  => $option];
        
        echo json_encode($data);
    }

    public function tampil_periode_bar($aksi = 'lihat')
    {
        $id_periode = $this->input->post('id_periode');

        $list = $this->M_monitoring->get_periode_bar($id_periode, $aksi);

        $data   = array();
        $no     = $this->input->post('start');

        foreach ($list as $a) {
            $no++;
            $tbody = array();

            if ($a['ttd_bar'] != null) {
                $ttd = "<div class='text-center'><h5><span class='badge badge-success'>BAR sudah TTD</span></h5></div>";
            } else {
                $ttd = "<div class='text-center'><h5><span class='badge badge-danger'>BAR belum TTD</span></h5></div>";
            }

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = nice_date($a['nama_periode'], 'F Y');
            $tbody[]    = $a['cabang_asuransi'];
            $tbody[]    = $a['bank'];
            $tbody[]    = $a['cabang_bank'];
            $tbody[]    = "<div align='center'><h5>".$a['no_bar']."</h5></div>";

            if ($aksi == 'lihat') {
                $tbody[]    = $ttd;
                $tbody[]    = date("d-M-Y H:i:s", strtotime($a['add_time']));
                $tbody[]    = $a['username'];
                $tbody[]    = "<div align='center'><a href='".base_url().'monitoring/cetak_bar/bar/'.$a['id_periode'].'/'.$a['id_rekon']."'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-info btn-sm mr-2 mt-2'>Cetak</button></a><a href='".base_url().'monitoring/cetak_bar/excel/'.$a['id_periode'].'/'.$a['id_rekon']."'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-success btn-sm mr-2 mt-2'>Excel</button></a><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-dark btn-sm upload-bar mr-2 mt-2' data-id='".$a['id_rekon']."'>Upload</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus mr-2 mt-2' data-id='".$a['id_rekon']."'>Hapus</button></div>";
            } else {
                $tbody[] = "<div align='center'><input type='checkbox' name='pilih_bar[]' class='pilih_bar' value='".$a['id_rekon']."'></div>";
            }

            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_monitoring->jumlah_semua_periode_bar($id_periode, $aksi),
                    "recordsFiltered"  => $this->M_monitoring->jumlah_filter_periode_bar($id_periode, $aksi),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // proses cetak bar
    public function cetak_bar()
    {
        $aksi       = $this->uri->segment(3);
        $id_periode = $this->uri->segment(4);
        $id_rekon   = $this->uri->segment(5);

        $data = [ 'data'    => $this->M_monitoring->get_data_cetak($id_rekon)->row(),
                  'all'     => $this->M_monitoring->get_data_all_cetak2($id_rekon),
                  'excel'   => $this->M_monitoring->get_data_excel($id_periode)
                ];
        
        if ($aksi != 'excel') {
            $this->load->view('monitoring/bar/V_cetak_bar', $data);
        } else {
            $this->load->view('monitoring/bar/V_cetak_bar_excel', $data);
            
        }
        
    }

    public function tes_lagi()
    {
        $s['no_bar'] = "SP.S/0003/ASK.BDG/BJB/2019";

        // mencari letak "/" diangka berapa
        $cari_2 = strpos($s['no_bar'], "/");

        // mengambil string
        $cari_3 = substr($s['no_bar'], $cari_2+1);

        // mencari lagi letak "/" yang kedua, diangka berapa
        $cari_4 = strpos($cari_3, "/");

        // mengambil string kode saja
        $cari_5 = substr($cari_3, 0, $cari_4);

        // menghilangkan angka 0 disebelah kiri
        $angka  = ltrim($cari_5, "0");

        // menambahkan +1 pada angka
        $kode   = $angka + 1;

        // menambahkan 0 disebelah kiri
        $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);

        echo $kodemax;

    }

    public function tes_bar()
    {
        $tahun      = date("Y");
        $tahun_bar  = substr("SP.S/0173/ASK.BDG/BJB/2020", -4);

        $kodemax = str_pad(1, 4, "0", STR_PAD_LEFT);

        if ($tahun === $tahun_bar) {
            echo "sama";
            echo $kodemax;
        } else {
            echo "tidak sama";
        }

    }

    // proses tambah bar 
    public function proses_tambah_bar()
    {
        $id_bar         = $this->input->post('pilih_bar');
        $add_time       = date("Y-m-d H:i:s", now('Asia/Jakarta'));
        $created_by     = $this->session->userdata('id_pengguna');

        // $id_bar = ["327", "326", "325", "324"];

        foreach ($id_bar as $a) {

            $id_rekon = $a;
            
            $cari_p = $this->M_monitoring->cari_data('rekonsiliasi', array('id_rekon' => $id_rekon))->row_array();

            $id_periode = $cari_p['id_periode'];

            $cari_1 = $this->M_monitoring->cari_cabang_asuransi_per($id_periode)->row_array();

                $bank               = $cari_1['sb'];
                $singkatan_cas      = $cari_1['singkatan_as'];
                $id_cabang_asuransi = $cari_1['id_cabang_as'];

                $tahun    = date("Y");

                // mencari singkatan cabang asuransi
                $cari_s = $this->M_monitoring->cari_singkatan_cas($singkatan_cas);

                // pengecekan jika singkatan cabang asuransi, tabel bar
                if($cari_s->num_rows() != 0){ 
                    
                    $s = $cari_s->row_array();

                    $tahun_bar = substr($s['no_bar'], -4);

                    // mencari letak "/" diangka berapa
                    $cari_2 = strpos($s['no_bar'], "/");

                    // mengambil string
                    $cari_3 = substr($s['no_bar'], $cari_2+1);

                    // mencari lagi letak "/" yang kedua, diangka berapa
                    $cari_4 = strpos($cari_3, "/");

                    // mengambil string kode saja
                    $cari_5 = substr($cari_3, 0, $cari_4);

                    // menghilangkan angka 0 disebelah kiri
                    $angka  = ltrim($cari_5, "0");

                    if ($tahun !== $tahun_bar) {
                        $kode   = 1;
                    } else {
                        // menambahkan +1 pada angka
                        $kode   = $angka + 1;
                    }   
                    
                    // menambahkan 0 disebelah kiri
                    $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);

                    $kodejadi = "SP.S/".$kodemax."/".$singkatan_cas."/".$bank."/".$tahun;

                } else {         

                    // cari singkatan cabang asuransi
                    $cas = $this->M_monitoring->cari_data('m_cabang_asuransi', array('id_cabang_asuransi' => $id_cabang_asuransi))->row_array();

                    $kode = 1;
                    $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);
                    $kodejadi = "SP.S/".$kodemax."/".$cas['singkatan']."/".$bank."/".$tahun; 
                }

                $data = ['no_bar'       => $kodejadi,
                         'add_time'     => $add_time,
                         'created_by'   => $created_by
                        ];

                $this->M_monitoring->input_data('bar', $data);
                
                $id_bar = $this->db->insert_id();
                $status = 1;
                $data2 = ['id_bar'=>$id_bar, 'status'=>$status];
                
                $this->M_monitoring->ubah_data('rekonsiliasi', $data2, array('id_rekon' => $id_rekon));
        }

        $periode  = $this->M_monitoring->list_periode_bar('lihat')->result_array();

        $option = "<option value='a'>-- Pilih Periode --</option>";

        foreach ($periode as $p) {
            $option .= "<option value='".$p['id_periode']."'>".nice_date($p['nama_periode'], 'F Y')."</option>";
        }

        $data = ['periode'  => $option, 'status' => TRUE];

        echo json_encode($data);
    }

    // 05-04-2021
    public function hapus_bar()
    {
        $id_rekon = $this->input->post('id_rekon');

        // cari rekon
            $cr = $this->M_monitoring->cari_data('rekonsiliasi', ['id_rekon' => $id_rekon])->row_array();

        $this->db->trans_begin();
        
        // hapus invoice
            if ($cr['id_invoice']) {
                $this->M_monitoring->hapus_data('invoice', ['id_invoice' => $cr['id_invoice']]);
            }

        // hapus bar
            if ($cr['id_bar']) {
                $this->M_monitoring->hapus_data('bar', ['id_bar' => $cr['id_bar']]);
            }
        
        // ubah bar ke status 0
            $this->M_monitoring->ubah_data('rekonsiliasi', ['id_bar' => null, 'id_invoice' => null, 'status' => 0], ['id_rekon' => $id_rekon]);

        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        // list option periode bar
            $periode  = $this->M_monitoring->list_periode_bar('lihat')->result_array();

            $option = "<option value='a'>-- Pilih Periode --</option>";

            foreach ($periode as $p) {
                $option .= "<option value='".$p['id_periode']."'>".nice_date($p['nama_periode'], 'F Y')."</option>";
            }
        // akhir list option periode bar

        $data = ['periode'  => $option, 'status' => TRUE];
        
        echo json_encode($data);
    }

    /*****************************************************************************************************/
    /*
    /*                                              INVOICE
    /*
    /*****************************************************************************************************/

    public function invoice()
    {
        $data = ['judul'        => 'Invoice',
                 'periode'      => $this->M_monitoring->list_periode_invoice()->result_array(),
                 'cbg_asuransi' => $this->M_monitoring->get_data_cabang_as()->result_array()
                ];

        $this->template->load('layout/template', 'monitoring/invoice/V_invoice', $data);
    }

    public function tampil_invoice()
    {
        $id_periode = $this->input->post('id_periode');

        $list = $this->M_monitoring->get_invoice($id_periode);

        $data   = array();
        $no     = $this->input->post('start');

        foreach ($list as $a) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = nice_date($a['nama_periode'], 'F Y');
            $tbody[]    = $a['cabang_asuransi'];
            $tbody[]    = $a['bank'];
            $tbody[]    = $a['cabang_bank'];
            $tbody[]    = "<div align='center'><h5>".$a['no_bar']."</h5></div>";
            $tbody[]    = "<div align='center'><h5>".$a['no_invoice']."</h5></div>";
            $tbody[]    = date("d-M-Y H:i:s", strtotime($a['add_time']));
            $tbody[]    = $a['username'];
            $tbody[]    = "<div align='center'><a href='".base_url().'monitoring/cetak_invoice/'.$a['id_periode'].'/'.$a['id_rekon'].'/'.$a['id_bar'].'/'.$a['id_invoice']."'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-info btn-sm mr-0 mt-2'>Cetak</button></a><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus mt-2' data-id='".$a['id_rekon']."'>Hapus</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_monitoring->jumlah_semua_invoice($id_periode),
                    "recordsFiltered"  => $this->M_monitoring->jumlah_filter_invoice($id_periode),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // mencetak invoice
    public function cetak_invoice()
    {
        $id_periode = $this->uri->segment(3);
        $id_rekon   = $this->uri->segment(4);
        $id_bar     = $this->uri->segment(5);
        $id_invoice = $this->uri->segment(6);

        $data   = [ 'tglinvoice'    => date("d F Y"),
                    'data'          => $this->M_monitoring->get_no_invoice($id_rekon)->row(),
                    // 'cabang'        => $this->M_monitoring->list_data_recov($id_invoice)->result_array()  
                    'cabang'        => $this->M_monitoring->list_data_recov2($id_invoice)  
                ];

        $this->load->view('monitoring/invoice/V_cetak', $data);

    }

    public function tampil_invoice_tambah()
    {
        $id_cabang_as = $this->input->post('id_cabang_asuransi');

        $list = $this->M_monitoring->get_invoice_tambah($id_cabang_as);

        $data   = array();
        $no     = $this->input->post('start');

        foreach ($list as $a) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $a['no_bar'];
            $tbody[]    = "<div align='center'><input type='checkbox' name='pilih_bar[]' value='".$a['id_rekon']."'></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_monitoring->jumlah_semua_invoice_tambah($id_cabang_as),
                    "recordsFiltered"  => $this->M_monitoring->jumlah_filter_invoice_tambah($id_cabang_as),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    public function tes()
    {
        $a = (int)37;
        // echo ltrim("$a","0");
        var_dump(strval($a));
    }

    public function tes_invoice()
    {
        $hasil = $this->M_monitoring->get_data('invoice')->result_array();

        foreach ($hasil as $h) {
            $id_invoice = $h['id_invoice'];

            $total_rec          = 0;
            $total_pendapatan   = 0;

            $nominal = $this->M_monitoring->list_data_recov($id_invoice)->result_array();

            foreach ($nominal as $r) {

                $total_rec          += $r['recoveries'] + $r['tot_recov_awal'];
                $total_pendapatan   += ($r['recoveries'] + $r['tot_recov_awal'] )* 0.15;

            }

            $dpp        = $total_pendapatan / 1.1;
            $pph23      = $dpp * 0.02;

            $komisi_aju = $dpp - $pph23;

            $data_in = ['komisi_diajukan'    => $komisi_aju,
                        'recoveries_aju'     => $total_rec
                        ];

            $this->M_monitoring->ubah_data('invoice', $data_in, array('id_invoice' => $id_invoice));
        }
    }

    public function proses_tambah_invoice()
    {
        $id_cabang_as   = $this->input->post('id_cabang_as');
        $id_rekon       = $this->input->post('id_rekon');
        
        $add_time       = date("Y-m-d H:i:s", now('Asia/Jakarta'));
        $created_by     = $this->session->userdata('id_pengguna');

        $tahun = date("Y");

        // cari singkatan cabang asuransi 
        $cr = $this->M_monitoring->cari_data('m_cabang_asuransi', array('id_cabang_asuransi' => $id_cabang_as))->row_array();

        $singkatan = $cr['singkatan'];

        // cari singkatan pada tabel invoice
        $cari_1 = $this->M_monitoring->cari_dari_singkatan($singkatan);

        if ($cari_1->num_rows() != 0) {
            
            $s = $cari_1->row_array();

            $tahun_invoice = substr($s['no_invoice'], -4);

            // mencari letak "/" diangka berapa
            $cari_2 = strpos($s['no_invoice'], "/");
            // mengambil string
            $cari_3 = substr($s['no_invoice'], $cari_2+1);
            // mencari lagi letak "/" yang kedua, diangka berapa
            $cari_4 = strpos($cari_3, "/");
            // mengambil string kode saja
            $cari_5 = substr($cari_3, 0, $cari_4);

            // menghilangkan angka 0 disebelah kiri
            $angka  = ltrim($cari_5, "0");

            if ($tahun !== $tahun_invoice) {
                $kode   = 1;
            } else {
                // menambahkan +1 pada angka
                $kode   = $angka + 1;
            }  
            
            // menambahkan 0 sebelah kiri
            $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);

            $kodejadi = "SP.FS/".$kodemax."/".$singkatan."/".$tahun;

        } else {

            $kode = 1;

            $kodemax  = str_pad($kode, 4, "0", STR_PAD_LEFT);

            $kodejadi = "SP.FS/".$kodemax."/".$singkatan."/".$tahun;

        }

        $data = ['no_invoice'   => $kodejadi,
                 'add_time'     => $add_time,
                 'created_by'   => $created_by
                ];

        $this->M_monitoring->input_data('invoice', $data);

        $id_invoice = $this->db->insert_id();
        
        foreach ($id_rekon as $a => $value) {
            
            $where  = ['id_rekon' => $value];

            $data1   = ['status' => 2, 'id_invoice'  => $id_invoice];

            $this->M_monitoring->ubah_data('rekonsiliasi', $data1, $where);
        }

        $total_rec          = 0;
        $total_pendapatan   = 0;

        $nominal = $this->M_monitoring->list_data_recov($id_invoice)->result_array();

        foreach ($nominal as $r) {

            $total_rec          += $r['recoveries'] + $r['tot_recov_awal'];
            $total_pendapatan   += ($r['recoveries'] + $r['tot_recov_awal'] )* 0.15;

        }

        $dpp        = $total_pendapatan / 1.1;
        $pph23      = $dpp * 0.02;

        $komisi_aju = $dpp - $pph23;

        $data_in = ['komisi_diajukan'    => $komisi_aju,
                    'recoveries_aju'     => $total_rec
                    ];

        $this->M_monitoring->ubah_data('invoice', $data_in, array('id_invoice' => $id_invoice));

        $periode = $this->M_monitoring->list_periode_invoice()->result_array();

        $option = "<option value='a'>-- Pilih Periode --</option>";

        foreach ($periode as $a) {
            $option .= "<option value='".$a['id_periode']."'>".nice_date($a['nama_periode'], 'F Y')."</option>";
        }

        $data = ['periode'  => $option, 'status' => TRUE];

        echo json_encode($data);
    }

    // menampilkan list periode invoice
    public function list_periode_invoice()
    {
        $periode = $this->M_monitoring->list_periode_invoice()->result_array();

        $option = "<option value='a'>-- Pilih Periode --</option>";

        foreach ($periode as $a) {
            $option .= "<option value='".$a['id_periode']."'>".nice_date($a['nama_periode'], 'F Y')."</option>";
        }

        $data = ['periode'  => $option, 'status' => TRUE];

        echo json_encode($data);
    }

    // 05-04-2021
    public function hapus_invoice()
    {
        $id_rekon = $this->input->post('id_rekon');

        // cari rekon
            $cr = $this->M_monitoring->cari_data('rekonsiliasi', ['id_rekon' => $id_rekon])->row_array();

        $this->db->trans_begin();
        
        // hapus invoice
            if ($cr['id_invoice']) {
                $this->M_monitoring->hapus_data('invoice', ['id_invoice' => $cr['id_invoice']]);
            }
        
        // ubah bar ke status 0
            $this->M_monitoring->ubah_data('rekonsiliasi', ['id_invoice' => null, 'status' => 1], ['id_rekon' => $id_rekon]);

        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        // list option periode invoice
            $periode = $this->M_monitoring->list_periode_invoice()->result_array();

            $option = "<option value='a'>-- Pilih Periode --</option>";

            foreach ($periode as $a) {
                $option .= "<option value='".$a['id_periode']."'>".nice_date($a['nama_periode'], 'F Y')."</option>";
            }
        // akhir list option periode invoice

        $data = ['periode'  => $option, 'status' => TRUE];

        echo json_encode($data);
        
    }

    public function tampil_list_cabang_as()
    {
        $cbg_asuransi   = $this->M_monitoring->get_data_cabang_as()->result_array();

        $option = "<option value='a'>-- Pilih Cabang Asuransi --</option>";

        foreach ($cbg_asuransi as $a) {
            $option .= "<option value='".$a['id_cabang_asuransi']."'>".$a['cabang_asuransi']."</option>";
        }

        $data = ['cbg_asuransi'  => $option];
        
        echo json_encode($data);
    }

    public function tes_xss()
    {
        $user = $this->input->post('username');
        $pass = $this->input->post('password');

        $data['tanpa_xss'] = ['username' => $user,
                              'password' => $pass
                            ];

        $data['gun_xss'] = $this->security->xss_clean($data['tanpa_xss']);

        $this->load->view('tes_xss', $data);
        
    }

    /*****************************************************************************************************/
    /*
    /*                                           PEMBAYARAN KLIEN
    /*
    /*****************************************************************************************************/

    public function pembayaran_klien()
    {
        $data = [ 'judul'   => 'Pembayaran Klien'];

        $this->template->load('layout/template', 'monitoring/V_pembayaran_klien', $data);
    }

    // menampilkan data pembayaran klien
    public function tampil_byr_klien()
    {
        $list = $this->M_monitoring->get_data_bayar_klien();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $total_rec          = 0;
            $total_pendapatan   = 0;

            $nominal = $this->M_monitoring->list_data_recov($o['id_invoice'])->result_array();

            foreach ($nominal as $r) {

                $total_rec          += $r['recoveries'] + $r['tot_recov_awal'];
                $total_pendapatan   += ($r['recoveries'] + $r['tot_recov_awal'] )* 0.15;

            }

            $dpp        = $total_pendapatan / 1.1;
            $pph23      = $dpp * 0.02;

            $komisi_aju = $dpp - $pph23;

            $tgl_cair = "<div align='center'>".nice_date($o['tgl_cair'], 'd-M-Y')."</div>";
            $k_byr    = "<div align='right'>".number_format($o['komisi_dibayarkan'],'2',',','.')."</div>";

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['cabang_asuransi'];
            $tbody[]    = "<div align='center'>".nice_date($o['nama_periode'], 'M-Y')."</div>";
            $tbody[]    = $o['no_invoice'];
            $tbody[]    = "<div align='right'>".number_format($komisi_aju,'2',',','.')."</div>";
            $tbody[]    = ($o['tgl_cair'] == '') ? '' : $tgl_cair;
            $tbody[]    = ($o['komisi_dibayarkan'] == '') ? '' : $k_byr;
            $tbody[]    = $o['keterangan'];
            $tbody[]    = $o['rekening'];
            $tbody[]    = "<div align='center'><div align='center'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-info btn-sm mr-3 input-byr-klien' data-id='".$o['id_invoice']."'>Input</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_monitoring->jumlah_semua_bayar_klien(),
                    "recordsFiltered"  => $this->M_monitoring->jumlah_filter_bayar_klien(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // ambil no_invoice
    public function ambil_no_invoice()
    {
        $id_invoice = $this->input->post('id_invoice');
        
        $data = $this->M_monitoring->cari_data('invoice', array('id_invoice' => $id_invoice))->row_array();

        $tgl_byr = nice_date($data['tgl_cair'], 'd-F-Y');

        array_push($data, array('tgl_byr' => $tgl_byr));

        echo json_encode($data);
    }

    // proses simpan bayar klien 
    public function simpan_bayar_klien()
    {
        $id_invoice     = $this->input->post('id_invoice');
        $komisi_dibyr   = ($this->input->post('komisi_dibayarkan') == '') ? null : $this->input->post('komisi_dibayarkan');
        $tgl_bayar      = nice_date($this->input->post('tgl_bayar'), 'Y-m-d');
        $keterangan     = $this->input->post('keterangan');
        $no_rek         = $this->input->post('no_rek');
        
        $data = [ 'komisi_dibayarkan'   => $komisi_dibyr,
                  'tgl_cair'            => $tgl_bayar,
                  'keterangan'          => $keterangan,
                  'rekening'            => $no_rek,
                  'updated_at'          => date("Y-m-d H:i:s", now('Asia/Jakarta'))
                ];

        // ubah data 
        $this->M_monitoring->ubah_data('invoice', $data, array('id_invoice' => $id_invoice));

        echo json_encode(['status' => TRUE, 'tgl' => $tgl_bayar]);
        
    }

    /*****************************************************************************************************/
    /*
    /*                                           UPLOAD DOKUMEN
    /*
    /*****************************************************************************************************/

    public function upload_dokumen()
    {
        $data = [
            'report'        => 'aktif',
            'judul'         => 'Print Report',
            'jenis'         => 'Upload File',
            'data_upload'   => $this->M_monitoring->get_data('tr_laporan')->result_array()
        ];

        $this->template->load('layout/template','monitoring/V_upload_file', $data);
    }

    public function hapus_file_dok()
    {
        $id_laporan = $this->input->post('id_laporan');
        $dok        = $this->input->post('dok');
        
        $this->M_monitoring->hapus_data('tr_laporan', array('id_laporan' => $id_laporan));

        unlink("./assets/dokumen/$dok");

        redirect('monitoring/upload_dokumen');
    }

    public function do_upload()
    {
        $config['upload_path']      = "./assets/dokumen";
        $config['allowed_types']    = "*";
        $config['encrypt_name']     = FALSE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload("file")) {

            $data = array('upload_data' => $this->upload->data());

            $judul = $this->input->post('judul');
            $image = $data['upload_data']['file_name'];

            $this->M_monitoring->simpan_upload($judul, $image);
            
            redirect('monitoring/upload_dokumen');

        } else {
            echo $er = $this->upload->display_errors();
        }
    }

    public function download()
    {
        $nama_file = $this->input->post('dok');
        
        force_download("assets/dokumen/$nama_file", NULL);
    }


}

/* End of file Monitoring.php */
