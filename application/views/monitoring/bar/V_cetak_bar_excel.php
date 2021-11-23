
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<?php
	// Fungsi header dengan mengirimkan raw data excel
// header("Content-type: application/vnd-ms-excel");
// header("Content-Disposition: attachment; filename=Lampiran Debitur.xlxs");
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=\"Lampiran Debitur.xls\"");
header("Cache-Control: max-age=0");

?>
<html>
<head>
	
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
	<title></title>
	
	<style type="text/css">
		body,div,table,thead,tbody,tfoot,tr,th,td,p { font-family:"Tahoma"; font-size:x-small }
		a.comment-indicator:hover + comment { background:#ffd; position:absolute; display:block; border:1px solid black; padding:0.5em;  } 
		a.comment-indicator { background:red; display:inline-block; border:1px solid black; width:0.5em; height:0.5em;  } 
		comment { display:none;  } 
	</style>
	
</head>
<body>
<table cellspacing="0" border="0">
	<tr style="height:24px;">
		<td colspan="9" height="24" align="center"><b>Laporan Rekonsiliasi Per Debitur</b></td>
	</tr>
	<tr style="height:24px;">
		<td height="17" align="left"><br></td>
		<td height="17" align="left"><br></td>
		<td height="17" align="left"><br></td>
		<td height="17" align="left"><br></td>
		<td height="17" align="left"><br></td>
		<td height="17" align="left"><br></td>
		<td height="17" align="left"><br></td>
		<td height="17" align="left"><br></td>
		<td height="17" align="left"><br></td>
	</tr>
	<tr style="height:24px;">
		<td height="17" align="left">Askrindo</td>
		<td align="left">:PT. <?php echo $data->cabang_asuransi;?></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
	</tr>
	<tr style="height:24px;">
		<td height="17" align="left">Bank</td>
		<td align="left">:PT. <?php echo $data->bank; ?> </td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
	</tr>
	<tr style="height:24px;">
		<td height="17" align="left">Cabang</td>
		<td align="left">:<?php echo $data->cabang_bank;?></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
	</tr>
	<tr style="height:24px;">
		<td height="17" align="left">Periode</td>
		<td align="left">:<?php echo tgl_indo($data->tgl_bayar_awal); ?> s/d <?php echo tgl_indo($data->tgl_bayar_akhir)  ?></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
	</tr>
	<tr style="height:24px;">
		<td height="17" align="left">No. SPK</td>
		<td align="left">:</td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
	</tr>
	<tr style="height:24px;">
		<td height="17" align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
		<td align="left"><br></td>
	</tr>
	<tr style="height:24px;">
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="center" bgcolor="#808080"><b><font color="#FFFFFF">No</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" height="17" align="center" bgcolor="#808080"><b><font color="#FFFFFF">No Klaim</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" height="17" align="center" bgcolor="#808080"><b><font color="#FFFFFF">Tgl Klaim</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" height="17" align="center" bgcolor="#808080"><b><font color="#FFFFFF">Jenis Kredit</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" height="17" align="center" bgcolor="#808080"><b><font color="#FFFFFF">Debitur</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" height="17" align="center" bgcolor="#808080"><b><font color="#FFFFFF">Recoveries</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" height="17" align="center" bgcolor="#808080"><b><font color="#FFFFFF">Tanggal Pembayaran</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" height="17" align="center" bgcolor="#808080"><b><font color="#FFFFFF">No Rekening</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" height="17" align="center" bgcolor="#808080"><b><font color="#FFFFFF">Unit/KCP</font></b></td>
	</tr>
    <?php $total_rec=0; $no=1; foreach ($excel as $r) : 
        
        $total_rec += $r['nominal'];

        ?>
        <tr style="height:24px;">
            <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="17" align="left"><?php echo $no; ?></td>
            <td height="17" style="border-bottom: 1px solid #000000; border-right: 1px solid #000000"><?php echo $r['no_klaim'];?></td>
            <td height="17" style="border-bottom: 1px solid #000000; border-right: 1px solid #000000"><?php echo $r['tgl_klaim'];?></td>
            <td height="17" style="border-bottom: 1px solid #000000; border-right: 1px solid #000000"><?php echo $r['jenis_kredit'];?></td>
            <td height="17" style="border-bottom: 1px solid #000000; border-right: 1px solid #000000"><?php echo $r['nama_debitur'];?></td>
            <td height="17" style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align=right><?php echo number_format($r['nominal'],2);?></td>
            <td height="17" style="border-bottom: 1px solid #000000; border-right: 1px solid #000000"><?php echo $r['tgl_bayar'];?></td>
            <td height="17" style="border-bottom: 1px solid #000000; border-right: 1px solid #000000">'<?php echo ltrim($r["no_rek"]);?></td>
            <td height="17" style="border-bottom: 1px solid #000000; border-right: 1px solid #000000"><?php echo $r['capem_bank'];?></td>
        </tr>
    <?php $no++; endforeach; ?>
	<tr style="height:24px;">
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 height="17" align="center" bgcolor="#808080"><b><font color="#FFFFFF">GRAND TOTAL</font></b></td>
		<td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="right" height="17" bgcolor="#969696"><b><font color="#FFFFFF"><?php echo number_format($total_rec,2); ?></font></b></td>
		<td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" colspan=3 height="17" align="left" bgcolor="#808080"><br></td>
	</tr>
</table>
</body>
</html>