<div class="row">
    <div class="col-12 table-responsive">
        <table class="table table-bordered table-hover mt-4" width="100%" id="tabel">
            <thead class="bg-info text-white">
                <tr>
                    <th>No</th>
                    <th>Deal Reff</th>
                    <th>No Klaim</th>
                    <th>Nama Debitur</th>
                    <th>No Rekening</th>
                    <th>Nominal</th>
                    <th>Tanggal Bayar</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; 
                foreach ($data as $d): 
                ?>
                    <tr>
                        <td align="center"><?= $no++ ?></td>
                        <td><?= $d['no_reff'] ?></td>
                        <td><?= $d['no_klaim'] ?></td>
                        <td><?= $d['nama_debitur'] ?></td>
                        <td><?= $d['no_rek'] ?></td>
                        <td align="right">Rp. <?= number_format($d['nominal'],'0','.',',') ?></td>
                        <td align="center"><?= nice_date($d['tgl_bayar'], 'd-F-Y') ?></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#tabel').DataTable();
    })
</script>