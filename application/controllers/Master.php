<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_master'));
        $this->load->library(array('Cek_login_lib', 'excel'));
		$this->cek_login_lib->logged_in_false();
    }

    public function tes()
    {
        $data = array();
        
        // dokumen asset
        $this->db->select('*');
        $this->db->from('dokumen_asset');
        $h = $this->db->get()->result();
        $ar = array();
        foreach ($h as $b) {
            $ar[] = $b->id_debitur;
        }
        $im = implode(",", $ar);
        $ex = explode(",", $im);

        $this->db->select('d.id_debitur, d.nama_debitur');
        $this->db->from('debitur as d');
        
        if ($ex[0] != "") {
            $this->db->where_in('d.id_debitur', $ex);
        }

        $this->db->order_by('d.id_debitur', 'asc');
        

        $hasil = $this->db->get()->result_array();

        foreach ($hasil as $h) {
            array_push($data, $h['id_debitur']);
        }

        // tr_fu
        $this->db->select('*');
        $this->db->from('tr_fu');
        $h = $this->db->get()->result();
        $ar = array();
        foreach ($h as $b) {
            $ar[] = $b->id_debitur;
        }
        $im = implode(",", $ar);
        $ex = explode(",", $im);

        $this->db->select('d.id_debitur, d.nama_debitur');
        $this->db->from('debitur as d');
        
        if ($ex[0] != "") {
            $this->db->where_in('d.id_debitur', $ex);
        }

        $this->db->order_by('d.id_debitur', 'asc');
        

        $hasil2 = $this->db->get()->result_array();

        foreach ($hasil2 as $h) {
            array_push($data, $h['id_debitur']);
        }

        // kunjungan
        $this->db->select('*');
        $this->db->from('kunjungan');
        $h = $this->db->get()->result();
        $ar = array();
        foreach ($h as $b) {
            $ar[] = $b->id_debitur;
        }
        $im = implode(",", $ar);
        $ex = explode(",", $im);

        $this->db->select('d.id_debitur, d.nama_debitur');
        $this->db->from('debitur as d');
        
        if ($ex[0] != "") {
            $this->db->where_in('d.id_debitur', $ex);
        }

        $this->db->order_by('d.id_debitur', 'asc');
        

        $hasil3 = $this->db->get()->result_array();

        foreach ($hasil3 as $h) {
            array_push($data, $h['id_debitur']);
        }

        // tr_prioritas
        $this->db->select('*');
        $this->db->from('tr_prioritas');
        $h = $this->db->get()->result();
        $ar = array();
        foreach ($h as $b) {
            $ar[] = $b->id_debitur;
        }
        $im = implode(",", $ar);
        $ex = explode(",", $im);

        $this->db->select('d.id_debitur, d.nama_debitur');
        $this->db->from('debitur as d');
        
        if ($ex[0] != "") {
            $this->db->where_in('d.id_debitur', $ex);
        }

        $this->db->order_by('d.id_debitur', 'asc');
        

        $hasil4 = $this->db->get()->result_array();

        foreach ($hasil4 as $h) {
            array_push($data, $h['id_debitur']);
        }

        // tr_recov_as
        $this->db->select('*');
        $this->db->from('tr_recov_as');
        $h = $this->db->get()->result();
        $ar = array();
        foreach ($h as $b) {
            $ar[] = $b->id_debitur;
        }
        $im = implode(",", $ar);
        $ex = explode(",", $im);

        $this->db->select('d.id_debitur, d.nama_debitur');
        $this->db->from('debitur as d');
        
        if ($ex[0] != "") {
            $this->db->where_in('d.id_debitur', $ex);
        }

        $this->db->order_by('d.id_debitur', 'asc');
        

        $hasil5 = $this->db->get()->result_array();

        foreach ($hasil5 as $h) {
            array_push($data, $h['id_debitur']);
        }

        // tr_foto_dokumen
        $this->db->select('*');
        $this->db->from('tr_foto_dokumen');
        $h = $this->db->get()->result();
        $ar = array();
        foreach ($h as $b) {
            $ar[] = $b->id_debitur;
        }
        $im = implode(",", $ar);
        $ex = explode(",", $im);

        $this->db->select('d.id_debitur, d.nama_debitur');
        $this->db->from('debitur as d');
        
        if ($ex[0] != "") {
            $this->db->where_in('d.id_debitur', $ex);
        }

        $this->db->order_by('d.id_debitur', 'asc');
        

        $hasil6 = $this->db->get()->result_array();

        foreach ($hasil6 as $h) {
            array_push($data, $h['id_debitur']);
            // echo $h['id_debitur'], "<br>";
        }

        $a = array_unique($data);

        // foreach ($a as $b) {
        //   echo $b,"<br>";
        // }

        // exit();

        $data2 = array();

        $deb = $this->db->get('debitur')->result_array();
        
        foreach ($deb as $d) {
        array_push($data2, $d['id_debitur']);
        }

        $c = array_diff($data2, $a);

        $no = 0;
        foreach ($c as $cc) {
            $this->db->delete('debitur', array('id_debitur' => $cc));
            // echo $cc."<br>";
            $no++;
        }

        echo "Data debitur yang dihapus sebanyak: ".$no;
        
    }

    public function teslagi()
    {
        // SELECT id_debitur, count(id_debitur)
        // FROM tr_recov_as 
        // GROUP BY id_debitur
        // ORDER BY id_debitur asc
        
        $this->db->select('id_debitur, count(id_debitur)');
        $this->db->from('tr_recov_bank');
        $this->db->group_by('id_debitur');
        $this->db->order_by('id_debitur', 'asc');
        $cari   = $this->db->get()->result_array();
        
        $arr = [];

        foreach ($cari as $c) {

            $id_debitur = $c['id_debitur'];
            
            $this->db->select('id_debitur, count(id_debitur)');
            $this->db->from('tr_recov_as');
            $this->db->where('id_debitur', $id_debitur);
            $this->db->group_by('id_debitur');
            $this->db->order_by('id_debitur', 'asc');
            $cari2   = $this->db->get()->row_array();

            if ($cari2['count'] != $c['count']) {
                array_push($arr, $id_debitur);
            }
        }
        

        print_r($arr);
    }

    /*****************************************************************************************************/
    /*
    /*                                              DEBITUR
    /*
    /*****************************************************************************************************/

    public function index()
    {
        $data   = [ 'judul'     => 'Master Debitur',
                    'asuransi'  => $this->M_master->get_data('m_asuransi')->result_array(),
                    'bank'      => $this->M_master->get_data_bank_3()->result_array(),
                    'no_spk'    => $this->M_master->cari_data('spk', array('status' => 1))->result_array()
                  ];

        $this->template->load('layout/template', 'master/debitur/V_debitur', $data);
    }

    public function debitur_import($aksi)
    {
        if($aksi == 1){

            $id_spk     = $this->input->post('no_spk');

            $path = $_FILES["upload_excel"]["tmp_name"];
      
            $object = PHPExcel_IOFactory::load($path);
      
            foreach($object->getWorksheetIterator() as $worksheet) {
      
                $highestRow = $worksheet->getHighestRow();
      
                $highestColumn = $worksheet->getHighestColumn();
      
                for($row=2; $row<=$highestRow; $row++){
        
                    $nama_debitur       = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $no_reff_lama       = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $no_reff            = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $no_klaim_lama      = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $no_klaim           = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $id_cabang_as       = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $id_capem_bank      = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $penyebab_klaim     = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $jns_kredit         = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $pokok              = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $bunga              = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $denda              = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $jumlah             = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $subrogasi_as       = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    $alamat             = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                    $tgl_wo             = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow(15, $row)->getValue()));
                    $tgl_klaim          = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow(16, $row)->getValue()));
                    $maturity_date      = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow(17, $row)->getValue()));
                    $id_spk             = ($id_spk == 'a') ? null : $id_spk;

                    $nr = trim($no_reff_lama);
                    $nk = trim($no_klaim_lama);

                    // cari id debitur
                    $cari = $this->M_master->cari_data('debitur', array('no_klaim' => $nk, 'no_reff' => $nr))->row_array();

                    // cari cabang asuransi
                    $cari2 = $this->M_master->cari_data('m_cabang_asuransi', array('id_cabang_asuransi' => $id_cabang_as))->row_array();

                    // cari capem bank
                    $cari3 = $this->M_master->cari_data('m_capem_bank', array('id_capem_bank' => $id_capem_bank))->row_array();

                    // cari no spk
                    $cari4 = $this->M_master->cari_data('spk', array('id_spk' => $id_spk))->row_array();

                    $data[] = array(

                            'id_debitur'                => $cari['id_debitur'],
                            'nama_debitur'              => $nama_debitur,
                            'no_klaim'                  => $no_klaim_lama,
                            'no_reff'                   => $no_reff_lama,
                            'cabang_as'                 => $cari2['cabang_asuransi'],
                            'capem_bank'                => $cari3['capem_bank'],
                            'subrogasi_as'              => $subrogasi_as,
                            'penyebab_klaim'            => $penyebab_klaim,
                            'jenis_kredit'              => $jns_kredit,
                            'pokok'                     => $pokok,
                            'bunga'                     => $bunga,
                            'denda'                     => $denda,
                            'jumlah'                    => $jumlah,
                            'alamat_awal'               => $alamat,
                            'tgl_wo'                    => $tgl_wo,
                            'tgl_klaim'                 => $tgl_klaim,
                            'maturity_date'             => $maturity_date,
                            'id_spk'                    => $cari4['no_spk']
            
                    );
      
                }
      
            } 

            $dt = ['data'   => $data];
                
            $this->load->view('master/debitur/V_preview_upload', $dt);
      
        } else {

            $id_spk     = $this->input->post('no_spk');

            $path = $_FILES["upload_excel"]["tmp_name"];
      
            $object = PHPExcel_IOFactory::load($path);
      
            foreach($object->getWorksheetIterator() as $worksheet) {
      
                $highestRow = $worksheet->getHighestRow();
      
                $highestColumn = $worksheet->getHighestColumn();
      
                for($row=2; $row<=$highestRow; $row++){
        
                    $nama_debitur       = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $no_reff_lama       = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $no_reff            = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $no_klaim_lama      = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $no_klaim           = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $id_cabang_as       = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $id_capem_bank      = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $penyebab_klaim     = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $jns_kredit         = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $pokok              = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $bunga              = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $denda              = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $jumlah             = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $subrogasi_as       = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    $alamat             = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                    $tgl_wo             = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow(15, $row)->getValue()));
                    $tgl_klaim          = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow(16, $row)->getValue()));
                    $maturity_date      = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow(17, $row)->getValue()));
                    $id_spk             = ($id_spk == 'a') ? null : $id_spk;

                    $data = array(
            
                        'nama_debitur'              => $nama_debitur,
                        'no_klaim'                  => $no_klaim,
                        'no_reff'                   => $no_reff,
                        'id_cabang_as'              => $id_cabang_as,
                        'id_capem_bank'             => $id_capem_bank,
                        'subrogasi_as'              => $subrogasi_as,
                        'penyebab_klaim'            => $penyebab_klaim,
                        'jenis_kredit'              => $jns_kredit,
                        'pokok'                     => $pokok,
                        'bunga'                     => $bunga,
                        'denda'                     => $denda,
                        'jumlah'                    => $jumlah,
                        'alamat_awal'               => $alamat,
                        'tgl_wo'                    => $tgl_wo,
                        'tgl_klaim'                 => $tgl_klaim,
                        'maturity_date'             => $maturity_date,
                        'id_spk'                    => $id_spk
            
                    );

                    // cari id debitur
                    $cari = $this->M_master->cari_data_deb('debitur', $no_klaim_lama, $no_reff_lama);

                    if ($cari->num_rows() != 0) {

                        $deb = $cari->row_array();

                        if ($deb['id_spk'] != null) {
                            // insert data
                            $this->db->insert('debitur', $data);
                        } else {
                            // ada data yang sama, makan ubah data 

                            // cari id_debitur dahulu

                            // mendapatkan id debitur
                            $id_deb = $deb['id_debitur'];

                            // ubah data
                            $this->db->update('debitur', $data, array('id_debitur' => $id_deb));
                        }
                        
                        
                        
                    } else {

                        // insert data
                        $this->db->insert('debitur', $data);
                        
                    }
      
                }
      
            } 
            
            // $this->db->insert_batch('debitur', $data);
            
            echo json_encode(['status' => TRUE]);
        }
    }

    public function input_m_periode()
    {
        $bln_periode = nice_date($this->input->post('bln_periode'), 'Y-m');
        
        $this->M_master->input_data('m_periode', array('nama_periode' => $bln_periode));

        echo json_encode(['status' => TRUE]);
    }

    public function cari_duplikat()
    {
        // list id debitur
        $this->db->select('id_tr_recov_bank, id_debitur');
        $this->db->from('tr_recov_bank');
        $this->db->group_by('id_debitur');
        $this->db->group_by('id_tr_recov_bank');
        $cari1 = $this->db->get()->result_array();

        $arr = [];

        foreach ($cari1 as $c) {
            // id debitur
            $this->db->select('id_tr_recov_bank, tgl_bayar');
            $this->db->from('tr_recov_bank');
            $this->db->where('id_debitur', $c['id_debitur']);
            $cari2 = $this->db->get()->result_array();
            
            foreach ($cari2 as $c2) {

                $this->db->select('tgl_bayar');
                $this->db->from('tr_recov_bank');
                $this->db->where('id_debitur', $c['id_debitur']);
                $this->db->where('tgl_bayar', $c2['tgl_bayar']);
                $cari3 = $this->db->get()->num_rows();

                if ($cari3 > 1) {
                    array_push($arr, $c['id_debitur']);
                }
                
            }
            
        }

        echo "<pre>";
        print_r(array_unique($arr));
        echo "</pre>";
    }

    // update bayar
    public function update_bayar()
    {
        $id_deb     = $this->input->post('id_deb');
        $tgl_bayar  = nice_date($this->input->post('tgl_bayar'), 'Y-m-d');
        $recov      = str_replace(',','.', $this->input->post('recov'));
        $no_rek     = $this->input->post('no_rek');
        $koma       = $this->input->post('koma');

        if ($koma) {
            $k = ".".$koma;
        } else {
            $k = "";
        }

        $data       = ['id_debitur'     => $id_deb,
                       'tgl_bayar'      => $tgl_bayar,
                       'nominal'        => $recov.$k,
                       'no_rek'         => $no_rek,
                       'add_time'       => date("Y-m-d H:i:s", now('Asia/Jakarta')),
                       'created_by'     => $this->session->userdata('id_pengguna')
                    ];

        $this->db->trans_begin();
        
        $this->M_master->input_data('tr_recov_as', $data);
        $this->M_master->input_data('tr_recov_bank', $data);

        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        echo json_encode(['hasil' => TRUE]);

    }

    // ambil nama debitur
    public function ambil_nama_deb()
    {
        $id_debitur = $this->input->post('id_debitur');

        $nm = $this->M_master->cari_data('debitur', array('id_debitur' => $id_debitur))->row_array();

        $list = $this->M_master->cari_data('rekening', ['id_cabang_asuransi' => $nm['id_cabang_as']])->result_array();

        $option = "<option value=''>-- Pilih Rekening --</option>";

        foreach ($list as $p) {
            $option .= "<option value='".$p['no_rekening']."'>".$p['no_rekening']."</option>";
        }

        $data = ['nm_deb'   => "<h5>".$nm['nama_debitur']."</h5>", 'cabang_as' => $option];

        echo json_encode($data);
        
    }

    // form detail debitur 
    public function form_detail_debitur($aksi = 'detail')
    {
        $id_debitur = $this->input->post('id_debitur');

        $data = ['asuransi'         => $this->M_master->get_data('m_asuransi')->result_array(),
                 'bank'             => $this->M_master->get_data('m_bank')->result_array(),
                 'aksi'             => $aksi,
                 'dt_deb'           => $this->M_master->cari_data_debitur($id_debitur)->row_array(),
                 'cabang_asuransi'  => $this->M_master->get_data('m_cabang_asuransi')->result_array(),
                 'cabang_bank'      => $this->M_master->get_data('m_cabang_bank')->result_array(),
                 'capem_bank'       => $this->M_master->get_data('m_capem_bank')->result_array()
                ];

        $this->load->view('master/debitur/V_detail_deb', $data);
        
    }

    public function simpan_edit_debitur()
    {
        $id_deb     = $this->input->post('id_deb2');

        ($this->input->post('tgl_bayar2') == 'Unknown') ? $a = null : $a = $this->input->post('tgl_bayar2');

        // $tgl_klaim  = nice_date($a, 'Y-m-d');

        $tgl_klaim = date('Y-m-d', strtotime($a));

        $data = ['no_klaim'                 => $this->input->post('no_klaim2'),
                 'no_reff'                  => $this->input->post('no_reff2'),
                 'nama_debitur'             => $this->input->post('nama_deb2'),
                 'nama_debitur_bank'        => $this->input->post('nama_deb_bank'),
                 'tgl_klaim'                => ($tgl_klaim == 'Unknown') ? null : $tgl_klaim,
                 'id_cabang_as'             => $this->input->post('cabang_asuransi2'),
                 'id_capem_bank'            => $this->input->post('capem_bank2'),
                 'jenis_kredit'             => $this->input->post('jns_kredit2'),
                 'subrogasi_as'             => ($this->input->post('subrogasi_as2') == '') ? 0 : $this->input->post('subrogasi_as2'),
                 'bunga'                    => ($this->input->post('bunga2') == '') ? 0 : $this->input->post('bunga2'),
                 'pokok'                    => ($this->input->post('pokok2') == '') ? 0 : $this->input->post('pokok2'),
                 'denda'                    => ($this->input->post('denda2') == '') ? 0 : $this->input->post('denda2'),
                 'jumlah'                   => ($this->input->post('jumlah2') == '') ? 0 : $this->input->post('jumlah2'),
                 'recoveries_awal_asuransi' => ($this->input->post('recov_awal_as2') == '') ? 0 : $this->input->post('recov_awal_as2'),
                 'recoveries_awal_bank'     => ($this->input->post('recov_awal_bank2') == '') ? 0 : $this->input->post('recov_awal_bank2')
                ];

        $this->M_master->ubah_data('debitur', $data, array('id_debitur' => $id_deb));

        echo json_encode(['status'  => TRUE]);
    }

    // proses input debitur manual
    public function input_debitur()
    {
        $no_klaim       = $this->input->post('no_klaim');
        $no_reff        = $this->input->post('no_reff');
        $nm_debitur     = $this->input->post('nm_debitur');
        $nm_debitur_b   = $this->input->post('nm_debitur_bank');
        $tgl_klaim      = ($this->input->post('tgl_klaim') == '') ? null : $this->input->post('tgl_klaim');
        $id_cabang_as   = $this->input->post('id_cabang_as');
        $id_capem_bank  = $this->input->post('id_capem_bank');
        $jns_kredit     = $this->input->post('jns_kredit');
        $subrogasi_as   = ($this->input->post('subrogasi_as') == '') ? 0 : $this->input->post('subrogasi_as');
        $bunga          = ($this->input->post('bunga') == '') ? 0 : $this->input->post('bunga');
        $pokok          = ($this->input->post('pokok') == '') ? 0 : $this->input->post('pokok');
        $denda          = ($this->input->post('denda') == '') ? 0 : $this->input->post('denda');
        $recov_awal     = ($this->input->post('recov_awal') == '') ? 0 : $this->input->post('recov_awal');
        
        $data = [ 'no_klaim'                    => $no_klaim,
                  'no_reff'                     => $no_reff,
                  'nama_debitur'                => $nm_debitur,
                  'nama_debitur_bank'           => $nm_debitur_b,
                  'tgl_klaim'                   => ($tgl_klaim == null) ? null : date('Y-m-d', strtotime($tgl_klaim)),
                  'id_cabang_as'                => $id_cabang_as,
                  'id_capem_bank'               => $id_capem_bank,
                  'jenis_kredit'                => $jns_kredit,
                  'subrogasi_as'                => $subrogasi_as,
                  'bunga'                       => $bunga,
                  'pokok'                       => $pokok,
                  'denda'                       => $denda,
                  'recoveries_awal_asuransi'    => $recov_awal
                ];

        $this->M_master->input_data('debitur', $data);

        echo json_encode(['status' => TRUE]);
    }

    // menampilkan data debitur
    public function tampil_m_debitur()
    {
        $bank       = $this->input->post('id_bank');
        $cb_bank    = $this->input->post('id_cabang_bank');
        $spk        = $this->input->post('spk');

        $list = $this->M_master->get_data_m_debitur($bank, $cb_bank, $spk);

        $data   = array();
        $no     = $this->input->post('start');

        foreach ($list as $a) {
            $no++;
            $tbody = array();

            $shs = ($a['subrogasi_as'] - $a['recoveries_awal_asuransi']) - $a['tot_nominal_as'];

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $a['no_reff'];
            $tbody[]    = $a['no_klaim'];
            $tbody[]    = $a['nama_debitur'];
            $tbody[]    = $a['cabang_asuransi'];
            $tbody[]    = $a['bank'];
            $tbody[]    = $a['cabang_bank'];
            $tbody[]    = "<div align='right'><h6>Rp. ".number_format($shs, '2', ',', '.')."</h6></div>";
            $tbody[]    = "<div align='center'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-info detail-debitur' data-id=".$a['id_debitur'].">Detail</button></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_master->jumlah_semua_m_debitur($bank, $cb_bank, $spk),
                    "recordsFiltered"  => $this->M_master->jumlah_filter_m_debitur($bank, $cb_bank, $spk),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // 13-03-2020

        // menampilkan data unduh excel
        public function unduh_excel_debitur()
        {
            $bank       = $this->input->post('bank');
            $cb_bank    = $this->input->post('cabang_bank');
            $spk        = $this->input->post('spk3');

            $list = $this->M_master->get_debitur_excel($bank, $cb_bank, $spk)->result_array();

            $data       = [ 'data'       => $list,
                            'report'     => 'Master Debitur'
                          ];

            $this->template->load('layout/template_excel', 'master/debitur/V_excel_debitur', $data);
        }

    // Akhir 13-03-2020

    // ambil cabang asuransi
    public function ambil_cabang_asuransi()
    {
        $id_asuransi = $this->input->post('id_asuransi');

        if ($id_asuransi == "a") {
            $option = "<option value='a'>-- Pilih Cabang Asuransi --</option>";
        } else {
            $list_as = $this->M_master->cari_cab_asuransi($id_asuransi)->result_array();

            $option = "<option value='a'>-- Pilih Cabang Asuransi --</option>";

            foreach ($list_as as $a) {
                $option .= "<option value='".$a['id_cabang_asuransi']."'>".$a['cabang_asuransi']."</option>";
            }
        }
        $data = ['cabang_as'    => $option];

        echo json_encode($data);
        
    }

    // menampilkan cabang bank 
    public function ambil_cabang_bank()
    {
        $id_bank = $this->input->post('id_bank');
        
        if ($id_bank == "a") {
            $option = "<option value='a'>-- Pilih Cabang Bank --</option>";
        } else {
            $list_bank = $this->M_master->cari_cab_bank($id_bank)->result_array();

            $option = "<option value='a'>-- Pilih Cabang Bank --</option>";

            foreach ($list_bank as $a) {
                $option .= "<option value='".$a['id_cabang_bank']."'>".$a['cabang_bank']."</option>";
            }
        }

        $option1 = "<option value='a'>-- Pilih Capem Bank --</option>";

        $data = ['cabang_bank'    => $option, 'option1' => $option1];

        echo json_encode($data);
    }

    // menampilkan capem bank
    public function ambil_capem_bank()
    {
        $id_cabang_bank = $this->input->post('id_cabang_bank');

        if ($id_cabang_bank == "a") {
            $option = "<option value='a'>-- Pilih Capem Bank --</option>";
        } else {
            $list_cap_b = $this->M_master->cari_cap_bank($id_cabang_bank)->result_array();

            $option = "<option value='a'>-- Pilih Capem Bank --</option>";

            foreach ($list_cap_b as $a) {
                $option .= "<option value='".$a['id_capem_bank']."'>".$a['capem_bank']."</option>";
            }
        }
        $data = ['capem_bank'    => $option];

        echo json_encode($data);
    }

    /*****************************************************************************************************/
    /*
    /*                                              KARYAWAN
    /*
    /*****************************************************************************************************/

    public function karyawan()
    {
        $data = ['judul'    => 'Master Karyawan'
                ];

        $this->template->load('layout/template', 'master/karyawan/V_karyawan', $data);
    }

    // menampilkan data karyawan
    public function tampil_karyawan()
    {
        $list = $this->M_master->get_data_karyawan();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($o['verifikator'] == 0) {
                $ver = "<span class='badge badge-secondary'>Tidak</span>";
            } else {
                $ver = "<span class='badge badge-info'>Ya</span>";
            }

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['nama_lengkap'];
            $tbody[]    = $o['nik'];
            $tbody[]    = $o['telfon'];
            $tbody[]    = $o['alamat'];
            $tbody[]    = "<div align='center'>".$ver."</div>";
            $tbody[]    = "<div align='center'><div align='center' id='namanya'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-info btn-sm mr-2 edit-karyawan' data-id='".$o['id_karyawan']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-karyawan' data-id='".$o['id_karyawan']."'>Hapus</button></div></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_master->jumlah_semua_karyawan(),
                    "recordsFiltered"  => $this->M_master->jumlah_filter_karyawan(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi karyawan 
    public function aksi_karyawan()
    {
        $nama   = $this->input->post('nama');
        $nik    = $this->input->post('nik');
        $telfon = $this->input->post('telfon');
        $alamat = $this->input->post('alamat');
        $aksi   = $this->input->post('aksi');
        $id_kar = $this->input->post('id_karyawan');
        $ver    = $this->input->post('ver');
        
        $data = ['nama_lengkap' => $nama,
                 'nik'          => $nik,
                 'telfon'       => $telfon,
                 'alamat'       => $alamat,
                 'verifikator'  => $ver
                ];

        if ($aksi == 'Tambah') {
            $this->M_master->input_data('karyawan', $data);
        } elseif ($aksi == 'Edit') {
            $this->M_master->ubah_data('karyawan', $data, array('id_karyawan' => $id_kar));
        } else {
            $this->M_master->hapus_data('karyawan', array('id_karyawan' => $id_kar));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data karyawan
    public function ambil_data_karyawan($id_karyawan)
    {
        $data = $this->M_master->cari_data('karyawan', array('id_karyawan' => $id_karyawan))->row_array();

        echo json_encode($data);
    }

    /*****************************************************************************************************/
    /*
    /*                                            Rekening
    /*
    /*****************************************************************************************************/

    public function rekening()
    {
        $data = ['judul'        => 'Master Rekening',
                 'cabang_as'    => $this->M_master->get_data_order('m_cabang_asuransi', 'cabang_asuransi', 'asc')->result_array()
                ];

        $this->template->load('layout/template', 'master/rekening/V_rekening', $data);
    }

    // menampilkan data rekening
    public function tampil_rekening()
    {
        $list = $this->M_master->get_data_rekening();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['no_rekening'];
            $tbody[]    = $o['cabang_asuransi'];
            $tbody[]    = "<div align='center'><div align='center' id='namanya'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-info btn-sm mr-3 edit-rekening' data-id='".$o['id_rekening']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-rekening' data-id='".$o['id_rekening']."'>Hapus</button></div></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_master->jumlah_semua_rekening(),
                    "recordsFiltered"  => $this->M_master->jumlah_filter_rekening(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi rekening 
    public function aksi_rekening()
    {
        $no_rek         = $this->input->post('no_rek');
        $cabang_as      = $this->input->post('cabang_as');
        $aksi           = $this->input->post('aksi');
        $id_rekening    = $this->input->post('id_rekening');
        
        $data = ['no_rekening'          => $no_rek,
                 'id_cabang_asuransi'   => $cabang_as
                ];

        if ($aksi == 'Tambah') {
            $this->M_master->input_data('rekening', $data);
        } elseif ($aksi == 'Edit') {
            $this->M_master->ubah_data('rekening', $data, array('id_rekening' => $id_rekening));
        } else {
            $this->M_master->hapus_data('rekening', array('id_rekening' => $id_rekening));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data rekening
    public function ambil_data_rekening($id_rekening)
    {
        $data = $this->M_master->cari_data('rekening', array('id_rekening' => $id_rekening))->row_array();

        echo json_encode($data);
    }

    /*****************************************************************************************************/
    /*
    /*                                            SPK
    /*
    /*****************************************************************************************************/

    public function spk()
    {
        $data = ['judul'        => 'Master SPK',
                 'cabang_as'    => $this->M_master->get_data_order('m_cabang_asuransi', 'cabang_asuransi', 'asc')->result_array()
                ];

        $this->template->load('layout/template', 'master/spk/V_spk', $data);
    }

    // menampilkan data spk
    public function tampil_spk()
    {
        $list = $this->M_master->get_data_spk();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($o['status'] == 1) {
                $status = "<div align='center'><h4><span class='badge badge-info badge-pill'>Aktif</span></h4></div>";
            } else {
                $status = "<div align='center'><h4><span class='badge badge-danger badge-pill'>Tidak Aktif</span></h4></div>";
            }

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['no_spk'];
            $tbody[]    = $o['cabang_asuransi'];
            $tbody[]    = $o['no_rekening'];
            $tbody[]    = nice_date($o['tgl_mulai'], 'd-F-Y');
            $tbody[]    = nice_date($o['tgl_akhir'], 'd-F-Y');
            $tbody[]    = "<div align='center'>".$status."</div>";
            $tbody[]    = "<div align='center'><div align='center' id='namanya'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-info btn-sm mr-3 edit-spk' data-id='".$o['id_spk']."' id_rekening='".$o['id_rekening']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-spk' data-id='".$o['id_spk']."'>Hapus</button></div></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_master->jumlah_semua_spk(),
                    "recordsFiltered"  => $this->M_master->jumlah_filter_spk(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi spk 
    public function aksi_spk()
    {
        $no_spk         = $this->input->post('no_spk');
        $tgl_mulai      = nice_date($this->input->post('tgl_mulai'), 'Y-m-d');
        $tgl_akhir      = nice_date($this->input->post('tgl_akhir'), 'Y-m-d');
        $cabang_as      = $this->input->post('cabang_as');
        $aksi           = $this->input->post('aksi');
        $id_spk         = $this->input->post('id_spk');
        $id_rekening    = $this->input->post('id_rekening');
        
        $data = ['no_spk'               => $no_spk,
                 'id_cabang_asuransi'   => $cabang_as,
                 'tgl_mulai'            => $tgl_mulai,
                 'tgl_akhir'            => $tgl_akhir,
                 'id_rekening'          => ($id_rekening == '') ? null : $id_rekening,
                 'status'               => 1
                ];

        if ($aksi == 'Tambah') {
            // mencari id_cabang_asuransi terakhir
            $cari   = $this->M_master->cari_data_order('spk', array('id_cabang_asuransi' => $cabang_as), 'CAST(add_time as VARCHAR)', 'desc')->row_array();

            // proses ubah data status ke 0
            $this->M_master->ubah_data('spk', array('status' => 0), array('id_spk' => $cari['id_spk']));

            $this->M_master->input_data('spk', $data);
        } elseif ($aksi == 'Edit') {
            $this->M_master->ubah_data('spk', $data, array('id_spk' => $id_spk));
        } else {
            $this->M_master->hapus_data('spk', array('id_spk' => $id_spk));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data spk
    public function ambil_data_spk($id_spk)
    {
        $data = $this->M_master->cari_data('spk', array('id_spk' => $id_spk))->row_array();

        $dt = [ 'id_spk'        => $data['id_spk'],
                'no_spk'        => $data['no_spk'],
                'tgl_mulai'     => nice_date($data['tgl_mulai'], 'd-F-Y'),
                'tgl_akhir'     => nice_date($data['tgl_akhir'], 'd-F-Y'),
                'id_cabang_as'  => $data['id_cabang_asuransi'],
                'id_rekening'   => ($data['id_rekening'] == null) ? '' : $data['id_rekening']
              ];

        echo json_encode($dt);
    }

    // 05-04-2021
    public function ambil_list_rekening()
    {
        $id_cabang_as   = $this->input->post('id_cabang_as');
        $id_rekening    = $this->input->post('id_rekening');
        
        $list = $this->M_master->cari_data('rekening', ['id_cabang_asuransi' => $id_cabang_as])->result_array();

        $option = "<option value=''>-- Pilih Rekening --</option>";

        foreach ($list as $s) {
            if ($s['id_rekening'] == $id_rekening) {
                $sel = 'selected';
            } else {
                $sel = '';
            }
            
            $option .= "<option value='".$s['id_rekening']."' $sel>".$s['no_rekening']."</option>";
        }

        echo json_encode(['status' => true, 'option' => $option]);
    }

    /*****************************************************************************************************/
    /*
    /*                                            PENGGUNA
    /*
    /*****************************************************************************************************/

    public function pengguna()
    {
        $data = ['judul'    => 'Master Pengguna',
                 'level'    => $this->M_master->get_data('level')->result_array(),
                 'karyawan' => $this->M_master->get_data_order('karyawan', 'nama_lengkap', 'asc')->result_array()
                ];

        $this->template->load('layout/template', 'master/pengguna/V_pengguna', $data);
    }

    // menampilkan data pengguna
    public function tampil_pengguna()
    {
        $list = $this->M_master->get_data_pengguna();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            if ($o['status_pengguna'] == 1) {
                $status = "<div align='center'><h4><span class='badge badge-info badge-pill'>Aktif</span></h4></div>";
            } else {
                $status = "<div align='center'><h4><span class='badge badge-danger badge-pill'>Tidak Aktif</span></h4></div>";
            }

            // jika level asuransi
            // if ($o['id_level'] == 13) {
            //     $nm_as  = $this->M_master->cari_data('m_cabang_asuransi', array('id_cabang_asuransi' => $o['id_karyawan']))->row_array();
            //     $nama   = $nm_as['cabang_asuransi'];                
            // } elseif ($o['id_level'] == 14) {
            //     $nm_kor = $this->M_master->cari_data('m_korwil_asuransi', array('id_korwil_asuransi' => $o['id_karyawan']))->row_array();    
            //     $nama   = $nm_kor['korwil_asuransi'];
            // } else {
            //     $nm_kar = $this->M_master->cari_data_karyawan('karyawan', array('id_karyawan' => $o['id_karyawan']))->row_array();
            //     $nama   = $nm_kar['nama_lengkap'];
            // }

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = "";
            $tbody[]    = $o['username'];
            $tbody[]    = $o['level'];
            $tbody[]    = "<div align='center'>".$status."</div>";
            $tbody[]    = "<div align='center'><div align='center' id='namanya'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-info btn-sm mr-3 edit-pengguna' data-id='".$o['id_pengguna']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-pengguna' data-id='".$o['id_pengguna']."'>Hapus</button></div></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_master->jumlah_semua_pengguna(),
                    "recordsFiltered"  => $this->M_master->jumlah_filter_pengguna(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    /*****************************************************************************************************/
    /*
    /*                                              Bank
    /*
    /*****************************************************************************************************/

    public function bank()
    {
        $data = ['judul'    => 'Master Bank'
                ];

        $this->template->load('layout/template', 'master/bank/V_bank', $data);
    }

    // menampilkan data bank
    public function tampil_bank()
    {
        $list = $this->M_master->get_data_bank();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['bank'];
            $tbody[]    = $o['singkatan'];
            $tbody[]    = "<div align='center'><div align='center' id='namanya'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-info btn-sm mr-3 edit-bank' data-id='".$o['id_bank']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-bank' data-id='".$o['id_bank']."'>Hapus</button></div></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_master->jumlah_semua_bank(),
                    "recordsFiltered"  => $this->M_master->jumlah_filter_bank(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi bank 
    public function aksi_bank()
    {
        $nama       = $this->input->post('nama');
        $singkatan  = $this->input->post('singkatan');
        $aksi       = $this->input->post('aksi');
        $id_bank    = $this->input->post('id_bank');
        
        $data = ['bank'     => $nama,
                 'singkatan'=> $singkatan
                ];

        if ($aksi == 'Tambah') {
            $this->M_master->input_data('m_bank', $data);
        } elseif ($aksi == 'Edit') {
            $this->M_master->ubah_data('m_bank', $data, array('id_bank' => $id_bank));
        } else {
            $this->M_master->hapus_data('m_bank', array('id_bank' => $id_bank));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data bank
    public function ambil_data_bank($id_bank)
    {
        $data = $this->M_master->cari_data('m_bank', array('id_bank' => $id_bank))->row_array();

        echo json_encode($data);
    }


    /*****************************************************************************************************/
    /*
    /*                                         Cabang Bank
    /*
    /*****************************************************************************************************/

    public function cabang_bank()
    {
        $data = ['judul'    => 'Master Cabang Bank',
                 'bank'     => $this->M_master->get_data('m_bank')->result_array()
                ];

        $this->template->load('layout/template', 'master/bank/V_cabang_bank', $data);
    }

    // menampilkan data cabang_bank
    public function tampil_cabang_bank()
    {
        $list = $this->M_master->get_data_cabang_bank();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['bank'];
            $tbody[]    = $o['cabang_bank'];
            $tbody[]    = "<div align='center'><div align='center' id='namanya'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-info btn-sm mr-3 edit-cabang-bank' data-id='".$o['id_cabang_bank']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-cabang-bank' data-id='".$o['id_cabang_bank']."'>Hapus</button></div></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_master->jumlah_semua_cabang_bank(),
                    "recordsFiltered"  => $this->M_master->jumlah_filter_cabang_bank(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi cabang_bank 
    public function aksi_cabang_bank()
    {
        $nama           = $this->input->post('nama');
        $bank           = $this->input->post('bank');
        $aksi           = $this->input->post('aksi');
        $id_cabang_bank = $this->input->post('id_cabang_bank');
        
        $data = ['cabang_bank'  => $nama,
                 'id_bank'      => $bank
                ];

        if ($aksi == 'Tambah') {
            $this->M_master->input_data('m_cabang_bank', $data);
        } elseif ($aksi == 'Edit') {
            $this->M_master->ubah_data('m_cabang_bank', $data, array('id_cabang_bank' => $id_cabang_bank));
        } else {
            $this->M_master->hapus_data('m_cabang_bank', array('id_cabang_bank' => $id_cabang_bank));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data cabang_bank
    public function ambil_data_cabang_bank($id_cabang_bank)
    {
        $data = $this->M_master->cari_data('m_cabang_bank', array('id_cabang_bank' => $id_cabang_bank))->row_array();

        echo json_encode($data);
    }

    /*****************************************************************************************************/
    /*
    /*                                         Capem Bank
    /*
    /*****************************************************************************************************/

    public function capem_bank()
    {
        $data = ['judul'    => 'Master Capem Bank',
                 'bank'     => $this->M_master->get_data('m_bank')->result_array()
                ];

        $this->template->load('layout/template', 'master/bank/V_capem_bank', $data);
    }

    // menampilkan data capem_bank
    public function tampil_capem_bank()
    {
        $list = $this->M_master->get_data_capem_bank();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['bank'];
            $tbody[]    = $o['cabang_bank'];
            $tbody[]    = $o['capem_bank'];
            $tbody[]    = "<div align='center'><div align='center' id='namanya'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-info btn-sm mr-3 edit-capem-bank' data-id='".$o['id_capem_bank']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-capem-bank' data-id='".$o['id_capem_bank']."'>Hapus</button></div></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_master->jumlah_semua_capem_bank(),
                    "recordsFiltered"  => $this->M_master->jumlah_filter_capem_bank(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi capem_bank 
    public function aksi_capem_bank()
    {
        $nama           = $this->input->post('nama');
        $cabang_bank    = $this->input->post('cabang_bank');
        $aksi           = $this->input->post('aksi');
        $id_capem_bank  = $this->input->post('id_capem_bank');
        
        $data = ['capem_bank'       => $nama,
                 'id_cabang_bank'   => $cabang_bank
                ];

        if ($aksi == 'Tambah') {
            $this->M_master->input_data('m_capem_bank', $data);
        } elseif ($aksi == 'Edit') {
            $this->M_master->ubah_data('m_capem_bank', $data, array('id_capem_bank' => $id_capem_bank));
        } else {
            $this->M_master->hapus_data('m_capem_bank', array('id_capem_bank' => $id_capem_bank));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data capem_bank
    public function ambil_data_capem_bank($id_capem_bank)
    {
        $data = $this->M_master->cari_data('m_capem_bank', array('id_capem_bank' => $id_capem_bank))->row_array();

        echo json_encode($data);
    }

    // 09-03-2020

        // unduh excel 
        public function unduh_excel_capem_bank()
        {
            $data = ['data'     => $this->M_master->get_data_capem_bank_excel()->result_array(),
                     'report'   => 'Capem Bank'
                    ];

            $this->template->load('layout/template_excel', 'master/bank/V_excel_capem_bank', $data);
        }

    // Akhir 09-03-2020

    /*****************************************************************************************************/
    /*
    /*                                             Asuransi
    /*
    /*****************************************************************************************************/
    public function asuransi()
    {
        $data = ['judul'    => 'Master Asuransi'
                ];

        $this->template->load('layout/template', 'master/asuransi/V_asuransi', $data);
    }

    // menampilkan data asuransi
    public function tampil_asuransi()
    {
        $list = $this->M_master->get_data_asuransi();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['asuransi'];
            $tbody[]    = "<div align='center'><div align='center' id='namanya'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-info btn-sm mr-3 edit-asuransi' data-id='".$o['id_asuransi']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-asuransi' data-id='".$o['id_asuransi']."'>Hapus</button></div></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_master->jumlah_semua_asuransi(),
                    "recordsFiltered"  => $this->M_master->jumlah_filter_asuransi(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi asuransi 
    public function aksi_asuransi()
    {
        $nama           = $this->input->post('nama');
        $aksi           = $this->input->post('aksi');
        $id_asuransi    = $this->input->post('id_asuransi');
        
        $data = ['asuransi'  => $nama
                ];

        if ($aksi == 'Tambah') {
            $this->M_master->input_data('m_asuransi', $data);
        } elseif ($aksi == 'Edit') {
            $this->M_master->ubah_data('m_asuransi', $data, array('id_asuransi' => $id_asuransi));
        } else {
            $this->M_master->hapus_data('m_asuransi', array('id_asuransi' => $id_asuransi));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data asuransi
    public function ambil_data_asuransi($id_asuransi)
    {
        $data = $this->M_master->cari_data('m_asuransi', array('id_asuransi' => $id_asuransi))->row_array();

        echo json_encode($data);
    }

    /*****************************************************************************************************/
    /*
    /*                                           Korwil Asuransi
    /*
    /*****************************************************************************************************/
    public function korwil_asuransi()
    {
        $data = ['judul'    => 'Master Korwil Asuransi',
                 'asuransi' => $this->M_master->get_data('m_asuransi')->result_array()
                ];

        $this->template->load('layout/template', 'master/asuransi/V_korwil_asuransi', $data);
    }

    // menampilkan data korwil_asuransi
    public function tampil_korwil_asuransi()
    {
        $list = $this->M_master->get_data_korwil_asuransi();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['asuransi'];
            $tbody[]    = $o['korwil_asuransi'];
            $tbody[]    = "<div align='center'><div align='center' id='namanya'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-info btn-sm mr-3 edit-korwil-asuransi' data-id='".$o['id_korwil_asuransi']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-korwil-asuransi' data-id='".$o['id_korwil_asuransi']."'>Hapus</button></div></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_master->jumlah_semua_korwil_asuransi(),
                    "recordsFiltered"  => $this->M_master->jumlah_filter_korwil_asuransi(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi korwil_asuransi 
    public function aksi_korwil_asuransi()
    {
        $nama           = $this->input->post('nama');
        $asuransi       = $this->input->post('asuransi');
        $aksi           = $this->input->post('aksi');
        $id_korwil_asuransi    = $this->input->post('id_korwil_asuransi');
        
        $data = ['korwil_asuransi'  => $nama,
                 'id_asuransi'      => $asuransi
                ];

        if ($aksi == 'Tambah') {
            $this->M_master->input_data('m_korwil_asuransi', $data);
        } elseif ($aksi == 'Edit') {
            $this->M_master->ubah_data('m_korwil_asuransi', $data, array('id_korwil_asuransi' => $id_korwil_asuransi));
        } else {
            $this->M_master->hapus_data('m_korwil_asuransi', array('id_korwil_asuransi' => $id_korwil_asuransi));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data korwil_asuransi
    public function ambil_data_korwil_asuransi($id_korwil_asuransi)
    {
        $data = $this->M_master->cari_data('m_korwil_asuransi', array('id_korwil_asuransi' => $id_korwil_asuransi))->row_array();

        echo json_encode($data);
    }

    /*****************************************************************************************************/
    /*
    /*                                         Cabang Asuransi
    /*
    /*****************************************************************************************************/

    public function cabang_asuransi()
    {
        $data = ['judul'        => 'Master Cabang Asuransi',
                 'kor_asuransi' => $this->M_master->get_data('m_korwil_asuransi')->result_array()
                ];

        $this->template->load('layout/template', 'master/asuransi/V_cabang_asuransi', $data);
    }

    // menampilkan data cabang_asuransi
    public function tampil_cabang_asuransi()
    {
        $list = $this->M_master->get_data_cabang_asuransi();

        $data = array();

        $no   = $this->input->post('start');

        foreach ($list as $o) {
            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no."</div>";
            $tbody[]    = $o['asuransi'];
            $tbody[]    = $o['korwil_asuransi'];
            $tbody[]    = $o['cabang_asuransi'];
            $tbody[]    = $o['singkatan'];
            $tbody[]    = "<div align='center'><div align='center' id='namanya'><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-info btn-sm mr-3 edit-cabang-asuransi' data-id='".$o['id_cabang_asuransi']."'>Edit</button><button type='button' class='btn btn-sm waves-effect waves-light btn-outline-danger btn-sm hapus-cabang-asuransi' data-id='".$o['id_cabang_asuransi']."'>Hapus</button></div></div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_master->jumlah_semua_cabang_asuransi(),
                    "recordsFiltered"  => $this->M_master->jumlah_filter_cabang_asuransi(),   
                    "data"             => $data
                ];

        echo json_encode($output);
    }

    // aksi cabang_asuransi 
    public function aksi_cabang_asuransi()
    {
        $nama               = $this->input->post('nama');
        $singkatan          = $this->input->post('singkatan');
        $korwil_asuransi    = $this->input->post('korwil_asuransi');
        $aksi               = $this->input->post('aksi');
        $id_cabang_asuransi = $this->input->post('id_cabang_asuransi');
        
        $data = ['cabang_asuransi'      => $nama,
                 'id_korwil_asuransi'   => $korwil_asuransi,
                 'singkatan'            => $singkatan 
                ];

        if ($aksi == 'Tambah') {
            $this->M_master->input_data('m_cabang_asuransi', $data);
        } elseif ($aksi == 'Edit') {
            $this->M_master->ubah_data('m_cabang_asuransi', $data, array('id_cabang_asuransi' => $id_cabang_asuransi));
        } else {
            $this->M_master->hapus_data('m_cabang_asuransi', array('id_cabang_asuransi' => $id_cabang_asuransi));
        }

        echo json_encode(['status' => TRUE]);
    }

    // ambil data cabang_asuransi
    public function ambil_data_cabang_asuransi($id_cabang_asuransi)
    {
        $data = $this->M_master->cari_data('m_cabang_asuransi', array('id_cabang_asuransi' => $id_cabang_asuransi))->row_array();

        echo json_encode($data);
    }

    // 09-03-2020

        // unduh excel
        public function unduh_excel_cabang_asuransi()
        {
            $data = ['data'     => $this->M_master->get_data_cabang_asuransi_excel()->result_array(),
                     'report'   => "Cabang Asuransi"
                    ];

            $this->template->load('layout/template_excel', 'master/asuransi/V_cabang_asuransi_excel', $data);
        }

    // Akhir 09-03-2020

}

/* End of file Master.php */
