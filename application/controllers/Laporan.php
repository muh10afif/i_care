<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('Cek_login_lib'));
        $this->cek_login_lib->logged_in_false();
        $this->load->model(array('M_laporan'));
        $this->db_2 = $this->load->database('database_hrd', TRUE);
    }
    

    public function tes()
    {
        $hasil = $this->db_2->get('absensi')->result_array();
        
        print_r($hasil);
    }

    public function index()
    {
        $this->pengeluaran_bulanan();
    }

    /***********************************************************************/
    /*
    /*                       PENGELUARAN BULANAN
    /*
    /***********************************************************************/

    public function pengeluaran_bulanan()
    {
        $data = ['judul'    => 'Pengeluaran Bulanan'];

        $this->template->load('layout/template', 'laporan/peng_bulanan/V_peng_bulanan', $data);
    }

    // menampilkan data pengeluaran bulanan
    public function tampil_peng_bulanan()
    {
        $dt = [ 'tanggal_awal'      => $this->input->post('tanggal_awal'),
                'tanggal_akhir'     => $this->input->post('tanggal_akhir')
            ];

        $list = $this->M_laporan->get_data_peng_bulanan($dt);

        $data = array();

        $no   = $this->input->post('start');

        // foreach ($list as $key => $o) {
        //     if ($o['debit'] == 0) {
        //         unset($list[$key]);
        //     }
        // }

        foreach ($list as $o) {

            $no++;
            $tbody = array();

            $tbody[]    = "<div align='center'>".$no.".</div>";
            $tbody[]    = nice_date($o['tgl_transaksi'], 'd-M-Y');
            $tbody[]    = $o['keterangan'];
            $tbody[]    = ucwords($o['pengguna']);
            $tbody[]    = $o['no_coa_des'];
            $tbody[]    = $o['deskripsi_coa'];
            $tbody[]    = "<div class='text-right'>".number_format($o['debit'])."</div>";
            $data[]     = $tbody;
        }

        $output = [ "draw"             => $_POST['draw'],
                    "recordsTotal"     => $this->M_laporan->jumlah_semua_peng_bulanan($dt),
                    "recordsFiltered"  => $this->M_laporan->jumlah_filter_peng_bulanan($dt),   
                    "data"             => $data
                ];

        echo json_encode($output);
    } 

    // proses export data
    public function export_data()
    {
        $jns        = $this->input->post('jns');
        $tgl_awal   = $this->input->post('tgl_awal');
        $tgl_akhir  = $this->input->post('tgl_akhir');

        $data   = [ 'list_peng_bln' => $this->M_laporan->get_data_export($tgl_awal, $tgl_akhir)->result_array(),
                    'report'        => 'Laporan Pengeluaran Bulanan',
                    'tgl_awal'      => $tgl_awal,
                    'tgl_akhir'     => $tgl_akhir,
                    'jns'           => $jns
                    ];    

        if ($jns == 'excel') {
            $temp = 'layout/template_excel';
            $this->template->load("$temp", 'laporan/peng_bulanan/V_export', $data);
        } elseif ($jns == 'pdf') {
            $temp = 'layout/template_pdf';
            $this->template->load("$temp", 'laporan/peng_bulanan/V_export', $data);
        } else {
            $this->load->view('laporan/peng_bulanan/V_export', $data);  
        }
        
    }

    /***********************************************************************/
    /*
    /*                          BIAYA PER COA
    /*
    /***********************************************************************/

    public function biaya_per_coa()
    {
        $data = ['judul'    => 'Biaya Per COA'];

        $this->template->load('layout/template', 'laporan/biaya_p_coa/V_biaya_p_coa', $data);
    }

    public function tampil_biaya_p_bulan()
    {
        $a = $this->input->post('bulan_awal');
        $k = $this->input->post('bulan_akhir');

        $hasil = $this->M_laporan->get_data_detail_jurnal_coa($a, $k);

        if ($hasil->num_rows() != 0) {

            foreach ($hasil->result_array() as $a) {
                $data[] = [ 'no_coa'    => $a['no_coa_des'],
                            'deskripsi' => $a['deskripsi_coa'],
                            'bulan'     => nice_date($a['tgl_transaksi'], 'Y-m')
                        ];
            }

            $list = array_map(
                'unserialize',
                array_unique(
                    array_map(
                        'serialize',
                        $data
                    )
                )
            );

        } else {

            $list = [];

        }

        $no = 1;
        $nominal = 0;

        foreach ($list as $key => $value) {
            $tbody = array();

            $bln        = $value['bulan'];
            $no_coa     = $value['no_coa'];
            $deskripsi  = $value['deskripsi'];

            // cari nominal 
            $this->db_2->select('sum(d.debit) as tot_debit, sum(d.kredit) as tot_kredit');
            $this->db_2->from('detail_jurnal as d');
            $this->db_2->join('anggota as a', 'CAST(a.id_anggota as VARCHAR) = CAST(d.pelaksana as VARCHAR)', 'inner');
            $this->db_2->join('posisi as p', 'p.id_posisi = a.id_posisi', 'inner');
            $this->db_2->join('bagian as b','b.id_bagian = p.id_bagian', 'inner');
            $this->db_2->join('des_coa as c', 'c.no_coa_des = d.coa', 'inner');
            $this->db_2->where('b.id_bagian', 4);
            $this->db_2->where("CAST(d.tgl_transaksi as VARCHAR) LIKE '%$bln%'");
            $this->db_2->where('d.coa', $no_coa);
            $this->db_2->where('d.id_group', 8);

            $t = $this->db_2->get()->row_array();
            
            // $nominal = $t['tot_debit'] - $t['tot_kredit'];
            $nominal = $t['tot_debit'];

            if ($nominal == 0) {
                unset($list[$key]);
            }
        } 

        foreach ($list as $value) {
            $tbody = array();

            $bln        = $value['bulan'];
            $no_coa     = $value['no_coa'];
            $deskripsi  = $value['deskripsi'];

            // cari nominal 
            $this->db_2->select('sum(d.debit) as tot_debit, sum(d.kredit) as tot_kredit');
            $this->db_2->from('detail_jurnal as d');
            $this->db_2->join('anggota as a', 'CAST(a.id_anggota as VARCHAR) = CAST(d.pelaksana as VARCHAR)', 'inner');
            $this->db_2->join('posisi as p', 'p.id_posisi = a.id_posisi', 'inner');
            $this->db_2->join('bagian as b','b.id_bagian = p.id_bagian', 'inner');
            $this->db_2->join('des_coa as c', 'c.no_coa_des = d.coa', 'inner');
            $this->db_2->where('b.id_bagian', 4);
            $this->db_2->where("CAST(d.tgl_transaksi as VARCHAR) LIKE '%$bln%'");
            $this->db_2->where('d.coa', $no_coa);
            $this->db_2->where('d.id_group', 8);

            $t = $this->db_2->get()->row_array();
            
            // $nominal = $t['tot_debit'] - $t['tot_kredit'];
            $nominal = $t['tot_debit'];

            $tbody[] = "<div align='center'>".$no++."</div>";
            $tbody[] = nice_date($bln, 'F-Y');
            $tbody[] = $no_coa;
            $tbody[] = $deskripsi;
            $tbody[] = "<div class='text-right'>".number_format($nominal)."</div>";
            $data1[]  = $tbody; 
        }        

        if ($list) {
            echo json_encode(array('data'=> $data1));
        }else{
            echo json_encode(array('data'=>0));
        }
    }

    public function tampil_resume_coa()
    {
        $a = $this->input->post('bulan_awal');
        $k = $this->input->post('bulan_akhir');

        $hasil = $this->M_laporan->get_data_detail_jurnal_coa($a, $k);

        if ($hasil->num_rows() != 0) {

            foreach ($hasil->result_array() as $a) {
                $data[] = [ 'bulan'     => nice_date($a['tgl_transaksi'], 'Y-m')
                        ];
            }

            $list = array_map(
                'unserialize',
                array_unique(
                    array_map(
                        'serialize',
                        $data
                    )
                )
            );

        } else {

            $list = [];

        }

        $no = 1;
        $nominal = 0;

        foreach ($list as $key => $value) {
            $tbody = array();

            $bln        = $value['bulan'];

            $this->db_2->select('sum(d.debit) as tot_debit, sum(d.kredit) as tot_kredit');
            $this->db_2->from('detail_jurnal as d');
            $this->db_2->join('anggota as a', 'CAST(a.id_anggota as VARCHAR) = CAST(d.pelaksana as VARCHAR)', 'inner');
            $this->db_2->join('posisi as p', 'p.id_posisi = a.id_posisi', 'inner');
            $this->db_2->join('bagian as b','b.id_bagian = p.id_bagian', 'inner');
            $this->db_2->join('des_coa as c', 'c.no_coa_des = d.coa', 'inner');
            $this->db_2->where('b.id_bagian', 4);
            $this->db_2->where("CAST(d.tgl_transaksi as VARCHAR) LIKE '%$bln%'");
            $this->db_2->where('d.id_group', 8);

            $t = $this->db_2->get()->row_array();
            
            // $nominal = $t['tot_debit'] - $t['tot_kredit'];
            $nominal = $t['tot_debit'];

            if ($nominal == 0) {
                unset($list[$key]);
            }
        }        

        foreach ($list as $value) {
            $tbody = array();

            $bln        = $value['bulan'];

            $this->db_2->select('sum(d.debit) as tot_debit, sum(d.kredit) as tot_kredit');
            $this->db_2->from('detail_jurnal as d');
            $this->db_2->join('anggota as a', 'CAST(a.id_anggota as VARCHAR) = CAST(d.pelaksana as VARCHAR)', 'inner');
            $this->db_2->join('posisi as p', 'p.id_posisi = a.id_posisi', 'inner');
            $this->db_2->join('bagian as b','b.id_bagian = p.id_bagian', 'inner');
            $this->db_2->join('des_coa as c', 'c.no_coa_des = d.coa', 'inner');
            $this->db_2->where('b.id_bagian', 4);
            $this->db_2->where("CAST(d.tgl_transaksi as VARCHAR) LIKE '%$bln%'");
            $this->db_2->where('d.id_group', 8);

            $t = $this->db_2->get()->row_array();
            
            // $nominal = $t['tot_debit'] - $t['tot_kredit'];
            $nominal = $t['tot_debit'];

            $tbody[] = nice_date($bln, 'F-Y');
            $tbody[] = "<div class='text-right'>".number_format($nominal)."</div>";
            $data1[]  = $tbody; 
        }        

        if ($list) {
            echo json_encode(array('data'=> $data1));
        }else{
            echo json_encode(array('data'=>0));
        }
    }

    // proses export data
    public function export_data_coa()
    {
        $jns             = $this->input->post('jns');
        $bulan_awal_as   = $this->input->post('bulan_awal');
        $bulan_akhir_as  = $this->input->post('bulan_akhir');

        $bulan_awal		= nice_date($bulan_awal_as, 'Y-m');
        $bulan_akhir 	= nice_date($bulan_akhir_as, 'Y-m');

        $from   = $bulan_awal."-01";
        $from   = date('Y-m-d', strtotime("-1 day", strtotime($from)));
        $to     = $bulan_akhir."-01";

        $ar = array();
        $i=1;
        while (strtotime($from)<strtotime($to)){
            $from = mktime(0,0,0,date('m',strtotime($from)),date("d",strtotime($from))+1,date("Y",strtotime($from)));
            $from=date("Y-m-d", $from);
            array_push($ar, nice_date($from, 'Y-m'));

            $i++;
        }

        $bulan = array_unique($ar);

        $data   = [ 'report'        => 'Laporan Biaya Per COA',
                    'list_coa'      => $this->M_laporan->get_data_detail_jurnal_coa_2($bulan_awal_as, $bulan_akhir_as)->result_array(),
                    'bln_awal'      => $bulan_awal_as,
                    'bln_akhir'     => $bulan_akhir_as,
                    'd_bulan_awal'  => $bulan_awal,
                    'd_bulan_akhir' => $bulan_akhir,
                    'bulan'         => $bulan,
                    'jns'           => $jns
                    ];    

        if ($jns == 'excel') {
            $temp = 'layout/template_excel';
            $this->template->load("$temp", 'laporan/biaya_p_coa/V_export_coa', $data);
        } elseif ($jns == 'pdf') {
            $temp = 'layout/template_pdf';
            $this->template->load("$temp", 'laporan/biaya_p_coa/V_export_coa', $data);
        } else {
            $this->load->view('laporan/biaya_p_coa/V_export_coa', $data);  
        }
        
    }

    public function tes_bulan()
    {
        $bulan_awal = '2011-09';
        $from= $bulan_awal."-01";
        $from = date('Y-m-d', strtotime("-1 day", strtotime($from)));
        $to ='2012-03-07';

        $ar = array();
        $i=1;
        while (strtotime($from)<strtotime($to)){
        $from = mktime(0,0,0,date('m',strtotime($from)),date("d",strtotime($from))+1,date("Y",strtotime($from)));
        $from=date("Y-m-d", $from);
        array_push($ar, nice_date($from, 'Y-m'));

        $i++;
        }

        print_r(array_unique($ar));
    }

    /***********************************************************************/
    /*
    /*                          BIAYA PER PIC
    /*
    /***********************************************************************/

    public function biaya_per_pic()
    {
        $data = ['judul'    => 'Biaya Per PIC'];

        $this->template->load('layout/template', 'laporan/biaya_p_pic/V_biaya_p_pic', $data);
    }

    public function tampil_resume_pic()
    {
        $a = $this->input->post('bulan_awal');
        $k = $this->input->post('bulan_akhir');

        $hasil = $this->M_laporan->get_data_detail_jurnal($a, $k);

        if ($hasil->num_rows() != 0) {

            foreach ($hasil->result_array() as $a) {
                $data1[] = ['bulan'  => nice_date($a['tgl_transaksi'], 'Y-m')
                            ];
            }
            $list = array_map(
                'unserialize',
                array_unique(
                    array_map(
                        'serialize',
                        $data1
                    )
                )
            );

        } else {

            $list = [];
            
        }

        $no = 1;
        $nominal = 0;

        foreach ($list as $key => $value) {
            $tbody = array();

            $bln    = $value['bulan'];

            // cari nominal 
            $this->db_2->select('sum(d.debit) as tot_debit, sum(d.kredit) as tot_kredit');
            $this->db_2->from('detail_jurnal as d');
            $this->db_2->join('anggota as a', 'CAST(a.id_anggota as VARCHAR) = CAST(d.pelaksana as VARCHAR)', 'inner');
            $this->db_2->join('posisi as p', 'p.id_posisi = a.id_posisi', 'inner');
            $this->db_2->join('bagian as b','b.id_bagian = p.id_bagian', 'inner');
            $this->db_2->where('b.id_bagian', 4);
            $this->db_2->where("CAST(d.tgl_transaksi as VARCHAR) LIKE '%$bln%'");
            $this->db_2->where('d.id_group', 8);

            $t = $this->db_2->get()->row_array();
            
            // $nominal = $t['tot_debit'] - $t['tot_kredit'];
            $nominal = $t['tot_debit'];

            if ($nominal == 0) {
                unset($list[$key]);
            }
        }

        foreach ($list as $value) {
            $tbody = array();

            $bln    = $value['bulan'];

            // cari nominal 
            $this->db_2->select('sum(d.debit) as tot_debit, sum(d.kredit) as tot_kredit');
            $this->db_2->from('detail_jurnal as d');
            $this->db_2->join('anggota as a', 'CAST(a.id_anggota as VARCHAR) = CAST(d.pelaksana as VARCHAR)', 'inner');
            $this->db_2->join('posisi as p', 'p.id_posisi = a.id_posisi', 'inner');
            $this->db_2->join('bagian as b','b.id_bagian = p.id_bagian', 'inner');
            $this->db_2->where('b.id_bagian', 4);
            $this->db_2->where("CAST(d.tgl_transaksi as VARCHAR) LIKE '%$bln%'");
            $this->db_2->where('d.id_group', 8);

            $t = $this->db_2->get()->row_array();
            
            // $nominal = $t['tot_debit'] - $t['tot_kredit'];
            $nominal = $t['tot_debit'];

            $tbody[] = "<div class='text-center'>".nice_date($value['bulan'], 'F-Y')."</div>";
            $tbody[] = "<div class='text-right'>".number_format($nominal)."</div>";
            $data[]  = $tbody; 
        }

        if ($list) {
            echo json_encode(array('data'=> $data));
        }else{
            echo json_encode(array('data'=>0));
        }

    }

    public function tampil_biaya_p_pic()
    {
        $a = $this->input->post('bulan_awal');
        $k = $this->input->post('bulan_akhir');

        $hasil = $this->M_laporan->get_data_detail_jurnal($a, $k);

        if ($hasil->num_rows() != 0) {

            foreach ($hasil->result_array() as $a) {
                $data1[] = ['pic'    => $a['pengguna'],
                            'bulan'  => nice_date($a['tgl_transaksi'], 'Y-m'),
                            'id_pic' => $a['pelaksana']
                        ];
            }
            $list = array_map(
                'unserialize',
                array_unique(
                    array_map(
                        'serialize',
                        $data1
                    )
                )
            );

        } else {

            $list = [];
            
        }

        $no = 1;
        $nominal = 0;

        foreach ($list as $key => $value) {
            $bln    = $value['bulan'];
            $id_pic = $value['id_pic'];

            // cari nominal 
            $this->db_2->select('sum(d.debit) as tot_debit, sum(d.kredit) as tot_kredit');
            $this->db_2->from('detail_jurnal as d');
            $this->db_2->join('anggota as a', 'CAST(a.id_anggota as VARCHAR) = CAST(d.pelaksana as VARCHAR)', 'inner');
            $this->db_2->join('posisi as p', 'p.id_posisi = a.id_posisi', 'inner');
            $this->db_2->join('bagian as b','b.id_bagian = p.id_bagian', 'inner');
            $this->db_2->join('des_coa as c', 'c.no_coa_des = d.coa', 'inner');
            $this->db_2->where('b.id_bagian', 4);
            $this->db_2->where("CAST(d.tgl_transaksi as VARCHAR) LIKE '%$bln%'");
            $this->db_2->where('d.pelaksana', $id_pic);
            $this->db_2->where('d.id_group', 8);

            $t = $this->db_2->get()->row_array();
            
            // $nominal = $t['tot_debit'] - $t['tot_kredit'];
            $nominal = $t['tot_debit'];

            if ($nominal == 0) {
                unset($list[$key]);
            }
        }

        foreach ($list as $value) {
            $tbody = array();

            $bln    = $value['bulan'];
            $id_pic = $value['id_pic'];

            // cari nominal 
            $this->db_2->select('sum(d.debit) as tot_debit, sum(d.kredit) as tot_kredit');
            $this->db_2->from('detail_jurnal as d');
            $this->db_2->join('anggota as a', 'CAST(a.id_anggota as VARCHAR) = CAST(d.pelaksana as VARCHAR)', 'inner');
            $this->db_2->join('posisi as p', 'p.id_posisi = a.id_posisi', 'inner');
            $this->db_2->join('bagian as b','b.id_bagian = p.id_bagian', 'inner');
            $this->db_2->join('des_coa as c', 'c.no_coa_des = d.coa', 'inner');
            $this->db_2->where('b.id_bagian', 4);
            $this->db_2->where("CAST(d.tgl_transaksi as VARCHAR) LIKE '%$bln%'");
            $this->db_2->where('d.pelaksana', $id_pic);
            $this->db_2->where('d.id_group', 8);
            

            $t = $this->db_2->get()->row_array();
            
            // $nominal = $t['tot_debit'] - $t['tot_kredit'];
            $nominal = $t['tot_debit'];

            $tbody[] = "<div align='center'>".$no++."</div>";
            $tbody[] = nice_date($value['bulan'], 'F-Y');
            $tbody[] = ucwords($value['pic']);
            $tbody[] = number_format($nominal);
            $data[]  = $tbody; 
        }

        if ($list) {
            echo json_encode(array('data'=> $data));
        }else{
            echo json_encode(array('data'=>0));
        }
    }

    // proses export data
    public function export_data_pic()
    {
        $jns             = $this->input->post('jns');
        $bulan_awal_as   = $this->input->post('bulan_awal');
        $bulan_akhir_as  = $this->input->post('bulan_akhir');

        $bulan_awal		= nice_date($bulan_awal_as, 'Y-m');
        $bulan_akhir 	= nice_date($bulan_akhir_as, 'Y-m');

        $from   = $bulan_awal."-01";
        $from   = date('Y-m-d', strtotime("-1 day", strtotime($from)));
        $to     = $bulan_akhir."-01";

        $ar = array();
        $i=1;
        while (strtotime($from)<strtotime($to)){
            $from = mktime(0,0,0,date('m',strtotime($from)),date("d",strtotime($from))+1,date("Y",strtotime($from)));
            $from=date("Y-m-d", $from);
            array_push($ar, nice_date($from, 'Y-m'));

            $i++;
        }

        $bulan = array_unique($ar);

        $data   = [ 'report'        => 'Laporan Biaya Per PIC',
                    'list_pic'      => $this->M_laporan->get_data_detail_jurnal_pic($bulan_awal_as, $bulan_akhir_as)->result_array(),
                    'bln_awal'      => $bulan_awal_as,
                    'bln_akhir'     => $bulan_akhir_as,
                    'd_bulan_awal'  => $bulan_awal,
                    'd_bulan_akhir' => $bulan_akhir,
                    'bulan'         => $bulan,
                    'jns'           => $jns
                    ];    

        if ($jns == 'excel') {
            $temp = 'layout/template_excel';
            $this->template->load("$temp", 'laporan/biaya_p_pic/V_export_pic', $data);
        } elseif ($jns == 'pdf') {
            $temp = 'layout/template_pdf';
            $this->template->load("$temp", 'laporan/biaya_p_pic/V_export_pic', $data);
        } else {
            $this->load->view('laporan/biaya_p_pic/V_export_pic', $data);  
        }
        
    }

    public function teslagi()
    {
        $this->db_2->select('d.tgl_transaksi, c.deskripsi_coa, c.no_coa_des');
        $this->db_2->from('detail_jurnal as d');
        $this->db_2->join('karyawan as k', 'CAST(k.id_karyawan as VARCHAR) = d.pelaksana', 'inner');
        $this->db_2->join('anggota as a', 'a.id_anggota = k.id_anggota', 'inner');
        $this->db_2->join('posisi as p', 'p.id_posisi = a.id_posisi', 'inner');
        $this->db_2->join('bagian as b','b.id_bagian = p.id_bagian', 'inner');
        $this->db_2->join('des_coa as c', 'c.no_coa_des = d.coa', 'inner');
        $this->db_2->where('b.id_bagian', 4);

        $hasil = $this->db_2->get();

        $b = array();
        foreach ($hasil->result_array() as $a) {
            $data[] = [ 'no_coa'    => $a['no_coa_des'],
                        'bulan'     => nice_date($a['tgl_transaksi'], 'Y-m')
                    ];
        }
        $list = array_map(
            'unserialize',
            array_unique(
                array_map(
                    'serialize',
                    $data
                )
            )
        );

        echo "<pre>";
        print_r($list);
        echo "</pre>";
    }

}

/* End of file Laporan.php */
