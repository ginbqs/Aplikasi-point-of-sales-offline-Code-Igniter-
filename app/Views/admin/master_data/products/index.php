<?= $this->extend('admin/layouts/index') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Data Produk</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="mb-5">
            <button type="button" class="btn btn-success" onclick="addProducts()"><i class="fa fa-plus"></i> Tambah</button>
            <button type="button" class="btn btn-warning" id="btn-reset"><i class="fa fa-sync-alt"></i> Refresh</button>
            </div>
            <table id="tabel_serverside" class="table table-bordered table-striped" cellspacing="0" width="100%">
              <thead>
                  <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Harga Asal</th>
                      <th>Harga Jual</th>
                      <th>Deskripsi</th>
                      <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                  <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Harga Asal</th>
                      <th>Harga Jual</th>
                      <th>Deskripsi</th>
                      <th>Aksi</th>
                  </tr>
              </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div><!-- /.container-fluid -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog" id="modal_form_size">
        <div class="modal-content">
            <div class="overlay" id="modal_form_overlay" style="display:none">
                <i class="fas fa-2x fa-sync fa-spin"></i>
            </div>
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form action="#" id="formData" class="form-horizontal" method="post" >
            <div class="modal-body form">
                    <input type="hidden" value="" id="input_id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label">Nama</label>
                            <input id="input_name" placeholder="Nama" class="form-control" type="text">
                            <span id="input_name-error" class="error invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Satuan</label>
                            <div class="row">
                                <div class="col-md-10">
                                    <select id="input_unit_id" class="form-control">
                                        <?php foreach ($dt_units as $key) {?>
                                            <option value="<?php echo $key->id?>"><?php echo $key->name?></option>
                                        <?php }?>
                                    </select>
                                    <span id="input_unit-error" class="error invalid-feedback"></span>
                                </div>
                                <div class="col-md-2">
                                    <a href="<?php echo base_url("admin/master_data/units"); ?>" target="_black">
                                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Harga Asal</label>
                            <input id="input_original_price" placeholder="Harga" class="form-control" type="number" step="any">
                            <span id="input_original_price-error" class="error invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Harga Jual</label>
                            <input id="input_price" placeholder="Harga" class="form-control" type="number" step="any">
                            <span id="input_price-error" class="error invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Deskripsi</label>
                            <textarea id="input_desc" placeholder="Deskripsi" class="form-control" rows="5"></textarea>
                            <span id="input_desc-error" class="error invalid-feedback"></span>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->


<script type="text/javascript" language="javascript" >
$(document).ready(function() {
    var dataTable = $('#tabel_serverside').DataTable( {
        "processing" : true,
        "oLanguage": {
            "sLengthMenu": "Tampilkan _MENU_ data per halaman",
            "sSearch": "Pencarian: ",
            "sZeroRecords": "Maaf, tidak ada data yang ditemukan",
            "sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
            "sInfoEmpty": "Menampilkan 0 s/d 0 dari 0 data",
            "sInfoFiltered": "(di filter dari _MAX_ total data)",
            "oPaginate": {
                "sFirst": "<<",
                "sLast": ">>",
                "sPrevious": "<",
                "sNext": ">"
            }
        },
        columnDefs: [{
            targets: [0],
            orderable: false
        }],
        "order": [], //Initial no order.
        "ordering": true,
        "info": true,
        "serverSide": true,
        "stateSave" : true,
        "scrollX": true,
        "ajax":{
            url :"<?php echo base_url("admin/master_data/products/json"); ?>", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
                $(".tabel_serverside-error").html("");
                $("#tabel_serverside").append('<tbody class="tabel_serverside-error"><tr><th colspan="3">Data Tidak Ditemukan di Server</th></tr></tbody>');
                $("#tabel_serverside_processing").css("display","none");
            }
        }
    });
    $('#btn-reset').click(function(){ //button reset event click
        dataTable.ajax.reload();  //just reload table
    });
});
var save_method;
function addProducts()
{
    save_method = 'add';
    $('#formData')[0].reset(); // reset form on modals
    $('#modal_form').modal('show'); // show bootstrap modal
    $("#modal_title").text('Tambah Produk')
    // $("#modal_form_size").addClass('modal-lg')
}
function editProducts(id)
{
    if(!id){
        toastr.error('ID tidak ditemukan!')
        return false;
    }
    save_method = 'edit';
    $('#formData')[0].reset(); // reset form on modals
    $('#modal_form').modal('show'); // show bootstrap modal
    $("#modal_title").text('Ubah Produk')
    // $("#modal_form_size").addClass('modal-lg')
    $("#modal_form_overlay").show()
    $.get("<?php echo base_url('admin/master_data/products/edit')?>/"+id,function(response){
        $("#modal_form_overlay").hide()
        const res = JSON.parse(response)
        if(res.status){
            const data = res.message
            $("#input_id").val(data.id)
            $("#input_name").val(data.name)
            $("#input_unit_id").val(data.unit_id)
            $("#input_original_price").val(data.original_price)
            $("#input_price").val(data.price)
            $("#input_desc").val(data.desc)
        }else{
            toastr.error('Data tidak ditemukan!')
        }
    })
}
function deleteProducts(id){
    if(!id){
        toastr.error('ID tidak ditemukan!')
        return false;
    }
    Swal.fire({
        title: '<strong>HAPUS</strong>',
        icon: 'error',
        html:'Apakah Anda yakin akan menghapus data ini?',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Tutup!",
    }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo base_url('admin/master_data/products/delete')?>/"+id,
                type: 'DELETE',
                error: function() {
                    Swal.fire('Saved!', '', 'success')
                    $('#btn-reset').click()
                },
                success: function(response) {
                    const res = JSON.parse(response)
                    if(res.status){
                        toastr.success(res.message)
                    }else{
                        toastr.error('Data tidak ditemukan!')
                    }
                    $('#btn-reset').click()
                }
            });
        }
    })
}
function save()
{
    var url;
    if(save_method == 'add')
    {
        url = "<?php echo site_url('admin/master_data/products/create')?>";
    }
    else
    {
        url = "<?php echo site_url('admin/master_data/products/update')?>";
    }
    var data = {
        'input_id'      : $("#input_id").val(),
        'input_name'    : $("#input_name").val(),
        'input_unit_id' : $("#input_unit_id").val(),
        'input_original_price'   : $("#input_original_price").val(),
        'input_price'   : $("#input_price").val(),
        'input_desc'    : $("#input_desc").val()
    }
    $("#modal_form_overlay").show()
    $.post(url,data,function(response){
        const res = JSON.parse(response)
        if(res.status){
            toastr.success(res.message)
            $('#modal_form').modal('hide');
            $('#btn-reset').click()
            $("#modal_form_overlay").hide()
        }else{
            $("#modal_form_overlay").hide()
            toastr.error('Silahkan periksa form Anda kembali!')
            Object.entries(res.message).forEach(([key, value]) => {
                $(`#${key}`).addClass('is-invalid')
                $(`#${key}-error`).text(value)
            });
        }
    })

}
</script>
<?= $this->endSection() ?>

