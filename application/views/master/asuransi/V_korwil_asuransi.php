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
            <h4 class="page-title">Master Korwil Asuransi</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item"><a href="<?= base_url('master/korwil_asuransi') ?>">Korwil Asuransi</a></li>
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
                    <h4 class="mb-0 text-white">List Korwil Asuransi</h4>
                </div>
                <div class="card-body table-responsive">
    
                    <table class="table table-bordered table-hover" id="tabel_korwil_asuransi" width="100%">
                        <thead class="bg-info text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th width="25%">Asuransi</th>
                                <th width="25%">Korwil Asuransi</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- modal korwil_asuransi -->
    <div id="modal_korwil_asuransi" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title text-white" id="vcenter">Tambah Korwil Asuransi</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <input type="hidden" id="id_korwil_asuransi" name="id_korwil_asuransi">
                <input type="hidden" id="aksi" name="aksi" value="Tambah">
                <div class="modal-body">

                    <form id="form_korwil_asuransi" autocomplete="off">

                    <div class="row d-flex justify-content-center mt-3 mb-3">
                        <div class="col-md-10">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Korwil Asuransi</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Korwil Asuransi" id="nama">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 mt-3">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Asuransi</label>
                                <div class="col-md-9">
                                    <select class="select2 form-control custom-select" name="asuransi" id="asuransi" style="width: 100%; height:36px;">  
                                        <option value="a">-- Pilih Asuransi --</option>
                                        <?php foreach ($asuransi as $b): ?>
                                            <option value="<?= $b['id_asuransi'] ?>"><?= $b['asuransi'] ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    </form>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark waves-effect mr-2" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-info waves-effect" id="simpan_korwil_asuransi">Simpan</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>

$(document).ready(function () {

    // dataTables korwil_asuransi
    var tabel_korwil_asuransi = $('#tabel_korwil_asuransi').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "<?= base_url("master/tampil_korwil_asuransi") ?>",
            "type"  : "POST"
        },
        "columnDefs"        : [{
            "targets"   : [0],
            "orderable" : false
        }]

    })

    $('#tambah_data').on('click', function () {
        // $("a[href='#profile']").tab('show');

        $('#modal_korwil_asuransi').modal('show');

        $('#form_korwil_asuransi').trigger("reset");

        $('.modal-title').text('Tambah Korwil Asuransi');
        $('#aksi').val('Tambah');
    })

    // aksi simpan korwil_asuransi
    $('#simpan_korwil_asuransi').on('click', function () {
        
        var nama                = $('#nama').val();
        var asuransi            = $('#asuransi').val();
        var aksi                = $('#aksi').val();
        var id_korwil_asuransi  = $('#id_korwil_asuransi').val();

        if (nama == '') {
            swal({
                  title               : "Peringatan",
                  text                : 'Nama korwil harus terisi!',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-warning",
                  type                : 'warning'
              }); 

            return false;
        } else if (asuransi == 'a') {
            swal({
                  title               : "Peringatan",
                  text                : 'Asuransi harus terisi!',
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
                      url         : "<?= base_url('Master/aksi_korwil_asuransi') ?>",
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
                      data        : {nama:nama, asuransi:asuransi, aksi:aksi, id_korwil_asuransi:id_korwil_asuransi},
                      dataType    : "JSON",
                      success     : function (data) {

                          tabel_korwil_asuransi.ajax.reload(null, false);

                            swal({
                                title               : aksi+' Korwil Asuransi',
                                text                : 'Data Berhasil Disimpan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success'
                            }); 
                          
                          $('#modal_korwil_asuransi').modal('hide');
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
                        text                : 'Anda membatalkan '+aksi.toLowerCase()+' korwil_asuransi',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error'
                    }); 
              }
          })

        }

    })

    // aksi edit korwil_asuransi
    $('#tabel_korwil_asuransi').on('click', '.edit-korwil-asuransi', function () {
         var id_korwil_asuransi = $(this).data('id');

         console.log(id_korwil_asuransi);

         $.ajax({
            url : "<?php echo base_url('Master/ambil_data_korwil_asuransi')?>/"+id_korwil_asuransi,
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

                console.log(data);

                $('#id_korwil_asuransi').val(data.id_korwil_asuransi);
                $('#nama').val(data.korwil_asuransi);
                $('#asuransi').val(data.id_asuransi).trigger('change.select2');

                $('#modal_korwil_asuransi').modal('show');
                $('.modal-title').text('Edit Korwil Asuransi');
                $('#aksi').val('Edit');
     
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
         })        
    })

    // hapus korwil_asuransi
    $('#tabel_korwil_asuransi').on('click', '.hapus-korwil-asuransi', function () {
        
        var id_korwil_asuransi = $(this).data('id');

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
                      url         : "<?= base_url('Master/aksi_korwil_asuransi') ?>",
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
                      data        : {aksi:'hapus', id_korwil_asuransi:id_korwil_asuransi},
                      dataType    : "JSON",
                      success     : function (data) {

                          tabel_korwil_asuransi.ajax.reload(null, false);

                            swal({
                                title               : 'Hapus Korwil Asuransi',
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
                        text                : 'Anda membatalkan hapus korwil_asuransi',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error'
                    }); 
              }
          })

    })
    
})

</script>