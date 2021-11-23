<?php
	header("Cache-Control: ");
	header("Pragma: ");
	header("Content-type: application/vnd-ms-word");
	header("Content-Disposition: attachment;Filename=Invoice.doc");
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div>
<div>
<?php $total_rec=0; $total_debitur=0; $dpp=0; $ppn=0; $pph23=0; $total_pendapatan=0; foreach ($cabang as $r) { ?>
     <?php
	  $sum = $r['recoveries']++;
	  $total_rec += $sum;
	  $sum2 = $r['tot_deb']++;
	  $total_debitur += $sum2;
	  $total = ($r['recoveries'] * 0.15); 
	  $sum3 = $total++;
	  $total_pendapatan += $sum3;
	  $dpp = ($total_pendapatan / 1.1);
	  $ppn = ($dpp * 0.10);
	  $pph23 = ($dpp * 0.02);
}?>
<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: right; font-size: 11pt;"><span style="height: 0pt; text-align: left; display: block; position: absolute; z-index: -65536;"><img src="<?php echo base_url('assets/images/1556866006_invoice-bandung-0007.png');?>" alt="" width="222" height="64" /></span></p>
</div>
<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: 108%; font-size: 11pt;"><span style="font-family: Calibri;">Nomor</span><span style="width: 32.48pt; display: inline-block;">&nbsp;</span><span style="font-family: Calibri;">:</span><span style="font-family: Calibri;">&nbsp;&nbsp; </span><span style="font-family: Calibri;"><?php echo $data->no_invoice; ?></span></p>
<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: 108%; font-size: 11pt;"><span style="font-family: Calibri;">Tanggal</span><span style="width: 29.24pt; display: inline-block;">&nbsp;</span><span style="font-family: Calibri;">:</span><span style="font-family: Calibri;">&nbsp;&nbsp; </span><span style="font-family: Calibri;"><?php echo date('d F Y', now('Asia/Jakarta'));?></span></p>
<p style="margin-top: 0pt; margin-bottom: 0pt; font-size: 12pt;"><span style="font-family: Calibri; font-size: 11pt;">Lampiran</span><span style="width: 21.93pt; display: inline-block;">&nbsp;</span><span style="font-family: Calibri; font-size: 11pt;">: </span><span style="font-family: Calibri; font-size: 11pt;">&nbsp; </span><span style="font-family: Calibri; font-size: 11pt;">1</span> <span style="font-family: Calibri;">(Satu) </span><span style="font-family: Calibri;">Berkas</span></p>
<p style="margin-top: 0pt; margin-bottom: 8pt; text-align: justify; line-height: 108%; font-size: 11pt;"><span style="font-family: Calibri;">&nbsp;</span></p>
<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;"><span style="font-family: Calibri;">Kepada Yth.</span><span style="font-family: Calibri;">&nbsp; </span></p>
<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;"><strong><span style="font-family: Calibri;">PT. Asuransi Kredit Indonesia</span></strong> <strong><span style="font-family: Calibri;">(Persero)</span></strong></p>
<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: 108%; font-size: 11pt;"><span style="font-family: Calibri;">Kantor Cabang <?php echo $data->cabang_asuransi;?></span></p>
<p style="margin-top: 0pt; margin-bottom: 6pt; text-align: justify; font-size: 11pt;"><span style="font-family: Calibri;">&nbsp;</span></p>
<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; font-size: 11pt;"><span style="font-family: Calibri;">Perihal</span><span style="width: 39.81pt; display: inline-block;">&nbsp;</span><span style="font-family: Calibri;">:</span><span style="width: 11.21pt; display: inline-block;">&nbsp;</span><strong><u><span style="font-family: Calibri;">Permohonan Pembayaran Komisi Subrogasi &amp; Recoveries </span></u></strong></p>
<p style="margin-top: 8pt; margin-bottom: 8pt; text-align: justify; font-size: 11pt;"><span style="font-family: Calibri;">&nbsp;</span></p>
<p style="margin-top: 0pt; margin-bottom: 8pt; text-align: justify; line-height: 108%; font-size: 11pt;"><span style="font-family: Calibri;">Dengan hormat,</span></p>
<p style="margin-top: 0pt; margin-bottom: 12pt; text-align: justify; line-height: 108%; font-size: 12pt;"><span style="font-family: Calibri; font-size: 11pt;">Menunjuk pada Perjanjian antara </span><a name="_Hlk505771316"></a><span style="font-family: Calibri; font-size: 11pt;">PT.</span><span style="font-family: Calibri; font-size: 11pt;">&nbsp; </span><span style="font-family: Calibri; font-size: 11pt;">ASURANSI KREDIT INDONESIA (PERSERO) dengan </span><span style="font-family: Calibri; font-size: 11pt;">PT. SOLUSI PRIMA SELINDO </span><span style="font-family: Calibri; font-size: 11pt;">&nbsp;</span><span style="font-family: Calibri; font-size: 11pt;">tentang PENAGIHAN SALDO HAK SUBROGASI</span> <span style="font-family: Calibri; font-size: 11pt;">&nbsp;</span><img src="<?php echo base_url('assets/images/1556866006_invoice-bandung-0007-003.png');?>" alt="" width="177" height="32" /><span style="font-family: 'Calibri Light';">tanggal 31 Desember 2018</span><span style="font-family: Calibri; font-size: 11pt;">,</span><span style="font-family: Calibri; font-size: 11pt;"> kami sampaikan Permohonan Pembayaran Komisi Subrogasi &amp; Recoveries dengan rincian recoveries sebagai berikut :</span></p>
<table style="width: 468.3pt; border: 0.75pt solid #000000; border-collapse: collapse;" cellspacing="0" cellpadding="0">
<thead>
<tr>
<td style="border-right-style: solid; border-right-width: 0.75pt; border-bottom-style: solid; border-bottom-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #ffffff;">
<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 10pt;"><strong><span style="font-family: Calibri;">NO.</span></strong></p>
</td>
<td style="width: 72.05pt; border-right-style: solid; border-right-width: 0.75pt; border-left-style: solid; border-left-width: 0.75pt; border-bottom-style: solid; border-bottom-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #ffffff;">
<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 10pt;"><strong><span style="font-family: Calibri;">CABANG</span></strong></p>
</td>
<td style="width: 55.85pt; border-right-style: solid; border-right-width: 0.75pt; border-left-style: solid; border-left-width: 0.75pt; border-bottom-style: solid; border-bottom-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #ffffff;">
<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 10pt;"><strong><span style="font-family: Calibri;">JUMLAH DEBITUR</span></strong></p>
</td>
<td style="border-right-style: solid; border-right-width: 0.75pt; border-left-style: solid; border-left-width: 0.75pt; border-bottom-style: solid; border-bottom-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #ffffff;">
<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 10pt;"><strong><span style="font-family: Calibri;">RECOVERIES</span></strong></p>
</td>
<td style="border-right-style: solid; border-right-width: 0.75pt; border-left-style: solid; border-left-width: 0.75pt; border-bottom-style: solid; border-bottom-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #ffffff;">
<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 10pt;"><strong><span style="font-family: Calibri;">KOMISI (15%)</span></strong></p>
</td>
<td style="width: 105.05pt; border-left-style: solid; border-left-width: 0.75pt; border-bottom-style: solid; border-bottom-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #ffffff;">
<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 10pt;"><strong><span style="font-family: Calibri;">PERIODE</span></strong></p>
</td>
</tr>
</thead>
<tbody>
<?php $no=1; foreach ($cabang as $r) {?>
<tr>
<td style="border-top-style: solid; border-top-width: 0.75pt; border-right-style: solid; border-right-width: 0.75pt; border-bottom-style: solid; border-bottom-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #ffffff;">
<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 10pt;"><span style="font-family: Calibri;"><?php echo $no; ?></span></p>
</td>
<td style="width: 72.05pt; border-style: solid; border-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #ffffff;">
<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 10pt;"><span style="font-family: Calibri;"><?php echo $r['cabang_bank'] ?></span></p>
</td>
<td style="width: 55.85pt; border-style: solid; border-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #ffffff;">
<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 10pt;"><span style="font-family: Calibri;"><?php echo $r['tot_deb'] ?></span></p>
</td>
<td style="border-style: solid; border-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #ffffff;">
<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: right; font-size: 10pt;"><span style="font-family: Calibri;"><?php echo number_format($r['recoveries'],2);?></span></p>
</td>
<td style="border-style: solid; border-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #ffffff;">
<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: right; font-size: 10pt;"><span style="font-family: Calibri;"><?php echo number_format($r['recoveries']*0.15,2);?></span></p>
</td>
<td style="width: 105.05pt; border-top-style: solid; border-top-width: 0.75pt; border-left-style: solid; border-left-width: 0.75pt; border-bottom-style: solid; border-bottom-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #ffffff;">
<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 10pt;"><span style="font-family: Calibri;"><?php echo date('d-m-Y', strtotime($r['tgl_awal'])); ?> ~ <?php echo date('d-m-Y', strtotime($r['tgl_akhir'])); ?></span></p>
</td>
</tr>
<?php $no++; }?>
<tr>
	<td style="width: 124.75pt; border-top-style: solid; border-top-width: 0.75pt; border-right-style: solid; border-right-width: 0.75pt; border-bottom-style: solid; border-bottom-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #FFFFFF;" colspan="2">
		<p style="margin-top: 0pt; margin-bottom: 0pt; text-align:center; font-size: 10pt;"><span style="font-family: Calibri;">SUB TOTAL</span></p>
	</td>
	<td style="width: 55.85pt; border-style: solid; border-width: 0.75pt; padding-right: 5.03pt; padding-left:5.03pt; background-color: #FFFFFF;">
		<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 10pt;"><span style="font-family: Calibri;"><?php echo $total_debitur;?></span></p>
	</td>
	<td style="border-style: solid; border-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #FFFFFF">
		<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: right; font-size: 10pt;"><span style="font-family: Calibri;"><?php echo number_format($total_rec,2);?></span></p>
	</td>
	<td style="border-style: solid; border-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #FFFFFF">
		<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: right; font-size: 10pt;"><span style="font-family: Calibri;"><?php echo number_format($total_pendapatan,2);?></span></p>
	</td>
	<td style="width: 105.05pt; border-top-style: solid; border-top-width: 0.75pt; border-left-style: solid; border-left-width: 0.75pt; border-bottom-style: solid; border-bottom-width: 0.75pt; padding-right:5.03pt; padding-left: 5.03pt; vertical-align: top; background-color: #FFFFFF;">
		<p style="margin-top: 0pt; margin-bottom: 0pt; font-size: 10pt;"><span style="font-family: Calibri;">&nbsp;</span></p>
	</td>
</tr>
<tr>
	<td style="width: 124.75pt; border-top-style: solid; border-top-width: 0.75pt; border-right-style: solid; border-right-width: 0.75pt; border-bottom-style: solid; border-bottom-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #FFFFFF;" colspan="2">
		<p style="margin-top: 0pt; margin-bottom: 0pt; text-align:center; font-size: 10pt;"><span style="font-family: Calibri;">DPP</span></p>
	</td>
	<td style="width: 55.85pt; border-style: solid; border-width: 0.75pt; padding-right: 5.03pt; padding-left:5.03pt; background-color: #FFFFFF;">
		<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 10pt;"><span style="font-family: Calibri;"></span><span style="font-family: Calibri;"></span></p>
	</td>
	<td style="border-style: solid; border-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #FFFFFF">
		<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: right; font-size: 10pt;"><span style="font-family: Calibri;"></span></p>
	</td>
	<td style="border-style: solid; border-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #FFFFFF">
		<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: right; font-size: 10pt;"><span style="font-family: Calibri;"><?php echo number_format($dpp,2);?></span></p>
	</td>
	<td style="width: 105.05pt; border-top-style: solid; border-top-width: 0.75pt; border-left-style: solid; border-left-width: 0.75pt; border-bottom-style: solid; border-bottom-width: 0.75pt; padding-right:5.03pt; padding-left: 5.03pt; vertical-align: top; background-color: #FFFFFF;">
		<p style="margin-top: 0pt; margin-bottom: 0pt; font-size: 10pt;"><span style="font-family: Calibri;">&nbsp;</span></p>
	</td>
</tr>
<tr>
	<td style="width: 124.75pt; border-top-style: solid; border-top-width: 0.75pt; border-right-style: solid; border-right-width: 0.75pt; border-bottom-style: solid; border-bottom-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #FFFFFF;" colspan="2">
		<p style="margin-top: 0pt; margin-bottom: 0pt; text-align:center; font-size: 10pt;"><span style="font-family: Calibri;">PPN</span></p>
	</td>
	<td style="width: 55.85pt; border-style: solid; border-width: 0.75pt; padding-right: 5.03pt; padding-left:5.03pt; background-color: #FFFFFF;">
		<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 10pt;"><span style="font-family: Calibri;"></span><span style="font-family: Calibri;"></span></p>
	</td>
	<td style="border-style: solid; border-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #FFFFFF">
		<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: right; font-size: 10pt;"><span style="font-family: Calibri;"></span></p>
	</td>
	<td style="border-style: solid; border-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #FFFFFF">
		<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: right; font-size: 10pt;"><span style="font-family: Calibri;"><?php echo number_format($ppn,2); ?></span></p>
	</td>
	<td style="width: 105.05pt; border-top-style: solid; border-top-width: 0.75pt; border-left-style: solid; border-left-width: 0.75pt; border-bottom-style: solid; border-bottom-width: 0.75pt; padding-right:5.03pt; padding-left: 5.03pt; vertical-align: top; background-color: #FFFFFF;">
		<p style="margin-top: 0pt; margin-bottom: 0pt; font-size: 10pt;"><span style="font-family: Calibri;">&nbsp;</span></p>
	</td>
</tr>
<tr>
	<td style="width: 124.75pt; border-top-style: solid; border-top-width: 0.75pt; border-right-style: solid; border-right-width: 0.75pt; border-bottom-style: solid; border-bottom-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #FFFFFF;" colspan="2">
		<p style="margin-top: 0pt; margin-bottom: 0pt; text-align:center; font-size: 10pt;"><span style="font-family: Calibri;">PPH 23</span></p>
	</td>
	<td style="width: 55.85pt; border-style: solid; border-width: 0.75pt; padding-right: 5.03pt; padding-left:5.03pt; background-color: #FFFFFF;">
		<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 10pt;"><span style="font-family: Calibri;"></span><span style="font-family: Calibri;"></span></p>
	</td>
	<td style="border-style: solid; border-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #FFFFFF">
		<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: right; font-size: 10pt;"><span style="font-family: Calibri;"></span></p>
	</td>
	<td style="border-style: solid; border-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #FFFFFF">
		<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: right; font-size: 10pt;"><span style="font-family: Calibri;"><?php echo number_format($pph23,2); ?></span></p>
	</td>
	<td style="width: 105.05pt; border-top-style: solid; border-top-width: 0.75pt; border-left-style: solid; border-left-width: 0.75pt; border-bottom-style: solid; border-bottom-width: 0.75pt; padding-right:5.03pt; padding-left: 5.03pt; vertical-align: top; background-color: #FFFFFF;">
		<p style="margin-top: 0pt; margin-bottom: 0pt; font-size: 10pt;"><span style="font-family: Calibri;">&nbsp;</span></p>
	</td>
</tr>
<tr>
	<td style="width: 124.75pt; border-top-style: solid; border-top-width: 0.75pt; border-right-style: solid; border-right-width: 0.75pt; border-bottom-style: solid; border-bottom-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #FFFFFF;" colspan="2">
		<p style="margin-top: 0pt; margin-bottom: 0pt; text-align:center; font-size: 10pt;"><strong><span style="font-family: Calibri;">NET KOMISI</span></strong></p>
	</td>
	<td style="width: 55.85pt; border-style: solid; border-width: 0.75pt; padding-right: 5.03pt; padding-left:5.03pt; background-color: #FFFFFF;">
		<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: center; font-size: 10pt;"><span style="font-family: Calibri;">&nbsp;</span></p>
	</td>
	<td style="border-style: solid; border-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #FFFFFF">
		<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: right; font-size: 10pt;"><span style="font-family: Calibri;">&nbsp;</span></p>
	</td>
	<td style="border-style: solid; border-width: 0.75pt; padding-right: 5.03pt; padding-left: 5.03pt; background-color: #FFFFFF">
		<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: right; font-size: 10pt;"><strong><span style="font-family: Calibri;"><?php echo number_format(($hasil = $dpp - $pph23), 2) ?></span></strong></p>
	</td>
	<td style="width: 105.05pt; border-top-style: solid; border-top-width: 0.75pt; border-left-style: solid; border-left-width: 0.75pt; border-bottom-style: solid; border-bottom-width: 0.75pt; padding-right:5.03pt; padding-left: 5.03pt; vertical-align: top; background-color: #FFFFFF;">
		<p style="margin-top: 0pt; margin-bottom: 0pt; font-size: 10pt;"><span style="font-family: Calibri;">&nbsp;</span></p>
	</td>
</tr>
</tbody>
</table>
<p style="margin-top: 12pt; margin-bottom: 8pt; text-align: justify; line-height: 108%; font-size: 11pt;"><span style="font-family: Calibri;">&nbsp;</span></p>
<p style="margin-top: 12pt; margin-bottom: 8pt; text-align: justify; line-height: 108%; font-size: 11pt;"><span style="font-family: Calibri;">Berkenan dengan hal tersebut kami mohon agar komisi sebesar Rp.</span><span style="font-family: Calibri;"><?php echo number_format(($hasil = $dpp - $pph23), 2) ?>&nbsp;</span><span style="font-family: Calibri;">dapat di transfer ke Nomor Rekening 130-00-58-00-7777 pada Bank Mandiri KK Bandung BEC atas nama PT. Solusi Prima Selindo.</span></p>
<p style="margin-top: 6pt; margin-bottom: 0pt; text-align: justify;line-height: 108%; font-size: 11pt;"><span style="font-family: Calibri;">Demikian kami sampaikan permohonan ini, atas perhatian dan kerjasamanya&nbsp;</span><span style="font-family: Calibri;">k</span><span style="font-family: Calibri;">ami ucapkan terima&nbsp;</span><span style="font-family: Calibri;">kasih</span><span style="font-family: Calibri;">.</span></p>
<p style="margin-top: 6pt;  margin-bottom: 0pt; line-height: 108%; font-size: 11pt;"><span style="font-family: Calibri;">Hormat kami, </span></p>
<p style="margin-top: 6pt; margin-bottom: 0pt; line-height: 108%; font-size:11pt;"><strong><span style="font-family: Calibri;">PT. Solusi Prima Selindo</span></strong></p>
<p style="margin-top: 0pt; margin-bottom: 0pt; line-height: 108%; font-size: 11pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="height:0pt; display: block; position: absolute; z-index: 0;"><img style="margin-top: 1.75pt; margin-left: 17.25pt; position: absolute;" src="<?php echo base_url('assets/images/1556866006_invoice-bandung-0007-004.png');?>" alt="" width="95" height="85"/></span></p>
<p style="margin-top: 0pt; margin-bottom: 0pt; font-size: 11pt;"><span style="font-family: Calibri;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><strong><u><span style="font-family: Calibri;">Rio&nbsp;</span></u></strong><strong><u><span style="font-family: Calibri;">S</span></u></strong><strong><u><span style="font-family: Calibri;">ukmawan</span></u></strong></p>
<p style="margin-top: 0pt; margin-bottom: 0pt; text-align: justify; line-height: 108%; font-size: 11pt;"><span style="font-family: Calibri;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="font-family: Calibri;">Direktur Utama</span></p>