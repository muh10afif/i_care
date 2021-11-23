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
            <h4 class="page-title">Laporan Biaya Per COA</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Laporan</li>
                        <li class="breadcrumb-item"><a href="<?= base_url('') ?>">Laporan Biaya Per COA</a></li>
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
                <form action="<?= base_url('laporan/export_data_coa') ?>" method="POST" target="_self" id="aksi_export">
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
                                            <div class="input-daterange input-group datepicker-bulan">
                                                <input type="text" class="form-control" name="bulan_awal" id="start" placeholder="Awal Periode" readonly/>
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-info b-0 text-white">s / d</span>
                                                </div>
                                                <input type="text" class="form-control" name="bulan_akhir" id="end" placeholder="Akhir Periode" readonly/>
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
        <div class="col-md-9">
            <div class="card shadow">
                <div class="card-header bg-info">
                    <h4 class="mb-0 text-white">List</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="tbl_biaya_p_coa" width="100%">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>No</th>
                                <th>Bulan</th>
                                <th>COA</th>
                                <th>Deskripsi COA</th>
                                <th>Nominal</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3">
			<div class="card border-left border-info shadow">
                <div class="card-header bg-info">
                    <h4 class="mb-0 text-white">Resume</h4>
                </div>
				<div class="card-body">
					<table class="table table-hover table-bordered" id="tbl_resume" width="100%" id="resume">
						<thead class="bg-info text-white">
							<tr>
                                <th>Bulan</th>
                                <th>Jumlah</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			
		</div>
    </div>
</div>

<script>

$(document).ready(function () {
    
    var tbl_biaya_p_coa = $('#tbl_biaya_p_coa').DataTable({
        "processing"    : true,
        "ajax"          : {
            "url"   : "<?=base_url("laporan/tampil_biaya_p_bulan")?>",
            "type"  : "POST",
            "data"  : function (data) {
                data.bulan_awal       = $('#start').val();
                data.bulan_akhir      = $('#end').val();
            }
        },
        stateSave       : true,
        "order"         : [],
        "columnDefs"        : [{
            "targets"   : [0],
            "orderable" : false
        }, {
            "targets"   : [1],
            "className" : "text-center"
        }]
    });

    // tabel resume
    var tbl_resume = $('#tbl_resume').DataTable({
        "processing"    : true,
        "dom"           : "t",
        "ajax"          : {
            "url"   : "<?=base_url("laporan/tampil_resume_coa")?>",
            "type"  : "POST",
            "data"  : function (data) {
                data.bulan_awal       = $('#start').val();
                data.bulan_akhir      = $('#end').val();
            }
        },
        stateSave       : true,
        "order"         : [],
        "columnDefs"        : [{
            "targets"   : [0,1],
            "orderable" : false
        }]
    });

    // aksi filter data
    $('#filter').click(function () {
        tbl_biaya_p_coa.ajax.reload(null, false);        
        tbl_resume.ajax.reload(null, false);        
    })

    // aksi reset data filter
    $('#reset').click(function () {
        $('.datepicker-bulan input').datepicker('setDate', null);

        tbl_biaya_p_coa.ajax.reload(null, false);
        tbl_biaya_p_coa.clear().draw();
        tbl_biaya_p_coa.search("").draw();

        tbl_resume.ajax.reload(null, false);
        tbl_resume.clear().draw();
        tbl_resume.search("").draw();
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