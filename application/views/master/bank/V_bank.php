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
            <h4 class="page-title">Master Bank</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item"><a href="<?= base_url('master/bank') ?>">Bank</a></li>
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
                    <h4 class="mb-0 text-white">List Bank</h4>
                </div>
                <div class="card-body table-responsive">
    
                    <table class="table table-bordered table-hover" id="tabel_bank" width="100%">
                        <thead class="bg-info text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th width="25%">Bank</th>
                                <th width="25%">Singkatan</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- modal bank -->
    <div id="modal_bank" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title text-white" id="vcenter">Tambah Bank</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <input type="hidden" id="id_bank" name="id_bank">
                <input type="hidden" id="aksi" name="aksi" value="Tambah">
                <div class="modal-body">

                    <form id="form_bank" autocomplete="off">

                    <div class="row d-flex justify-content-center mt-3 mb-3">
                        <div class="col-md-10">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Nama Bank</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Nama Bank" id="nama">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 mt-3">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Singkatan</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="singkatan" id="singkatan" placeholder="singkatan"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    </form>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark waves-effect mr-2" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-info waves-effect" id="simpan_bank">Simpan</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>

  $(document).ready(function () {

      // dataTables bank
      var tabel_bank = $('#tabel_bank').DataTable({
          "processing"        : true,
          "serverSide"        : true,
          "order"             : [],
          "ajax"              : {
              "url"   : "<?= base_url("master/tampil_bank") ?>",
              "type"  : "POST"
          },
          "columnDefs"        : [{
              "targets"   : [0],
              "orderable" : false
          }]

      })

      $('#tambah_data').on('click', function () {
          // $("a[href='#profile']").tab('show');

          $('#modal_bank').modal('show');

          $('#form_bank').trigger("reset");

          $('.modal-title').text('Tambah Bank');
          $('#aksi').val('Tambah');
      })

      // aksi simpan bank
      $('#simpan_bank').on('click', function () {
          
          var nama        = $('#nama').val();
          var singkatan   = $('#singkatan').val();
          var aksi        = $('#aksi').val();
          var id_bank     = $('#id_bank').val();

          if (nama == '') {
              swal({
                    title               : "Peringatan",
                    text                : 'Nama harus terisi!',
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
                        url         : "<?= base_url('Master/aksi_bank') ?>",
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
                        data        : {nama:nama, singkatan:singkatan, aksi:aksi, id_bank:id_bank},
                        dataType    : "JSON",
                        success     : function (data) {

                            tabel_bank.ajax.reload(null, false);

                              swal({
                                  title               : aksi+' Bank',
                                  text                : 'Data Berhasil Disimpan',
                                  buttonsStyling      : false,
                                  confirmButtonClass  : "btn btn-success",
                                  type                : 'success'
                              }); 
                            
                            $('#modal_bank').modal('hide');
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
                          text                : 'Anda membatalkan '+aksi.toLowerCase()+' bank',
                          buttonsStyling      : false,
                          confirmButtonClass  : "btn btn-info",
                          type                : 'error'
                      }); 
                }
            })

          }

      })

      // aksi edit bank
      $('#tabel_bank').on('click', '.edit-bank', function () {
           var id_bank = $(this).data('id');

           console.log(id_bank);

           $.ajax({
              url : "<?php echo base_url('Master/ambil_data_bank')?>/"+id_bank,
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

                  $('#id_bank').val(data.id_bank);
                  $('#nama').val(data.bank);
                  $('#singkatan').val(data.singkatan);

                  $('#modal_bank').modal('show');
                  $('.modal-title').text('Edit Bank');
                  $('#aksi').val('Edit');
       
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
           })        
      })

      // hapus bank
      $('#tabel_bank').on('click', '.hapus-bank', function () {
          
          var id_bank = $(this).data('id');

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
                        url         : "<?= base_url('Master/aksi_bank') ?>",
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
                        data        : {aksi:'hapus', id_bank:id_bank},
                        dataType    : "JSON",
                        success     : function (data) {

                            tabel_bank.ajax.reload(null, false);

                              swal({
                                  title               : 'Hapus Bank',
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
                          text                : 'Anda membatalkan hapus bank',
                          buttonsStyling      : false,
                          confirmButtonClass  : "btn btn-info",
                          type                : 'error'
                      }); 
                }
            })

      })
      
  })

</script>