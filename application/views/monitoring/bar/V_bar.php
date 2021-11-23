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
            <h4 class="page-title">Bar</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Monitoring</li>
                        <li class="breadcrumb-item"><a href="<?= base_url('recoveries') ?>">Bar</a></li>
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

    <div class="row list_bar">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-info">
                    <button class="btn btn-warning btn-sm float-right" type="button" id="tambah_data">Tambah Data</button>
                    <h4 class="mb-0 text-white">List Bar</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="tabel_periode" width="100%">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>No</th>
                                <th>Periode</th>
                                <th>Asuransi</th>
                                <th>Bank</th>
                                <th>Cabang Bank</th>
                                <th>BAR</th>
                                <th>TTD</th>
                                <th>Created At</th>
                                <th>Created By</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row list_bar_tambah" hidden>
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-info">
                    <button class="btn btn-warning btn-sm float-right" type="button" id="buat_bar" hidden>Simpan Data</button>
                    <h4 class="mb-0 text-white">List Bar</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="tabel_periode_bar" width="100%">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>No</th>
                                <th>Periode</th>
                                <th>Asuransi</th>
                                <th>Bank</th>
                                <th>Cabang Bank</th>
                                <th>BAR</th>
                                <th width="18%">Aksi</th>
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

    
<!-- modal ttd bar -->
<div id="modal_upload_ttd_bar" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title text-white" id="vcenter">Upload TTD Bar</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form id="form_upload_ttd_bar" autocomplete="off" method="post">
                <input type="hidden" name="id_rekon" id="id_rekon">
                <input type="hidden" name="nm_foto" id="nm_foto" value="kosong">
                <div class="modal-body">
                    <div class="row" style="margin-top: 15px">
                        <label class="col-12">Foto TTD Bar</label>
                        <div class="col-md-12 align-items-center">
                            <input type="file" id="foto" class="dropify" name="foto">
                        </div>
                    </div>    
                </div>
                <div class="modal-footer">
                    
                    <button class="btn btn-warning" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success" type="submit" id="simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>

<script src="<?= base_url() ?>template/assets/libs/jquery/dist/jquery.min.js"></script>

<script>

    $(document).ready(function () {

        $('.dropify').dropify({
            messages: {
                default: 'Drag atau drop untuk memilih gambar',
                replace: 'Ganti',
                remove:  'Hapus',
                error:   'error'
            }
        });

        $('#simpan').on('click', function () {
            if ($('#nm_foto').val() == 'kosong') {
                swal(
                    'Peringatan',
                    'Foto TTD Bar Harus Terisi',
                    'warning'
                )

                return false;
            }
        });

        // proses tambah tdd bar
        $('#form_upload_ttd_bar').on('submit', function () {

            $.ajax({
                url         : "<?= base_url('monitoring/upload_ttd_bar') ?>",
                type        : "post",
                data        : new FormData(this),
                processData : false,
                contentType : false,
                cache       : false,
                async       : false,
                dataType    : "JSON",
                success     : function (data) {

                    if (data.hasil == 1) {

                        tabel_periode.ajax.reload(null, false);

                        swal(
                            'Upload TTD Bar',
                            'Anda berhasil upload TTD bar',
                            'success'
                        )

                        $('#modal_upload_ttd_bar').modal('hide');

                        var drEvent = $('.dropify').dropify();
                        drEvent = drEvent.data('dropify');
                        drEvent.resetPreview();
                        drEvent.clearElement();

                    } else {
                        
                        swal(
                            'Gagal',
                            'Data tidak berhasil diupload',
                            'error'
                        ) 

                        $('#modal_upload_ttd_bar').modal('hide');

                        return false;
                    }
                    
                }
            })

            return false;

        })

        // menampilkan modal upload ttd bar
        $('#tabel_periode').on('click', '.upload-bar', function () {
            var id_rekon = $(this).data('id');

            console.log(id_rekon);

            $('#id_rekon').val(id_rekon);

            $('#modal_upload_ttd_bar').modal('show');

            var drEvent = $('.dropify').dropify();
            drEvent = drEvent.data('dropify');
            drEvent.resetPreview();
            drEvent.clearElement();

            $('#foto').change(function() {
                var foto = $('#foto').val();

                var nm_foto = $('#nm_foto').val(foto);         

            });

        })
        
        // load datatables
        var tabel_periode = $('#tabel_periode').DataTable({

            "processing"    : true,
            "serverSide"    : true,
            "order"         : [],
            "ajax"          : {
                "url"   : "<?= base_url("monitoring/tampil_periode_bar") ?>",
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

        var tabel_periode_bar = $('#tabel_periode_bar').DataTable({

            "processing"    : true,
            "serverSide"    : true,
            "order"         : [],
            "ajax"          : {
                "url"   : "<?= base_url("monitoring/tampil_periode_bar/buat") ?>",
                "type"  : "POST",
                "data"  : function (data) {
                    data.id_periode    = $('#periode').val();
                }
            },
            "columnDefs"    : [{
                "targets"       : [0, 6],
                "orderable"     : false
            }]
        })

        // aksi filter data
        $('#cari').click(function () {
            tabel_periode.ajax.reload(null, false);            
            tabel_periode_bar.ajax.reload(null, false);            
        })

        // aksi reset data filter
        $('#reset').click(function () {
            $('#periode').select2("val", 'a');
            tabel_periode.ajax.reload(null, false);
            tabel_periode_bar.ajax.reload(null, false);
        })

        // tambah data
        $('#tambah_data').on('click', function () {

            $.ajax({
                url             : "<?= base_url('monitoring/option_periode_bar/buat') ?>",
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

                    $('#periode').html(data.periode);

                    tabel_periode_bar.ajax.reload(null, false);

                    $('.list_bar').hide();
                    $('.list_bar_tambah').removeAttr('hidden');
                    $('#kembali').removeAttr('hidden');

                    $('#buat_bar').attr('hidden', true);
                }
            })

            return false;
        })

        // kembali
        $('#kembali').on('click', function () {

            $.ajax({
                url             : "<?= base_url('monitoring/option_periode_bar/lihat') ?>",
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

                    $('#periode').html(data.periode);

                    tabel_periode.ajax.reload(null, false);

                    $('.list_bar').show();
                    $('.list_bar_tambah').attr('hidden', true);
                    $('#kembali').attr('hidden', true);

                }
            })

            return false;

        })

        $('#tabel_periode_bar').on('click', '.pilih_bar', function () {
            var pilih_bar = $('input[name="pilih_bar[]"]:checked').map(function () {
                return this.value;
            }).get();

            if(pilih_bar != "") 
            {
                $('#buat_bar').removeAttr('hidden');
            } else {
                $('#buat_bar').attr('hidden', true);
            }
        })

        // buat bar 
        $('#buat_bar').on('click', function () {
            
            var pilih_bar = $('input[name="pilih_bar[]"]:checked').map(function () {
                return this.value;
            }).get();

            if (pilih_bar == "") {
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
                            url         : "<?= base_url('monitoring/proses_tambah_bar') ?>",
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
                            data        : {pilih_bar:pilih_bar},
                            dataType    : "JSON",
                            success     : function (data) {
                                $('#periode').html(data.periode);

                                tabel_periode.ajax.reload(null, false);

                                swal(
                                    'Tambah Bar',
                                    'Data Berhasil Disimpan',
                                    'success'
                                )

                                $('.list_bar').show();
                                $('.list_bar_tambah').attr('hidden', true);
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
                            'Anda membatalkan tambah bar',
                            'error'
                        )
                    }
                })
            }

        })

        // 05-04-2021
        $('#tabel_periode').on('click', '.hapus', function () {
            
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
                        url         : "<?= base_url('monitoring/hapus_bar') ?>",
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

                            tabel_periode.ajax.reload(null, false);

                            swal(
                                'Hapus Bar',
                                'Data Berhasil Disimpan',
                                'success'
                            )

                            $('.list_bar').show();
                            $('.list_bar_tambah').attr('hidden', true);
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
                        'Anda membatalkan hapus bar',
                        'error'
                    )
                }
            })

        })

    })

</script>