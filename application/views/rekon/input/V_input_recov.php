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
            <h4 class="page-title">Input Recoveries</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Rekonsiliasi</li>
                        <li class="breadcrumb-item"><a href="<?= base_url('recoveries') ?>">Input Recoveries</a></li>
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

                        <!-- bank -->
                        <div class="col-md-4 mr-3">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3 ">
                                        <label class="mt-2">Bank</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="select2 form-control custom-select" name="bank" id="bank" style="width: 100%; height:36px;">  
                                            <option value="a">-- Pilih Bank --</option>
                                            <?php foreach ($bank as $b): ?>
                                                <option value="<?= $b['id_bank'] ?>"><?= $b['bank'] ?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- cabang bank -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3 ">
                                        <label class="mt-2">Cabang Bank</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <select class="select2 form-control custom-select" name="cabang_bank" id="cabang_bank" style="width: 100%; height:36px;">  
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

                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                            <button class="btn btn-info btn-sm mr-3" type="button" id="cari"><i class="fas fa-search mr-2"></i>Tampilkan</button>
                            <button class="btn btn-danger btn-sm" type="button" id="reset"><i class="fas fa-sync mr-2"></i>Reset</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
     
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-info">
                    <button class="btn btn-warning btn-sm float-right" id="button_upload" data-toggle="modal" data-target=".bs-example-modal-lg">Upload Data</button>
                    <h4 class="mb-0 text-white">List Debitur</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="tabel_debitur_r" width="100%">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Deal Reff</th>
                                <th>Asuransi</th>
                                <th>Bank</th>
                                <th>Cabang Bank</th>
                                <th>SHS</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bs-example-modal-lg" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h4 class="modal-title" id="myLargeModalLabel">Upload Data</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('rekon/input_recov_import') ?>" id="import_form" method="POST" enctype="multipart/form-data">
                    <div class="row mt-3 m-10 ">
                        <div class="col-md-8 offset-md-2">
                            <div class="form-group row">
                                <label class="col-sm-2 control-label">File</label>
                                <div class="col-sm-7">
                                    <input type="file" name="upload" id="upload" class="form-control" accept=".xls,.xlsx">
                                </div>
                                <div class="col-sm-3 text-right">
                                    <a href="<?= base_url('excel/format_input_recov.xlsx') ?>"><button class="btn btn-success btn-sm" type="button">Download Format</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                

                <div class="tabel_preview">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info waves-effect text-left mr-2" id="simpan_upload">Simpan</button>
                <button type="button" class="btn btn-secondary waves-effect text-left" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- modal update bayar -->
<div id="modal_update_bayar" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title text-white" id="vcenter">Update Bayar</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form id="form_update_bayar" autocomplete="off">

                <input type="hidden" id="id_deb" name="id_deb">
                <div class="modal-body">

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">Nama Debitur</label>
                                <div class="col-sm-9">
                                <p class="form-control-static" id="nama_deb"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-3 control-label col-form-label">Tanggal Bayar</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" name="tgl_bayar" id="tgl_bayar" placeholder="Tanggal Bayar" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="recov" class="col-sm-3 control-label col-form-label">Recoveries</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div> 
                                        <input type="text" class="form-control separator" name="recov" id="recov" placeholder="Masukkan Recoveries">
                                        
                                        <div class="input-group-append">
                                            <span class="input-group-text font-weight-bold">,</span>
                                            <input type="text" class="form-control angka" name="koma" id="koma" placeholder="0" size="8">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="no_rek" class="col-sm-3 control-label col-form-label">No Rekening</label>
                                <div class="col-sm-9">
                                    <!-- <input type="text" class="form-control angka" name="no_rek" id="no_rek" placeholder="Masukkan No Rekening"> -->
                                    <select class="select2 form-control custom-select" name="no_rek" id="no_rek" style="width: 100%; height:36px;">  
                                        <option value="">-- Pilih Rekening --</option>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" id="simpan_update_bayar">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal detail bayar -->
<div id="modal_detail_bayar" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" id="histori">
            
        </div>
    </div>
</div>

<script src="<?= base_url() ?>template/assets/libs/jquery/dist/jquery.min.js"></script>

<script>

$(document).ready(function () {

    $('#simpan_upload').on('click', function () {

        swal({
            title       : 'Konfirmasi',
            text        : 'Yakin akan kirim data',
            type        : 'warning',

            buttonsStyling      : false,
            confirmButtonClass  : "btn btn-info",
            cancelButtonClass   : "btn btn-danger mr-3",

            showCancelButton    : true,
            confirmButtonText   : 'Kirim Data',
            confirmButtonColor  : '#d33',
            cancelButtonColor   : '#3085d6',
            cancelButtonText    : 'Batal',
            reverseButtons      : true
        }).then((result) => {
            if (result.value) {
                var im_form = document.querySelector("#import_form");

                $.ajax({
                    url             : "<?= base_url('rekon/input_recov_import/2') ?>",
                    method          : "POST",
                    beforeSend  : function () {
                        swal({
                            title   : 'Menunggu',
                            html    : 'Memproses halaman',
                            onOpen  : () => {
                                swal.showLoading();
                            }
                        })
                    },
                    data            : new FormData(im_form),
                    contentType     : false,
                    cache           : false,
                    processData     : false,
                    success     : function (data) {
                        $('#modal_upload').modal('hide');

                        swal({
                            title               : "Berhasil",
                            text                : 'Data berhasil disimpan',
                            buttonsStyling      : false,
                            confirmButtonClass  : "btn btn-success",
                            type                : 'success',
                            showConfirmButton   : false,
                            timer               : 1000
                        });

                    }
                })

                return false;
            } else if (result.dismiss === swal.DismissReason.cancel) {

                swal({
                        title               : 'Batal',
                        text                : 'Anda membatalkan upload data',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 1000
                    }); 
            }
        })

    })

    $('#button_upload').on('click', function () {
        $('#upload').val('');
        $('.tabel_preview').hide();
        $('#simpan_upload').hide();
    })

    $('#upload').on('change', function () {
        
        var im_form = document.querySelector("#import_form");

        var form    = new FormData(im_form);

        console.log(form);

        $.ajax({
            url             : "<?= base_url('rekon/input_recov_import/1') ?>",
            method          : "POST",
            beforeSend  : function () {
                swal({
                    title   : 'Menunggu',
                    html    : 'Memproses data',
                    onOpen  : () => {
                        swal.showLoading();
                    }
                })
            },
            data            : new FormData(im_form),
            contentType     : false,
            cache           : false,
            processData     : false,
            success         : function (data) {
                swal.close();

                $('.tabel_preview').show();
                $('#simpan_upload').show();
                
                $('.tabel_preview').html(data);

                console.log(data);
                
            }

        })

        return false;

    })
    
    // load datatables
    var tabel_debitur_r = $('#tabel_debitur_r').DataTable({

        "processing"    : true,
        "serverSide"    : true,
        "order"         : [],
        "ajax"          : {
            "url"   : "<?= base_url("rekon/tampil_debitur_recov") ?>",
            "type"  : "POST",
            "data"  : function (data) {
                data.id_bank        = $('#bank').val();
                data.id_cabang_bank = $('#cabang_bank').val();
            }
        },
        "columnDefs"    : [{
            "targets"       : [0, 5],
            "orderable"     : false
        }]
    })

    // aksi filter data
    $('#cari').click(function () {
        tabel_debitur_r.ajax.reload(null, false);            
    })

    // aksi reset data filter
    $('#reset').click(function () {
        $('#bank').select2("val", 'a');
        $('#cabang_bank').select2("val", 'a');
        tabel_debitur_r.ajax.reload(null, false);
    })

    // histori bayar 
    $('#tabel_debitur_r').on('click', '.detail-bayar', function () {

        var id_debitur = $(this).data('id');

        $.ajax({
            url         : "<?= base_url('rekon/form_detail_bayar') ?>",
            type        : "POST",
            beforeSend  : function () {
                swal({
                    title   : 'Menunggu',
                    html    : 'Memproses data',
                    onOpen  : () => {
                        swal.showLoading();
                    }
                })
            },
            data        : {id_debitur:id_debitur},
            success     : function (data) {
                swal.close();

                $('#modal_detail_bayar').modal('show');
                $('#histori').html(data);
            }
        })

        
    })

    // update bayar
    $('#tabel_debitur_r').on('click', '.update-bayar', function () {

        var id_debitur = $(this).data('id');

        $('#recov').val('');
        $('#no_rek').val('');
        $('#koma').val('');
        $('.datepicker').datepicker('setDate', null);

        $.ajax({
            url         : "<?= base_url('master/ambil_nama_deb') ?>",
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
            data        : {id_debitur:id_debitur},
            dataType    : "JSON",
            success     : function (data) {
                swal.close();

                $('#modal_update_bayar').modal('show');

                $('#id_deb').val(id_debitur);

                $('#nama_deb').html(data.nm_deb);

                $('#no_rek').html(data.cabang_as);

                $('#simpan_update_bayar').on('click', function () {

                    var tgl_bayar   = $('#tgl_bayar').val();
                    var recov       = $('#recov').val();
                    var no_rek      = $('#no_rek').val();

                    if (tgl_bayar == '') {
                        swal(
                            'Peringatan',
                            'Tanggal Bayar Harus Terisi',
                            'warning'
                        )

                        return false;
                    } else if (recov == '') {
                        swal(
                            'Peringatan',
                            'Recoveries Harus Terisi',
                            'warning'
                        )

                        return false;
                    } else if (no_rek == '') {
                        swal(
                            'Peringatan',
                            'No rekening Harus Terisi',
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
                                    url         : "<?= base_url('master/update_bayar') ?>",
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
                                    data        : $('#form_update_bayar').serialize(),
                                    success     : function (data) {
                                        tabel_debitur_r.ajax.reload(null, false);

                                        swal({
                                            title               : "Berhasil",
                                            text                : 'Data berhasil disimpan',
                                            buttonsStyling      : false,
                                            confirmButtonClass  : "btn btn-success",
                                            type                : 'success',
                                            showConfirmButton   : false,
                                            timer               : 1000
                                        });

                                        $('#modal_update_bayar').modal('hide');

                                        $('#recov').val('');
                                        $('#no_rek').val('');
                                        $('.datepicker').datepicker('setDate', null);

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
                })

            },
            error       : function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.Message);
            }

        })

        return false;
        
    })

    $('#loading_cab_bank').hide();

    $('#bank').change(function () {
        var id_bank = $(this).find('option:selected').val();

        $('#cabang_bank').next('.select2-container').hide();
        $('#loading_cab_bank').show();

        $.ajax({
            url         : "<?= base_url('master/ambil_cabang_bank') ?>",
            type        : "POST",
            beforeSend 	: function (e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charshet=UTF-8");
                }				
            },
            data        : {id_bank:id_bank},
            dataType    : "JSON",
            success     : function (data) {
                $('#loading_cab_bank').hide();
                $('#cabang_bank').next('.select2-container').show();
                $('#cabang_bank').html(data.cabang_bank);

                $('#capem_bank').html(data.option1);
            },
            error 		: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

})

</script>