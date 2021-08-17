<?= $this->extend('admin/layouts/index') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Data Riwayat Belanja</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="mb-5">
            <button type="button" class="btn btn-warning" id="btn-reset"><i class="fa fa-sync-alt"></i> Refresh</button>
            </div>
            <table id="tabel_serverside" class="table table-bordered table-striped" cellspacing="0" width="100%">
              <thead>
                  <tr>
                      <th>No</th>
                      <th>Invoice</th>
                      <th>Waktu</th>
                      <th>Total</th>
                      <th>Pembayaran</th>
                      <th>Kembalian</th>
                      <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                  <tr>
                      <th>No</th>
                      <th>Invoice</th>
                      <th>Waktu</th>
                      <th>Total</th>
                      <th>Pembayaran</th>
                      <th>Kembalian</th>
                      <th>Aksi</th>
                  </tr>
              </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div><!-- /.container-fluid -->

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
            url :"<?php echo base_url("admin/history/json"); ?>", // json datasource
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
function deleteHistory(id){
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
                url: "<?php echo base_url('admin/history/delete')?>/"+id,
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
</script>
<?= $this->endSection() ?>

