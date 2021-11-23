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
            <h4 class="page-title">Periode </h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Periode </li>
                        <li class="breadcrumb-item"><a href="<?= base_url('rekon/periode') ?>">Input Periode </a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row list-periode-rekon">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-info">
                    <button class="btn btn-warning btn-sm float-right" id="tambah_periode_rekon" type="button">Tambah Data</button>
                    <h4 class="mb-0 text-white">List Periode Rekonsiliasi</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="tabel_periode_rekon" width="100%">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>No</th>
                                <th>Periode Rekonsiliasi</th>
                                <th>Tanggal Bayar Awal</th>
                                <th>Tanggal Bayar Akhir</th>
                                <th>Cabang Asuransi</th>
                                <th>Bank</th>
                                <th>Cabang Bank</th>
                                <th>Created At</th>
                                <th>Created By</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="row hal-tambah-data" hidden>
        <div class="col-md-5">
            <div class="row">
                
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header bg-info">
                            <h4 class="mb-0 text-white">List Periode</h4>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="form-group col-md-7">
                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <label class="mt-2">Periode</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                    <input type="text" class="form-control datepicker-bulan" id="bln_periode" placeholder="Pilih Periode" readonly>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                    </div>
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning" type="button" id="tambah_m_periode">Tambah</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered table-hover" id="tabel_periode" width="100%">
                                <thead class="bg-info text-white">
                                    <tr>
                                        <th>No</th>
                                        <th>Periode</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card shadow">
                <div class="card-header bg-info">
                    <h4 class="mb-0 text-white">Form Tambah Periode Rekonsiliasi</h4>
                </div>
                <div class="card-body table-responsive">
                    <div class="d-flex justify-content-center mb-3">
                        <div class="form-group col-md-7">
                            <div class="row" id="list_periode">
                                <div class="col-md-4 text-right">
                                    <label class="mt-2">Bulan Periode</label>
                                </div>
                                <div class="col-md-5">
                                    <select class="select2 form-control custom-select" name="pil_periode" id="pil_periode" style="width: 100%; height:36px;">  
                                        <option value="a">-- Pilih Periode --</option>
                                        <?php foreach ($periode as $a): ?>
                                            <option value="<?= $a['id_periode'] ?>"><?= $a['nama_periode'] ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-sm btn-warning mt-1" id="buat_periode">Buat Periode</button>
                                </div>
                            </div>
                            <div class="row" id="list_periode_buat" hidden>
                                <div class="col-md-4 text-right">
                                    <label class="mt-2">Bulan Periode</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker-bulan" id="bln_periode" placeholder="Pilih Periode" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4 text-right">
                                    <label class="mt-2">Tanggal Awal Bayar</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" id="tgl_awal_byr" placeholder="Tanggal Awal Bayar" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4 text-right">
                                    <label class="mt-2">Tanggal Akhir Bayar</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" id="tgl_akhir_byr" placeholder="Tanggal Akhir Bayar" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4 text-right">
                                    <label class="mt-2">Cabang Asuransi</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="select2 form-control custom-select" name="cab_asuransi" id="cab_asuransi" style="width: 100%; height:36px;"> 
                                        <option value="a">-- Pilih Cabang Asuransi --</option>
                                        <?php foreach ($cab_asuransi as $a): ?>
                                            <option value="<?= $a['id_cabang_asuransi'] ?>"><?= $a['cabang_asuransi'] ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4 text-right">
                                    <label class="mt-2">Cabang Bank</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="select2 form-control custom-select" name="cab_bank" id="cab_bank" style="width: 100%; height:36px;"> 
                                        <option value="a">-- Pilih Cabang Bank --</option>
                                        <?php foreach ($cab_bank as $a): ?>
                                            <option value="<?= $a['id_cabang_bank'] ?>"><?= $a['cabang_bank'] ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success btn-sm float-right" id="simpan_buat_rekon" type="button">Simpan</button>
                </div>
            </div>
        </div>
    </div> -->

    <div class="align-items-center col-md-2" id="kembali" hidden>
        <button class="btn btn-warning btn-round ml-auto">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </button>
    </div>
</div>

<!-- modal tambah periode rekon -->
<div id="modal_tambah_periode_rekon" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title text-white" id="vcenter">Tambah Periode Rekonsiliasi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center mb-3">
                        <div class="form-group col-md-8">
                            <div class="row mt-3" id="list_periode">
                                <div class="col-md-4 ">
                                    <label class="mt-2">Bulan Periode</label>
                                </div>
                                <div class="col-md-5">
                                    <select class="select2 form-control custom-select" name="pil_periode" id="pil_periode" style="width: 100%; height:36px;">  
                                        <option value="a">-- Pilih Periode --</option>
                                        <?php foreach ($periode as $a): ?>
                                            <option value="<?= $a['id_periode'] ?>"><?= nice_date($a['nama_periode'], 'F Y') ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-sm btn-warning mt-1" data-toggle="tooltip" data-placement="top" title="Tekan ini, bila list pilihan bulan periode tidak ada!" id="buat_periode" type="button">Buat Periode</button>
                                </div>
                            </div>
                            <div class="row mt-3" id="list_periode_buat" hidden>
                                <div class="col-md-4 ">
                                    <label class="mt-2">Bulan Periode</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group d_bulan">
                                        <input type="text" class="form-control datepicker-bulan" id="bln_periode" placeholder="Pilih Periode" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4 ">
                                    <label class="mt-2">Tanggal Awal Bayar</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" id="tgl_awal_byr" placeholder="Tanggal Awal Bayar" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4 ">
                                    <label class="mt-2">Tanggal Akhir Bayar</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" id="tgl_akhir_byr" placeholder="Tanggal Akhir Bayar" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4 ">
                                    <label class="mt-2">Cabang Asuransi</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="select2 form-control custom-select" name="cab_asuransi" id="cab_asuransi" style="width: 100%; height:36px;"> 
                                        <option value="a">-- Pilih Cabang Asuransi --</option>
                                        <?php foreach ($cab_asuransi as $a): ?>
                                            <option value="<?= $a['id_cabang_asuransi'] ?>"><?= $a['cabang_asuransi'] ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4 ">
                                    <label class="mt-2">Cabang Bank</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="select2 form-control custom-select" name="cab_bank" id="cab_bank" style="width: 100%; height:36px;"> 
                                        <option value="a">-- Pilih Cabang Bank --</option>
                                        
                                    </select>

                                    <div id="loading_cab_bank" style="margin-top: 10px;" align='center'>
                                        <img src="<?= base_url('template/img/loading.gif') ?>" width="18"> <small>Loading...</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-sm float-right" type="button" id="buat_periode_rekon">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>template/assets/libs/jquery/dist/jquery.min.js"></script>

<script>

$(document).ready(function () {

    // load datatable 
    var tabel_periode_rekon = $('#tabel_periode_rekon').DataTable({
        "processing"    : true,
        "serverSide"    : true,
        "order"         : [],
        "ajax"          : {
            "url"           : "<?= base_url("rekon/tampil_periode_rekon") ?>",
            "type"          : "POST"
        },
        "columnDefs"    : [{
            "targets"       : [0],
            "orderable"     : false          
        }]
    })

    var tabel_periode = $('#tabel_periode').DataTable({
        "processing"    : true,
        "serverSide"    : true,
        "order"         : [],
        "ajax"          : {
            "url"           : "<?= base_url("rekon/tampil_periode") ?>",
            "type"          : "POST"
        },
        "columnDefs"    : [{
            "targets"       : [0],
            "orderable"     : false          
        }]
    })

    $('#tambah_periode_rekon').click(function () {
        
        $.ajax({
            url         : "<?= base_url('rekon/list_periode') ?>",
            method      : "POST",
            beforeSend  : function () {
                swal({
                    title   : 'Menunggu',
                    html    : 'Memproses Halaman',
                    onOpen  : () => {
                        swal.showLoading();
                    }
                })
            },
            dataType    : "JSON",
            success     : function (data) {
                swal.close();

                $('#modal_tambah_periode_rekon').modal('show');
                $('#list_periode').show();
                $('#list_periode_buat').attr('hidden', true);

                $('#pil_periode').html(data.periode);

                $('#pil_periode').select2('val', 'a');
                //$('.datepicker-bulan').data('datepicker').setDate(null);
                $('#bln_periode').datepicker('setDate', null);
                $('#tgl_awal_byr').datepicker('setDate', null);
                $('#tgl_akhir_byr').datepicker('setDate', null);
                $('#cab_asuransi').select2('val', 'a');
                $('#cab_bank').select2('val', 'a');

            }
        })
        
        return false;
        
    })

    $('#tambah_m_periode').click(function () {
        var bln_periode = $('#bln_periode').val();

        $.ajax({
            url         : "<?= base_url('master/input_m_periode') ?>",
            method      : "POST",
            beforeSend  : function () {
                swal({
                    title   : 'Menunggu',
                    html    : 'Memproses Halaman',
                    onOpen  : () => {
                        swal.showLoading();
                    }
                })
            },
            data        : {bln_periode:bln_periode},
            success     : function (data) {
                tabel_periode.ajax.reload(null, false);

                swal(
                    'Tambah Periode',
                    'Data Berhasil Disimpan',
                    'success'
                )

                $('.datepicker-bulan').datepicker('setDate', null);

            }
        })
        
        return false;
    })

    // kembali
    $('#kembali').on('click', function () {

        $.ajax({
            beforeSend  : function () {
                swal({
                    title   : 'Menunggu',
                    html    : 'Memproses halaman',
                    onOpen  : () => {
                        swal.showLoading();
                    }
                })
            },
            success     : function () {
                swal.close();

                tabel_periode_rekon.ajax.reload(null, false);

                $('.list-periode-rekon').show()
                $('.hal-tambah-data').attr("hidden", true);
                $('#kembali').attr("hidden", true);
            }
        })

    })

    $('#loading_cab_bank').hide();

    $('#cab_asuransi').on('change', function () {
        var id_cab_asuransi = $("#cab_asuransi").val();

        $('#cab_bank').next('.select2-container').hide();
        $('#loading_cab_bank').show();

        $.ajax({
            url         : "<?= base_url('rekon/ambil_cabang_bank') ?>",
            type        : "POST",
            beforeSend 	: function (e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charshet=UTF-8");
                }				
            },
            data        : {id_cab_asuransi:id_cab_asuransi},
            dataType    : "JSON",
            success     : function (data) {
                $('#loading_cab_bank').hide();
                $('#cab_bank').next('.select2-container').show();
                $('#cab_bank').html(data.cabang_bank);
            },
            error 		: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

    $('#buat_periode').click(function () {
        $('#list_periode').hide();
        $('#list_periode_buat').removeAttr('hidden');
    })

    $('#buat_periode_rekon').click(function () {

        var pil_periode     = $('#pil_periode').val();
        var bln_periode     = $('#bln_periode').val();
        var tgl_awal_byr    = $('#tgl_awal_byr').val();
        var tgl_akhir_byr   = $('#tgl_akhir_byr').val();
        var cab_asuransi    = $('#cab_asuransi').val();
        var cab_bank        = $('#cab_bank').val();

        if (bln_periode != '') {
            $.ajax({
                url         : "<?= base_url('rekon/cek_bln_periode') ?>",
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
                data        : {bln_periode:bln_periode},
                dataType    : "JSON",
                success     : function (data) {
                    
                    if (data.hasil != 0) {
                        swal(
                            'Peringatan',
                            'Bulan Periode Sudah Ada',
                            'warning'
                        )

                        $('.datepicker-bulan').datepicker("setDate", null);
                        $('#list_periode').show();
                        $('#list_periode_buat').attr('hidden', true);

                        return false;
                    } else {

                        if (bln_periode == 'a') {
                            swal(
                                'Peringatan',
                                'Pilih dahulu bulan periode',
                                'warning'
                            )

                            return false;
                        } else if(tgl_awal_byr == '') {
                            swal(
                                'Peringatan',
                                'Pilih dahulu tanggal awal bayar',
                                'warning'
                            )

                            return false;
                        } else if(tgl_akhir_byr == '') {
                            swal(
                                'Peringatan',
                                'Pilih dahulu tanggal akhir bayar',
                                'warning'
                            )

                            return false;
                        } else if(cab_asuransi == 'a') {
                            swal(
                                'Peringatan',
                                'Pilih dahulu cabang asuransi',
                                'warning'
                            )

                            return false;
                        } else if(cab_bank == 'a') {
                            swal(
                                'Peringatan',
                                'Pilih dahulu cabang bank',
                                'warning'
                            )

                            return false;
                        } else {

                            // awal

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
                                        url         : "<?= base_url('rekon/tambah_data_periode_rekon/2') ?>",
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
                                        data        : {bln_periode:bln_periode, tgl_awal_byr:tgl_awal_byr, tgl_akhir_byr:tgl_akhir_byr, cab_asuransi:cab_asuransi, cab_bank:cab_bank},
                                        success     : function (data) {
                                            tabel_periode_rekon.ajax.reload(null, false);

                                            swal(
                                                'Berhasil',
                                                'Data berhasil disimpan',
                                                'success'
                                            )

                                            $('#modal_tambah_periode_rekon').modal('hide');

                                            $('#pil_periode').select2('val', 'a');
                                            $('.datepicker-bulan').datepicker("setDate", null);
                                            $('.datepicker').datepicker("setDate", null);
                                            $('#cab_asuransi').select2('val', 'a');
                                            $('#cab_bank').select2('val', 'a');

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

                            // akhir

                        }

                    }

                },
                error       : function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }

            })

            return false;
        } else {

            if (pil_periode == 'a') {
                swal(
                    'Peringatan',
                    'Pilih dahulu bulan periode',
                    'warning'
                )

                return false;
            }  else if(tgl_awal_byr == '') {
                swal(
                    'Peringatan',
                    'Pilih dahulu tanggal awal bayar',
                    'warning'
                )

                return false;
            } else if(tgl_akhir_byr == '') {
                swal(
                    'Peringatan',
                    'Pilih dahulu tanggal akhir bayar',
                    'warning'
                )

                return false;
            } else if(cab_asuransi == 'a') {
                swal(
                    'Peringatan',
                    'Pilih dahulu cabang asuransi',
                    'warning'
                )

                return false;
            } else if(cab_bank == 'a') {
                swal(
                    'Peringatan',
                    'Pilih dahulu cabang bank',
                    'warning'
                )

                return false;
            }  else {

                // awal

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
                            url         : "<?= base_url('rekon/tambah_data_periode_rekon/1') ?>",
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
                            data        : {pil_periode:pil_periode, bln_periode:bln_periode, tgl_awal_byr:tgl_awal_byr, tgl_akhir_byr:tgl_akhir_byr, cab_asuransi:cab_asuransi, cab_bank:cab_bank},
                            success     : function (data) {
                                tabel_periode_rekon.ajax.reload(null, false);

                                swal(
                                    'Berhasil',
                                    'Data berhasil disimpan',
                                    'success'
                                )

                                $('#modal_tambah_periode_rekon').modal('hide');

                                $('#pil_periode').select2('val', 'a');
                                $('.datepicker-bulan').datepicker("setDate", null);
                                $('.datepicker').datepicker("setDate", null);
                                $('#cab_asuransi').select2('val', 'a');
                                $('#cab_bank').select2('val', 'a');

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
                            'Anda membatalkan update bayar',
                            'error'
                        )
                    }
                })

                // akhir

            }

            
        }

        

    })

})

</script>
