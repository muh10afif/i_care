<!doctype html>
<html>
    <head>
        <title>Print Laporan Pengeluaran Bulanan</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <?php if ($jns == 'print'): ?>

    <style>
    
        body {
                color: black;
                font-family: calibri;
                margin: 0;
            }

        @media print {
            @page { margin: 0; size: A4; }
            body { margin: 0.7cm; }
        }

        body {
            margin: 50px;
        }
    
    </style>

    <?php endif; ?>

    <style>

    #ad thead tr th {
      vertical-align: middle;
      text-align: center;
    }

    th, td {
      padding: 5px;
      font-size: 10px;
    }

    th {
      text-align: center;
    }

    tr th {
      background-color: #122E5D; color: white;
    }
    .a tr td {
      font-weight: bold;
    }
    body {
      margin: 20px 20px 20px 20px;
      color: black;
    }
    h5, h6 {
      font-weight: bold;
      text-align: center;
    }
    #d th {
      background-color: #122E5D; color: white;
    }
    #tot {
      background-color: #d2e0f7; font-weight: bold;
    }
    #tot_1 {
      font-weight: bold;
    }
    </style>
</head>
<body>

<h5 style="font-weight: bold;">Biaya Divisi Subrogasi</h5>
<h5 style="font-weight: bold;">Per PIC</h5>
<?php if($bln_awal != '' || $bln_akhir != '') : ?>
    <h5><?= strtoupper(bln_indo($d_bulan_awal)) ?> - <?= strtoupper(bln_indo($d_bulan_akhir)) ?></h5>
<?php endif; ?>

<table border="1" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama PIC</th>
            <?php foreach ($bulan as $c): ?>
              <th><?= nice_date($c, 'F-Y') ?></th>
            <?php endforeach ?>
        </tr>
    </thead>
    <tbody>

        <?php if (count($list_pic) == 0) : $bln = count($bulan); ?>

          <tr>
            <td align="center" colspan="<?= 2+$bln ?>"><b>Data Kosong</b></td>
          </tr>

        <?php else : ?>

        <?php $no=0; foreach ($list_pic as $c): $no++; ?>
            <tr>
                <td align="center"><?= $no ?></td>
                <td><?= ucwords($c['nama_lengkap']) ?></td>

                <?php foreach ($bulan as $d): ?>

                  <?php $hasil = $this->M_laporan->get_cetak_pic($d, $c['id_pic'])->row_array(); 
                  
                    if ($jns == 'excel') {
                        $total = ($hasil['total'] == '') ? 0 : $hasil['total'];
                    } else {
                        $total = number_format($hasil['total'],'2',',','.');
                    }
                  
                  ?>

                  <td align="right"><?= number_format($hasil['total'],'0','.','.') ?></td>

                  <?php  ?>

                <?php endforeach ?>

            </tr>
        <?php endforeach; ?>
        <tr>
          <th colspan="2" align='right' style="text-align: right">Jumlah</th>

          <?php $tot= 0; foreach ($bulan as $e) : ?>

          <?php $hasil = $this->M_laporan->get_cetak_pic_jumlah($e)->row_array();
          
            if ($jns == 'excel') {
                $total = ($hasil['total'] == '') ? 0 : $hasil['total'];
            } else {
                $total = number_format($hasil['total'],'2',',','.');
            }
          
          ?>

          <th align="right" style="text-align: right"><?= number_format($hasil['total']); ?></th>

          <?php endforeach ?>
        </tr>

        <?php endif; ?>
    </tbody>
</table>

</body>

    <?php if ($jns == 'print'): ?>
        <script>
            window.print();
        </script>
    <?php endif; ?>

</html>