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
            <h4 class="page-title">Master Karyawan</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item"><a href="<?= base_url('master/karyawan') ?>">Karyawan</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" hidden>
        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Home</span></a> </li>
        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Profile</span></a> </li>
        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Messages</span></a> </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content tabcontent-border">
        <div class="tab-pane active" id="home" role="tabpanel">
            

            <div class="row list-debitur">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header bg-info">
                            <button class="btn btn-warning btn-sm float-right" type="button" id="tambah_data">Tambah Data</button>
                            <h4 class="mb-0 text-white">List Karyawan</h4>
                        </div>
                        <div class="card-body table-responsive">
            
                            <table class="table table-bordered table-hover" id="tabel_karyawan" width="100%">
                                <thead class="bg-info text-white">
                                    <tr>
                                        <th>No</th>
                                        <th width="25%">Nama</th>
                                        <th>NIK</th>
                                        <th>Telefon</th>
                                        <th>Alamat</th>
                                        <th>Verifikator</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="tab-pane" id="profile" role="tabpanel">

        <div class="row list-debitur">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-info">
                        <button class="btn btn-warning btn-sm float-right" type="button" id="kembali">Kembali</button>
                        <h4 class="mb-0 text-white">List Karyawan</h4>
                    </div>
                    <div class="card-body table-responsive">

                        <div class="p-20">
                            <h3>Best Clean Tab ever</h3>
                            <h4>you can use it with the small code</h4>
                            <p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a.</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        </div>
        <div class="tab-pane p-20" id="messages" role="tabpanel">3</div>
    </div>

    <!-- modal karyawan -->
    <div id="modal_karyawan" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title text-white" id="vcenter">Tambah Karyawan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <input type="hidden" id="id_karyawan" name="id_karyawan">
                <input type="hidden" id="aksi" name="aksi" value="Tambah">
                <div class="modal-body">

                    <form id="form_karyawan">

                    <div class="row d-flex justify-content-center mt-3 mb-3">
                        <div class="col-md-10">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Nama Lengkap</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Nama Lengkap" id="nama">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 mt-3">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">NIK</label>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" placeholder="NIK" id="nik">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 mt-3">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Telfon</label>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" placeholder="Telfon" id="telfon">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 mt-3">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Alamat</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="alamat" id="alamat" placeholder="Alamat"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 mt-3">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Verifikator</label>
                                <div class="col-md-9 mt-2">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="r2" name="verifikator" class="custom-control-input ver" value="0" checked>
                                        <label class="custom-control-label" for="r2">Tidak</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="r1" name="verifikator" class="custom-control-input ver" value="1">
                                        <label class="custom-control-label" for="r1">Ya</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    </form>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark waves-effect mr-2" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-info waves-effect" id="simpan_karyawan">Simpan</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>

$(document).ready(function () {

    $('#kembali').on('click', function () {
        $("a[href='#home']").tab('show');
    })

    // dataTables karyawan
    var tabel_karyawan = $('#tabel_karyawan').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "<?= base_url("master/tampil_karyawan") ?>",
            "type"  : "POST"
        },
        "columnDefs"        : [{
            "targets"   : [0,6],
            "orderable" : false
        }]

    })

    $('#tambah_data').on('click', function () {
        // $("a[href='#profile']").tab('show');

        $('#modal_karyawan').modal('show');

        $('#form_karyawan').trigger("reset");

        $('.modal-title').text('Tambah Karyawan');
        $('#aksi').val('Tambah');
    })

    // aksi simpan karyawan
    $('#simpan_karyawan').on('click', function () {
        
        var nama         = $('#nama').val();
        var nik          = $('#nik').val();
        var telfon       = $('#telfon').val();
        var alamat       = $('#alamat').val();
        var aksi         = $('#aksi').val();
        var id_karyawan  = $('#id_karyawan').val();
        var ver          = $('input[name="verifikator"]:checked').val();

        if (nama == '') {
            swal({
                  title               : "Peringatan",
                  text                : 'Nama harus terisi!',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-warning",
                  type                : 'warning'
              }); 

            return false;
        } else if (nik == '') {
            swal({
                  title               : "Peringatan",
                  text                : 'NIK harus terisi!',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-warning",
                  type                : 'warning'
              }); 

            return false;
        } else if (telfon == '') {
            swal({
                  title               : "Peringatan",
                  text                : 'Telfon harus terisi!',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-warning",
                  type                : 'warning'
              }); 

            return false;
        } else if (alamat == '') {
            swal({
                  title               : "Peringatan",
                  text                : 'Alamat harus terisi!',
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
                      url         : "<?= base_url('Master/aksi_karyawan') ?>",
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
                      data        : {nama:nama, alamat:alamat, nik:nik, telfon:telfon, aksi:aksi, id_karyawan:id_karyawan, ver:ver},
                      dataType    : "JSON",
                      success     : function (data) {

                          tabel_karyawan.ajax.reload(null, false);

                            swal({
                                title               : aksi+' Karyawan',
                                text                : 'Data Berhasil Disimpan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            }); 
                          
                          $('#modal_karyawan').modal('hide');
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
                        text                : 'Anda membatalkan '+aksi.toLowerCase()+' karyawan',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error'
                    }); 
              }
          })

        }

    })

    // aksi edit karyawan
    $('#tabel_karyawan').on('click', '.edit-karyawan', function () {
         var id_karyawan = $(this).data('id');

         $.ajax({
            url : "<?php echo base_url('Master/ambil_data_karyawan')?>/"+id_karyawan,
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

                $('#id_karyawan').val(data.id_karyawan);
                $('#nama').val(data.nama_lengkap);
                $('#telfon').val(data.telfon);
                $('#nik').val(data.nik);
                $('#alamat').val(data.alamat);
                $("input[name=verifikator][value=" + data.verifikator + "]").prop('checked', true);

                $('#modal_karyawan').modal('show');
                $('.modal-title').text('Edit Karyawan');
                $('#aksi').val('Edit');
     
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
         })        
    })

    // hapus karyawan
    $('#tabel_karyawan').on('click', '.hapus-karyawan', function () {
        
        var id_karyawan = $(this).data('id');

        swal({
              title       : 'Konfirmasi',
              text        : 'Yakin akan hapus data?',
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
                      url         : "<?= base_url('Master/aksi_karyawan') ?>",
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
                      data        : {aksi:'hapus', id_karyawan:id_karyawan},
                      dataType    : "JSON",
                      success     : function (data) {

                          tabel_karyawan.ajax.reload(null, false);

                            swal({
                                title               : 'Hapus Karyawan',
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
                        text                : 'Anda membatalkan hapus karyawan',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error'
                    }); 
              }
          })

    })
    
})

</script>