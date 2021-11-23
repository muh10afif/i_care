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
            <h4 class="page-title">Master Capem Bank</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item"><a href="<?= base_url('master/capem_bank') ?>">Capem Bank</a></li>
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
                    <a href="<?= base_url('master/unduh_excel_capem_bank') ?>"><button class="btn btn-light btn-sm float-right" type="button">Unduh Excel</button></a>
                    <button class="btn btn-warning btn-sm float-right mr-3" type="button" id="tambah_data">Tambah Data</button>
                    <h4 class="mb-0 text-white">List Capem Bank</h4>
                </div>
                <div class="card-body table-responsive">
    
                    <table class="table table-bordered table-hover" id="tabel_capem_bank" width="100%">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>No</th>
                                <th>Bank</th>
                                <th>Cabang Bank</th>
                                <th width="25%">Capem Bank</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- modal capem_bank -->
    <div id="modal_capem_bank" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title text-white" id="vcenter">Tambah Capem Bank</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <input type="hidden" id="id_capem_bank" name="id_capem_bank">
                <input type="hidden" id="aksi" name="aksi" value="Tambah">
                <div class="modal-body">

                    <form id="form_capem_bank">

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
                                <label class="col-md-3 control-label col-form-label">Cabang Bank</label>
                                <div class="col-md-9">
                                    <select class="select2 form-control custom-select" name="cabang_bank" id="cabang_bank" style="width: 100%; height:36px;">  
                                        <option value="a">-- Pilih Cabang Bank --</option>
                                        
                                    </select>
                                    <div id="loading_cab_bank" style="margin-top: 10px;" align='center'>
                                        <img src="<?= base_url('template/img/loading.gif') ?>" width="18"> <small>Loading...</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 mt-3">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Capem Bank</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Nama Capem Bank" id="nama">
                                </div>
                            </div>
                        </div>
                    </div>

                    </form>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark waves-effect mr-2" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-info waves-effect" id="simpan_capem_bank">Simpan</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>

$(document).ready(function () {

    // dataTables capem_bank
    var tabel_capem_bank = $('#tabel_capem_bank').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "<?= base_url("master/tampil_capem_bank") ?>",
            "type"  : "POST"
        },
        "columnDefs"        : [{
            "targets"   : [0],
            "orderable" : false
        }]

    })

    $('#tambah_data').on('click', function () {
        // $("a[href='#profile']").tab('show');

        $('#modal_capem_bank').modal('show');

        $('#form_capem_bank').trigger("reset");

        $('.modal-title').text('Tambah Capem Bank');
        $('#aksi').val('Tambah');
    })

    // aksi simpan capem_bank
    $('#simpan_capem_bank').on('click', function () {
        
        var nama            = $('#nama').val();
        var cabang_bank     = $('#cabang_bank').val();
        var aksi            = $('#aksi').val();
        var id_capem_bank   = $('#id_capem_bank').val();

        if (cabang_bank == 'a') {
            swal({
                  title               : "Peringatan",
                  text                : 'Cabang Bank harus terisi!',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-warning",
                  type                : 'warning'
              }); 

            return false;
        } else if (nama == '') {
            swal({
                  title               : "Peringatan",
                  text                : 'Nama Capem harus terisi!',
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
                      url         : "<?= base_url('Master/aksi_capem_bank') ?>",
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
                      data        : {nama:nama, cabang_bank:cabang_bank, aksi:aksi, id_capem_bank:id_capem_bank},
                      dataType    : "JSON",
                      success     : function (data) {

                          tabel_capem_bank.ajax.reload(null, false);

                            swal({
                                title               : aksi+' Capem Bank',
                                text                : 'Data Berhasil Disimpan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success'
                            }); 
                          
                          $('#modal_capem_bank').modal('hide');
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
                        text                : 'Anda membatalkan '+aksi.toLowerCase()+' capem_bank',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error'
                    }); 
              }
          })

        }

    })

    // aksi edit capem_bank
    $('#tabel_capem_bank').on('click', '.edit-capem-bank', function () {
         var id_capem_bank = $(this).data('id');

         console.log(id_capem_bank);

         $.ajax({
            url : "<?php echo base_url('Master/ambil_data_capem_bank')?>/"+id_capem_bank,
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

                $('#id_capem_bank').val(data.id_capem_bank);
                $('#nama').val(data.capem_bank);
                $('#singkatan').val(data.singkatan);

                $('#modal_capem_bank').modal('show');
                $('.modal-title').text('Edit Capem Bank');
                $('#aksi').val('Edit');
     
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
         })        
    })

    // hapus capem_bank
    $('#tabel_capem_bank').on('click', '.hapus-capem-bank', function () {
        
        var id_capem_bank = $(this).data('id');

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
                      url         : "<?= base_url('Master/aksi_capem_bank') ?>",
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
                      data        : {aksi:'hapus', id_capem_bank:id_capem_bank},
                      dataType    : "JSON",
                      success     : function (data) {

                          tabel_capem_bank.ajax.reload(null, false);

                            swal({
                                title               : 'Hapus Capem Bank',
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
                        text                : 'Anda membatalkan hapus capem_bank',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error'
                    }); 
              }
          })

    })

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