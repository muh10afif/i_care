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
            <h4 class="page-title">Master Cabang Asuransi</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item"><a href="<?= base_url('master/cabang_asuransi') ?>">Cabang Asuransi</a></li>
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
                    <a href="<?= base_url('master/unduh_excel_cabang_asuransi') ?>"><button class="btn btn-light btn-sm float-right" type="button">Unduh Excel</button></a>
                    <button class="btn btn-warning btn-sm float-right mr-3" type="button" id="tambah_data">Tambah Data</button>
                    <h4 class="mb-0 text-white">List Cabang Asuransi</h4>
                </div>
                <div class="card-body table-responsive">
    
                    <table class="table table-bordered table-hover" id="tabel_cabang_asuransi" width="100%">
                        <thead class="bg-info text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th width="25%">Asuransi</th>
                                <th width="15%">Korwil Asuransi</th>
                                <th width="15%">Cabang Asuransi</th>
                                <th width="15%">Singkatan</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- modal cabang_asuransi -->
    <div id="modal_cabang_asuransi" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title text-white" id="vcenter">Tambah Cabang Asuransi</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <input type="hidden" id="id_cabang_asuransi" name="id_cabang_asuransi">
                <input type="hidden" id="aksi" name="aksi" value="Tambah">
                <div class="modal-body">

                    <form id="form_cabang_asuransi">

                    <div class="row d-flex justify-content-center mt-3 mb-3">
                        <div class="col-md-10">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Cabang Asuransi</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Nama Cabang Asuransi" id="nama">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 mt-3">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Singkatan</label>
                                <div class="col-md-9">
                                    <input class="form-control" name="singkatan" id="singkatan" placeholder="singkatan">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 mt-3">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Korwil Asuransi</label>
                                <div class="col-md-9">
                                    <select class="select2 form-control custom-select" name="korwil_asuransi" id="korwil_asuransi" style="width: 100%; height:36px;">  
                                        <option value="a">-- Pilih Korwil Asuransi --</option>
                                        <?php foreach ($kor_asuransi as $b): ?>
                                            <option value="<?= $b['id_korwil_asuransi'] ?>"><?= $b['korwil_asuransi'] ?></option>
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
                    <button type="button" class="btn btn-info waves-effect" id="simpan_cabang_asuransi">Simpan</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>

$(document).ready(function () {

    // dataTables cabang_asuransi
    var tabel_cabang_asuransi = $('#tabel_cabang_asuransi').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "<?= base_url("master/tampil_cabang_asuransi") ?>",
            "type"  : "POST"
        },
        "columnDefs"        : [{
            "targets"   : [0],
            "orderable" : false
        }]

    })

    $('#tambah_data').on('click', function () {
        // $("a[href='#profile']").tab('show');

        $('#modal_cabang_asuransi').modal('show');

        $('#form_cabang_asuransi').trigger("reset");

        $('.modal-title').text('Tambah Cabang Asuransi');
        $('#aksi').val('Tambah');
    })

    // aksi simpan cabang_asuransi
    $('#simpan_cabang_asuransi').on('click', function () {
        
        var nama                = $('#nama').val();
        var singkatan           = $('#singkatan').val();
        var korwil_asuransi     = $('#korwil_asuransi').val();
        var aksi                = $('#aksi').val();
        var id_cabang_asuransi  = $('#id_cabang_asuransi').val();

        if (nama == '') {
            swal({
                  title               : "Peringatan",
                  text                : 'Cabang asuransi harus terisi!',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-warning",
                  type                : 'warning'
              }); 

            return false;
        } else if (singkatan == '') {
            swal({
                  title               : "Peringatan",
                  text                : 'Singkatan harus terisi!',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-warning",
                  type                : 'warning'
              }); 

            return false;
        } else if (korwil_asuransi == 'a') {
            swal({
                  title               : "Peringatan",
                  text                : 'Korwil asuransi harus terisi!',
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
                      url         : "<?= base_url('Master/aksi_cabang_asuransi') ?>",
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
                      data        : {nama:nama, singkatan:singkatan, korwil_asuransi:korwil_asuransi, aksi:aksi, id_cabang_asuransi:id_cabang_asuransi},
                      dataType    : "JSON",
                      success     : function (data) {

                          tabel_cabang_asuransi.ajax.reload(null, false);

                            swal({
                                title               : aksi+' Cabang Asuransi',
                                text                : 'Data Berhasil Disimpan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success'
                            }); 
                          
                          $('#modal_cabang_asuransi').modal('hide');
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
                        text                : 'Anda membatalkan '+aksi.toLowerCase()+' cabang_asuransi',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error'
                    }); 
              }
          })

        }

    })

    // aksi edit cabang_asuransi
    $('#tabel_cabang_asuransi').on('click', '.edit-cabang-asuransi', function () {
         var id_cabang_asuransi = $(this).data('id');

         console.log(id_cabang_asuransi);

         $.ajax({
            url : "<?php echo base_url('Master/ambil_data_cabang_asuransi')?>/"+id_cabang_asuransi,
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

                $('#id_cabang_asuransi').val(data.id_cabang_asuransi);
                $('#nama').val(data.cabang_asuransi);
                $('#singkatan').val(data.singkatan);
                $('#korwil_asuransi').val(data.id_korwil_asuransi).trigger('change.select2');

                $('#modal_cabang_asuransi').modal('show');
                $('.modal-title').text('Edit Cabang Asuransi');
                $('#aksi').val('Edit');
     
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
         })        
    })

    // hapus cabang_asuransi
    $('#tabel_cabang_asuransi').on('click', '.hapus-cabang-asuransi', function () {
        
        var id_cabang_asuransi = $(this).data('id');

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
                      url         : "<?= base_url('Master/aksi_cabang_asuransi') ?>",
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
                      data        : {aksi:'hapus', id_cabang_asuransi:id_cabang_asuransi},
                      dataType    : "JSON",
                      success     : function (data) {

                          tabel_cabang_asuransi.ajax.reload(null, false);

                            swal({
                                title               : 'Hapus Cabang Asuransi',
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
                        text                : 'Anda membatalkan hapus cabang_asuransi',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error'
                    }); 
              }
          })

    })
    
})

</script>