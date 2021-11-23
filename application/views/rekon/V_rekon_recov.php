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
            <h4 class="page-title">Rekonsilisasi Recoveries</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Rekonsiliasi</li>
                        <li class="breadcrumb-item"><a href="<?= base_url('Rekon/rekon_recov') ?>">Rekonsilisasi Recoveries</a></li>
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
                    <h4 class="mb-0 text-white">Recoveries</h4>
                </div>
                <div class="card-body table-responsive">

                    <ul class="nav nav-tabs mt-2 mb-4">
                        <li class=" nav-item"> <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false"><h6>Recoveries Asuransi</h6></a> </li>
                        <li class="nav-item upload-dt"> <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false"><h6>Recoveries Bank</h6></a> </li>
                    </ul>

                    <div class="tab-content br-n pn">
                        <div id="navpills-1" class="tab-pane active">
                            <table class="table table-bordered table-hover" id="tabel_debitur_r" width="100%">
                                <thead class="bg-info text-white">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Deal Reff</th>
                                        <th>Asuransi</th>
                                        <th>Bank</th>
                                        <th>Cabang Bank</th>
                                        <th>Recoveries</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div id="navpills-2" class="tab-pane">
                            <table class="table table-bordered table-hover" id="tabel_debitur_rb" width="100%">
                                <thead class="bg-info text-white">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Deal Reff</th>
                                        <th>Asuransi</th>
                                        <th>Bank</th>
                                        <th>Cabang Bank</th>
                                        <th>Recoveries</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {

        var tabel_debitur_r = $('#tabel_debitur_r').DataTable({

            "processing"    : true,
            "serverSide"    : true,
            "order"         : [],
            "ajax"          : {
                "url"   : "<?= base_url("rekon/tampil_debitur_rekon_recov") ?>",
                "type"  : "POST",
                "data"  : function (data) {
                    data.id_bank        = $('#bank').val();
                    data.id_cabang_bank = $('#cabang_bank').val();
                    data.jenis          = 'asuransi';
                }
            },
            "columnDefs"    : [{
                "targets"       : [0],
                "orderable"     : false
            }]

        })

        var tabel_debitur_rb = $('#tabel_debitur_rb').DataTable({

            "processing"    : true,
            "serverSide"    : true,
            "order"         : [],
            "ajax"          : {
                "url"   : "<?= base_url("rekon/tampil_debitur_rekon_recov") ?>",
                "type"  : "POST",
                "data"  : function (data) {
                    data.id_bank        = $('#bank').val();
                    data.id_cabang_bank = $('#cabang_bank').val();
                    data.jenis          = 'bank';
                }
            },
            "columnDefs"    : [{
                "targets"       : [0],
                "orderable"     : false
            }]

        })

        // aksi filter data
        $('#cari').click(function () {
            tabel_debitur_r.ajax.reload(null, false);            
            tabel_debitur_rb.ajax.reload(null, false);            
        })

        // aksi reset data filter
        $('#reset').click(function () {
            $('#bank').select2("val", 'a');
            $('#cabang_bank').select2("val", 'a');
            tabel_debitur_r.ajax.reload(null, false);
            tabel_debitur_rb.ajax.reload(null, false);
        })

        // 12-04-2021
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