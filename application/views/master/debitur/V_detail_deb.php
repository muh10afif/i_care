<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist" hidden>
    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#detail" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Detail</span></a> </li>
    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#edit" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Edit</span></a> </li>
</ul>
<!-- tab content -->
<div class="tab-content tabcontent-border">
    <div class="tab-pane active" id="detail" role="tabpanel">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-info">
                        <input type="hidden" id="id_deb" value="<?= $dt_deb['id_debitur'] ?>">

                        <?php if ($aksi != 'detail'): ?>
                            <button class="btn btn-warning btn-sm float-right" id="simpan_edit_debitur" type="button">Simpan</button>
                            <h4 class="mb-0 text-white" id="judul">Edit Debitur</h4>
                        <?php else: ?>
                            <button class="btn btn-warning btn-sm float-right" id="edit_debitur" type="button">Edit</button>
                            <h4 class="mb-0 text-white" id="judul">Detail Debitur</h4>
                        <?php endif; ?>

                    </div>
                            
                    <div class="card-body">
                        <form class="form-horizontal r-separator">
                            <div class="card-body row">
                                <div class="col-md-6">
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Id Care</label>
                                        <div class="col-sm-7">
                                        : <?= $dt_deb['id_debitur'] ?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Nomor Reff</label>
                                        <div class="col-sm-7">
                                        : <?= $dt_deb['no_reff'] ?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Nomor Klaim</label>
                                        <div class="col-sm-7">
                                        : <?= $dt_deb['no_klaim'] ?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Nama Asuransi</label>
                                        <div class="col-sm-7">
                                        : <?= $dt_deb['nama_debitur'] ?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Nama Bank</label>
                                        <div class="col-sm-7">
                                        : <?= $dt_deb['nama_debitur'] ?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Tanggal Klaim</label>
                                        <div class="col-sm-7">
                                        : <?= date('d-F-Y', strtotime($dt_deb['tgl_klaim'])) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Asuransi</label>
                                        <div class="col-sm-7">
                                        : <?= $dt_deb['asuransi'] ?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Cabang Asuransi</label>
                                        <div class="col-sm-7">
                                        : <?= $dt_deb['cabang_asuransi'] ?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Bank</label>
                                        <div class="col-sm-7">
                                        : <?= $dt_deb['bank'] ?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Cabang Bank</label>
                                        <div class="col-sm-7">
                                        : <?= $dt_deb['cabang_bank'] ?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Capem Bank</label>
                                        <div class="col-sm-7">
                                        : <?= $dt_deb['capem_bank'] ?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Jenis Kredit</label>
                                        <div class="col-sm-7">
                                        : <?= $dt_deb['jenis_kredit'] ?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Subrogasi Asuransi</label>
                                        <div class="col-sm-7">
                                        : <?= number_format($dt_deb['subrogasi_as']) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Bunga</label>
                                        <div class="col-sm-7">
                                        : <?= number_format($dt_deb['bunga']) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Pokok</label>
                                        <div class="col-sm-7">
                                        : <?= number_format($dt_deb['pokok']) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Denda</label>
                                        <div class="col-sm-7">
                                        : <?= number_format($dt_deb['denda']) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Jumlah Tagihan</label>
                                        <div class="col-sm-7">
                                        : <?= number_format($dt_deb['jumlah']) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Recoveries Awal Asuransi</label>
                                        <div class="col-sm-7">
                                        : <?= number_format($dt_deb['recoveries_awal_asuransi']) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Recoveries Awal Bank</label>
                                        <div class="col-sm-7">
                                        : <?= number_format($dt_deb['recoveries_awal_bank']) ?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        
                                    </div>
                                </div>
                                
                            </div>
                        </form>          
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="tab-pane" id="edit" role="tabpanel">

    <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-info">

                        <button class="btn btn-warning btn-sm float-right" id="simpan_edit_debitur" type="button">Simpan</button>
                        <h4 class="mb-0 text-white" id="judul">Edit Debitur</h4>

                    </div>
                            
                    <form id="form-debitur">
                    <input type="hidden" id="id_deb" name="id_deb2" value="<?= $dt_deb['id_debitur'] ?>">
                    <div class="card-body">
                    <form class="form-horizontal r-separator">
                            <div class="card-body row">
                                <div class="col-md-6">
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Id Care</label>
                                        <div class="col-sm-7">
                                        : <?= $dt_deb['id_debitur'] ?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Nomor Reff</label>
                                        <div class="col-sm-7">
                                        <input type="text" class="form-control" name="no_reff2" id="no_reff_edit" value="<?= $dt_deb['no_reff'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Nomor Klaim</label>
                                        <div class="col-sm-7">
                                        <input type="text" class="form-control" name="no_klaim2" id="no_klaim_edit" value="<?= $dt_deb['no_klaim'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Nama Asuransi</label>
                                        <div class="col-sm-7">
                                        <input type="text" name="nama_deb2" id="nama_deb" class="form-control" value="<?= $dt_deb['nama_debitur'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Nama Bank</label>
                                        <div class="col-sm-7">
                                        <input type="text" name="nama_deb_bank" id="nama_deb" class="form-control" value="<?= $dt_deb['nama_debitur'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Tanggal Klaim</label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control datepicker" name="tgl_bayar2" id="tgl_bayar_deb" value="<?= date('d-F-Y', strtotime($dt_deb['tgl_klaim'])) ?>">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Asuransi</label>
                                        <div class="col-sm-7">
                                        <select class="select2 form-control custom-select" name="asuransi2" id="asuransi2" style="width: 100%; height:36px;">  
                                            <option value="a">-- Pilih Asuransi --</option>
                                            <?php foreach ($asuransi as $a): ?>
                                                <option value="<?= $a['id_asuransi'] ?>" <?= ($a['id_asuransi'] == $dt_deb['id_asuransi']) ? 'selected' : '' ?>><?= $a['asuransi'] ?></option>
                                            <?php endforeach;?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Cabang Asuransi</label>
                                        <div class="col-sm-7">
                                        <select class="select2 form-control custom-select" name="cabang_asuransi2" id="cabang_asuransi2" style="width: 100%; height:36px;">  
                                            <option value="a">-- Pilih Cabang Asuransi --</option>
                                            <?php foreach ($cabang_asuransi as $a): ?>
                                                <option value="<?= $a['id_cabang_asuransi'] ?>" <?= ($a['id_cabang_asuransi'] == $dt_deb['id_cabang_asuransi']) ? 'selected' : '' ?>><?= $a['cabang_asuransi'] ?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <div id="loading_cab_as2" style="margin-top: 10px;" align='center'>
                                            <img src="<?= base_url('template/img/loading.gif') ?>" width="18"> <small>Loading...</small>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Bank</label>
                                        <div class="col-sm-7">
                                            <select class="select2 form-control custom-select" name="bank2" id="bank2" style="width: 100%; height:36px;">  
                                                <option value="a">-- Pilih Bank --</option>
                                                <?php foreach ($bank as $a): ?>
                                                    <option value="<?= $a['id_bank'] ?>" <?= ($a['id_bank'] == $dt_deb['id_bank']) ? 'selected' : '' ?>><?= $a['bank'] ?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Cabang Bank</label>
                                        <div class="col-sm-7">
                                            <select class="select2 form-control custom-select" name="cabang_bank2" id="cabang_bank2" style="width: 100%; height:36px;">  
                                                <option value="a">-- Pilih Cabang Bank --</option>
                                                <?php foreach ($cabang_bank as $a): ?>
                                                    <option value="<?= $a['id_cabang_bank'] ?>" <?= ($a['id_cabang_bank'] == $dt_deb['id_cabang_bank']) ? 'selected' : '' ?>><?= $a['cabang_bank'] ?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <div id="loading_cab_bank2" style="margin-top: 10px;" align='center'>
                                                <img src="<?= base_url('template/img/loading.gif') ?>" width="18"> <small>Loading...</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Capem Bank</label>
                                        <div class="col-sm-7">
                                            <select class="select2 form-control custom-select" name="capem_bank2" id="capem_bank2" style="width: 100%; height:36px;">  
                                                <option value="a">-- Pilih Capem Bank --</option>
                                                <?php foreach ($capem_bank as $a): ?>
                                                    <option value="<?= $a['id_capem_bank'] ?>" <?= ($a['id_capem_bank'] == $dt_deb['id_capem_bank']) ? 'selected' : '' ?>><?= $a['capem_bank'] ?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <div id="loading_cap_bank2" style="margin-top: 10px;" align='center'>
                                                <img src="<?= base_url('template/img/loading.gif') ?>" width="18"> <small>Loading...</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Jenis Kredit</label>
                                        <div class="col-sm-7">
                                        <input type="text" name="jns_kredit2" class="form-control" value="<?= $dt_deb['jenis_kredit'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Subrogasi Asuransi</label>
                                        <div class="col-sm-7">
                                        <input type="number" name="subrogasi_as2" id="subrogasi_as2" class="form-control" value="<?= $dt_deb['subrogasi_as'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Bunga</label>
                                        <div class="col-sm-7">
                                            <input type="text" name="bunga2" id="bunga2" class="form-control" value="<?= $dt_deb['bunga'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Pokok</label>
                                        <div class="col-sm-7">
                                            <input type="number" name="pokok2" class="form-control" value="<?= $dt_deb['pokok'] ?>">        
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Denda</label>
                                        <div class="col-sm-7">
                                        <input type="number" name="denda2" id="denda" class="form-control" value="<?= $dt_deb['denda'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Jumlah Tagihan</label>
                                        <div class="col-sm-7">
                                        <input type="number" name="jumlah2" id="jumlah" class="form-control" value="<?= $dt_deb['jumlah'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Recoveries Awal Asuransi</label>
                                        <div class="col-sm-7">
                                        <input type="number" name="recov_awal_as2" id="recov_awal_as" class="form-control" value="<?= $dt_deb['recoveries_awal_asuransi'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        <label for="inputEmail3" class="col-sm-5  control-label col-form-label">Recoveries Awal Bank</label>
                                        <div class="col-sm-7">
                                        <input type="number" name="recov_awal_bank2" id="recov_awal_bank" class="form-control" value="<?= $dt_deb['recoveries_awal_bank'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row pb-1">
                                        
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                                            
                    </div>
                    </form>

                </div>
            </div>

        </div>
        
    </div>
</div>

<!-- Select2 -->
<script src="<?= base_url() ?>template/assets/libs/select2/dist/js/select2.full.min.js"></script>
<script src="<?= base_url() ?>template/assets/libs/select2/dist/js/select2.min.js"></script>
<script src="<?= base_url() ?>template/dist/js/pages/forms/select2/select2.init.js"></script>

<script>

    jQuery('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format      : "dd-MM-yyyy",
        orientation : "bottom"
    });

$(document).ready(function () {
    
    // proses edit debitur
    $('#edit_debitur').on('click', function () {

        var id_debitur = $('#id_deb').val();

        $.ajax({
            url         : "<?= base_url('master/form_detail_debitur/edit') ?>",
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

                // $('.detail-deb').html(data);

                // $('.list-debitur').hide();
                // $('.detail-deb').removeAttr('hidden');

                $("a[href='#edit']").tab('show');
            }
        })

        return false;

    })

    // proses simpan edit debitur 
    $('#simpan_edit_debitur').on('click', function () {

        var id_debitur  = $('#id_deb').val();
        var no_reff     = $('#no_reff_edit').val();
        var no_klaim    = $('#no_klaim_edit').val();
        var tgl_klaim    = $('#tgl_bayar_deb').val();

        var datanya = $('#form-debitur').serialize();

        console.log(tgl_klaim);

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
            data        : datanya,
            dataType    : "JSON",
            success     : function (data) {
                
                swal({
                    title               : 'Ubah Debitur',
                    text                : 'Data Berhasil Disimpan',
                    buttonsStyling      : false,
                    confirmButtonClass  : "btn btn-success",
                    type                : 'success'
                });

            }
        })

        return false;
        
    })

    // linked combobox
    $('#loading_cab_as2').hide();
    $('#loading_cab_bank2').hide();
    $('#loading_cap_bank2').hide();
    $('#loading_ver2').hide();

    $('#asuransi2').on('change', function () {
        var id_asuransi  = $("#asuransi2").val();

        console.log(id_asuransi);

        $('#cabang_asuransi2').next('.select2-container').hide();
        $('#loading_cab_as2').show();

        $.ajax({
            url         : "<?= base_url('Master/ambil_cabang_asuransi') ?>",
            type        : "POST",
            beforeSend 	: function (e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charshet=UTF-8");
                }				
            },
            data        : {id_asuransi:id_asuransi},
            dataType    : "JSON",
            success     : function (data) {
                $('#loading_cab_as2').hide();
                $('#cabang_asuransi2').next('.select2-container').show();
                $('#cabang_asuransi2').html(data.cabang_as);
            },
            error 		: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

    $('#bank2').change(function () {
        var id_bank = $(this).find('option:selected').val();

        $('#cabang_bank2').next('.select2-container').hide();
        $('#loading_cab_bank2').show();

        $.ajax({
            url         : "<?= base_url('Master/ambil_cabang_bank') ?>",
            type        : "POST",
            beforeSend 	: function (e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charshet=UTF-8");
                }				
            },
            data        : {id_bank:id_bank},
            dataType    : "JSON",
            success     : function (data) {
                $('#loading_cab_bank2').hide();
                $('#cabang_bank2').next('.select2-container').show();
                $('#cabang_bank2').html(data.cabang_bank);

                $('#capem_bank2').html(data.option1);
            },
            error 		: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

    // mencari capem bank
    $('#cabang_bank2').change(function () {
        var id_cabang_bank = $(this).find('option:selected').val();

        $('#capem_bank2').next('.select2-container').hide();
        $('#loading_cap_bank2').show();

        $.ajax({
            url         : "<?= base_url('Master/ambil_capem_bank') ?>",
            type        : "POST",
            beforeSend  : function (e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charshet=UTF-8");
                }
            },
            data        : {id_cabang_bank:id_cabang_bank},
            dataType    : "JSON",
            success     : function (data) {
                $('#loading_cap_bank2').hide();
                $('#capem_bank2').next('.select2-container').show();
                $('#capem_bank2').html(data.capem_bank);
            },
            error 		: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

})

</script>