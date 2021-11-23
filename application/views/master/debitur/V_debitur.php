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
            <h4 class="page-title">Master Debitur</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item"><a href="<?= base_url('master') ?>">Debitur</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

<!-- filter data -->
    <div class="row filter_data">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-info">
                    <h4 class="mb-0 text-white">Filter Data</h4>
                </div>
                <form action="<?= base_url('master/unduh_excel_debitur') ?>" method="post">
                    <div class="card-body">
                        <div class="d-flex justify-content-center m-10">

                            <!-- spk -->
                            <div class="col-md-4 mr-3">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3 ">
                                            <label class="mt-2">SPK</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="select2 form-control custom-select" name="spk3" id="spk3" style="width: 100%; height:36px;">  
                                                <option value="a">-- Pilih SPK --</option>
                                                <?php foreach ($no_spk as $b): ?>
                                                    <option value="<?= $b['id_spk'] ?>"><?= $b['no_spk'] ?></option>
                                                <?php endforeach;?>
                                                <option value="null">NO SPK</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- bank -->
                            <div class="col-md-4 mr-3">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3 ">
                                            <label class="mt-2">Bank</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="select2 form-control custom-select" name="bank" id="bank3" style="width: 100%; height:36px;">  
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
                                                <select class="select2 form-control custom-select" name="cabang_bank" id="cabang_bank3" style="width: 100%; height:36px;">  
                                                    <option value="a">-- Pilih Cabang Bank --</option>
                                                    
                                                </select>
                                                <div id="loading_cab_bank3" style="margin-top: 10px;" align='center'>
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
                                <button class="btn btn-warning btn-sm mr-3" type="submit" id="unduh_excel"><i class="fas fa-file-excel mr-2"></i>Unduh Excel</button>
                                <button class="btn btn-danger btn-sm" type="button" id="reset"><i class="fas fa-sync mr-2"></i>Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row list-debitur">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-info">
                    <button class="btn btn-warning btn-sm float-right" type="button" id="tambah_data">Tambah Data</button>
                    <h4 class="mb-0 text-white">List Debitur</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="tabel_m_debitur" width="100%">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>No</th>
                                <th>Deal Reff</th>
                                <th>No Klaim</th>
                                <th>Nama</th>
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
    <div class="row form-tambah-debitur" hidden>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <ul class="nav nav-tabs mt-2 mb-4">
                        <li class=" nav-item"> <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false"><h6>Tambah Manual</h6></a> </li>
                        <li class="nav-item upload-dt"> <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false"><h6>Upload Data</h6></a> </li>
                    </ul>

                    <div class="tab-content br-n pn">
                        <div id="navpills-1" class="tab-pane active">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card shadow">
                                        <div class="card-header bg-info">
                                            <h4 class="mb-0 text-white">Form Tambah Debitur</h4>
                                        </div>
                                        <div class="card-body">
                                            <form id="form-deb-tambah" autocomplete="off">
                                            
                                                <div class="row">
                                                    <div class="col-sm-12 col-lg-6">
                                                        <div class="form-group row">
                                                            <label for="id_care" class="col-sm-3 control-label col-form-label ">No Klaim</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="no_klaim" placeholder="Masukkan No Klaim">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6">
                                                        <div class="form-group row">
                                                            <label for="id_care" class="col-sm-3 control-label col-form-label ">Nomor Reff</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="no_reff" placeholder="Masukkan Nomor Reff">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6">
                                                        <div class="form-group row">
                                                            <label for="id_care" class="col-sm-3 control-label col-form-label ">Nama Debitur Asuransi</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="nm_debitur" placeholder="Masukkan Nama Debitur Asuransi">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6">
                                                        <div class="form-group row">
                                                            <label for="id_care" class="col-sm-3 control-label col-form-label ">Nama Debitur Bank</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="nm_debitur_bank" placeholder="Masukkan Nama Debitur Bank">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6">
                                                        <div class="form-group row">
                                                            <label for="id_care" class="col-sm-3 control-label col-form-label ">Tanggal Klaim</label>
                                                            <div class="col-sm-9">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control datepicker" id="tgl_klaim" placeholder="Tanggal Klaim" readonly>
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6">
                                                        <div class="form-group row">
                                                            <label for="id_care" class="col-sm-3 control-label col-form-label ">Asuransi</label>
                                                            <div class="col-sm-9">
                                                                <select class="select2 form-control custom-select" name="asuransi" id="asuransi" style="width: 100%; height:36px;">  
                                                                    <option value="a">-- Pilih Asuransi --</option>
                                                                    <?php foreach ($asuransi as $a): ?>
                                                                        <option value="<?= $a['id_asuransi'] ?>"><?= $a['asuransi'] ?></option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6">
                                                        <div class="form-group row">
                                                            <label for="id_care" class="col-sm-3 control-label col-form-label ">Cabang Asuransi</label>
                                                            <div class="col-sm-9">
                                                                <select class="select2 form-control custom-select" name="cabang_asuransi" id="cabang_asuransi" style="width: 100%; height:36px;">  
                                                                    <option value="a">-- Pilih Cabang Asuransi --</option>
                                                                    
                                                                </select>
                                                                <div id="loading_cab_as" style="margin-top: 10px;" align='center'>
                                                                    <img src="<?= base_url('template/img/loading.gif') ?>" width="18"> <small>Loading...</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6">
                                                        <div class="form-group row">
                                                            <label for="id_care" class="col-sm-3 control-label col-form-label ">Bank</label>
                                                            <div class="col-sm-9">
                                                                <select class="select2 form-control custom-select" name="bank" id="bank" style="width: 100%; height:36px;">  
                                                                    <option value="a">-- Pilih Bank --</option>
                                                                    <?php foreach ($bank as $b): ?>
                                                                        <option value="<?= $b['id_bank'] ?>"><?= $b['bank'] ?></option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6">
                                                        <div class="form-group row">
                                                            <label for="id_care" class="col-sm-3 control-label col-form-label ">Cabang Bank</label>
                                                            <div class="col-sm-9">
                                                                <select class="select2 form-control custom-select" name="cabang_bank" id="cabang_bank" style="width: 100%; height:36px;">  
                                                                    <option value="a">-- Pilih Cabang Bank --</option>
                                                                    
                                                                </select>
                                                                <div id="loading_cab_bank" style="margin-top: 10px;" align='center'>
                                                                    <img src="<?= base_url('template/img/loading.gif') ?>" width="18"> <small>Loading...</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6">
                                                        <div class="form-group row">
                                                            <label for="id_care" class="col-sm-3 control-label col-form-label ">Capem Bank</label>
                                                            <div class="col-sm-9">
                                                                <select class="select2 form-control custom-select" name="capem_bank" id="capem_bank" style="width: 100%; height:36px;">  
                                                                    <option value="a">-- Pilih Capem Bank --</option>
                                                                    
                                                                </select>
                                                                <div id="loading_cap_bank" style="margin-top: 10px;" align='center'>
                                                                    <img src="<?= base_url('template/img/loading.gif') ?>" width="18"> <small>Loading...</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6">
                                                        <div class="form-group row">
                                                            <label for="id_care" class="col-sm-3 control-label col-form-label ">Jenis Kredit</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="jns_kredit" placeholder="Masukkan Jenis Kredit">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6">
                                                        <div class="form-group row">
                                                            <label for="id_care" class="col-sm-3 control-label col-form-label ">Subrogasi</label>
                                                            <div class="col-sm-9">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Rp. </span>
                                                                    </div> 
                                                                    <input type="number" class="form-control" id="subrogasi" placeholder="Masukkan Subrogasi">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6">
                                                        <div class="form-group row">
                                                            <label for="id_care" class="col-sm-3 control-label col-form-label ">Pokok</label>
                                                            <div class="col-sm-9">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Rp. </span>
                                                                    </div> 
                                                                    <input type="number" class="form-control" id="pokok" placeholder="Masukkan Pokok">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6">
                                                        <div class="form-group row">
                                                            <label for="id_care" class="col-sm-3 control-label col-form-label ">Bunga</label>
                                                            <div class="col-sm-9">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Rp. </span>
                                                                    </div> 
                                                                    <input type="number" class="form-control" id="bunga" placeholder="Masukkan Bunga">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6">
                                                        <div class="form-group row">
                                                            <label for="id_care" class="col-sm-3 control-label col-form-label ">Denda</label>
                                                            <div class="col-sm-9">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Rp. </span>
                                                                    </div> 
                                                                    <input type="number" class="form-control" id="denda" placeholder="Masukkan Denda">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6">
                                                        <div class="form-group row">
                                                            <label for="id_care" class="col-sm-3 control-label col-form-label ">Recoveries Awal Asuransi</label>
                                                            <div class="col-sm-9">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Rp. </span>
                                                                    </div> 
                                                                    <input type="number" class="form-control" id="recov_awal_as" placeholder="Masukkan Recoveries Awal Asuransi">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                        <div class="card-footer">
                                            <div class="col-12">
                                                <button class="btn btn-success float-right" type="button" id="simpan_debitur">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="navpills-2" class="tab-pane">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card shadow">
                                        <div class="card-header bg-info">
                                        <a href="<?= base_url('excel/format_debitur.xlsx') ?>"><button class="btn btn-warning btn-sm float-right">Download Format</button></a>
                                        <h4 class="mb-0 text-white">Upload File Excel</h4>
                                        </div>
                                        <form id="import_form" method="POST" enctype="multipart/form-data">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-center">
                                                    <div class="col-sm-12 col-lg-6">
                                                        <div class="form-group row nomor_spk">
                                                            <label for="id_care" class="col-sm-3 control-label col-form-label">Nomor SPK</label>
                                                            <div class="col-sm-9">
                                                                <select class="select2 form-control custom-select" name="no_spk" id="no_spk" style="width: 100%; height:36px;">  
                                                                    <option value="a">-- Pilih Nomor SPK --</option>
                                                                    <?php foreach ($no_spk as $a): ?>
                                                                        <option value="<?= $a['id_spk'] ?>"><?= $a['no_spk'] ?></option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    <div class="col-sm-12 col-lg-6">
                                                        <div class="form-group row">
                                                            <label for="id_care" class="col-sm-3 control-label col-form-label">Upload File</label>
                                                            <div class="col-sm-9">
                                                                <input type="file" class="form-control" name="upload_excel" id="upload_excel" accept=".xls,.xlsx" disabled> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tabel_preview">

                                                </div>
                                            </div>
                                            <div class="b-upload" hidden>
                                                <div class="card-footer d-flex justify-content-end">
                                                    <button type="button" class="btn btn-success" id="proses_upload">Upload Data</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="detail-deb" hidden>

    </div>
    <div class="detail-deb-2" hidden>

    </div>

    <div class="align-items-center col-md-2" id="kembali" hidden>
        <button class="btn btn-warning btn-round ml-auto">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </button>
    </div>

</div>

<script>

$(document).ready(function () {

    // 12-03-2020

        // aksi jika no spk terpilih
        $('#no_spk').on('change', function () {

            var no_spk = $(this).val();

            if (no_spk != 'a') {
                $('#upload_excel').removeAttr('disabled');
            } else {
                $('#upload_excel').attr('disabled', true);
            }

        })

        // aksi untuk menampilkan preview upload
        $('#upload_excel').on('change', function () {
        
            var im_form = document.querySelector("#import_form");

            var form    = new FormData(im_form);

            console.log(form);

            $.ajax({
                url             : "<?= base_url('master/debitur_import/1') ?>",
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
                    $('.b-upload').removeAttr('hidden');
                    
                    $('.tabel_preview').html(data);

                    console.log(data);
                    
                }

            })

            return false;

        })

        // aksi untuk upload debitur
        $('#proses_upload').on('click', function () {

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
                        url             : "<?= base_url('master/debitur_import/2') ?>",
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

                            tabel_m_debitur.ajax.reload(null, false);

                            swal({
                                title               : "Berhasil",
                                text                : 'Data berhasil disimpan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            });

                            $('#no_spk').select2('val', 'a');
                            $('#upload_excel').val('');
                            $('.tabel_preview').hide();
                            $('.b-upload').attr('hidden', true);

                            $('.form-tambah-debitur').attr('hidden', true);
                            $('.filter_data').removeAttr('hidden');
                            $('.list-debitur').show();
                            $('#kembali').attr('hidden', true);

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

    // Akhir 12-03-2020
    
    var tabel_m_debitur = $('#tabel_m_debitur').DataTable({
        "processing"    : true,
        "serverSide"    : true,
        "order"         : [],
        "ajax"          : {
            "url"   : "<?= base_url("master/tampil_m_debitur") ?>",
            "type"  : "POST",
            "data"  : function (data) {
                data.id_bank        = $('#bank3').val();
                data.id_cabang_bank = $('#cabang_bank3').val();
                data.spk            = $('#spk3').val();
            }
        },
        "columnDefs"    : [{
            "targets"       : [0,7,8],
            "orderable"     : false
        }]
    })

     // aksi filter data
     $('#cari').click(function () {
        tabel_m_debitur.ajax.reload(null, false);            
    })

    // aksi reset data filter
    $('#reset').click(function () {
        $('#bank3').select2("val", 'a');
        $('#cabang_bank3').select2("val", 'a');
        $('#spk3').select2("val", 'a');
        tabel_m_debitur.ajax.reload(null, false);
    })

    // saat klik upload data 
    $('.upload-dt').on('click', function () {
        $('#jenis_data').select2('val', 'a');
        $('#no_spk').select2('val', 'a');
        $('#upload_excel').val('');
        $('.tabel_preview').hide();
        $('.b-upload').attr('hidden', true);
    })

    // proses simpan edit debitur 
    $('#simpan_edit_debitur').on('click', function () {

        var no_reff     = $('#no_reff_edit').val();
        var no_klaim    = $('#no_klaim_edit').val();

        $.ajax({
            url         : "<?= base_url('master/simpan_edit_debitur') ?>",
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
            data        : {id_debitur:id_debitur},
            success     : function (data) {
                tabel_m_debitur.ajax.reload(null, false);
                
                swal(
                    'Ubah Debitur',
                    'Data Berhasil Disimpan',
                    'success'
                )

                $('.list-debitur').show();
                $("#kembali").attr("hidden", true);
                $(".form-tambah-debitur").attr("hidden", true);
            }
        })

        return false;

    })

    // menampilkan selectbox nomor spk 
    // $('#jenis_data').on('change', function () {
    //     var jenis = $(this).val();

    //     if (jenis == 'asuransi') {
    //         $('.nomor_spk').removeAttr('hidden');
    //     } else {
    //         $('.nomor_spk').attr('hidden', true);
    //     }
    // })

    // proses detail debitur
    $('#tabel_m_debitur').on('click', '.detail-debitur', function () {
        
        var id_debitur = $(this).data('id');

        $.ajax({
            url         : "<?= base_url('master/form_detail_debitur') ?>",
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
            data        : {id_debitur:id_debitur},
            success     : function (data) {
                swal.close();

                $('.detail-deb').html(data);

                $('.list-debitur').hide();
                $('#kembali').removeAttr('hidden');
                $('.detail-deb').removeAttr('hidden');
                $('.filter_data').attr('hidden', true);
            }
        })

    })

    // proses upload excel
    $('#import_form2').on('submit', function (event) {
        
        event.preventDefault();

        var file      = $('#upload_excel').val();
        var no_spk    = $('#no_spk').val();

        // var data = new FormData(this);

        // Display the values
        // for (var value of data.values()) {
        //     console.log(value); 
        // }

        if (no_spk == 'a') {

            swal({
                    title               : 'Peringatan',
                    text                : 'Nomor SPK Harus Terisi',
                    buttonsStyling      : false,
                    confirmButtonClass  : "btn btn-warning",
                    type                : 'warning'
                }); 

            return false;
        } else if (file == '') {

            swal({
                    title               : 'Peringatan',
                    text                : 'File Harus Terisi',
                    buttonsStyling      : false,
                    confirmButtonClass  : "btn btn-warning",
                    type                : 'warning'
                }); 

            return false;
        } else {

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
                    $.ajax({
                        url         : "<?= base_url('master/debitur_import') ?>",
                        method      : "POST",
                        beforeSend  : function () {
                            swal({
                                title   : 'Menunggu',
                                html    : 'Memproses halaman',
                                onOpen  : () => {
                                    swal.showLoading();
                                }
                            })
                        },
                        data            : new FormData(this),
                        contentType     : false,
                        cache           : false,
                        processData     : false,
                        success         : function (data) {
                            tabel_m_debitur.ajax.reload(null, false);

                            if (data.hasil != 0) {
                                swal(
                                    'Tambah Debitur',
                                    'Data Berhasil Disimpan',
                                    'success'
                                )

                                $('.list-debitur').show();
                                $("#kembali").attr("hidden", true);
                                $(".form-tambah-debitur").attr("hidden", true);

                                $('#upload_excel').val('');
                            } else {
                                swal(
                                    'Gagal',
                                    'Data Gagal Disimpan',
                                    'error'
                                )
                            }

                        }

                    })

                    return false;
                } else if (result.dismiss === swal.DismissReason.cancel) {

                    swal({
                            title               : 'Batal',
                            text                : 'Anda membatalkan upload data',
                            buttonsStyling      : false,
                            confirmButtonClass  : "btn btn-info",
                            type                : 'error'
                        }); 
                }
            })

        }


    })
    

    // tambah debitur
    $('#tambah_data').click(function () {

        $.ajax({
            // url         : "<?= base_url('manager/form_tambah_prioritas') ?>",
            // type        : "POST",
            beforeSend  : function () {
                swal({
                    title   : 'Menunggu',
                    html    : 'Memproses halaman',
                    onOpen  : () => {
                        swal.showLoading();
                    }
                })
            },
            success     : function (data) {
                swal.close();

                $('.list-debitur').hide();
                $('.form-tambah-debitur').removeAttr('hidden');
                $('#kembali').removeAttr('hidden');
                $('.filter_data').attr('hidden', true);

                $('#form-deb-tambah').trigger('reset');

                $('#no_klaim').val('');
                $('#no_reff').val('');
                $('#nm_debitur').val('');
                $('.datepicker').datepicker('setDate', null);
                $('#asuransi').select2("val", 'a');
                $('#cabang_asuransi').select2("val",'a');
                $('#bank').select2("val",'a');
                $('#cabang_bank').select2("val",'a');
                $('#capem_bank').select2("val",'a');
                $('#jns_kredit').val('');
                $('#subrogasi').val('');
                $('#bunga').val('');

                $('#upload_excel').val('');
            }
        })

        return false;
    })

    // proses simpan data
    $('#simpan_debitur').click(function () {

        var no_klaim        = $('#no_klaim').val();
        var no_reff         = $('#no_reff').val();
        var nm_debitur      = $('#nm_debitur').val();
        var nm_debitur_bank = $('#nm_debitur_bank').val();
        var tgl_klaim       = $('#tgl_klaim').val();
        var id_cabang_as    = $('#cabang_asuransi').val();
        var id_capem_bank   = $('#capem_bank').val();
        var jns_kredit      = $('#jns_kredit').val();
        var subrogasi_as    = $('#subrogasi').val();
        var bunga           = $('#bunga').val();
        var pokok           = $('#pokok').val();
        var denda           = $('#denda').val();
        var recov_awal      = $('#recov_awal_as').val();

        swal({
            title       : 'Konfirmasi',
            text        : 'Pastikan semua data terisi dan benar!',
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
                    url         : "<?= base_url('master/input_debitur') ?>",
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
                    data        : {no_klaim:no_klaim, no_reff:no_reff, nm_debitur:nm_debitur, tgl_klaim:tgl_klaim, id_cabang_as:id_cabang_as, id_capem_bank:id_capem_bank, jns_kredit:jns_kredit, subrogasi_as:subrogasi_as, bunga:bunga, pokok:pokok, denda:denda, recov_awal:recov_awal, nm_debitur_bank:nm_debitur_bank},
                    success     : function (data) {
                        tabel_m_debitur.ajax.reload(null, false);

                        swal(
                            'Tambah Debitur',
                            'Data Berhasil Disimpan',
                            'success'
                        )

                        $('.list-debitur').show();
                        $("#kembali").attr("hidden", true);
                        $(".form-tambah-debitur").attr("hidden", true);
                        $('.filter_data').removeAttr('hidden');

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
                    'Anda membatalkan tambah debitur',
                    'error'
                )
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

                tabel_m_debitur.ajax.reload(null, false);

                $('.list-debitur').show();
                $("#kembali").attr("hidden", true);
                $(".form-tambah-debitur").attr("hidden", true);
                $('.detail-deb').attr("hidden", true);
                $('.filter_data').removeAttr('hidden');
            }
        })

    })

    // linked combobox
    $('#loading_cab_as').hide();
    $('#loading_cab_bank').hide();
    $('#loading_cap_bank').hide();

    $('#asuransi').on('change', function () {
        var id_asuransi = $("#asuransi").val();

        $('#cabang_asuransi').next('.select2-container').hide();
        $('#loading_cab_as').show();

        $.ajax({
            url         : "<?= base_url('master/ambil_cabang_asuransi') ?>",
            type        : "POST",
            beforeSend 	: function (e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charshet=UTF-8");
                }				
            },
            data        : {id_asuransi:id_asuransi},
            dataType    : "JSON",
            success     : function (data) {
                $('#loading_cab_as').hide();
                $('#cabang_asuransi').next('.select2-container').show();
                $('#cabang_asuransi').html(data.cabang_as);
            },
            error 		: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

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

    // mencari capem bank
    $('#cabang_bank').change(function () {
        var id_cabang_bank = $(this).find('option:selected').val();

        $('#capem_bank').next('.select2-container').hide();
        $('#loading_cap_bank').show();

        $.ajax({
            url         : "<?= base_url('master/ambil_capem_bank') ?>",
            type        : "POST",
            beforeSend  : function (e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charshet=UTF-8");
                }
            },
            data        : {id_cabang_bank:id_cabang_bank},
            dataType    : "JSON",
            success     : function (data) {
                $('#loading_cap_bank').hide();
                $('#capem_bank').next('.select2-container').show();
                $('#capem_bank').html(data.capem_bank);
            },
            error 		: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

    $('#loading_cab_bank3').hide();

    $('#bank3').change(function () {
        var id_bank = $(this).find('option:selected').val();

        $('#cabang_bank3').next('.select2-container').hide();
        $('#loading_cab_bank3').show();

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
                $('#loading_cab_bank3').hide();
                $('#cabang_bank3').next('.select2-container').show();
                $('#cabang_bank3').html(data.cabang_bank);

            },
            error 		: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

})

</script>