<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Master Cabang Asuransi</title>

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

<h5 style="font-weight: bold;">Master Cabang Asuransi</h5>

<table border="1" width=="100%">
    <thead>
        <tr>
            <th>Id Cabang Asuransi</th>
            <th>Cabang Asuransi</th>
            <th>Singkatan</th>
            <th>Korwil Asuransi</th>
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
                
            ?>
                <tr>
                    <td><?= $d['id_cabang_asuransi'] ?></td>
                    <td><?= $d['cabang_asuransi'] ?></td>
                    <td><?= $d['singkatan'] ?></td>
                    <td><?= $d['korwil_asuransi'] ?></td>
                </tr>
            <?php endforeach; ?>

        <?php endif; ?>
    </tbody>
</table>
    
</body>
</html>