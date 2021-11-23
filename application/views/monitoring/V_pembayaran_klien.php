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
            <h4 class="page-title">Pembayaran Klien</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">I-care</li>
                        <li class="breadcrumb-item"><a href="<?= base_url('master') ?>">Pembayaran Klien</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- <?= form_open('monitoring/tes_xss') ?>

    <input type="text" name="username">
    <input type="text" name="password">

    <button type="submit">Simpan</button>

<?= form_close() ?> -->

<div class="container-fluid">
    <div class="row list-debitur">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-info">
                    <h4 class="mb-0 text-white">List Cabang Asuransi</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="tbl_pembayaran_klien" width="100%">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>No</th>
                                <th>Asuransi</th>
                                <th>Periode Tagihan</th>
                                <th>No Invoice</th>
                                <th>Komisi Ditagihkan</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Komisi Dibayarkan</th>
                                <th>Keterangan</th>
                                <th>Rekening Tujuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- modal input bayar klien -->
<div id="modal_bayar_klien" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title text-white" id="judul">Input Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form id="form_bayar_klien" autocomplete="off">

                <input type="hidden" id="id_invoice" name="id_invoice">
                <div class="modal-body">

                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="recov" class="col-sm-3 control-label col-form-label">Komisi Dibayarkan</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div> 
                                        <input type="number" class="form-control" name="komisi_dibayarkan" id="komisi_dibayarkan" placeholder="Masukkan Komisi Dibayarkan">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-3 control-label col-form-label">Tanggal Pembayaran</label>
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

                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="recov" class="col-sm-3 control-label col-form-label">Keterangan</label>
                                <div class="col-sm-9">
                                    <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Masukkan Keterangan"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="no_rek" class="col-sm-3 control-label col-form-label">No Rekening</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control angka" name="no_rek" id="no_rek" placeholder="Masukkan No Rekening">
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary waves-effect mr-3">Cancel</button>
                    <button type="button" class="btn btn-info waves-effect" id="simpan_bayar_klien">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

$(document).ready(function () {

    // dataTables pembayaran klien
    var tbl_pembayaran_klien = $('#tbl_pembayaran_klien').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "<?= base_url("monitoring/tampil_byr_klien") ?>",
            "type"  : "POST"
        },
        "columnDefs"        : [{
            "targets"   : [0,9],
            "orderable" : false
        }]

    })

    // menampilkan modal bayar klien
    $('#tbl_pembayaran_klien').on('click', '.input-byr-klien', function () {

        var id_invoice = $(this).data('id');

        console.log(id_invoice);

        $.ajax({
            url         : "<?= base_url('monitoring/ambil_no_invoice') ?>",
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
            data        : {id_invoice:id_invoice},
            dataType    : "JSON",
            success     : function (data) {
                swal.close();

                console.log(data);

                $('#modal_bayar_klien').modal('show');
                $('#judul').text("Input Data | No. Invoice "+data.no_invoice);

                $('#komisi_dibayarkan').val(data.komisi_dibayarkan);
                $('#tgl_bayar').datepicker('setDate', data[0].tgl_byr);
                $('#keterangan').val(data.keterangan);
                $('#no_rek').val(data.rekening);

                $('#id_invoice').val(id_invoice);
            }
        })
    })

    // aksi simpan bayar klien
    $('#simpan_bayar_klien').on('click', function () {
        
        var dt = $('#form_bayar_klien').serialize();

        console.log(dt);

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
                    url         : "<?= base_url('monitoring/simpan_bayar_klien') ?>",
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
                    data            : dt,
                    dataType        : "JSON",
                    success         : function (data) {

                        tbl_pembayaran_klien.ajax.reload(null, false);
                        
                        $('#modal_bayar_klien').modal('hide');

                        swal({
                            title               : 'Berhasil',
                            text                : 'Data berhasil disimpan',
                            buttonsStyling      : false,
                            confirmButtonClass  : "btn btn-success",
                            type                : 'success'
                        });

                    }

                })

                return false;
            } else if (result.dismiss === swal.DismissReason.cancel) {

                swal({
                        title               : 'Batal',
                        text                : 'Anda membatalkan input bayar klien',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error'
                    }); 
            }
        })

    })
    
})

</script>