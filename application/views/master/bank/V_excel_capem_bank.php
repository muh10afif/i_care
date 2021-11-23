<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Master Caprm Bank</title>

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

<h5 style="font-weight: bold;">Master Capem Bank</h5>

<table border="1" width=="100%">
    <thead>
        <tr>
            <th>Id Capem Bank</th>
            <th>Cabang Bank</th>
            <th>Capem Bank</th>
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
                    <td><?= $d['id_capem_bank'] ?></td>
                    <td><?= $d['cabang_bank'] ?></td>
                    <td><?= $d['capem_bank'] ?></td>
                </tr>
            <?php endforeach; ?>

        <?php endif; ?>
    </tbody>
</table>
    
</body>
</html>