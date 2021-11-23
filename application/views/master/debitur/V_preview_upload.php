<div class="row">
    <div class="col-12 table-responsive">
        <table class="table table-bordered table-hover mt-4" width="100%" id="tabel">
            <thead class="bg-info text-white">
                <tr>
                    <th>No</th>
                    <th>Deal Reff</th>
                    <th>No Klaim</th>
                    <th>Nama Debitur</th>
                    <th>Cabang Asuransi</th>
                    <th>Capem Bank</th>
                    <th>Subrogasi</th>
                    <th>Penyebab Klaim</th>
                    <th>Jenis Kredit</th>
                    <th>Pokok</th>
                    <th>Bunga</th>
                    <th>Denda</th>
                    <th>Jumlah</th>
                    <th>Alamat</th>
                    <th>Tanggal WO</th>
                    <th>Tanggal Klaim</th>
                    <th>Maturity Date</th>
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
                        <td><?= $d['cabang_as'] ?></td>
                        <td><?= $d['capem_bank'] ?></td>
                        <td>Rp. <?= number_format($d['subrogasi_as'],'2','.',',') ?></td>
                        <td><?= $d['penyebab_klaim'] ?></td>
                        <td><?= $d['jenis_kredit'] ?></td>
                        <td>Rp. <?= number_format($d['pokok'],'2','.',',') ?></td>
                        <td>Rp. <?= number_format($d['bunga'],'2','.',',') ?></td>
                        <td>Rp. <?= number_format($d['denda'],'2','.',',') ?></td>
                        <td>Rp. <?= number_format($d['jumlah'],'2','.',',') ?></td>
                        <td><?= $d['alamat_awal'] ?></td>
                        <td align="center"><?= nice_date($d['tgl_wo'], 'd-F-Y') ?></td>
                        <td align="center"><?= nice_date($d['tgl_klaim'], 'd-F-Y') ?></td>
                        <td align="center"><?= nice_date($d['maturity_date'], 'd-F-Y') ?></td>
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