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

    thead tr th {
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

<h5 style="font-weight: bold;">Laporan Keuangan Pengeluaran Bulanan</h5>
<?php if($tgl_awal != '' || $tgl_akhir != '') : ?>
<h6><?= nice_date($tgl_awal, 'd-F-Y') ?> s/d <?= nice_date($tgl_akhir, 'd-F-Y') ?></h6>
<?php endif; ?>

<table border="1" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th width="25%">Keterangan</th>
            <th>PIC</th>
            <th>COA</th>
            <th>Deskripsi COA</th>
            <th>Nominal</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($list_peng_bln)): ?>
            <tr>
                <td align="center" colspan="10">DATA KOSONG</td>
            </tr>
        <?php endif; ?>

        <?php $no=0; foreach ($list_peng_bln as $d): $no++;

            if ($jns == 'excel') {
              $nominal = $d['debit'];
            } else {
              $nominal = number_format($d['debit'], '2',',','.');
            }

        ?>
            <tr>
                <td><?= $no ?></td>
                <td align='center'><?= nice_date($d['tgl_transaksi'], 'd-M-Y') ?></td>
                <td><?= $d['keterangan'] ?></td>
                <td><?= ucwords($d['nama_lengkap']) ?></td>
                <td><?= $d['no_coa_des'] ?></td>
                <td><?= $d['deskripsi_coa'] ?></td>
                <td><?= $nominal ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>

    <?php if ($jns == 'print'): ?>
        <script>
            window.print();
        </script>
    <?php endif; ?>

</html>