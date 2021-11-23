<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Master Debitur</title>

    <!-- Custom CSS -->
    <link href="<?= base_url() ?>template/dist/css/style.min.css" rel="stylesheet">

    <style>
        th, td {
        padding: 5px;
        font-size: 12px;
        }
        th {
        text-align: center;
        }
        thead tr th {
        background-color: #eee;
        }
        body {
        margin: 20px 20px 20px 20px;
        color: black;
        }
    </style>
</head>
<body>

<h5 style="font-weight: bold;">Master Debitur</h5>

<table border="1" width=="100%">
    <thead>
        <tr>
            <ttr>
                <th>Id Debitur</th>
                <th>Deal Reff</th>
                <th>No Klaim</th>
                <th>Nama</th>
                <th>Asuransi</th>
                <th>Bank</th>
                <th>Cabang Bank</th>
                <th>Subrogasi</th>
                <th>Recoveries</th>
                <th>SHS</th>
                <th>No SPK</th>
            </tr>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($data)): ?>

            <tr>
                <td align="center" colspan="12">DATA KOSONG</td>
            </tr>

        <?php else : ?>

            <?php $no=0; foreach ($data as $d): 
            
            $no++;
                
            $shs = ($d['subrogasi_as'] - $d['recoveries_awal_asuransi']) - $d['tot_nominal_as'];

            ?>
                <tr>
                    <td><?= $d['id_debitur'] ?></td>
                    <td><?= $d['no_reff'] ?></td>
                    <td><?= $d['no_klaim'] ?></td>
                    <td><?= $d['nama_debitur'] ?></td>
                    <td><?= $d['cabang_asuransi'] ?></td>
                    <td><?= $d['bank'] ?></td>
                    <td><?= $d['cabang_bank'] ?></td>
                    <td><?= $d['subrogasi_as'] ?></td>
                    <td><?= $d['tot_nominal_as'] ?></td>
                    <td><?= $shs ?></td>
                    <td><?= $d['no_spk'] ?></td>
                </tr>
            <?php endforeach; ?>

        <?php endif; ?>
    </tbody>
</table>
    
</body>
</html>