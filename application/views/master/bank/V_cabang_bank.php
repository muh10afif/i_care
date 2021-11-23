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
            <h4 class="page-title">Master Cabang Bank</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item"><a href="<?= base_url('master/cabang_bank') ?>">Cabang Bank</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    <div class="row list-debitur">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-info">
                    <button class="btn btn-warning btn-sm float-right" type="button" id="tambah_data">Tambah Data</button>
                    <h4 class="mb-0 text-white">List Cabang Bank</h4>
                </div>
                <div class="card-body table-responsive">
    
                    <table class="table table-bordered table-hover" id="tabel_cabang_bank" width="100%">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>No</th>
                                <th>Bank</th>
                                <th width="25%">Cabang Bank</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- modal cabang_bank -->
    <div id="modal_cabang_bank" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title text-white" id="vcenter">Tambah Cabang Bank</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <input type="hidden" id="id_cabang_bank" name="id_cabang_bank">
                <input type="hidden" id="aksi" name="aksi" value="Tambah">
                <div class="modal-body">

                    <form id="form_cabang_bank">

                    <div class="row d-flex justify-content-center mt-3 mb-3">
                        <div class="col-md-10 mt-3">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Bank</label>
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
                        <div class="col-md-10 mt-3">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Nama Cabang Bank</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Nama Cabang Bank" id="nama">
                                </div>
                            </div>
                        </div>
                    </div>

                    </form>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark waves-effect mr-2" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-info waves-effect" id="simpan_cabang_bank">Simpan</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>

$(document).ready(function () {

    // dataTables cabang_bank
    var tabel_cabang_bank = $('#tabel_cabang_bank').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "<?= base_url("master/tampil_cabang_bank") ?>",
            "type"  : "POST"
        },
        "columnDefs"        : [{
            "targets"   : [0],
            "orderable" : false
        }]

    })

    $('#tambah_data').on('click', function () {
        // $("a[href='#profile']").tab('show');

        $('#modal_cabang_bank').modal('show');

        $('#form_cabang_bank').trigger("reset");

        $('.modal-title').text('Tambah Cabang Bank');
        $('#aksi').val('Tambah');
    })

    // aksi simpan cabang_bank
    $('#simpan_cabang_bank').on('click', function () {
        
        var nama            = $('#nama').val();
        var bank            = $('#bank').val();
        var aksi            = $('#aksi').val();
        var id_cabang_bank  = $('#id_cabang_bank').val();

        if (bank == 'a') {
            swal({
                  title               : "Peringatan",
                  text                : 'Bank harus terisi!',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-warning",
                  type                : 'warning'
              }); 

            return false;
        } else if (nama == '') {
            swal({
                  title               : "Peringatan",
                  text                : 'Cabang harus terisi!',
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
                      url         : "<?= base_url('Master/aksi_cabang_bank') ?>",
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
                      data        : {nama:nama, bank:bank, aksi:aksi, id_cabang_bank:id_cabang_bank},
                      dataType    : "JSON",
                      success     : function (data) {

                          tabel_cabang_bank.ajax.reload(null, false);

                            swal({
                                title               : aksi+' Cabang Bank',
                                text                : 'Data Berhasil Disimpan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success'
                            }); 
                          
                          $('#modal_cabang_bank').modal('hide');
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
                        text                : 'Anda membatalkan '+aksi.toLowerCase()+' cabang_bank',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error'
                    }); 
              }
          })

        }

    })

    // aksi edit cabang_bank
    $('#tabel_cabang_bank').on('click', '.edit-cabang-bank', function () {
         var id_cabang_bank = $(this).data('id');

        //  console.log(id_cabang_bank);

         $.ajax({
            url : "<?php echo base_url('Master/ambil_data_cabang_bank')?>/"+id_cabang_bank,
            type: "GET",
            beforeSend  : function () {
              swal({
                  title   : 'Menunggu',
                  html    : 'Memproses Data',
                  onOpen  : () => {
                      swal.showLoading();
                  }
              })
            },
            dataType: "JSON",
            success: function(data)
            {
                swal.close();

                console.log(data.id_bank);

                $('#id_cabang_bank').val(data.id_cabang_bank);
                $('#nama').val(data.cabang_bank);
                // $('#bank').select2("val", data.id_bank);
                $('#bank').val(data.id_bank).trigger('change.select2');

                $('#modal_cabang_bank').modal('show');
                $('.modal-title').text('Edit Cabang Bank');
                $('#aksi').val('Edit');
     
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
         })        
    })

    // hapus cabang_bank
    $('#tabel_cabang_bank').on('click', '.hapus-cabang-bank', function () {
        
        var id_cabang_bank = $(this).data('id');

        swal({
              title       : 'Konfirmasi',
              text        : 'Yakin akan hapus data',
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
                      url         : "<?= base_url('Master/aksi_cabang_bank') ?>",
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
                      data        : {aksi:'hapus', id_cabang_bank:id_cabang_bank},
                      dataType    : "JSON",
                      success     : function (data) {

                          tabel_cabang_bank.ajax.reload(null, false);

                            swal({
                                title               : 'Hapus Cabang Bank',
                                text                : 'Data Berhasil Dihapus',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success'
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
                        text                : 'Anda membatalkan hapus cabang_bank',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error'
                    }); 
              }
          })

    })
    
})

</script>