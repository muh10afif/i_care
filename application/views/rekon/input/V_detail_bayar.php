<div class="modal-header bg-info">
    <h4 class="modal-title text-white" id="judul">Detail Bayar Debitur <?= ucwords(strtolower($nm_deb['nama_debitur'])) ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white;">×</button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-bordered table-hover mt-4 tabel_detail_bayar" width="100%" id="tabel">
                <thead class="bg-info text-white">
                    <tr>
                        <th>No</th>
                        <th>No Rekening</th>
                        <th>Nominal</th>
                        <th>Tanggal Bayar</th>
                        <th>Created At</th>
                        <th>Created By</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        var tabel_detail_bayar = $('.tabel_detail_bayar').DataTable({

            "processing"    : true,
            "ajax"          : "<?=base_url("Rekon/tampil_detail_bayar/$id_debitur")?>",
            stateSave       : true,
            "order"         : []

        })

        // 09-04-2021
        $('.tabel_detail_bayar').on('click', '.hapus', function () {
        
            var id_recov_as = $(this).data('id');

            swal({
                title       : 'Konfirmasi',
                text        : 'Yakin akan hapus recoveries?',
                type        : 'warning',

                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-danger",
                cancelButtonClass   : "btn btn-info mr-3",

                showCancelButton    : true,
                confirmButtonText   : 'Ya, hapus',
                confirmButtonColor  : '#d33',
                cancelButtonColor   : '#3085d6',
                cancelButtonText    : 'Batal',
                reverseButtons      : true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url         : "<?= base_url('Rekon/hapus_recov') ?>",
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
                        data        : {id_recov_as:id_recov_as},
                        dataType    : "JSON",
                        success     : function (data) {

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
                                }],
                                "bDestroy"  : true
                                
                            })

                            tabel_detail_bayar.ajax.reload(null, false);

                            swal({
                                title               : 'Hapus Data',
                                text                : 'Data Berhasil Dihapus',
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            }); 
                            
                        },
                        error       : function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            alert(err.Message);
                        }

                    })

                    return false;
                } else if (result.dismiss === swal.DismissReason.cancel) {

                    swal({
                            title               : 'Batal',
                            text                : 'Anda membatalkan hapus recoveries',
                            type                : 'error',
                            showConfirmButton   : false,
                            timer               : 1000
                        }); 
                }
            })

        })
    })
</script>