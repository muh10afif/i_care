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
            <h4 class="page-title">Master SPK</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item"><a href="<?= base_url('master/spk') ?>">SPK</a></li>
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
                    <h4 class="mb-0 text-white">List SPK</h4>
                </div>
                <div class="card-body table-responsive">
    
                    <table class="table table-bordered table-hover" id="tabel_spk" width="100%">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>No</th>
                                <th width="25%">SPK</th>
                                <th>Cabang Asuransi</th>
                                <th>No Rekening</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Akhir</th>
                                <th>Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- modal spk -->
    <div id="modal_spk" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title text-white" id="vcenter">Tambah SPK</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <input type="hidden" id="id_spk" name="id_spk">
                <input type="hidden" id="aksi" name="aksi" value="Tambah">
                <div class="modal-body">

                    <form id="form_spk">

                    <div class="row d-flex justify-content-center mt-2 mb-3">

                        <div class="col-md-10 mt-3">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">No SPK</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="No SPK" id="no_spk" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 mt-3">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Cabang Asuransi</label>
                                <div class="col-md-9">
                                    <select class="select2 form-control custom-select" name="cabang_as" id="cabang_as" style="width: 100%; height:36px;">  
                                        <option value="a">-- Pilih Cabang Asuransi --</option>
                                        <?php foreach ($cabang_as as $b): ?>
                                            <option value="<?= $b['id_cabang_asuransi'] ?>"><?= $b['cabang_asuransi'] ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 mt-3">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Rekening</label>
                                <div class="col-md-9 t_rekening">
                                    <input type="hidden" class="id_rekening">
                                    <select class="select2 form-control custom-select" name="rekening" id="rekening" style="width: 100%; height:36px;">  
                                        <option value="">-- Pilih Rekening --</option>
                                        
                                    </select>
                                </div>
                                <div class="col-md-9 text-center t_gif" hidden>
                                    <img src="<?= base_url('template/img/loading1.gif') ?>" alt="loading" width="130px">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 mt-3">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Periode</label>
                                <div class="col-md-9">
                                    <div class="input-daterange input-group" id="date-range">
                                        <input type="text" class="form-control" name="tgl_mulai" id="tgl_mulai" placeholder="Awal Periode" readonly/>
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-info b-0 text-white">s / d</span>
                                        </div>
                                        <input type="text" class="form-control" name="tgl_akhir" id="tgl_akhir" placeholder="Akhir Periode" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    </form>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark waves-effect mr-2" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-info waves-effect" id="simpan_spk">Simpan</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>

$(document).ready(function () {

    // dataTables spk
    var tabel_spk = $('#tabel_spk').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "<?= base_url("master/tampil_spk") ?>",
            "type"  : "POST"
        },
        "columnDefs"        : [{
            "targets"   : [0],
            "orderable" : false
        }]

    })

    function sel_cabang() {
        var id_cabang_as    = $('#cabang_as').val();
        var id_rekening     = $('.id_rekening').val();

        $('.t_rekening').attr('hidden', true);
        $('.t_gif').attr('hidden', false);

        $.ajax({
            url     : "<?= base_url('Master/ambil_list_rekening') ?>",
            method  : "POST",
            data    : {id_cabang_as:id_cabang_as, id_rekening:id_rekening},
            dataType: "JSON",
            success : function (data) {
                $('#rekening').html(data.option);

                $('.t_rekening').attr('hidden', false);
                $('.t_gif').attr('hidden', true);
            }
        })
    }

    // 05-04-2021
    $('#cabang_as').on('change', function () {
        var id_cabang_as    = $(this).val();
        var id_rekening     = $('.id_rekening').val();

        $('.t_rekening').attr('hidden', true);
        $('.t_gif').attr('hidden', false);

        $.ajax({
            url     : "<?= base_url('Master/ambil_list_rekening') ?>",
            method  : "POST",
            data    : {id_cabang_as:id_cabang_as, id_rekening:id_rekening},
            dataType: "JSON",
            success : function (data) {
                $('#rekening').html(data.option);

                $('.t_rekening').attr('hidden', false);
                $('.t_gif').attr('hidden', true);
            }
        })

        return false;
    })

    $('#tambah_data').on('click', function () {
        // $("a[href='#profile']").tab('show');

        $('#modal_spk').modal('show');

        $('#form_spk').trigger("reset");

        $('#tgl_mulai').datepicker('setDate', null);
        $('#tgl_akhir').datepicker('setDate', null);

        $('#cabang_as').val('a').trigger('change.select2');
        $('#rekening').val('').trigger('change');

        $('.modal-title').text('Tambah SPK');
        $('#aksi').val('Tambah');
    })

    // aksi simpan spk
    $('#simpan_spk').on('click', function () {
        
        var no_spk       = $('#no_spk').val();
        var cabang_as    = $('#cabang_as').val();
        var tgl_mulai    = $('#tgl_mulai').val();
        var tgl_akhir    = $('#tgl_akhir').val();
        var aksi         = $('#aksi').val();
        var id_spk       = $('#id_spk').val();
        var id_rekening  = $('#rekening').val();

        if (cabang_as == 'a') {
            swal({
                  title               : "Peringatan",
                  text                : 'Cabang Asuransi harus terisi!',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-warning",
                  type                : 'warning'
              }); 

            return false;
        } else if (no_spk == '') {
            swal({
                  title               : "Peringatan",
                  text                : 'No spk harus terisi!',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-warning",
                  type                : 'warning'
              }); 

            return false;
        } else if (tgl_mulai == '') {
            swal({
                  title               : "Peringatan",
                  text                : 'Tanggal Mulai harus terisi!',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-warning",
                  type                : 'warning'
              }); 

            return false;
        } else if (tgl_akhir == '') {
            swal({
                  title               : "Peringatan",
                  text                : 'Tanggal Akhir harus terisi!',
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
                      url         : "<?= base_url('Master/aksi_spk') ?>",
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
                      data        : {no_spk:no_spk, cabang_as:cabang_as, aksi:aksi, id_spk:id_spk, tgl_mulai:tgl_mulai, tgl_akhir:tgl_akhir, id_rekening:id_rekening},
                      dataType    : "JSON",
                      success     : function (data) {

                          tabel_spk.ajax.reload(null, false);

                            swal({
                                title               : aksi+' SPK',
                                text                : 'Data Berhasil Disimpan',
                                showConfirmButton   : false,
                                timer               : 1000,
                                type                : 'success'
                            }); 
                          
                          $('#modal_spk').modal('hide');
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
                        text                : 'Anda membatalkan '+aksi.toLowerCase()+' spk',
                        showConfirmButton   : false,
                        timer               : 1000,
                        type                : 'error'
                    }); 
              }
          })

        }

    })

    // aksi edit spk
    $('#tabel_spk').on('click', '.edit-spk', function () {
         var id_spk         = $(this).data('id');
         var id_rekening    = $(this).attr('id_rekening');
         
         $('.id_rekening').val(id_rekening);

         

         $.ajax({
            url : "<?php echo base_url('Master/ambil_data_spk')?>/"+id_spk,
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

                $('#id_spk').val(data.id_spk);
                $('#no_spk').val(data.no_spk);
                // $('#cabang_as').select2("val", data.id_cabang_as);
                $('#cabang_as').val(data.id_cabang_as).trigger('change.select2');
                //$('#tgl_mulai').val(data.tgl_mulai);
                $('#tgl_mulai').datepicker('setDate', data.tgl_mulai);
                $('#tgl_akhir').datepicker('setDate', data.tgl_akhir);
                //$('#tgl_akhir').val(data.tgl_akhir);

                $('#modal_spk').modal('show');
                $('.modal-title').text('Edit SPK');
                $('#aksi').val('Edit');

                sel_cabang();
     
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
         })        
    })

    // hapus spk
    $('#tabel_spk').on('click', '.hapus-spk', function () {
        
        var id_spk = $(this).data('id');

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
                      url         : "<?= base_url('Master/aksi_spk') ?>",
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
                      data        : {aksi:'hapus', id_spk:id_spk},
                      dataType    : "JSON",
                      success     : function (data) {

                          tabel_spk.ajax.reload(null, false);

                            swal({
                                title               : 'Hapus SPK',
                                text                : 'Data Berhasil Dihapus',
                                showConfirmButton   : false,
                                timer               : 1000,
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
                        text                : 'Anda membatalkan hapus spk',
                        showConfirmButton   : false,
                        timer               : 1000,
                        type                : 'error'
                    }); 
              }
          })

    })
    
})

</script>