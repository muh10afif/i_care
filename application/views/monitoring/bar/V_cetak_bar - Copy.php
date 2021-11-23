<?php
	header("Cache-Control: ");
	header("Pragma: ");
	header("Content-type: application/vnd.ms-word");
	header("Content-Disposition: attachment;Filename=BAR.doc");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>BAR</title>
    <link rel="stylesheet" href="<?php echo base_url()?>template/assets/libs/bootstrap/dist/css/bootstrap.min.css" />
	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 10px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #000000;
	}

	a {
		color: #000000;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 5px 0 5px;
	}

	#container {
		margin: 0px;
	}
	
	img{float:left;padding-right:10px;}
	</style>
</head>
<div id="container">
	<div id="body">
	<p>No. : <?php echo $data->no_bar; ?></p>
<p>Hal : Berita acara hasil rekonsiliasi saldo hak subrogasi PT. Askrindo (Persero)</p>
<br/>
<p style="text-align: justify;">&emsp;Pada Tanggal <?php echo tgl_indo($data->tgl_bayar_akhir);?>, telah dilakukan Rekonsiliasi Data Hak Subrogasi antara PT. Askrindo (Persero) Cabang <?php echo $data->cabang_asuransi;?> dengan PT. <?php echo $data->bank;?> <?php echo $data->cabang_bank;?> (berikut unit-unit) dengan hasil sementara sebagai berikut:</p>
<br/>
<p><b>A. SALDO HAK SUBROGASI (SHS) POSISI PERIODE <?php echo tgl_indo($data->tgl_bayar_awal) ?> s/d <?php echo tgl_indo($data->tgl_bayar_akhir) ?></b></p>
<br/>
<div class="table-responsive">

<table border="1" cellspacing="0" cellpadding="0" > 
	<thead> 
		<tr>
			<td align="center"><p><b>NO.</b></p></td>
			<td align="center"><p><b>KANTOR CABANG /UNIT</b></p></td>
			<td align="center"><p><b>JUMLAH DEBITUR</b></p></td>
			<td align="center"><p><b>&nbsp;&nbsp;SUBROGASI&nbsp;&nbsp;</b></p></td>
			<td align="center"><p><b>&nbsp;&nbsp;RECOVERIES&nbsp;&nbsp;</b></p></td>
			<td align="center"><p><b>SALDO HAK SUBROGASI</b></p></td>
			<td align="center"><p><b>CRP %</b></p></td>
		</tr>
	</thead> 
	<tbody>
    <?php 

        $tot_jml_deb    = 0;
        $tot_subrogasi  = 0;
        $tot_recov      = 0;
        $tot_shs        = 0;
		$tot_crp        = 0;

		$no=1; foreach ($all as $r)  : 

		if ($r['tot_recov_as'] == null) {
			$tmk = 0;
		} else {
			$tmk = $r['tot_nominal_kurang'];
		}

        $subrogasi      = $r['tot_subrogasi'] - $tmk;
        $recoveries_as  = $r['tot_recov_as_awal'] + $r['tot_recov_as'];
        $shs            = ($subrogasi - $r['tot_recov_as_awal']) - $r['tot_recov_as'];

        if ($shs == 0) {
            $crp = 0;
        } else {
            $crp = $recoveries_as / $subrogasi;
		}
        
        $tot_jml_deb    += $r['jumlah_debitur'];
        $tot_subrogasi  += $subrogasi;
        $tot_recov      += $recoveries_as;
        $tot_shs        += $shs;
        $tot_crp        += $crp;

    ?>
		<tr>
			<td align="center"><?php echo $no;?></td>
			<td align="center"><?php echo $r['capem_bank']; ?></td>
            <td align="center"><?php echo $r['jumlah_debitur'];?></td>
            <?php if ($r['jumlah_debitur'] == 0): ?>
                <td align="right">0&nbsp;</td>
                <td align="right">0&nbsp;</td>
                <td align="right">0&nbsp;</td>
                <td align="center">0,00</td>
            <?php else: 
                
            ?>
                <td align="right"><?php echo number_format($subrogasi,2)?>&nbsp;</td>
                <td align="right"><?php echo number_format($recoveries_as,2)?>&nbsp;</td>
                <td align="right"><?php echo number_format($shs,2)?>&nbsp;</td>
                <td align="center"><?php echo number_format($crp,2); ?></td>
            <?php endif; ?>
			
		</tr>
		<?php $no++; endforeach; ?>
		<tr>
			<td colspan="2" align="center" ><p>Total</p></td>
			<td align="center"><?php echo $tot_jml_deb; ?></td>
			<td align="right"><?php echo number_format($tot_subrogasi,2); ?>&nbsp;</td>
			<td align="right"><?php echo number_format($tot_recov,2); ?>&nbsp;</td>
			<td align="right"><?php echo number_format($tot_shs,2); ?>&nbsp;</td>
			<td align="center"><?php echo number_format($tot_crp,2); ?></td>
		</tr>
	</tbody>
</table>

<br/><p><b>B. HASIL REKONSILIASI</b></p>
	<ol>
		<li style="text-align: justify;">Kami telah melakukan Rekonsiliasi terhadap <?php echo $tot_jml_deb; ?> debitur dengan nilai SHS Rp. <?php echo number_format($tot_shs,2); ?>, dengan hasil Recoveries sebesar Rp.<?php echo number_format($tot_recov,2); ?> dari <?php echo $tot_jml_deb; ?> debitur.</li>
		<li style="text-align: justify;">
			Tingkat pengembalian Recoveries/Collectibility Ratio Performance (CRP) PT. Askrindo (persero) cabang <?php echo $data->cabang_asuransi;?> beserta unit-unit pada saat Rekonsiliasi masih <?php echo number_format($tot_crp,2); ?> %.
			Kami mengharapkan agar pihak bank dapat meningkatkan penagihan terhadap klaim-klaim yang telah kami bayarkan.
		</li>
		<li>
			Terhadap hasil Rekonsiliasi tersebut, pihak bank akan meneliti kembali.
		</li>
	</ol>
<p>Demikian Berita Acara ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
    <table border="0" width="100%">
        <thead>
            <tr>
                <th></th>
                <th style="text-align: center;">Bandung, <?php echo tgl_indo($data->tgl_bayar_akhir);?></th>
            </tr>
            <tr>
                <th style="text-align: center;">PT. <?php echo $data->bank;?></th>
                <th style="text-align: center;">PT. Askrindo (Persero)</th>
            </tr>
            <tr>
                <th style="text-align: center;">DIVISI PPK</th>
                <th style="text-align: center;">Tim Rekonsiliasi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td style="text-align: center;">(……………………………………)</td>
                <td style="text-align: center;">(……………………………………)</td>
            </tr>
        </tbody>
    </table>
</body>
</html>