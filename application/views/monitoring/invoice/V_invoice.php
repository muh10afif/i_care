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
            <h4 class="page-title">Invoice</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Monitoring</li>
                        <li class="breadcrumb-item"><a href="<?= base_url('monitoring/invoice') ?>">Invoice</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    <!-- filter data -->
    <div class="row filter-invoice">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-info">
                    <h4 class="mb-0 text-white">Filter Data</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <div class="form-group col-md-6">
                            <div class="row">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row list_invoice">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-info">
                    <button class="btn btn-warning btn-sm float-right" type="button" id="tambah_data">Tambah Data</button>
                    <h4 class="mb-0 text-white">List Invoice</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="tabel_invoice" width="100%">
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
                                <th width="5%">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row filter-tambah-invoice" hidden>
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-info">
                    <h4 class="mb-0 text-white">Filter Data</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <div class="form-group col-md-6">
                            <div class="row">
                                <div class="col-md-2 text-right">
                                    <label class="mt-2">Cabang Asuransi</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <select class="select2 form-control custom-select" name="cabang_asuransi" id="cabang_asuransi" style="width: 70%; height:36px;">  
                                            <option value="a">-- Pilih Cabang Asuransi --</option>
                                            <?php foreach ($cbg_asuransi as $b): ?>
                                                <option value="<?= $b['id_cabang_as'] ?>"><?= $b['cabang_asuransi'] ?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-info" type="button" id="cari_tambah"><i class="fas fa-search"></i></button>
                                            <button class="btn btn-danger" type="button" id="reset_tambah"><i class="fas fa-sync"></i></button>
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

    <div class="row list_invoice_tambah" hidden>
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-info">
                    <button class="btn btn-warning btn-sm float-right" type="button" id="buat_invoice" hidden>Simpan Data</button>
                    <h4 class="mb-0 text-white">List Invoice</h4>
                </div>
                <div class="card-body table-responsive">
                    <div class="d-flex justify-content-center">
                        <div class="col-md-8">
                            <table class="table table-bordered table-hover" id="tabel_invoice_tambah" width="100%">
                                <thead class="bg-info text-white">
                                    <tr>
                                        <th width="10%">No</th>
                                        <th>BAR</th>
                                        <th width="18%">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    
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
        var tabel_invoice = $('#tabel_invoice').DataTable({

            "processing"    : true,
            "serverSide"    : true,
            "order"         : [],
            "ajax"          : {
                "url"   : "<?= base_url("monitoring/tampil_invoice") ?>",
                "type"  : "POST",
                "data"  : function (data) {
                    data.id_periode    = $('#periode').val();
                }
            },
            "columnDefs"    : [{
                "targets"       : [0, 9],
                "orderable"     : false
            }]
        })

        // aksi filter data
        $('#cari').click(function () {
            tabel_invoice.ajax.reload(null, false);                
        })

        // aksi reset data filter
        $('#reset').click(function () {
            $('#periode').select2("val", 'a');
            tabel_invoice.ajax.reload(null, false);
        })

        // load datatables
        var tabel_invoice_tambah = $('#tabel_invoice_tambah').DataTable({

            "processing"    : true,
            "serverSide"    : true,
            "order"         : [],
            "ajax"          : {
                "url"   : "<?= base_url("monitoring/tampil_invoice_tambah") ?>",
                "type"  : "POST",
                "data"  : function (data) {
                    data.id_cabang_asuransi    = $('#cabang_asuransi').val();
                }
            },
            "columnDefs"    : [{
                "targets"       : [0, 2],
                "orderable"     : false
            }]
        })

        // aksi filter data
        $('#cari_tambah').click(function () {
            tabel_invoice_tambah.ajax.reload(null, false);                
        })

        // aksi reset data filter
        $('#reset_tambah').click(function () {
            $('#cabang_asuransi').select2("val", 'a');
            tabel_invoice_tambah.ajax.reload(null, false);
        })

        $('#cabang_asuransi').on('change', function () {
            
            var id_cabang_as  = $(this).val();

            console.log(id_cabang_as);

            if (id_cabang_as != 'a') {
                tabel_invoice_tambah.ajax.reload(null, false);
                $('#buat_invoice').removeAttr('hidden');
            } else {
                tabel_invoice_tambah.ajax.reload(null, false);
                $('#buat_invoice').attr('hidden', true);
                
            }

        })

        // pindah halaman tambah data
        $('#tambah_data').on('click', function () {
            
            $.ajax({
                url             : "<?= base_url('monitoring/tampil_list_cabang_as') ?>",
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

                    $('#cabang_asuransi').html(data.cbg_asuransi);

                    tabel_invoice_tambah.ajax.reload(null, false);

                    $('.filter-invoice').hide();
                    $('.list_invoice').hide();
                    $('.filter-tambah-invoice').removeAttr('hidden');
                    $('.list_invoice_tambah').removeAttr('hidden');
                    $('#kembali').removeAttr('hidden');

                    $('#buat_invoice').attr('hidden', true);

                }
            })

            return false;

        })

        // kembali
        $('#kembali').on('click', function () {

            $.ajax({
                url         : "<?= base_url('monitoring/list_periode_invoice') ?>",
                method      : "POST",
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

                    $('#periode').html(data.periode);

                    tabel_invoice.ajax.reload(null, false);

                    $('.filter-invoice').show();
                    $('.list_invoice').show();
                    $('.filter-tambah-invoice').attr('hidden', true);
                    $('.list_invoice_tambah').attr('hidden', true);
                    $('#kembali').attr('hidden', true);

                }
            })

            return false;

        })

        // simpan invoice
        $('#buat_invoice').on('click', function () {
            
            var pilih_bar = $('input[name="pilih_bar[]"]:checked').map(function () {
                return this.value;
            }).get();
            var id_cabang_as = $('#cabang_asuransi').val();

            console.log(id_cabang_as);

            if (id_cabang_as == 'a') {
                swal(
                    'Peringatan',
                    'Harap pilih cabang asuransi dahulu',
                    'warning'
                )

                return false;
            } else if (pilih_bar == "") {
                swal(
                    'Peringatan',
                    'Harap pilih periode bar dahulu sebelum simpan data',
                    'warning'
                )

                return false;
            } else {
                swal({
                    title       : 'Konfirmasi',
                    text        : 'Yakin akan kirim data',
                    type        : 'warning',

                    showCancelButton    : true,
                    confirmButtonText   : 'Kirim Data',
                    confirmButtonColor  : '#3085d6',
                    cancelButtonColor   : '#d33',
                    cancelButtonText    : 'Batal',
                    reverseButtons      : true
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url         : "<?= base_url('monitoring/proses_tambah_invoice') ?>",
                            method      : "POST",
                            beforeSend  : function () {
                                swal({
                                    title   : 'Menunggu',
                                    html    : 'Memproses Data',
                                    onOpen  : () => {
                                        swal.showLoading();
                                    }
                                })
                            },
                            data        : {id_rekon:pilih_bar, id_cabang_as:id_cabang_as},
                            dataType    : "JSON",
                            success     : function (data) {
                                $('#periode').html(data.periode);

                                tabel_invoice.ajax.reload(null, false);

                                swal(
                                    'Tambah Invoice',
                                    'Data Berhasil Disimpan',
                                    'success'
                                )

                                $('.filter-invoice').show();
                                $('.list_invoice').show();
                                $('.filter-tambah-invoice').attr('hidden', true);
                                $('.list_invoice_tambah').attr('hidden', true);
                                $('#kembali').attr('hidden', true);
                            },
                            error       : function(xhr, status, error) {
                                var err = eval("(" + xhr.responseText + ")");
                                alert(err.Message);
                            }

                        })

                        return false;
                    } else if (result.dismiss === swal.DismissReason.cancel) {
                        swal(
                            'Batal',
                            'Anda membatalkan tambah invoice',
                            'error'
                        )
                    }
                })
            }

        })

        // 05-04-2021
        $('#tabel_invoice').on('click', '.hapus', function () {
            
            var id_rekon = $(this).data('id');

            swal({
                title       : 'Konfirmasi',
                text        : 'Yakin akan hapus data?',
                type        : 'warning',

                showCancelButton    : true,
                confirmButtonText   : 'Ya, hapus',
                confirmButtonColor  : '#d33',
                cancelButtonColor   : '#3085d6',
                cancelButtonText    : 'Batal',
                reverseButtons      : true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url         : "<?= base_url('monitoring/hapus_invoice') ?>",
                        method      : "POST",
                        beforeSend  : function () {
                            swal({
                                title   : 'Menunggu',
                                html    : 'Memproses Data',
                                onOpen  : () => {
                                    swal.showLoading();
                                }
                            })
                        },
                        data        : {id_rekon:id_rekon},
                        dataType    : "JSON",
                        success     : function (data) {
                            $('#periode').html(data.periode);

                            tabel_invoice.ajax.reload(null, false);

                            swal(
                                'Hapus Invoice',
                                'Data Berhasil Disimpan',
                                'success'
                            )
                        },
                        error       : function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            alert(err.Message);
                        }

                    })

                    return false;
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal(
                        'Batal',
                        'Anda membatalkan hapus invoice',
                        'error'
                    )
                }
            })

        })

    })

</script>