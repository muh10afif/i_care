<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Rekon extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('Cek_login_lib', 'excel'));
        $this->cek_login_lib->logged_in_false();
        $this->load->model(array('M_master', 'M_rekon'));
        
    }

    /*****************************************************************************************************/
    /*
    /*                                        REKONSILIASI
    /*
    /*****************************************************************************************************/

    public function index()
    {
        $data   = [ 'judul'         => 'Rekonsiliasi',
                    'periode'       => $this->M_rekon->list_periode_rekon()->result_array(),
                    'periode_cab'   => $this->M_rekon->get_periode_cab()->result_array()
                 ];

        $this->template->load('layout/template', 'rekon/V_rekonsiliasi', $data);
    }

    public function tampil_option_periode_buat()
    {
        $periode_cab   = $this->M_rekon->get_periode_cab()->result_array();

        $option = "<option value='a'>-- Pilih Periode --</option>";

        foreach ($periode_cab as $a) {
            $option .= "<option value='".$a['id_periode']."'>".nice_date($a['nama_periode'], 'F Y')." - ".$a['cabang_bank']."</option>";
        }

        $data = ['periode'  => $option];
        
        echo json_encode($data);
    }

    public function simpan_rekon()
    {
        $id_periode     = $this->input->post('id_periode');
        $add_time       = date("Y-m-d H:i:s", now('Asia/Jakarta'));
        $created_by     = $this->session->userdata('id_pengguna');

        $data = ['id_periode'   => $id_periode,
                 'add_time'     => $add_time,
                 'created_by'   => $created_by
                ];

        $this->M_rekon->input_data('rekonsiliasi', $data);

        $periode = $this->M_rekon->list_periode_rekon()->result_array();

        $option = "<option value='a'>-- Pilih Periode --</option>";

        foreach ($periode as $a) {
            $option .= "<option value='".$a['id_periode']."'>".nice_date($a['nama_periode'], 'F Y')."</option>";
        }

        echo json_encode(['hasil' => TRUE, 'periode' => $option]);
        
    }

    // menampilkan option periode
    public function list_periode_rekon()
    {
        $periode = $this->M_rekon->list_periode_rekon()->result_array();

        $option = "<option value='a'>-- Pilih Periode --</option>";

        foreach ($periode as $a) {
            $option .= "<option value='".$a['id_periode']."'>".nice_date($a['nama_periode'], 'F Y')."</option>";
        }

        echo json_encode(['hasil' => TRUE, 'periode' => $option]);
    }

    public function tampil_rekon()
    {
        $id_periode = $this->input->post('id_periode');

        $list = $this->M_rekon->get_rekon($id_periode);

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
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_rekon->jumlah_semua_rekon($id_periode),
                    "recordsFiltered"  => $this->M_rekon->jumlah_filter_rekon($id_periode),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    public function tampil_rekon_deb()
    {
        $id_periode = $this->input->post('id_periode');

        $list = $this->M_rekon->get_rekon_deb($id_periode);

        $data   = array();
        $no     = $this->input->post('start');

        foreach ($list as $a) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = nice_date($a['nama_periode'], 'F Y');
            $tbody[]    = $a['nama_debitur'];
            $tbody[]    = $a['cabang_asuransi'];
            $tbody[]    = $a['bank'];
            $tbody[]    = $a['cabang_bank'];
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_rekon->jumlah_semua_rekon_deb($id_periode),
                    "recordsFiltered"  => $this->M_rekon->jumlah_filter_rekon_deb($id_periode),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    /*****************************************************************************************************/
    /*
    /*                                     INPUT RECOVERIES
    /*
    /*****************************************************************************************************/

    public function input()
    {
        $data   = [ 'judul'     => 'Input Recoveries',
                    'bank'      => $this->M_rekon->list_bank_rekon()->result_array()
                 ];

        $this->template->load('layout/template', 'rekon/input/V_input_recov', $data);
    }

    public function tampil_debitur_recov()
    {
        $bank       = $this->input->post('id_bank');
        $cb_bank    = $this->input->post('id_cabang_bank');
        
        $list = $this->M_rekon->get_debitur_r($bank, $cb_bank);

        $data   = array();
        $no     = $this->input->post('start');

        foreach ($list as $a) {
            $no++;
            $tbody = array();

            $shs = ($a['subrogasi_as'] - $a['recoveries_awal_asuransi']) - $a['tot_nominal_as'];

            if (isset($a['tot_nominal_as'])) {
                $aksi = "<div align='center'><button type='button' class='btn waves-effect waves-light btn-outline-info btn-sm update-bayar mr-3' data-id=".$a['id_debitur'].">Update Bayar</button><button type='button' class='btn waves-effect waves-light btn-outline-success btn-sm detail-bayar' data-id=".$a['id_debitur'].">History</button></div>";
            } else {
                $aksi = "<div align='center'><button type='button' class='btn waves-effect waves-light btn-outline-info btn-sm update-bayar mr-3' data-id=".$a['id_debitur'].">Update Bayar</button></div>";
            }

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $a['nama_debitur'];
            $tbody[]    = $a['no_reff'];
            $tbody[]    = $a['cabang_asuransi'];
            $tbody[]    = $a['bank'];
            $tbody[]    = $a['cabang_bank'];
            $tbody[]    = "<div align='right'><h6>Rp. ".(number_format($shs,'2',',','.'))."</h6></div>";
            $tbody[]    = $aksi;
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_rekon->jumlah_semua_debitur_r($bank, $cb_bank),
                    "recordsFiltered"  => $this->M_rekon->jumlah_filter_debitur_r($bank, $cb_bank),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    public function form_detail_bayar()
    {
        $id_debitur = $this->input->post('id_debitur');

        $data = [ 
                    // 'd_deb'   => $this->M_rekon->cari_data_histori('tr_recov_as', array('id_debitur' => $id_debitur))->result_array(),
                    'd_deb'         => $this->M_rekon->get_recov_as($id_debitur)->result_array(),
                    'nm_deb'        => $this->M_rekon->cari_data('debitur', array('id_debitur' => $id_debitur))->row_array(),
                    'id_debitur'    => $id_debitur  
                ];
        
        $this->load->view('rekon/input/V_detail_bayar', $data);
    }

    // 09-04-2021
    public function tampil_detail_bayar($id_debitur)
    {
        $list = $this->M_rekon->get_recov_as($id_debitur)->result_array();

        $data   = array();
        $no     = $this->input->post('start');

        foreach ($list as $a) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $a['no_rek'];
            $tbody[]    = "<div align='right' class='font-weight-bold'>".number_format($a['nominal'],2,',','.')."</div>";
            $tbody[]    = date("d-F-Y", strtotime($a['tgl_bayar']));
            $tbody[]    = date("d-F-Y H:i:s", strtotime($a['add_time']));
            $tbody[]    = $a['username'];
            $tbody[]    = "<div align='center'><button type='button' class='btn waves-effect waves-light btn-outline-danger btn-sm hapus' data-id=".$a['id_tr_recov_as'].">Hapus</button></div>";
            $data[]     = $tbody;
        }

        if ($list) {
            echo json_encode(array('data'=> $data));
        }else{
            echo json_encode(array('data'=>0));
        }
    }

    // 09-04-2021
    public function hapus_recov()
    {
        $id_tr_recov_as = $this->input->post('id_recov_as');

        $this->M_master->hapus_data('tr_recov_as', ['id_tr_recov_as' => $id_tr_recov_as]);
        
        echo json_encode(['status' => true]);
    }

    // 11-03-2020

        // untuk menampilkan data upload
        public function input_recov_import($aksi)
        {
            if ($aksi == 1) {
                $path = $_FILES["upload"]["tmp_name"];
      
                $object = PHPExcel_IOFactory::load($path);
        
                foreach($object->getWorksheetIterator() as $worksheet) {
        
                    $highestRow = $worksheet->getHighestRow();
        
                    $highestColumn = $worksheet->getHighestColumn();
        
                    for($row=2; $row<=$highestRow; $row++){
            
                        $nama_debitur       = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $no_klaim           = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $no_reff            = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $no_rek             = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $nominal            = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $tgl_bayar          = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow(5, $row)->getValue()));

                        // cari id debitur
                        $cari = $this->M_master->cari_data('debitur', array('no_klaim' => trim($no_klaim), 'no_reff' => trim($no_reff)))->row_array();

                        $data[] = array(
                
                            'id_debitur'    => $cari['id_debitur'],
                            'nama_debitur'  => $nama_debitur,
                            'no_klaim'      => $no_klaim,
                            'no_reff'       => $no_reff,
                            'no_rek'        => $no_rek,
                            'nominal'       => $nominal,
                            'tgl_bayar'     => $tgl_bayar
                
                        ); 
        
                    }
        
                }

                $dt = ['data'   => $data];
                
                $this->load->view('rekon/input/V_preview_upload', $dt);
            } else {

                $path = $_FILES["upload"]["tmp_name"];
      
                $object = PHPExcel_IOFactory::load($path);
        
                foreach($object->getWorksheetIterator() as $worksheet) {
        
                    $highestRow = $worksheet->getHighestRow();
        
                    $highestColumn = $worksheet->getHighestColumn();
        
                    for($row=2; $row<=$highestRow; $row++){
            
                        $nama_debitur       = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $no_klaim           = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $no_reff            = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $no_rek             = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $nominal            = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $tgl_bayar          = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow(5, $row)->getValue()));

                        // cari id debitur
                        $cari = $this->M_master->cari_data('debitur', array('no_klaim' => trim($no_klaim), 'no_reff' => trim($no_reff)))->row_array();

                        $data = array(
                
                            'id_debitur'    => $cari['id_debitur'],
                            'no_rek'        => $no_rek,
                            'nominal'       => $nominal,
                            'tgl_bayar'     => $tgl_bayar
                
                        ); 

                        $this->db->insert('tr_recov_as', $data);  
                        $this->db->insert('tr_recov_bank', $data);  
        
                    }
        
                }

                echo json_encode(['status' => TRUE]);

            }
                        
        }

        public function input_recov_dari_upload()
        {
            $data = $this->input->post('data');

            foreach ($data as $d) {
                $dt = [ 'id_debitur' => $d['id_debitur'],
                        'no_rek'     => $d['no_rek'],
                        'nominal'    => $d['nominal'],
                        'tgl_bayar'  => $d['tgl_bayar']
                      ];

                $this->db->insert('tr_recov_as', $dt);
                
            }

            echo json_encode(['status' => TRUE]);
            
        }

    // Akhir 11-03-2020

    /*****************************************************************************************************/
    /*
    /*                                   REKONSILIASI RECOVERIES
    /*
    /*****************************************************************************************************/

    // 12-04-2021
    public function rekon_recov()
    {
        $data   = [ 'judul'     => 'Rekon Recoveries',
                    'bank'      => $this->M_rekon->list_bank_rekon()->result_array()
                 ];

        $this->template->load('layout/template', 'rekon/V_rekon_recov', $data);
    }

    // 12-04-2021
    public function tampil_debitur_rekon_recov()
    {
        $bank       = $this->input->post('id_bank');
        $cb_bank    = $this->input->post('id_cabang_bank');
        $jenis      = $this->input->post('jenis');
        
        $list = $this->M_rekon->get_debitur_rba($bank, $cb_bank);

        $data   = array();
        $no     = $this->input->post('start');

        foreach ($list as $a) {
            $no++;
            $tbody = array();

            if ($jenis == 'asuransi') {
                $shs = ($a['subrogasi_as'] - $a['recoveries_awal_asuransi']) - $a['tot_nominal_as'];
            } else {
                $shs = ($a['subrogasi_as'] - $a['recoveries_awal_bank']) - $a['tot_nominal_as'];
            }

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $a['nama_debitur'];
            $tbody[]    = $a['no_reff'];
            $tbody[]    = $a['cabang_asuransi'];
            $tbody[]    = $a['bank'];
            $tbody[]    = $a['cabang_bank'];
            $tbody[]    = "<div align='right'><h6>Rp. ".(number_format($a['tot_nominal_as'],'2',',','.'))."</h6></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_rekon->jumlah_semua_debitur_r($bank, $cb_bank),
                    "recordsFiltered"  => $this->M_rekon->jumlah_filter_debitur_r($bank, $cb_bank),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    /*****************************************************************************************************/
    /*
    /*                                          PERIODE
    /*
    /*****************************************************************************************************/

    public function periode()
    {
        $data = ['judul'        => 'Periode',
                 'periode'      => $this->M_master->get_data('m_periode')->result_array(),
                 'cab_asuransi' => $this->M_master->get_data('m_cabang_asuransi')->result_array(),
                 'cab_bank'     => $this->M_master->get_data('m_cabang_bank')->result_array()
                ];

        $this->template->load('layout/template', 'rekon/periode/V_periode', $data);
    }

    public function tambah_data_periode_rekon($aksi)
    {
        $pil_periode    = $this->input->post('pil_periode');
        $bln_periode    = nice_date($this->input->post('bln_periode'), 'Y-m');
        $tgl_awal_byr   = nice_date($this->input->post('tgl_awal_byr'), 'Y-m-d');
        $tgl_akhir_byr  = nice_date($this->input->post('tgl_akhir_byr'), 'Y-m-d');
        $cab_asuransi   = $this->input->post('cab_asuransi');
        $cab_bank       = $this->input->post('cab_bank');
        $add_time       = date("Y-m-d H:i:s", now('Asia/Jakarta'));
        $created_by     = $this->session->userdata('id_pengguna');
        
        if ($aksi == 2) {
            $this->M_master->input_data('m_periode', array('nama_periode' => $bln_periode));

            $id_m_periode = $this->db->insert_id();
            
            $data   = [ 'm_periode'         => $id_m_periode,
                        'tgl_bayar_awal'    => $tgl_awal_byr,
                        'tgl_bayar_akhir'   => $tgl_akhir_byr,
                        'id_cabang_as'      => $cab_asuransi,
                        'id_cabang_bank'    => $cab_bank,
                        'add_time'          => $add_time,
                        'created_by'        => $created_by
                    ];
        } else {
            $data   = [ 'm_periode'         => $pil_periode,
                        'tgl_bayar_awal'    => $tgl_awal_byr,
                        'tgl_bayar_akhir'   => $tgl_akhir_byr,
                        'id_cabang_as'      => $cab_asuransi,
                        'id_cabang_bank'    => $cab_bank,
                        'add_time'          => $add_time,
                        'created_by'        => $created_by
                    ];
        }
        
        $this->M_master->input_data('periode', $data);

        echo json_encode(['status' => TRUE]);
    }

    public function cek_bln_periode()
    {
        $bln_periode = nice_date($this->input->post('bln_periode'), 'Y-m');
        
        $cek = $this->M_master->cari_data('m_periode', array('nama_periode' => $bln_periode))->num_rows();

        echo json_encode(['hasil' => $cek]);
    }

    public function tampil_periode_rekon()
    {
        $list = $this->M_rekon->get_periode_rekon();

        $data   = array();
        $no     = $this->input->post('start');

        foreach ($list as $a) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = nice_date($a['nama_periode'], 'F-Y');
            $tbody[]    = nice_date($a['tgl_bayar_awal'], 'd-M-Y');
            $tbody[]    = nice_date($a['tgl_bayar_akhir'], 'd-M-Y');
            $tbody[]    = $a['cabang_asuransi'];
            $tbody[]    = $a['bank'];
            $tbody[]    = $a['cabang_bank'];
            $tbody[]    = date("d-M-Y H:i:s", strtotime($a['add_time']));
            $tbody[]    = $a['username'];
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_rekon->jumlah_semua_periode_rekon(),
                    "recordsFiltered"  => $this->M_rekon->jumlah_filter_periode_rekon(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    public function tampil_periode()
    {
        $list = $this->M_rekon->get_periode();

        $data   = array();
        $no     = $this->input->post('start');

        foreach ($list as $a) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = nice_date($a['nama_periode'], 'F-Y');
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_rekon->jumlah_semua_periode(),
                    "recordsFiltered"  => $this->M_rekon->jumlah_filter_periode(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    public function list_periode()
    {
        $hasil = $this->M_rekon->get_data('m_periode')->result_array();

        $option = "<option value='a'>-- Pilih Periode --</option>";

        foreach ($hasil as $a) {
            $option .= "<option value='".$a['id_periode']."'>".nice_date($a['nama_periode'], 'F-Y')."</option>";
        }

        $data = ['periode'    => $option];

        echo json_encode($data);
        
    }

    public function ambil_cabang_bank()
    {
        $id_cab_asuransi = $this->input->post('id_cab_asuransi');

        if ($id_cab_asuransi != 'a') {

            $hasil = $this->M_rekon->cari_cabang_bank($id_cab_asuransi)->result_array();

            $option = "<option value='a'>-- Pilih Cabang Bank --</option>";

            foreach ($hasil as $a) {
                $option .= "<option value='".$a['id_cabang_bank']."'>".$a['cabang_bank']."</option>";
            }

        } else {
            $option = "<option value='a'>-- Pilih Cabang Bank --</option>";
        }
        
        
        $data = ['cabang_bank'    => $option];

        echo json_encode($data);
    }

}

/* End of file Rekon.php */
