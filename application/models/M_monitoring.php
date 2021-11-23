<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_monitoring extends CI_Model {

    public function input_data($tabel, $data)
    {
        $this->db->insert($tabel, $data);
        
    }

    public function ubah_data($tabel, $data, $where)
    {
        $this->db->where($where);
        $this->db->update($tabel, $data);
        
    }

    public function get_data($tabel)
    {
        return $this->db->get($tabel);
    }

    public function hapus_data($tabel, $where)
    {
        $this->db->delete($tabel, $where);
    }

    public function cari_data($tabel, $where)
    {
        return $this->db->get_where($tabel, $where);
    }

    public function simpan_upload($judul, $dok)
	{
		$data = [
		    'judul'     => $judul,
		    'dokumen'   => $dok 
		];

		$hasil = $this->db->insert('tr_laporan', $data);

		return $hasil;
	}

    public function cari_cabang_asuransi_per($id_periode)
    {
        $this->db->SELECT("b.cabang_asuransi, d.singkatan AS sb, b.singkatan as singkatan_as, a.id_cabang_as");
        $this->db->FROM("periode a");
        $this->db->JOIN("m_cabang_asuransi b","a.id_cabang_as = b.id_cabang_asuransi","inner");
        $this->db->JOIN("m_cabang_bank c","a.id_cabang_bank = c.id_cabang_bank","inner");
        $this->db->JOIN("m_bank d","d.id_bank = c.id_bank","inner");
        $this->db->WHERE("a.id_periode",$id_periode);

        return $this->db->get();
        
    }

    public function cari_singkatan_cas($singkatan_cas)
    {
        $this->db->select('no_bar, add_time');
        $this->db->from('bar');
        $this->db->where("no_bar LIKE '%$singkatan_cas%'");
        $this->db->order_by('id_bar', 'desc');
        $this->db->limit(1);
        
        return $this->db->get();
    }

    // menampilkan data untuk cetak bar
    public function get_data_cetak($id_rekon)
    {
        $this->db->select('c.cabang_asuransi,d.cabang_bank,e.bank, br.no_bar, b.tgl_bayar_awal, b.tgl_bayar_akhir');
        $this->db->from('rekonsiliasi a');
        $this->db->join("periode b","b.id_periode = a.id_periode","inner");
        $this->db->join("m_cabang_asuransi c","c.id_cabang_asuransi = b.id_cabang_as","inner");
        $this->db->join("m_cabang_bank d","d.id_cabang_bank = b.id_cabang_bank","inner");
        $this->db->join("m_bank e","e.id_bank = d.id_bank","inner");
        $this->db->join('bar as br', 'br.id_bar = a.id_bar', 'inner');
        
        $this->db->where("a.id_rekon",$id_rekon);

        return $this->db->get();
    }

    // menampilkan data semua untuk cetak bar
    public function get_data_all_cetak2($id_rekon)
	{
		$hasil_akhir = array();

        $query = "SELECT d.capem_bank,d.id_capem_bank,c.id_cabang_bank,e.id_cabang_asuransi,b.tgl_bayar_awal,b.tgl_bayar_akhir from rekonsiliasi a 
        INNER JOIN periode b ON (b.id_periode = a.id_periode) INNER JOIN m_cabang_bank c ON (b.id_cabang_bank = c.id_cabang_bank) 
        INNER JOIN m_capem_bank d ON (d.id_cabang_bank = c.id_cabang_bank) INNER JOIN m_cabang_asuransi e ON (e.id_cabang_asuransi=b.id_cabang_as) WHERE a.id_rekon = $id_rekon ORDER BY d.capem_bank ASC";
		$hasil = $this->db->query($query)->result_array();

		foreach($hasil as $row)
		{
			$noa = 0;
			$tot_subrogasi = 0;
			$tot_recoveries = 0;
			$shs = 0;
			$crp = 0;
			$asuransi = $row['id_cabang_asuransi'];
			$capem_bank = $row['capem_bank'];
            $id_capem_bank = $row['id_capem_bank'];
            $tgl_bayar_awal = $row['tgl_bayar_awal'];
            $tgl_bayar_akhir = $row['tgl_bayar_akhir'];
            $this->db->SELECT("a.id_debitur as idDK,a.subrogasi_as");
            $this->db->FROM("debitur a");
            $this->db->JOIN("m_cabang_asuransi b","b.id_cabang_asuransi = a.id_cabang_as","INNER");
            $this->db->WHERE("b.id_cabang_asuransi",$asuransi);
            $this->db->WHERE("a.id_capem_bank",$id_capem_bank);
			$hasil2 = $this->db->get()->result_array();

			foreach ($hasil2 as $row2)
			{
				$noa++;
				$id_data_klaim = $row2['idDK'];
                $subrogasi = $row2['subrogasi_as'];
                $recoveries = 0;
				if($recoveries == null)
					$recoveries = 0;

					$this->db->SELECT("SUM(nominal) AS hitung");
					$this->db->FROM("tr_recov_as");
					$this->db->WHERE("id_debitur = $id_data_klaim AND tgl_bayar < '$tgl_bayar_awal'");
					$recoveries3 = $this->db->get()->row_array();
					if($recoveries3 == null)
						$recoveries3 = 0;
	
					$tot_subrogasi += $subrogasi - ($recoveries + $recoveries3['hitung']);

				$this->db->SELECT("SUM(nominal) AS hitung");
				$this->db->FROM("tr_recov_as");
				$this->db->WHERE("id_debitur= $id_data_klaim AND tgl_bayar BETWEEN '$tgl_bayar_awal' AND
				'$tgl_bayar_akhir'");
				$recoveries2 = $this->db->get()->row_array();
				if($recoveries2 == null)
					$recoveries2 = 0;

				$tot_recoveries += $recoveries2['hitung'];
			}

			$shs = $tot_subrogasi - $tot_recoveries;

			if($shs == 0)
				$crp = 0;
			else
				$crp = $tot_recoveries / $tot_subrogasi;

			$hasil_akhir[] = array(
				'capem_bank'    => $capem_bank,
				'subrogasi'     => $tot_subrogasi,
				'recoveries'    => $tot_recoveries,
				'shs'           => $shs,
				'noa'           => $noa,
				'crp'           => $crp
			);
		}
		
		return $hasil_akhir;
    }


    public function get_data_all_cetak($id_rekon)
    {
        // SELECT
        //     c.cabang_asuransi,
        //     d.cabang_bank,
        //     e.bank,
        //     br.no_bar,
        //     b.tgl_bayar_awal,
        //     b.tgl_bayar_akhir,
        //     (
        //     SELECT COUNT
        //         (DISTINCT de.id_debitur ) AS jumlah_debitur 
        //     FROM
        //         debitur AS de
        //         JOIN m_capem_bank AS mc ON mc.id_capem_bank = de.id_capem_bank
        //         INNER JOIN m_cabang_bank cp ON cp.id_cabang_bank = mc.id_cabang_bank
        //         INNER JOIN tr_recov_as AS tra ON tra.id_debitur = de.id_debitur 
        //     WHERE
        //         de.id_cabang_as = c.id_cabang_asuransi 
        //         AND cp.id_cabang_bank = d.id_cabang_bank 
        //         AND tra.tgl_bayar BETWEEN b.tgl_bayar_awal 
        //         AND b.tgl_bayar_akhir 
        //     ),
        //     (SELECT sum(DISTINCT de.subrogasi_as) as tot_subrogasi
            
        //     FROM
        //         debitur AS de
        //         JOIN m_capem_bank AS mc ON mc.id_capem_bank = de.id_capem_bank
        //         INNER JOIN m_cabang_bank cp ON cp.id_cabang_bank = mc.id_cabang_bank
        //         INNER JOIN tr_recov_as AS tra ON tra.id_debitur = de.id_debitur 
        //     WHERE
        //         de.id_cabang_as = c.id_cabang_asuransi 
        //         AND cp.id_cabang_bank = d.id_cabang_bank 
        //         AND tra.tgl_bayar BETWEEN b.tgl_bayar_awal 
        //         AND b.tgl_bayar_akhir 
            
        //     ),
        //     COALESCE((SELECT sum(DISTINCT de.recoveries_awal_asuransi) as tot_recov_as_awal FROM debitur AS de JOIN m_capem_bank AS mc ON mc.id_capem_bank = de.id_capem_bank INNER JOIN m_cabang_bank cp ON cp.id_cabang_bank = mc.id_cabang_bank INNER JOIN tr_recov_as AS tra ON tra.id_debitur = de.id_debitur  WHERE de.id_cabang_as = c.id_cabang_asuransi  AND cp.id_cabang_bank = d.id_cabang_bank  AND tra.tgl_bayar BETWEEN b.tgl_bayar_awal AND b.tgl_bayar_akhir ), 0) + COALESCE((SELECT sum(tra.nominal ) AS tot_recov FROM debitur AS de JOIN m_capem_bank AS mc ON mc.id_capem_bank = de.id_capem_bank INNER JOIN m_cabang_bank cp ON cp.id_cabang_bank = mc.id_cabang_bank INNER JOIN tr_recov_as AS tra ON tra.id_debitur = de.id_debitur WHERE de.id_cabang_as = c.id_cabang_asuransi  AND cp.id_cabang_bank = d.id_cabang_bank  AND tra.tgl_bayar BETWEEN b.tgl_bayar_awal  AND b.tgl_bayar_akhir ), 0) AS tot_recoveries_as,

        // (COALESCE((SELECT sum(DISTINCT de.subrogasi_as) as tot_subrogasi
            
        //     FROM
        //         debitur AS de
        //         JOIN m_capem_bank AS mc ON mc.id_capem_bank = de.id_capem_bank
        //         INNER JOIN m_cabang_bank cp ON cp.id_cabang_bank = mc.id_cabang_bank
        //         INNER JOIN tr_recov_as AS tra ON tra.id_debitur = de.id_debitur 
        //     WHERE
        //         de.id_cabang_as = c.id_cabang_asuransi 
        //         AND cp.id_cabang_bank = d.id_cabang_bank 
        //         AND tra.tgl_bayar BETWEEN b.tgl_bayar_awal 
        //         AND b.tgl_bayar_akhir 
            
        //     ), 0) - COALESCE((SELECT sum(DISTINCT de.recoveries_awal_asuransi) as tot_recov_as_awal FROM debitur AS de JOIN m_capem_bank AS mc ON mc.id_capem_bank = de.id_capem_bank INNER JOIN m_cabang_bank cp ON cp.id_cabang_bank = mc.id_cabang_bank INNER JOIN tr_recov_as AS tra ON tra.id_debitur = de.id_debitur  WHERE de.id_cabang_as = c.id_cabang_asuransi  AND cp.id_cabang_bank = d.id_cabang_bank  AND tra.tgl_bayar BETWEEN b.tgl_bayar_awal AND b.tgl_bayar_akhir ), 0) ) - COALESCE((SELECT sum(tra.nominal ) AS tot_recov FROM debitur AS de JOIN m_capem_bank AS mc ON mc.id_capem_bank = de.id_capem_bank INNER JOIN m_cabang_bank cp ON cp.id_cabang_bank = mc.id_cabang_bank INNER JOIN tr_recov_as AS tra ON tra.id_debitur = de.id_debitur WHERE de.id_cabang_as = c.id_cabang_asuransi  AND cp.id_cabang_bank = d.id_cabang_bank  AND tra.tgl_bayar BETWEEN b.tgl_bayar_awal  AND b.tgl_bayar_akhir ), 0) as shs,
        //     (COALESCE((SELECT sum(DISTINCT de.recoveries_awal_asuransi) as tot_recov_as_awal FROM debitur AS de JOIN m_capem_bank AS mc ON mc.id_capem_bank = de.id_capem_bank INNER JOIN m_cabang_bank cp ON cp.id_cabang_bank = mc.id_cabang_bank INNER JOIN tr_recov_as AS tra ON tra.id_debitur = de.id_debitur  WHERE de.id_cabang_as = c.id_cabang_asuransi  AND cp.id_cabang_bank = d.id_cabang_bank  AND tra.tgl_bayar BETWEEN b.tgl_bayar_awal AND b.tgl_bayar_akhir ), 0) + COALESCE((SELECT sum(tra.nominal ) AS tot_recov FROM debitur AS de JOIN m_capem_bank AS mc ON mc.id_capem_bank = de.id_capem_bank INNER JOIN m_cabang_bank cp ON cp.id_cabang_bank = mc.id_cabang_bank INNER JOIN tr_recov_as AS tra ON tra.id_debitur = de.id_debitur WHERE de.id_cabang_as = c.id_cabang_asuransi  AND cp.id_cabang_bank = d.id_cabang_bank  AND tra.tgl_bayar BETWEEN b.tgl_bayar_awal  AND b.tgl_bayar_akhir ), 0)) / COALESCE ( (SELECT sum(DISTINCT de.subrogasi_as) as tot_subrogasi
            
        //     FROM
        //         debitur AS de
        //         JOIN m_capem_bank AS mc ON mc.id_capem_bank = de.id_capem_bank
        //         INNER JOIN m_cabang_bank cp ON cp.id_cabang_bank = mc.id_cabang_bank
        //         INNER JOIN tr_recov_as AS tra ON tra.id_debitur = de.id_debitur 
        //     WHERE
        //         de.id_cabang_as = c.id_cabang_asuransi 
        //         AND cp.id_cabang_bank = d.id_cabang_bank 
        //         AND tra.tgl_bayar BETWEEN b.tgl_bayar_awal 
        //         AND b.tgl_bayar_akhir 
            
        //     ), 0) as crp
            
        // FROM
        //     rekonsiliasi as a
        //     JOIN periode b ON b.id_periode = a.id_periode
        //     JOIN m_cabang_asuransi c ON c.id_cabang_asuransi = b.id_cabang_as
        //     JOIN m_cabang_bank d ON d.id_cabang_bank = b.id_cabang_bank
        //     JOIN m_bank e ON e.id_bank = d.id_bank
        //     JOIN bar AS br ON br.id_bar = a.id_bar 
        // WHERE
        //     a.id_rekon = 321

        $this->db->select('c.cabang_asuransi, d.cabang_bank, cep.capem_bank, e.bank, br.no_bar, b.tgl_bayar_awal, b.tgl_bayar_akhir, (SELECT COUNT (de.id_debitur ) AS jumlah_debitur FROM debitur AS de JOIN m_capem_bank AS mc ON mc.id_capem_bank = de.id_capem_bank WHERE mc.id_capem_bank = cep.id_capem_bank), (SELECT sum(tra.nominal ) AS tot_nominal_kurang FROM debitur AS de JOIN m_capem_bank AS mc ON mc.id_capem_bank = de.id_capem_bank INNER JOIN m_cabang_bank cp ON cp.id_cabang_bank = mc.id_cabang_bank INNER JOIN tr_recov_as AS tra ON tra.id_debitur = de.id_debitur WHERE de.id_cabang_as = c.id_cabang_asuransi  AND mc.id_capem_bank = cep.id_capem_bank AND tra.tgl_bayar < b.tgl_bayar_awal), (SELECT sum(de.subrogasi_as) as tot_subrogasi FROM debitur AS de JOIN m_capem_bank AS mc ON mc.id_capem_bank = de.id_capem_bank WHERE mc.id_capem_bank = cep.id_capem_bank), (SELECT sum(tra.nominal ) AS tot_recov_as FROM debitur AS de JOIN m_capem_bank AS mc ON mc.id_capem_bank = de.id_capem_bank INNER JOIN m_cabang_bank cp ON cp.id_cabang_bank = mc.id_cabang_bank INNER JOIN tr_recov_as AS tra ON tra.id_debitur = de.id_debitur WHERE mc.id_capem_bank = cep.id_capem_bank and (tra.tgl_bayar BETWEEN b.tgl_bayar_awal and b.tgl_bayar_akhir)), (SELECT sum(de.recoveries_awal_asuransi) as tot_recov_as_awal FROM debitur AS de JOIN m_capem_bank AS mc ON mc.id_capem_bank = de.id_capem_bank WHERE mc.id_capem_bank = cep.id_capem_bank)');
        $this->db->from('rekonsiliasi as a');
        $this->db->join("periode b","b.id_periode = a.id_periode","inner");
        $this->db->join("m_cabang_asuransi c","c.id_cabang_asuransi = b.id_cabang_as","inner");
        $this->db->join("m_cabang_bank d","d.id_cabang_bank = b.id_cabang_bank","inner");
        $this->db->join("m_capem_bank cep", "cep.id_cabang_bank = d.id_cabang_bank", "inner");
        $this->db->join("m_bank e","e.id_bank = d.id_bank","inner");
        $this->db->join('bar as br', 'br.id_bar = a.id_bar', 'inner');
        
        $this->db->where("a.id_rekon",$id_rekon);

        return $this->db->get();
    }

    // menampilkan list debitur cetak excel 
    public function get_data_excel($id_periode)
    {
        // $this->db->select('de.nama_debitur,c.cabang_asuransi,d.cabang_bank,cp.capem_bank,e.bank,de.no_klaim,de.tgl_klaim,de.jenis_kredit,tr.nominal,tr.tgl_bayar,tr.no_rek');
        // $this->db->from('periode b');
        // $this->db->join('m_cabang_asuransi c', 'c.id_cabang_asuransi = b.id_cabang_as', 'inner');
        // $this->db->join('m_cabang_bank d', 'd.id_cabang_bank = b.id_cabang_bank', 'inner');
        // $this->db->join('m_capem_bank as cp', 'cp.id_cabang_bank = d.id_cabang_bank', 'inner');
        // $this->db->join('m_bank e', 'e.id_bank = d.id_bank', 'inner');
        // $this->db->join('debitur de', 'de.id_capem_bank = cp.id_capem_bank', 'inner');
        // $this->db->join('tr_recov_as as tr', 'tr.id_debitur = de.id_debitur', 'inner');
        
        // $this->db->where('b.id_periode', $id_periode);
        
        // return $this->db->get(); 

        $hasil_akhir = array();
		$ambil_cabang = "SELECT id_cabang_bank,tgl_bayar_awal,tgl_bayar_akhir,id_cabang_as FROM periode WHERE id_periode = $id_periode";
		$hasil = $this->db->query($ambil_cabang)->row_array();
		$awal       = $hasil['tgl_bayar_awal'];
		$akhir      = $hasil['tgl_bayar_akhir'];
		$asuransi   = $hasil['id_cabang_as'];
        $cabang     = $hasil['id_cabang_bank'];
        
		$ambil_capem = "SELECT DISTINCT b.id_debitur,d.capem_bank,e.cabang_bank,f.bank,c.cabang_asuransi,b.no_klaim,b.tgl_klaim,b.nama_debitur,b.jenis_kredit,a.no_rek,  a.nominal,a.tgl_bayar FROM tr_recov_as a 
						INNER JOIN debitur b ON (a.id_debitur = b.id_debitur) 
						INNER JOIN m_cabang_asuransi c ON(b.id_cabang_as = c.id_cabang_asuransi) 
						INNER JOIN m_capem_bank d ON (d.id_capem_bank = b.id_capem_bank) 
						INNER JOIN m_cabang_bank e ON (e.id_cabang_bank = d.id_cabang_bank) 
						INNER JOIN m_bank f ON (f.id_bank = e.id_bank) WHERE e.id_cabang_bank = '$cabang' AND c.id_cabang_asuransi = $asuransi
						AND a.tgl_bayar BETWEEN '$awal' AND '$akhir'
                        ORDER BY d.capem_bank ASC";
                        
        $hasil2 = $this->db->query($ambil_capem)->result_array();
        
		foreach ($hasil2 AS $row)
		{
			$capem_bank         = $row['capem_bank'];
			$id_debitur         = $row['id_debitur'];
			$cabang_bank        = $row['cabang_bank'];
			$cabang_asuransi    = $row['cabang_asuransi'];
			$tgl_klaim          = $row['tgl_klaim'];
			$debitur            = $row['nama_debitur'];
			$jenis_kredit       = $row['jenis_kredit'];
			$bank               = $row['bank'];
			$no_klaim           = $row['no_klaim'];
			$tot_recoveries     = $row['nominal'];
			$tgl_bayar          = $row['tgl_bayar'];
			$no_rek             = $row['no_rek'];
			
			$hasil_akhir[] = array(

				'capem_bank'        =>$capem_bank,
				'cabang_bank'       =>$cabang_bank,
				'bank'              =>$bank,
				'cabang_asuransi'   =>$cabang_asuransi,
				'no_klaim'          =>$no_klaim,
				'tgl_klaim'         =>$tgl_klaim,
				'nama_debitur'      =>$debitur,
				'jenis_kredit'      =>$jenis_kredit,
				'nominal'           =>$tot_recoveries,
				'tgl_bayar'         =>$tgl_bayar,
				'no_rek'            =>$no_rek
			);
		}
		return $hasil_akhir;
    }

    public function list_periode_bar($aksi)
    {
        $this->db->select('mp.id_periode, mp.nama_periode');
        $this->db->from('periode as p');
        $this->db->join('m_periode as mp', 'mp.id_periode = p.m_periode', 'inner');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = p.id_cabang_as', 'inner');
        $this->db->join('m_cabang_bank as cb', 'cb.id_cabang_bank = p.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cb.id_bank', 'inner');
        $this->db->join('rekonsiliasi as r', 'r.id_periode = p.id_periode', 'inner');
        $this->db->join('bar as br', 'br.id_bar = r.id_bar', 'left');

        if ($aksi == 'lihat') {
            $this->db->where('r.status !=', 0);
        } else {
            $this->db->where('r.status', 0);
        }

        $this->db->group_by('mp.id_periode');
        $this->db->group_by('mp.nama_periode');

        return $this->db->get();
        
    }

    public function get_periode_bar($id_periode, $aksi)
    {
        $this->_get_datatables_query_periode_bar($id_periode, $aksi);

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_periode_bar = [null, 'mp.nama_periode', 'ca.cabang_asuransi', 'b.bank', 'cb.cabang_bank', 'br.no_bar', '', "LOWER(CAST(to_char(br.add_time, 'DD-Mon-YYYY HH24:MI:SS') AS VARCHAR))", 'g.username'];
    var $kolom_cari_periode_bar  = ['LOWER(mp.nama_periode)', 'LOWER(ca.cabang_asuransi)', 'LOWER(b.bank)', 'LOWER(cb.cabang_bank)', 'LOWER(br.no_bar)', "LOWER(CAST(to_char(br.add_time, 'DD-Mon-YYYY HH24:MI:SS') AS VARCHAR))", 'g.username'];
    var $order_periode_bar       = ['r.id_rekon' => 'desc'];

    public function _get_datatables_query_periode_bar($id_periode, $aksi)
    {
        $this->db->select('r.id_rekon, p.id_periode, mp.nama_periode, br.no_bar, br.ttd_bar, ca.cabang_asuransi, cb.cabang_bank, b.bank, br.add_time, g.username');
        $this->db->from('periode as p');
        $this->db->join('m_periode as mp', 'mp.id_periode = p.m_periode', 'inner');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = p.id_cabang_as', 'inner');
        $this->db->join('m_cabang_bank as cb', 'cb.id_cabang_bank = p.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cb.id_bank', 'inner');
        $this->db->join('rekonsiliasi as r', 'r.id_periode = p.id_periode', 'inner');
        $this->db->join('bar as br', 'br.id_bar = r.id_bar', 'left');
        $this->db->join('pengguna as g', 'g.id_pengguna = br.created_by', 'left');

        if ($aksi == 'lihat') {
            $this->db->where('r.status !=', 0);
        } else {
            $this->db->where('r.status', 0);
        }
        
        
        if ($id_periode != 'a') {
            $this->db->where('p.m_periode', $id_periode);
        }
        
        $b = 0;

        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_periode_bar;

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

            $kolom_order = $this->kolom_order_periode_bar;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_periode_bar)) {
            
            $order = $this->order_periode_bar;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }

    }

    public function jumlah_semua_periode_bar($id_periode, $aksi)
    {
        $this->db->select('r.id_rekon, p.id_periode, mp.nama_periode, br.no_bar, br.ttd_bar, ca.cabang_asuransi, cb.cabang_bank, b.bank, br.add_time, g.username');
        $this->db->from('periode as p');
        $this->db->join('m_periode as mp', 'mp.id_periode = p.m_periode', 'inner');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = p.id_cabang_as', 'inner');
        $this->db->join('m_cabang_bank as cb', 'cb.id_cabang_bank = p.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cb.id_bank', 'inner');
        $this->db->join('rekonsiliasi as r', 'r.id_periode = p.id_periode', 'inner');
        $this->db->join('bar as br', 'br.id_bar = r.id_bar', 'left');
        $this->db->join('pengguna as g', 'g.id_pengguna = br.created_by', 'left');
        
        if ($aksi == 'lihat') {
            $this->db->where('r.status !=', 0);
        } else {
            $this->db->where('r.status', 0);
        }
        
        if ($id_periode != 'a') {
            $this->db->where('p.m_periode', $id_periode);
        }

        return $this->db->count_all_results();
    }

    public function jumlah_filter_periode_bar($id_periode, $aksi)
    {
        $this->_get_datatables_query_periode_bar($id_periode, $aksi);
        return $this->db->get()->num_rows();
        
    }

    public function list_periode_invoice()
    {
        $this->db->select('mp.nama_periode, mp.id_periode');
        $this->db->from('periode as p');
        $this->db->join('m_periode as mp', 'mp.id_periode = p.m_periode', 'inner');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = p.id_cabang_as', 'inner');
        $this->db->join('m_cabang_bank as cb', 'cb.id_cabang_bank = p.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cb.id_bank', 'inner');
        $this->db->join('rekonsiliasi as r', 'r.id_periode = p.id_periode', 'inner');
        $this->db->join('bar as br', 'br.id_bar = r.id_bar', 'inner');
        $this->db->join('invoice as in', 'in.id_invoice = r.id_invoice', 'inner');
        $this->db->where('r.status', 2);

        $this->db->group_by('mp.id_periode');
        $this->db->group_by('mp.nama_periode');

        return $this->db->get();
        
    }

    // invoice
    public function get_invoice($id_periode)
    {
        $this->_get_datatables_query_invoice($id_periode);

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_invoice = [null, 'mp.nama_periode', 'ca.cabang_asuransi', 'b.bank', 'cb.cabang_bank', 'br.no_bar', 'in.no_invoice', "LOWER(CAST(to_char(i.add_time, 'DD-Mon-YYYY HH24:MI:SS') AS VARCHAR))", 'g.username'];
    var $kolom_cari_invoice  = ['LOWER(mp.nama_periode)', 'LOWER(ca.cabang_asuransi)', 'LOWER(b.bank)', 'LOWER(cb.cabang_bank)', 'LOWER(br.no_bar)', 'LOWER(no_invoice)', "LOWER(CAST(to_char(i.add_time, 'DD-Mon-YYYY HH24:MI:SS') AS VARCHAR))", 'LOWER(g.username)'];
    var $order_invoice       = ['r.id_rekon' => 'desc'];

    public function _get_datatables_query_invoice($id_periode)
    {
        $this->db->select('p.id_periode, mp.nama_periode, br.no_bar, ca.cabang_asuransi, cb.cabang_bank, b.bank, i.no_invoice, i.id_invoice, r.id_rekon, br.id_bar, i.add_time, g.username');
        $this->db->from('periode as p');
        $this->db->join('m_periode as mp', 'mp.id_periode = p.m_periode', 'inner');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = p.id_cabang_as', 'inner');
        $this->db->join('m_cabang_bank as cb', 'cb.id_cabang_bank = p.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cb.id_bank', 'inner');
        $this->db->join('rekonsiliasi as r', 'r.id_periode = p.id_periode', 'inner');
        $this->db->join('bar as br', 'br.id_bar = r.id_bar', 'inner');
        $this->db->join('invoice as i', 'i.id_invoice = r.id_invoice', 'inner');
        $this->db->join('pengguna as g', 'g.id_pengguna = i.created_by', 'left');
        $this->db->where('r.status', 2);
        
        if ($id_periode != 'a') {
            $this->db->where('p.m_periode', $id_periode);
        }

        $b = 0;

        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_invoice;

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

            $kolom_order = $this->kolom_order_invoice;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_invoice)) {
            
            $order = $this->order_invoice;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }

    }

    public function jumlah_semua_invoice($id_periode)
    {
        $this->db->select('p.id_periode, mp.nama_periode, br.no_bar, ca.cabang_asuransi, cb.cabang_bank, b.bank, i.no_invoice, i.id_invoice, r.id_rekon, br.id_bar, i.add_time, g.username');
        $this->db->from('periode as p');
        $this->db->join('m_periode as mp', 'mp.id_periode = p.m_periode', 'inner');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = p.id_cabang_as', 'inner');
        $this->db->join('m_cabang_bank as cb', 'cb.id_cabang_bank = p.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cb.id_bank', 'inner');
        $this->db->join('rekonsiliasi as r', 'r.id_periode = p.id_periode', 'inner');
        $this->db->join('bar as br', 'br.id_bar = r.id_bar', 'inner');
        $this->db->join('invoice as i', 'i.id_invoice = r.id_invoice', 'inner');
        $this->db->join('pengguna as g', 'g.id_pengguna = i.created_by', 'left');
        $this->db->where('r.status', 2);
        
        if ($id_periode != 'a') {
            $this->db->where('p.m_periode', $id_periode);
        }

        return $this->db->count_all_results();
    }

    public function jumlah_filter_invoice($id_periode)
    {
        $this->_get_datatables_query_invoice($id_periode);
        return $this->db->get()->num_rows();
    }

    public function get_data_cabang_as()
    {
        $this->db->select('ca.id_cabang_asuransi, ca.cabang_asuransi, ca.singkatan');
        $this->db->from('periode as p');
        $this->db->join('m_periode as mp', 'mp.id_periode = p.m_periode', 'inner');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = p.id_cabang_as', 'inner');
        $this->db->join('m_cabang_bank as cb', 'cb.id_cabang_bank = p.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cb.id_bank', 'inner');
        $this->db->join('rekonsiliasi as r', 'r.id_periode = p.id_periode', 'inner');
        $this->db->join('bar as br', 'br.id_bar = r.id_bar', 'inner');
        $this->db->where('r.status', 1);

        $this->db->group_by('ca.cabang_asuransi');
        $this->db->group_by('ca.id_cabang_asuransi');
        $this->db->group_by('ca.singkatan');
        

        return $this->db->get();
        
    }

    public function get_invoice_tambah($id_cabang_as)
    {
        $this->_get_datatables_query_invoice_tambah($id_cabang_as);

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_invoice_tambah = [null, 'br.no_bar'];
    var $kolom_cari_invoice_tambah  = ['LOWER(br.no_bar)'];
    var $order_invoice_tambah       = ['r.id_rekon' => 'desc'];

    public function _get_datatables_query_invoice_tambah($id_cabang_as)
    {
        $this->db->select('br.no_bar, r.id_rekon');
        $this->db->from('periode as p');
        $this->db->join('m_periode as mp', 'mp.id_periode = p.m_periode', 'inner');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = p.id_cabang_as', 'inner');
        $this->db->join('m_cabang_bank as cb', 'cb.id_cabang_bank = p.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cb.id_bank', 'inner');
        $this->db->join('rekonsiliasi as r', 'r.id_periode = p.id_periode', 'inner');
        $this->db->join('bar as br', 'br.id_bar = r.id_bar', 'inner');
        $this->db->where('r.status', 1);
        
        if ($id_cabang_as != 'a') {
            $this->db->where('ca.id_cabang_asuransi', $id_cabang_as);
        }

        $b = 0;

        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_invoice_tambah;

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

            $kolom_order = $this->kolom_order_invoice_tambah;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_invoice_tambah)) {
            
            $order = $this->order_invoice_tambah;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
    }

    public function jumlah_semua_invoice_tambah($id_cabang_as)
    {
        $this->db->select('br.no_bar, r.id_rekon');
        $this->db->from('periode as p');
        $this->db->join('m_periode as mp', 'mp.id_periode = p.m_periode', 'inner');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = p.id_cabang_as', 'inner');
        $this->db->join('m_cabang_bank as cb', 'cb.id_cabang_bank = p.id_cabang_bank', 'inner');
        $this->db->join('m_bank as b', 'b.id_bank = cb.id_bank', 'inner');
        $this->db->join('rekonsiliasi as r', 'r.id_periode = p.id_periode', 'inner');
        $this->db->join('bar as br', 'br.id_bar = r.id_bar', 'inner');
        $this->db->where('r.status', 1);
        
        if ($id_cabang_as != 'a') {
            $this->db->where('ca.id_cabang_asuransi', $id_cabang_as);
        }

        return $this->db->count_all_results();
    }

    public function jumlah_filter_invoice_tambah($id_cabang_as)
    {
        $this->_get_datatables_query_invoice_tambah($id_cabang_as);
        return $this->db->get()->num_rows();
        
    }

    public function get_invoice_2()
    {
        $this->db->order_by('id_invoice', 'desc');
        
        return $this->db->get('invoice');
        
    }

    public function cari_dari_singkatan($singkatan)
    {
        $this->db->select('no_invoice');
        $this->db->from('invoice');
        $this->db->where("no_invoice LIKE '%$singkatan%'");
        $this->db->order_by('add_time', 'desc');
        $this->db->limit(1);
        
        return $this->db->get();
    }

    // mengambil no invoice
    public function get_no_invoice($id_rekon)
    {
        $this->db->select("b.no_invoice, c.cabang_asuransi");
        $this->db->from("rekonsiliasi a");
        $this->db->join("invoice b","a.id_invoice = b.id_invoice", 'inner');
        $this->db->join("periode p","p.id_periode = a.id_periode","inner");
        $this->db->join("m_cabang_asuransi c","c.id_cabang_asuransi = p.id_cabang_as","inner");
        $this->db->where("a.id_rekon",$id_rekon);

        return $this->db->get();
    }

    // mencari data list data recov cabang bank 
    public function list_data_recov($id_invoice)
    {
        $this->db->select('c.cabang_bank, (SELECT count(de.id_debitur) as tot_deb from debitur as de JOIN m_capem_bank as mc ON mc.id_capem_bank = de.id_capem_bank INNER JOIN m_cabang_bank cp ON cp.id_cabang_bank = mc.id_cabang_bank INNER JOIN tr_recov_as as tra ON tra.id_debitur = de.id_debitur where id_cabang_as = b.id_cabang_as and cp.id_cabang_bank = c.id_cabang_bank and tra.tgl_bayar BETWEEN b.tgl_bayar_awal AND b.tgl_bayar_akhir), (SELECT sum(tra.nominal) as recoveries from debitur as de JOIN m_capem_bank as mc ON mc.id_capem_bank = de.id_capem_bank INNER JOIN m_cabang_bank cp ON cp.id_cabang_bank = mc.id_cabang_bank INNER JOIN tr_recov_as as tra ON tra.id_debitur = de.id_debitur where id_cabang_as = b.id_cabang_as and cp.id_cabang_bank = c.id_cabang_bank and tra.tgl_bayar BETWEEN b.tgl_bayar_awal AND b.tgl_bayar_akhir), (SELECT sum(de.recoveries_awal_asuransi) as tot_recov_awal from debitur as de JOIN m_capem_bank as mc ON mc.id_capem_bank = de.id_capem_bank INNER JOIN m_cabang_bank cp ON cp.id_cabang_bank = mc.id_cabang_bank INNER JOIN tr_recov_as as tra ON tra.id_debitur = de.id_debitur where id_cabang_as = b.id_cabang_as and cp.id_cabang_bank = c.id_cabang_bank and tra.tgl_bayar BETWEEN b.tgl_bayar_awal AND b.tgl_bayar_akhir), b.tgl_bayar_awal as tgl_awal, b.tgl_bayar_akhir as tgl_akhir');
        $this->db->from('rekonsiliasi as a');
        $this->db->join('periode b', 'b.id_periode = a.id_periode', 'inner');
        $this->db->join('m_cabang_bank c', 'b.id_cabang_bank = c.id_cabang_bank', 'inner');
        $this->db->where('a.id_invoice', $id_invoice);
        $this->db->order_by('c.cabang_bank', 'asc');
        
        return $this->db->get();
        
    }

    public function list_data_recov2($id_invoice)
    {
        $hasil_akhir = array();
        
        $query = "SELECT c.cabang_bank, b.id_cabang_as, b.tgl_bayar_awal, b.tgl_bayar_akhir FROM rekonsiliasi a 
            INNER JOIN periode b ON (b.id_periode = a.id_periode) INNER JOIN m_cabang_asuransi e ON (e.id_cabang_asuransi = b.id_cabang_as) 
            INNER JOIN m_cabang_bank c ON (b.id_cabang_bank = c.id_cabang_bank) WHERE a.id_invoice = $id_invoice ORDER BY c.cabang_bank ASC";

        $hasil = $this->db->query($query)->result_array();

        foreach ($hasil as $row) {
            $noa = 0;
            $tot_subrogasi = 0;
            $tot_recoveries = 0;

            $cabang = $row['cabang_bank'];
            $asuransi = $row['id_cabang_as'];
            $awal = $row['tgl_bayar_awal'];
            $akhir = $row['tgl_bayar_akhir'];
            $this->db->DISTINCT();
            $this->db->SELECT("a.id_debitur as idDK");
            $this->db->FROM("debitur a");
            $this->db->JOIN("m_cabang_asuransi e","e.id_cabang_asuransi = a.id_cabang_as","INNER");
            $this->db->JOIN("m_capem_bank b","b.id_capem_bank = a.id_capem_bank","INNER");
            $this->db->JOIN("m_cabang_bank c","c.id_cabang_bank = b.id_cabang_bank","INNER");
            $this->db->JOIN("tr_recov_as d","d.id_debitur = a.id_debitur","INNER");
            $this->db->WHERE("d.tgl_bayar BETWEEN '$awal' AND '$akhir'");
            $this->db->WHERE("e.id_cabang_asuransi",$asuransi);
            $this->db->WHERE("c.cabang_bank",$cabang);
            $hasil2 = $this->db->get()->result_array();
            foreach ($hasil2 as $row2) {
                $noa++;
                $id_data_klaim = $row2['idDK'];
                $this->db->SELECT("SUM(nominal) AS hitung");
                $this->db->FROM("tr_recov_as");
                $this->db->WHERE("id_debitur= $id_data_klaim AND tgl_bayar BETWEEN '$awal' AND
                '$akhir'");
                $recoveries2 = $this->db->get()->row_array();
                $tot_recoveries += $recoveries2['hitung'];
            }
            
            $hasil_akhir[] = array(
                'tgl_awal'=>$awal,
                'tgl_akhir'=>$akhir,
				'cabang_bank' => $cabang,
                'recoveries' => $tot_recoveries,
                'tot_deb' => $noa
			);
        }
        return $hasil_akhir;
    }

    // PEMBAYARAN KLIEN

    public function get_data_bayar_klien()
    {
        $this->_get_datatables_query_bayar_klien();

        if ($this->input->post('length') != -1) {
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
            
            return $this->db->get()->result_array();
        }
    }

    var $kolom_order_bayar_klien = [null, 'ca.cabang_asuransi', 'mp.nama_periode', 'br.no_invoice', 'br.komisi_diajukan', 'CAST(br.tgl_cair as VARCHAR)', 'br.komisi_dibayarkan', 'br.keterangan', 'br.rekening'];
    var $kolom_cari_bayar_klien  = ['LOWER(ca.cabang_asuransi)', 'LOWER(mp.nama_periode)', 'LOWER(br.no_invoice)', 'CAST(br.komisi_diajukan as VARCHAR)', 'CAST(br.tgl_cair as VARCHAR)', 'CAST(br.komisi_dibayarkan as VARCHAR)', 'LOWER(br.keterangan)', 'LOWER(br.rekening)'];
    var $order_bayar_klien       = ['mp.nama_periode' => 'desc'];

    public function _get_datatables_query_bayar_klien()
    {
        $this->db->DISTINCT();
        $this->db->select('ca.cabang_asuransi, mp.nama_periode, br.*');
        $this->db->from('rekonsiliasi as r');
        $this->db->join('periode as p', 'r.id_periode = p.id_periode', 'inner');
        $this->db->join('m_periode as mp', 'mp.id_periode = p.m_periode', 'inner');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = p.id_cabang_as', 'inner');
        $this->db->join('invoice as br', 'br.id_invoice = r.id_invoice', 'inner');

        $b = 0;
        
        $input_cari = strtolower($_POST['search']['value']);
        $kolom_cari = $this->kolom_cari_bayar_klien;

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

            $kolom_order = $this->kolom_order_bayar_klien;
            $this->db->order_by($kolom_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        } elseif (isset($this->order_bayar_klien)) {
            
            $order = $this->order_bayar_klien;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
        
    }

    public function jumlah_semua_bayar_klien()
    {
        $this->db->DISTINCT();
        $this->db->select('ca.cabang_asuransi, mp.nama_periode, br.*');
        $this->db->from('rekonsiliasi as r');
        $this->db->join('periode as p', 'r.id_periode = p.id_periode', 'inner');
        $this->db->join('m_periode as mp', 'mp.id_periode = p.m_periode', 'inner');
        $this->db->join('m_cabang_asuransi as ca', 'ca.id_cabang_asuransi = p.id_cabang_as', 'inner');
        $this->db->join('invoice as br', 'br.id_invoice = r.id_invoice', 'inner');

        return $this->db->count_all_results();
    }

    public function jumlah_filter_bayar_klien()
    {
        $this->_get_datatables_query_bayar_klien();

        return $this->db->get()->num_rows();
        
    }

}

/* End of file M_monitoring.php */
