<style>
    .table tr th {
        text-align: center;
        vertical-align: middle;
        font-weight: bold;
    }   
</style>
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 align-self-center">
            <h4 class="page-title">Laporan Pengeluaran Bulanan</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Laporan</li>
                        <li class="breadcrumb-item"><a href="<?= base_url('') ?>">Laporan Pengeluaran Bulanan</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
        <div class="card border-info shadow">
                <div class="card-header bg-info">
                    <h4 class="mb-0 text-white">Filter Data</h4></div>
                <form action="<?= base_url('laporan/export_data') ?>" method="POST" target="_self" id="aksi_export">  
                    <input type="hidden" id="aksi" name="jns">
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <!-- periode -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="mt-2">Periode</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="input-daterange input-group" id="date-range-2">
                                                <input type="text" class="form-control" name="tgl_awal" id="start" placeholder="Awal Periode" readonly/>
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-info b-0 text-white">s / d</span>
                                                </div>
                                                <input type="text" class="form-control" name="tgl_akhir" id="end" placeholder="Akhir Periode" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" name="export" data="excel" class="btn btn-light btn-lg mr-3"><i class="fas fa-file-excel fa-lg text-success"></i></button>
                                <button type="submit" name="export" data="pdf" class="btn btn-light btn-lg mr-3"><i class="fas fa-file-pdf fa-lg text-danger"></i></button>
                                <button type="submit" name="export" data="print" class="btn btn-light btn-lg"><i class="fas fa-print fa-lg text-info"></i></button>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="button" class="btn btn-success" id="filter">Tampilkan</button><?= nbs(3) ?>
                                <button type="button" class="btn btn-warning" id="reset">Reset</button>
                            </div>
                        </div>
                    </div>
                 </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-info">
                    <h4 class="mb-0 text-white">List</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="tbl_peng_bulanan" width="100%">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th width="30%">Keterangan</th>
                                <th>PIC</th>
                                <th>COA</th>
                                <th>Deskripsi COA</th>
                                <th>Nominal</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
        
        var tbl_peng_bulanan = $('#tbl_peng_bulanan').DataTable({
            "processing"        : true,
            "serverSide"        : true,
            "pageLength"        : 10,
            "order"             : [],
            "ajax"              : {
                "url"   : "<?= base_url("laporan/tampil_peng_bulanan") ?>",
                "type"  : "POST",
                "data"  : function (data) {
                    data.tanggal_awal       = $('#start').val();
                    data.tanggal_akhir      = $('#end').val();
                }
            },
            "columnDefs"        : [{
                "targets"   : [0],
                "orderable" : false
            }, {
                "targets"   : [1],
                "className" : "text-center"
            }]
        })

        // aksi filter data
        $('#filter').click(function () {
            tbl_peng_bulanan.ajax.reload(null, false);        
        })

        // aksi reset data filter
        $('#reset').click(function () {
            $('#date-range-2 input').datepicker('setDate', null);

            var m = "minuman";

            tbl_peng_bulanan.ajax.reload(null, false);
            tbl_peng_bulanan.clear().draw();
            // tbl_peng_bulanan.search(m).draw();
            tbl_peng_bulanan.search("").draw();
        })

        $('button[name="export"]').on('click', function () {
            var jns         = $(this).attr('data');
            var tgl_awal    = $('#start').val();
            var tgl_akhir   = $('#end').val();
            var aksi_export = $('#aksi_export').val();

            $('#aksi').val(jns);

            console.log(jns);

            if (jns != 'print') {
                $("#aksi_export").attr('target', '_self');
            } else {
                $("#aksi_export").attr('target', '_blank');
            }
                    
        })

    })

</script>