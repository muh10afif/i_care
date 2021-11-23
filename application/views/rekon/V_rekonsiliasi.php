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
            <h4 class="page-title">Rekonsiliasi</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Rekonsiliasi</li>
                        <li class="breadcrumb-item"><a href="<?= base_url('rekon') ?>">List Rekonsiliasi</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    <!-- filter data -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-info">
                    <h4 class="mb-0 text-white">Filter Data</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <div class="form-group col-md-6">
                            <div class="row" id="periode_1">
                                <div class="col-md-2 text-right">
                                    <label class="mt-2">Periode</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <select class="select2 form-control custom-select" name="periode" id="periode" style="width: 70%; height:36px;">  
                                            <option value="a">-- Pilih Periode --</option>
                                            <?php foreach ($periode as $b): ?>
                                                <option value="<?= $b['id_periode'] ?>"><?= nice_date($b['nama_periode'], 'F Y') ?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-info" type="button" id="cari"><i class="fas fa-search"></i></button>
                                            <button class="btn btn-danger" type="button" id="reset"><i class="fas fa-sync"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="periode_2" hidden>
                                <div class="col-md-2 text-right">
                                    <label class="mt-2">Periode</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <select class="select2 form-control custom-select" name="periode_buat" id="periode_buat" style="width: 70%; height:36px;">  
                                            <option value="a">-- Pilih Periode --</option>
                                            <?php foreach ($periode_cab as $b): ?>
                                                <option value="<?= $b['id_periode'] ?>"><?= nice_date($b['nama_periode'], 'F Y') ?> - <?= $b['cabang_bank'] ?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-info" type="button" id="cari_buat" data-toggle="tooltip" data-placement="top" title="Cari"><i class="fas fa-search"></i></button>
                                            <button class="btn btn-danger" type="button" id="reset_buat" data-toggle="tooltip" data-placement="top" title="Reset"><i class="fas fa-sync"></i></button>
                                            <button class="btn btn-warning" type="button" id="simpan_buat" data-toggle="tooltip" data-placement="top" title="Buat Rekonsiliasi"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row list-rekon">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-info">
                    <button class="btn btn-warning btn-sm float-right" type="button" id="buat_rekon">Tambah Data</button>
                    <h4 class="mb-0 text-white">List Rekonsiliasi</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="tabel_rekon" width="100%">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>No</th>
                                <th>Periode</th>
                                <th>Asuransi</th>
                                <th>Bank</th>
                                <th>Cabang Bank</th>
                                <th>BAR</th>
                                <th>Invoice</th>
                                <th>Created At</th>
                                <th>Created By</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row list-deb-rekon" hidden>
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-info">
                    <h4 class="mb-0 text-white">List Debitur Rekonsiliasi</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="tabel_rekon_deb" width="100%">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>No</th>
                                <th>Periode</th>
                                <th>Nama Debitur</th>
                                <th>Asuransi</th>
                                <th>Bank</th>
                                <th>Cabang Bank</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="align-items-center col-md-2" id="kembali" hidden>
        <button class="btn btn-warning btn-round ml-auto">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </button>
    </div>

</div>

<script src="<?= base_url() ?>template/assets/libs/jquery/dist/jquery.min.js"></script>

<script>

    $(document).ready(function () {
        
        // load datatables
        var tabel_rekon = $('#tabel_rekon').DataTable({

            "processing"    : true,
            "serverSide"    : true,
            "order"         : [],
            "ajax"          : {
                "url"   : "<?= base_url("rekon/tampil_rekon") ?>",
                "type"  : "POST",
                "data"  : function (data) {
                    data.id_periode    = $('#periode').val();
                }
            },
            "columnDefs"    : [{
                "targets"       : [0],
                "orderable"     : false
            }]
        })

        // load datatables
        var tabel_rekon_deb = $('#tabel_rekon_deb').DataTable({

            "processing"    : true,
            "serverSide"    : true,
            "order"         : [],
            "ajax"          : {
                "url"   : "<?= base_url("rekon/tampil_rekon_deb") ?>",
                "type"  : "POST",
                "data"  : function (data) {
                    data.id_periode    = $('#periode_buat').val();
                }
            },
            "columnDefs"    : [{
                "targets"       : [0],
                "orderable"     : false
            }]
        })

        // aksi filter data
        $('#cari').click(function () {
            tabel_rekon.ajax.reload(null, false);         
        })

        $('#cari_buat').click(function () {     
            tabel_rekon_deb.ajax.reload(null, false);     
        })

        // aksi reset data filter
        $('#reset').click(function () {
            $('#periode').select2("val", 'a');

            tabel_rekon.ajax.reload(null, false);
        })

        $('#reset_buat').click(function () {
            $('#periode_buat').select2("val", 'a');

            tabel_rekon_deb.ajax.reload(null, false);
        })

        $('#buat_rekon').on('click', function () {

            $.ajax({
                url             : "<?= base_url('rekon/tampil_option_periode_buat') ?>",
                type            : "POST",
                beforeSend      : function () {
                    swal({
                        title   : "Menunggu",
                        html    : "Memproses Halaman",
                        onOpen  : () => {
                            swal.showLoading();
                        }
                    })
                },
                dataType        : "JSON",
                success         : function (data) {
                    swal.close();

                    $('#periode_2').removeAttr('hidden');
                    $('#periode_buat').next('.select2-container').show();
                    $('#periode_buat').html(data.periode);

                    tabel_rekon_deb.ajax.reload(null, false);

                    $('#periode_1').hide();
                    $('.list-rekon').hide();
                    $('.list-deb-rekon').removeAttr('hidden');
                    $("#kembali").removeAttr('hidden');

                }
            })

            return false;

        })

        // proses simpan buat rekonsiliasi 
        $('#simpan_buat').click(function () {
            var id_periode = $('#periode_buat').val();

            if (id_periode == 'a') {
                swal(
                    'Peringatan',
                    'Periode harus terisi dahulu',
                    'warning'
                )

                return false;
            } else {

                swal({
                    title       : 'Konfirmasi',
                    text        : 'Yakin akan kirim data!',
                    type        : 'warning',

                    showCancelButton    : true,
                    confirmButtonText   : 'Ya',
                    confirmButtonColor  : '#3085d6',
                    cancelButtonColor   : '#d33',
                    cancelButtonText    : 'Batal',
                    reverseButtons      : true
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url         : "<?= base_url('rekon/simpan_rekon') ?>",
                            type        : "POST",
                            beforeSend  : function () {
                                swal({
                                    title   : 'Menunggu',
                                    html    : 'Memproses halaman',
                                    onOpen  : () => {
                                        swal.showLoading();
                                    }
                                })
                            },
                            data        : {id_periode:id_periode},
                            dataType    : "JSON",
                            success     : function (data) {
                                $('#periode').html(data.periode);

                                tabel_rekon.ajax.reload(null, false);
                                tabel_rekon_deb.ajax.reload(null, false);

                                swal(
                                    'Berhasil',
                                    'Data berhasil disimpan',
                                    'success'
                                )

                                $('#periode_1').show();
                                $('#periode_2').attr('hidden', true);
                                $('.list-rekon').show();
                                $('.list-deb-rekon').attr('hidden', true);
                                $("#kembali").attr('hidden', true);
                            }
                        })

                        return false;

                    } else if (result.dismiss === swal.DismissReason.cancel) {
                        swal(
                            'Batal',
                            'Anda membatalkan tambah rekonsiliasi',
                            'error'
                        )
                    }
                })

                return false;

            }
        })

        // aksi kembali 
        $('#kembali').click(function () {
            $.ajax({
                url         : "<?= base_url('rekon/list_periode_rekon') ?>",
                type        : "POST",
                beforeSend      : function () {
                    swal({
                        title   : "Menunggu",
                        html    : "Memproses Halaman",
                        onOpen  : () => {
                            swal.showLoading();
                        }
                    })
                },
                dataType        : "JSON",
                success         : function () {
                    swal.close();

                    $('#periode').html(data.periode);

                    tabel_rekon.ajax.reload(null, false);

                    $('#periode_1').show();
                    $('#periode_2').attr('hidden', true);
                    $('.list-rekon').show();
                    $('.list-deb-rekon').attr('hidden', true);
                    $("#kembali").attr('hidden', true);

                }
            })

            return false;
        })

    })

</script>